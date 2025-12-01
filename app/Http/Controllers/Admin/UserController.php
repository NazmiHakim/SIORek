<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            // 'role'     => ['required', Rule::in(['admin', 'user'])],
            'nama_organisasi' => 'nullable|string|max:255',
            'program_studi'   => 'nullable|string|max:255',
            'fakultas'        => 'nullable|string|max:255',
            'nama_pj'         => 'nullable|string|max:255',
            'nomor_pj'        => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        $dataToStore = $validated;
        $dataToStore['password'] = Hash::make($validated['password']);
        $dataToStore['role'] = 'user'; // otomatis user

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logo_organisasi');
            $dataToStore['logo'] = str_replace('public/', '', $path);
        }

        $user = User::create($dataToStore);

        // notif wa dengan api fonte dan cek nomor pj
        if (!empty($user->nomor_pj)) {
            try {
                $message = "Halo *{$user->nama_pj}*,\n\n";
                $message .= "Akun SIORek Anda telah berhasil dibuat oleh Admin.\n\n";
                $message .= "Detail Akun:\n";
                $message .= "Username: {$user->username}\n";
                $message .= "Password: {$validated['password']}\n\n"; // pw asli bukan yang hash
                $message .= "Silakan login dan segera ganti password Anda demi keamanan.\n";
                $message .= "Terima kasih.";

                // request ke api fontenya
                $response = Http::withHeaders([
                    'Authorization' => 'X1qzkz3tqpx3n2UJrvk7', // Token WA
                ])->post('https://api.fonnte.com/send', [
                    'target' => $user->nomor_pj,
                    'message' => $message,
                    'countryCode' => '62',
                ]);

            } catch (\Exception $e) {}
        }

        return redirect()->route('daftarPenggunaAdmin')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username'        => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'role'            => ['required', Rule::in(['admin', 'user'])],
            'password'        => 'nullable|string|min:6|max:64', 
            
            'nama_organisasi' => 'nullable|string|max:100', 
            'program_studi'   => 'nullable|string|max:100', 
            'fakultas'        => 'nullable|string|max:100', 
            'nama_pj'         => 'nullable|string|max:100', 
            
            'nomor_pj'        => 'nullable|string|max:15|regex:/^[0-9]+$/',
            'alamat'          => 'nullable|string|max:255', 
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ], [
            'nomor_pj.regex' => 'Nomor Penanggung Jawab hanya boleh berisi angka.',
        ]);

        // cek validasi
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('edit_mode', true);
        }

        // ambil data yang sudah divalidasi
        $validated = $validator->validated();

        // update data
        $user->username = $validated['username'];
        $user->role = $validated['role'];
        $user->nama_organisasi = $validated['nama_organisasi'] ?? $user->nama_organisasi;
        $user->program_studi = $validated['program_studi'] ?? $user->program_studi;
        $user->fakultas = $validated['fakultas'] ?? $user->fakultas;
        $user->nama_pj = $validated['nama_pj'] ?? $user->nama_pj;
        $user->nomor_pj = $validated['nomor_pj'] ?? $user->nomor_pj;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

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