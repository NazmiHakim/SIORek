<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM(
            'menunggu_persetujuan',
            'disetujui',
            'menunggu_konfirmasi_pemilik',
            'sedang_dipinjam',
            'menunggu_konfirmasi_pengembalian',
            'selesai',
            'ditolak',
            'bermasalah'
        ) NOT NULL DEFAULT 'menunggu_persetujuan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
