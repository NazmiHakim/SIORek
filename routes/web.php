<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DaftarPenggunaController; 
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\RiwayatPeminjamanController;

// Akses Publik
// Halaman utama (login)
Route::get('/', function () {
    return view('login');
})->name('login');

// Proses login
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Akses Login (terproteksi)
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Riwayat Peminjaman
    Route::get('/riwayat-peminjaman', function () {
        return view('riwayat-peminjaman');
    })->name('riwayat-peminjaman');

    // Daftar Pengguna (Yang akan Anda kerjakan)
    Route::get('/daftar-pengguna', [DaftarPenggunaController::class, 'index'])->name('daftar-pengguna');

    // CRUD
    Route::controller(ItemController::class)->group(function () {
        Route::get('/barang', 'index')->name('barang');
        Route::post('/barang', 'store')->name('barang.store');
        Route::get('/barang/{item}/edit', 'edit')->name('barang.edit');
        Route::put('/barang/{item}', 'update')->name('barang.update');
        Route::delete('/barang/{item}', 'destroy')->name('barang.destroy');
    });

});