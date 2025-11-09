<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facedes\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        ]);

        // siapkan data untuk disimpan
        $dataToStore = $validated;
        $dataToStore['user_id'] = Auth::id(); // Tambahkan ID pemilik barang

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

        // Validasi input
        $validated = $request->validate([
            'nama_item'    => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'jumlah_total' => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string',
        ]);

        // update data item di database
        $item->update($validated);

        // kembalikan ke halaman dengan pesan sukses
        return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        // pengecekan Keamanan dan memastikan pengguna yang login adalah pemilik barang
        if ($item->user_id != Auth::id()) {
            // jika bukan pemilik, tolak dan kirim pesan error dalam menghapus
            return redirect()->route('barang')->with('error', 'Anda tidak berhak menghapus barang ini!');
        }

        // aman, hapus barang
        $item->delete();

        // kembalikan ke halaman
        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus.');
    }
}