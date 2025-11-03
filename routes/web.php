<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; // Impor Controller yang baru

// Route GET untuk menampilkan form login (halaman utama)
Route::get('/', function () {
    return view('login');
})->name('login');

// Route POST untuk memproses login
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Kumpulan route yang memerlukan autentikasi ('auth' middleware)
Route::middleware('auth')->group(function () {
    
    // Route Dashboard setelah login berhasil
    Route::get('/home', function () {
        // Anda harus membuat file view 'home.blade.php'
        return view('home'); 
    })->name('home');

    // Route Logout (disarankan menggunakan POST)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});