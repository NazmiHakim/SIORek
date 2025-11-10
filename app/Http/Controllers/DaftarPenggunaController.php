<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPenggunaController extends Controller
{
    
    public function index()
    {
        $currentUserId = Auth::id();

        // mengambil semua pengguna kecuali akun kita
        $users = User::where('id', '!=', $currentUserId)->get();

        // Tentukan status mana yang berarti barang "tidak tersedia"
        $activeStatuses = [
            'menunggu_persetujuan',
            'disetujui',
            'sedang_dipinjam',
            'menunggu_konfirmasi_pengembalian',
            'bermasalah'
        ];

        // mengambil semua barang kecuali milik akun kita dan menghitung pinjaman
        $items = Item::where('user_id', '!=', $currentUserId)
                     ->with('user')
                     ->withSum(['loans' => function ($query) use ($activeStatuses) {
                         $query->whereIn('status', $activeStatuses);}], 'jumlah')
                     ->get();

        // menghitung sisa stok disisi php
        foreach ($items as $item) {
            $item->jumlah_dipinjam = $item->loans_sum_jumlah ?? 0;
            $item->jumlah_tersedia = $item->jumlah_total - $item->jumlah_dipinjam;
        }

        // mengiririm kedua data keview
        return view('daftar-pengguna', [
            'users' => $users,
            'items' => $items,
        ]);
    }
}