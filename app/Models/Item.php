<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_item',
        'kategori',
        'deskripsi',
        'jumlah_total',
        'foto_item',
    ];

    // mendapatkan data user (kepemilikan) dari item.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function getJumlahTersedia()
    {
        // status barang
        $activeStatuses = [
            'menunggu_persetujuan',
            'disetujui',
            'sedang_dipinjam',
            'menunggu_konfirmasi_pengembalian',
            'bermasalah'
        ];

        // menghitung barang yang sedang aktif
        $jumlahDipinjam = $this->loans()
                               ->whereIn('status', $activeStatuses)
                               ->sum('jumlah');

        // stok tersedia = total - yang dipinjam
        return $this->jumlah_total - $jumlahDipinjam;
    }
}