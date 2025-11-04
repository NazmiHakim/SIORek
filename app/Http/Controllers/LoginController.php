<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Menangani upaya autentikasi.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Tentukan field autentikasi (WAJIB DILAKUKAN)
        // Array yang diserahkan ke Auth::attempt akan mencari field 
        // yang cocok dengan kolom di tabel users (username dan password)
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            
            // Regenerasi sesi untuk mencegah serangan fiksasi sesi
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('username');
    }

    // ... (method logout tidak perlu diubah)
}