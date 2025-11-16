<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // data login
        'username', 
        'password',
        'role',
        
        // profil
        'nama_organisasi',
        'program_studi',
        'fakultas',
        'nama_pj',
        'nomor_pj',
        'alamat',
        'logo',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    
    // mendapatkan semua item yang dimiliki pengguna ini
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'user_id');
    }

    
    // mendapatkan semua transaksi, user adalah peminjam barang
    public function loans_as_borrower(): HasMany
    {
        return $this->hasMany(Loan::class, 'peminjam_id');
    }

    
    //  mendapatkan semua transaksi, user adalah pemilik barang
    public function loans_as_owner(): HasMany
    {
        return $this->hasMany(Loan::class, 'pemilik_id');
    }
}