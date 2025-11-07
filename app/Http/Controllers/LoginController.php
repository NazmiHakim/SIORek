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
        // validasi
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}