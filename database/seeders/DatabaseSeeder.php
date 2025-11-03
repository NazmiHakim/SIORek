<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder utama aplikasi.
     */
    public function run(): void
    {
        // Panggil seeder UserSeeder
        $this->call([
            UserSeeder::class,
        ]);
    }
}
