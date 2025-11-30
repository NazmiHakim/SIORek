<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class LoanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'         => 'required|exists:items,id',
            'jumlah'          => 'required|integer|min:1|max:10000', 
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'foto_kim'        => 'required|image|mimes:jpeg,png,jpg|max:10240', 
            'surat_peminjaman'=> 'required|file|mimes:pdf|max:10240', 
        ]);

        // ambil data tambahan
        $item = Item::findOrFail($validated['item_id']);
        $peminjamId = Auth::id(); 
        $pemilikId = $item->user_id;

        // cek stok
        if ($item->getJumlahTersedia() < $validated['jumlah']) {
            return back()->with('error', 'Jumlah pinjam melebihi stok yang tersedia.');
        }

        // upload file 
        $fotoKimPath = $request->file('foto_kim')->store('public/dokumen_peminjam');
        $suratPath = $request->file('surat_peminjaman')->store('public/dokumen_peminjam');

        // simpan data ke database DAN TANGKAP KE VARIABEL $loan
        $loan = Loan::create([
            'item_id'         => $validated['item_id'],
            'peminjam_id'     => $peminjamId,
            'pemilik_id'      => $pemilikId,
            'jumlah'          => $validated['jumlah'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status'          => 'menunggu_persetujuan',
            'foto_kim'        => str_replace('public/', '', $fotoKimPath),
            'surat_peminjaman'=> str_replace('public/', '', $suratPath),
        ]);

        // notif wa pemilik
        $loan->load(['item', 'peminjam', 'pemilik']); // load data
        
        $pesan = "Halo *{$loan->pemilik->nama_pj}*,\n\n";
        $pesan .= "Ada permintaan peminjaman baru!\n";
        $pesan .= "Barang: {$loan->item->nama_item}\n";
        $pesan .= "Peminjam: {$loan->peminjam->username} ({$loan->peminjam->nama_pj})\n";
        $pesan .= "Jumlah: {$loan->jumlah} unit\n";
        $pesan .= "Tgl: {$loan->tanggal_mulai} s/d {$loan->tanggal_selesai}\n\n";
        $pesan .= "Silakan cek dashboard untuk menyetujui/menolak.";

        $this->kirimNotifWA($loan->pemilik->nomor_pj, $pesan);

        return redirect()->route('daftar-pengguna')->with('success', 'Permintaan berhasil dikirim!');
    }

    public function handlePermintaan(Request $request, Loan $loan)
    {
        if (Auth::id() != $loan->pemilik_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        if ($loan->status != 'menunggu_persetujuan') {
            return redirect()->route('dashboard')->with('error', 'Permintaan ini sudah diproses.');
        }

        $action = $request->input('action');
        $loan->load(['item', 'peminjam', 'pemilik']); // load untuk notif

        if ($action == 'setujui') {
            $loan->status = 'disetujui';
            $loan->save();
            
            // notif peminjam
            $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
            $pesan .= "Permintaan peminjaman *{$loan->item->nama_item}* telah DISETUJUI oleh pemilik.\n";
            $pesan .= "Silakan ambil barang dan lakukan konfirmasi di dashboard.";
            $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);
            
            return redirect()->route('dashboard')->with('success', 'Permintaan berhasil disetujui.');

        } elseif ($action == 'tolak') {
            $request->validate(['alasan_penolakan' => 'required|string|min:10|max:255']);
            
            $loan->status = 'ditolak';
            $loan->alasan_penolakan = $request->input('alasan_penolakan');
            $loan->save();

            $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
            $pesan .= "Mohon maaf, permintaan peminjaman *{$loan->item->nama_item}* DITOLAK.\n";
            $pesan .= "Alasan: {$loan->alasan_penolakan}";
            $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);

            return redirect()->route('dashboard')->with('success', 'Permintaan berhasil ditolak.');
        }

        return redirect()->route('dashboard')->with('error', 'Aksi tidak dikenal.');
    }

    public function konfirmasiPengambilan(Request $request, Loan $loan)
    {
        if (Auth::id() != $loan->peminjam_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        if ($loan->status != 'disetujui') {
            return redirect()->route('dashboard')->with('error', 'Peminjaman ini tidak dalam status siap diambil.');
        }

        $validated = $request->validate([
            'foto_kondisi_awal' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $path = $request->file('foto_kondisi_awal')->store('public/kondisi_barang');

        $loan->status = 'menunggu_konfirmasi_pemilik';
        $loan->foto_kondisi_awal = str_replace('public/', '', $path);
        $loan->save();

        // notif pemilik
        $loan->load(['item', 'peminjam', 'pemilik']);
        $pesan = "Halo *{$loan->pemilik->nama_pj}*,\n\n";
        $pesan .= "Barang *{$loan->item->nama_item}* telah DIAMBIL oleh peminjam ({$loan->peminjam->username}).\n";
        $pesan .= "Status sekarang: Sedang Dipinjam.";
        $this->kirimNotifWA($loan->pemilik->nomor_pj, $pesan);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil diambil! Selamat meminjam.');
    }

    public function validasiBarangKeluar(Request $request, Loan $loan)
    {
        // 1. Pastikan yang login adalah PEMILIK
        if (Auth::id() != $loan->pemilik_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        // 2. Pastikan statusnya benar
        if ($loan->status != 'menunggu_konfirmasi_pemilik') {
            return redirect()->route('dashboard')->with('error', 'Status peminjaman tidak valid.');
        }

        $action = $request->input('action');

        // meload data agar bisa ambil nama & nomor HP
        $loan->load(['item', 'peminjam', 'pemilik']);

        if ($action == 'setujui') {
            $loan->status = 'sedang_dipinjam';
            $loan->save();

            // notif setuju
            $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
            $pesan .= "✅ *Peminjaman Dimulai*\n";
            $pesan .= "Pemilik telah menerima bukti foto pengambilan barang *{$loan->item->nama_item}*.\n";
            $pesan .= "Selamat menggunakan barang tersebut.";
            
            $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);


            return redirect()->route('dashboard')->with('success', 'Barang resmi dipinjamkan.');

        } elseif ($action == 'tolak') {
            // tolak dan bisa upload ulang
            $loan->status = 'disetujui';
            
            // $loan->foto_kondisi_awal = null;
            
            $loan->save();

            // notif tolak
            $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
            $pesan .= "⚠️ *Bukti Foto Ditolak*\n";
            $pesan .= "Foto kondisi awal untuk barang *{$loan->item->nama_item}* ditolak oleh pemilik.\n";
            $pesan .= "Silakan upload ulang foto yang lebih jelas/sesuai.";
            
            $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);


            return redirect()->route('dashboard')->with('warning', 'Bukti ditolak. Peminjam diminta upload ulang.');
        }

        return redirect()->route('dashboard')->with('error', 'Aksi tidak dikenal.');
    }

    public function ajukanPengembalian(Request $request, Loan $loan)
    {
        if (Auth::id() != $loan->peminjam_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        if ($loan->status != 'sedang_dipinjam') {
            return redirect()->route('dashboard')->with('error', 'Barang ini tidak dalam status sedang dipinjam.');
        }

        $validated = $request->validate([
            'foto_kondisi_akhir' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $path = $request->file('foto_kondisi_akhir')->store('public/kondisi_barang');

        $loan->status = 'menunggu_konfirmasi_pengembalian';
        $loan->foto_kondisi_akhir = str_replace('public/', '', $path);
        $loan->tanggal_pengembalian_aktual = now(); 
        $loan->save();

        // notif pemilik
        $loan->load(['item', 'peminjam', 'pemilik']);
        $pesan = "Halo *{$loan->pemilik->nama_pj}*,\n\n";
        $pesan .= "Peminjam telah mengajukan PENGEMBALIAN barang *{$loan->item->nama_item}*.\n";
        $pesan .= "Silakan cek kondisi barang dan konfirmasi di dashboard.";
        $this->kirimNotifWA($loan->pemilik->nomor_pj, $pesan);

        return redirect()->route('dashboard')->with('success', 'Pengajuan pengembalian berhasil dikirim. Menunggu konfirmasi pemilik.');
    }

    public function konfirmasiPengembalian(Request $request, Loan $loan)
    {
        if (Auth::id() != $loan->pemilik_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        if ($loan->status != 'menunggu_konfirmasi_pengembalian') {
            return redirect()->route('dashboard')->with('error', 'Pengembalian ini sudah diproses.');
        }

        $action = $request->input('action');
        $loan->load(['item', 'peminjam', 'pemilik']);

        if ($action == 'selesai') {
            $loan->status = 'selesai';
            $loan->save();
            
            // notif
            $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
            $pesan .= "Terima kasih! Pengembalian barang *{$loan->item->nama_item}* telah diterima.\n";
            $pesan .= "Transaksi SELESAI.";
            $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);
            
            return redirect()->route('dashboard')->with('success', 'Peminjaman telah selesai.');

        } elseif ($action == 'bermasalah') {

            $request->validate(['keterangan_sanksi' => 'required|string|min:10|max:500']);
            
            $loan->status = 'bermasalah';
            $loan->keterangan_sanksi = $request->input('keterangan_sanksi');
            $loan->save();

            $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
            $pesan .= "PERHATIAN: Pengembalian barang *{$loan->item->nama_item}* ditandai BERMASALAH oleh pemilik.\n";
            $pesan .= "Keterangan: {$loan->keterangan_sanksi}\n";
            $pesan .= "Mohon segera hubungi pemilik untuk penyelesaian.";
            $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);

            return redirect()->route('dashboard')->with('success', 'Pengembalian ditandai bermasalah.');
        }

        return redirect()->route('dashboard')->with('error', 'Aksi tidak dikenal.');
    }
    
    public function selesaikanMasalah(Loan $loan)
    {
        if (Auth::id() != $loan->pemilik_id) {
            return redirect()->route('dashboard')->with('error', 'Hanya pemilik barang yang bisa menyelesaikan masalah ini.');
        }

        if ($loan->status != 'bermasalah') {
            return redirect()->route('dashboard')->with('error', 'Status peminjaman tidak valid.');
        }

        $loan->status = 'selesai';
        $loan->save();

        // notif peminjam
        $loan->load(['item', 'peminjam', 'pemilik']);
        $pesan = "Halo *{$loan->peminjam->nama_pj}*,\n\n";
        $pesan .= "Kabar Baik! Masalah pada peminjaman *{$loan->item->nama_item}* telah diselesaikan oleh pemilik.\n";
        $pesan .= "Transaksi kini ditutup (SELESAI).";
        $this->kirimNotifWA($loan->peminjam->nomor_pj, $pesan);

        return redirect()->route('dashboard')->with('success', 'Masalah terselesaikan. Transaksi ditutup.');
    }

    private function kirimNotifWA($nomorTujuan, $pesan)
    {
        if (empty($nomorTujuan)) { return; }
        try {
            Http::withOptions(['verify' => false]) 
                ->withHeaders(['Authorization' => 'X1qzkz3tqpx3n2UJrvk7'])
                ->post('https://api.fonnte.com/send', [
                    'target' => $nomorTujuan,
                    'message' => $pesan,
                    'countryCode' => '62', 
                ]);
        } catch (\Exception $e) {}
    }
}