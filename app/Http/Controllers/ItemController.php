<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // status barang
        $activeStatuses = [
            'menunggu_persetujuan',
            'disetujui',
            'sedang_dipinjam',
            'menunggu_konfirmasi_pengembalian',
            'bermasalah'
        ];

        // mengambil semua item dan menghitung jumlah dari peminjaman (yang aktif)
        $items = Item::where('user_id', $userId)
                    ->withSum(['loans' => function ($query) use ($activeStatuses) {
                        $query->whereIn('status', $activeStatuses);
                    }], 'jumlah')
                    ->get();

        // hitung sisa stok di sisi PHP
        foreach ($items as $item) {
            $item->jumlah_dipinjam = $item->loans_sum_jumlah ?? 0;
            $item->jumlah_tersedia = $item->jumlah_total - $item->jumlah_dipinjam;
        }

        // kirim data items keview
        return view('barang', [
            'items' => $items
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'nama_item'    => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'jumlah_total' => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string',
            'foto_item'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // siapkan data untuk disimpan
        $dataToStore = $validated;
        $dataToStore['user_id'] = Auth::id();

        if ($request->hasFile('foto_item')) {
            $path = $request->file('foto_item')->store('public/foto_barang');
            $dataToStore['foto_item'] = str_replace('public/', '', $path);
        }

        // simpan ke database
        Item::create($dataToStore);

        // kembalikan kehalaman Barang Saya
        return redirect()->route('barang')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Item $item)
    {
        // Pengecekan Keamanan (sama seperti destroy)
        if ($item->user_id != Auth::id()) {
            return redirect()->route('barang')->with('error', 'Anda tidak berhak mengedit barang ini!');
        }

        // menampilkan view dari edit-barang.blade dan mengirim data item
        return view('edit-barang', [
            'item' => $item
        ]);
    }

    public function update(Request $request, Item $item)
    {
        // pengecekan Keamanan
        if ($item->user_id != Auth::id()) {
            return redirect()->route('barang')->with('error', 'Anda tidak berhak mengedit barang ini!');
        }

        // validasi input
        $validated = $request->validate([
            'nama_item'    => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'jumlah_total' => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string',
            'foto_item'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('foto_item')) {
            // hapus foto lama
            if ($item->foto_item) {
                Storage::delete('public/' . $item->foto_item);
            }

            // simpan foto baru
            $path = $request->file('foto_item')->store('public/foto_barang');
            $validated['foto_item'] = str_replace('public/', '', $path);
        }

        // update data item ke db
        $item->update($validated);

        return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        // pengecekan Keamanan dan memastikan pengguna yang login adalah pemilik barang
        if ($item->user_id != Auth::id()) {
            // jika bukan pemilik, tolak dan kirim pesan error dalam menghapus
            return redirect()->route('barang')->with('error', 'Anda tidak berhak menghapus barang ini!');
        }

        if ($item->foto_item) {
            Storage::delete('public/' . $item->foto_item);
        }

        // aman, hapus barang
        $item->delete();

        // kembalikan ke halaman
        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus.');
    }
}