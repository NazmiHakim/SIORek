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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel users untuk menandakan siapa pemilik item
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('nama_item');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_total');
            $table->string('foto_item')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};