<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            // foreig key
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('peminjam_id')->constrained('users')->onDelete('cascade'); // Siapa yang meminjam
            $table->foreignId('pemilik_id')->constrained('users')->onDelete('cascade'); // Siapa pemilik barang

            // detail peminjaman barang
            $table->integer('jumlah');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_pengembalian_aktual')->nullable(); 

            // status peminjaman barang
            $table->string('status')->default('menunggu_persetujuan');

            // dokumen yang di upload
            $table->string('foto_kim')->nullable(); 
            $table->string('surat_peminjaman')->nullable(); 
            $table->string('foto_kondisi_awal')->nullable(); 
            $table->string('foto_kondisi_akhir')->nullable(); 

            // respom pemilik
            $table->text('alasan_penolakan')->nullable(); 
            $table->text('keterangan_sanksi')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};