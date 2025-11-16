<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // mengambil semua akun pengguna
        $allUsers = User::all();

        // untuk rektorak atau admin
        $rektoratUsers = $allUsers->where('role', 'admin');
        
        // himpunan
        $himpunanUsers = $allUsers->where('role', 'user')->whereNotNull('program_studi');

        // organisasi
        $organisasiUsers = $allUsers->where('role', 'user')->whereNull('program_studi');

        // kirim ke view
        return view('daftar-pengguna-admin', [
            'rektoratUsers' => $rektoratUsers,
            'himpunanUsers' => $himpunanUsers,
            'organisasiUsers' => $organisasiUsers
        ]);
    }

    public function store(Request $request)
    {
        // validasi akun
        $validated = $request->validate([
            // data untukn login
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in(['admin', 'user'])],
            
            // profil
            'nama_organisasi' => 'nullable|string|max:255',
            'program_studi'   => 'nullable|string|max:255',
            'fakultas'        => 'nullable|string|max:255',
            'nama_pj'         => 'nullable|string|max:255',
            'nomor_pj'        => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048'
        ]);

        // data siap akan disimpan
        $dataToStore = $validated;
        
        // pass hash
        $dataToStore['password'] = Hash::make($validated['password']);

        // logonya
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logo_organisasi');
            $dataToStore['logo'] = str_replace('public/', '', $path);
        }

        // buat akun
        User::create($dataToStore);

        // balik ke halaman/sukses
        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', Rule::in(['Admin', 'User'])],
            'password' => 'nullable|string|min:6',
            
            'nama_organisasi' => 'nullable|string|max:255',
            'program_studi'   => 'nullable|string|max:255',
            'fakultas'        => 'nullable|string|max:255',
            'nama_pj'         => 'nullable|string|max:255',
            'nomor_pj'        => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $user->username = $validated['username'];
        $user->role = $validated['role'];
        $user->nama_organisasi = $validated['nama_organisasi'];
        $user->program_studi = $validated['program_studi'];
        $user->fakultas = $validated['fakultas'];
        $user->nama_pj = $validated['nama_pj'];
        $user->nomor_pj = $validated['nomor_pj'];
        $user->alamat = $validated['alamat'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('logo')) {
            if ($user->logo) {
                Storage::delete('public/' . $user->logo);
            }
            $path = $request->file('logo')->store('public/logo_organisasi');
            $user->logo = str_replace('public/', '', $path);
        }

        // simpan
        $user->save();

        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('daftarPenggunaAdmin')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->logo) {
            Storage::delete('public/' . $user->logo);
        }

        $user->delete();
        
        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Pengguna berhasil dihapus.');
    }
}