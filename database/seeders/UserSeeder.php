<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Siorek',
            'password' => Hash::make('123'),
            'role'     => 'admin',
        ]);

        User::create([
            'username' => 'HMTI',
            'password' => Hash::make('HMTI123'),
            'role'     => 'user',
            
            // profil
            'nama_organisasi' => 'Himpunan Mahasiswa Teknologi Informasi',
            'program_studi'   => 'Teknologi Informasi',
            'fakultas'        => 'Teknik',
            'nama_pj'         => 'Muhammad Ibnu Sina',
            'nomor_pj'        => '08123456789'
        ]);

        User::create([
            'username' => 'Erika123',
            'password' => Hash::make('Maulidya456'),
            'role'     => 'admin',
        ]);
        
    }
}