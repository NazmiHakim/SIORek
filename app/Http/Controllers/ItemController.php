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
        // mengambil id user yang sedang login
        $userId = Auth::id();

        // mengambil semua item database dari pengguna
        $items = Item::where('user_id', $userId)->get();

        // mengirim data item ke view
        return view('barang', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        // Pengecekan Keamanan (Sama seperti destroy)
        if ($item->user_id != Auth::id()) {
            return redirect()->route('barang')->with('error', 'Anda tidak berhak mengedit barang ini!');
        }

        // Tampilkan view dari edit-barang.blade dan mengirim data item
        return view('edit-barang', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item) // Perhatikan: 'Item $item'
    {
        // pengecekan Keamanan
        // memastikan pengguna yang login adalah pemilik barang
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