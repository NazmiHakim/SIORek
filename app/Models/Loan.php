<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'peminjam_id',
        'pemilik_id',
        'jumlah',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_pengembalian_aktual',
        'status',
        'foto_kim',
        'surat_peminjaman',
        'foto_kondisi_awal',
        'foto_kondisi_akhir',
        'alasan_penolakan',
        'keterangan_sanksi',
    ];

    
    // mendapatkan data item yang dipinjam
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    
    // mendapatkan data user yang meminjam
    public function peminjam(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    
    // mendapatkan data user dari item
    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }
}