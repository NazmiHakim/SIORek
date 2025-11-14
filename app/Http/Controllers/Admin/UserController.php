<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // mengambil semua data pengguna
        $users = User::all(); 

        // mengirim ke view
        return view('daftar-pengguna-admin', [
            'users' => $users
        ]);
    }

    // buat dan simpan akun baruu
    public function store(Request $request)
    {
        // validasi input form
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in(['admin', 'user'])],
        ]);

        // buat pengguna baru
        User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // suksess
        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }


    public function update(Request $request, User $user)
    {
        
        // validasi input
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', Rule::in(['admin', 'user'])],
            'password' => 'nullable|string|min:6'
        ]);

        $user->username = $validated['username'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {   
        // tidak bisa hapus akun sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('daftarPenggunaAdmin')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        
        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Pengguna berhasil dihapus.');
    }
}