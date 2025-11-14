<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    
    // menyimpan permintaan peminjaman baru kedatabase
    public function store(Request $request)
    {
        // validasi input form
        $validated = $request->validate([
            'item_id'         => 'required|exists:items,id',
            'jumlah'          => 'required|integer|min:1',
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'foto_kim'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'surat_peminjaman'=> 'required|file|mimes:pdf|max:2048',
        ]);

        // ambil data tambahan
        $item = Item::findOrFail($validated['item_id']);
        $peminjamId = Auth::id(); 
        $pemilikId = $item->user_id;

        // cek stok
        $jumlahTersedia = $item->getJumlahTersedia();
        
        if ($validated['jumlah'] > $jumlahTersedia) {
            return back()->with('error', 'Jumlah pinjam (' . $validated['jumlah'] . ') melebihi stok yang tersedia (' . $jumlahTersedia . ').');
        }

        // upload file 
        $fotoKimPath = $request->file('foto_kim')->store('public/dokumen_peminjam');
        $suratPath = $request->file('surat_peminjaman')->store('public/dokumen_peminjam');

        // simpan data ke database
        Loan::create([
            'item_id'         => $validated['item_id'],
            'peminjam_id'     => $peminjamId,
            'pemilik_id'      => $pemilikId,
            'jumlah'          => $validated['jumlah'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status'          => 'menunggu_persetujuan', // Status awal
            'foto_kim'        => str_replace('public/', '', $fotoKimPath),
            'surat_peminjaman'=> str_replace('public/', '', $suratPath),
        ]);

        // lalu kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('daftar-pengguna')->with('success', 'Permintaan peminjaman berhasil dikirim!');
    }

    public function handlePermintaan(Request $request, Loan $loan)
    {
        // memastikan login pemilik
        if (Auth::id() != $loan->pemilik_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        // cek status
        if ($loan->status != 'menunggu_persetujuan') {
            return redirect()->route('dashboard')->with('error', 'Permintaan ini sudah diproses.');
        }

        // konfirmasi request
        $action = $request->input('action');

        if ($action == 'setujui') {
                        
            $loan->status = 'disetujui';
            $loan->save();
            
            return redirect()->route('dashboard')->with('success', 'Permintaan berhasil disetujui.');

        } elseif ($action == 'tolak') {
            
            // alasan karena menolak
            $request->validate(['alasan_penolakan' => 'required|string|min:10']);
            
            $loan->status = 'ditolak';
            $loan->alasan_penolakan = $request->input('alasan_penolakan');
            $loan->save();

            return redirect()->route('dashboard')->with('success', 'Permintaan berhasil ditolak.');
        }

        return redirect()->route('dashboard')->with('error', 'Aksi tidak dikenal.');
    }

    public function konfirmasiPengambilan(Request $request, Loan $loan)
    {
        // memastikan login peminjam
        if (Auth::id() != $loan->peminjam_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        // cek status peminjam
        if ($loan->status != 'disetujui') {
            return redirect()->route('dashboard')->with('error', 'Peminjaman ini tidak dalam status siap diambil.');
        }

        // validasi upload foto
        $validated = $request->validate([
            'foto_kondisi_awal' => 'required|image|mimes:jpeg,png,jpg,webp|max:4048',
        ]);

        // upload file
        $path = $request->file('foto_kondisi_awal')->store('public/kondisi_barang');

        // update status peminjaman
        $loan->status = 'sedang_dipinjam';
        $loan->foto_kondisi_awal = str_replace('public/', '', $path);
        $loan->save();

        // balik ke dashboard
        return redirect()->route('dashboard')->with('success', 'Barang berhasil diambil! Selamat meminjam.');
    }

    public function ajukanPengembalian(Request $request, Loan $loan)
    {
        // login peminjam
        if (Auth::id() != $loan->peminjam_id) {
            return redirect()->route('dashboard')->with('error', 'Aksi tidak diizinkan!');
        }

        // statusnya
        if ($loan->status != 'sedang_dipinjam') {
            return redirect()->route('dashboard')->with('error', 'Barang ini tidak dalam status sedang dipinjam.');
        }

        // input foto
        $validated = $request->validate([
            'foto_kondisi_akhir' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // upload file
        $path = $request->file('foto_kondisi_akhir')->store('public/kondisi_barang');

        // update status peminjaman
        $loan->status = 'menunggu_konfirmasi_pengembalian';
        $loan->foto_kondisi_akhir = str_replace('public/', '', $path);
        $loan->tanggal_pengembalian_aktual = now(); 
        $loan->save();

        // kedashboard
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

        if ($action == 'selesai') {
            
            $loan->status = 'selesai';
            $loan->save();
            
            return redirect()->route('dashboard')->with('success', 'Peminjaman telah selesai.');

        } elseif ($action == 'bermasalah') {
            
            // tambah keterangan karena bermasalah
            $request->validate(['keterangan_sanksi' => 'required|string|min:10']);
            
            $loan->status = 'bermasalah';
            $loan->keterangan_sanksi = $request->input('keterangan_sanksi');
            $loan->save();

            return redirect()->route('dashboard')->with('success', 'Pengembalian ditandai bermasalah.');
        }

        return redirect()->route('dashboard')->with('error', 'Aksi tidak dikenal.');
    }
}