<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DaftarPenggunaController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatPeminjamanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

// halaman login
Route::get('/', function () {
    return view('login');
})->name('login');

// proses login
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// akses login yang terproteksi
Route::middleware('auth')->group(function () {

    // ;ogout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // riwayat peminjaman
    Route::get('/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index'])->name('riwayat-peminjaman');

    // daftar pengguna
    Route::get('/daftar-pengguna', [DaftarPenggunaController::class, 'index'])->name('daftar-pengguna');

    // CRUD
    Route::controller(ItemController::class)->group(function () {
        Route::get('/barang', 'index')->name('barang');
        Route::post('/barang', 'store')->name('barang.store');
        Route::get('/barang/{item}/edit', 'edit')->name('barang.edit');
        Route::put('/barang/{item}', 'update')->name('barang.update');
        Route::delete('/barang/{item}', 'destroy')->name('barang.destroy');
    });

    // peminjaman
    Route::post('/loan', [LoanController::class, 'store'])->name('loan.store');
    // persetujuan peminjaman
    Route::post('/loan/handle-permintaan/{loan}', [LoanController::class, 'handlePermintaan'])->name('loan.handlePermintaan');
    // konfirmasi pengambilan
    Route::post('/loan/konfirmasi-pengambilan/{loan}', [LoanController::class, 'konfirmasiPengambilan'])->name('loan.konfirmasiPengambilan');
    // mengajukan pengembalian
    Route::post('/loan/ajukan-pengembalian/{loan}', [LoanController::class, 'ajukanPengembalian'])->name('loan.ajukanPengembalian');
    // konfirmasi pengembalian
    Route::post('/loan/konfirmasi-pengembalian/{loan}', [LoanController::class, 'konfirmasiPengembalian'])->name('loan.konfirmasiPengembalian');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // rute daftar pengguna (admin)
    Route::get('/daftar-pengguna-admin', [AdminUserController::class, 'index'])
         ->name('daftarPenggunaAdmin');
    
    // rute rekap transaksi (admin)
    Route::get('/rekab-transaksi-admin', [AdminTransactionController::class, 'index'])
         ->name('rekabTransaksiAdmin');

    // rute untuk menyimpan pengguna baru
    Route::post('/admin/pengguna', [AdminUserController::class, 'store'])
         ->name('admin.pengguna.store');
    
    // rute memperbarui pengguna
    Route::put('/admin/pengguna/{user}', [AdminUserController::class, 'update'])
         ->name('admin.pengguna.update');
    
    // Rute delete pengguna
    Route::delete('/admin/pengguna/{user}', [AdminUserController::class, 'destroy'])
         ->name('admin.pengguna.destroy');

});