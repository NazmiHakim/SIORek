<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Hash; // <-- TAMBAHKAN INI

class UserSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'username' => 'siorek',
            'password' => Hash::make('123'),
            'role'     => 'Admin'
        ]);

        User::create([
            'username' => 'Himpunan Mahasiswa Teknologi Informasi',
            'password' => Hash::make('HMTI123'),
            'role'     => 'User'
        ]);

        User::create([
            'username' => 'Erika123',
            'password' => Hash::make('Maulidya456'),
            'role'     => 'Admin'
        ]);
        
    }
}