<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    // Ganti email menjadi username
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', // Ganti 'name' dan 'email' dengan 'username' jika itu yang digunakan
        'password',
    ];
    
    // Tambahkan method untuk mengubah kolom autentikasi
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

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
            // Pastikan tidak ada 'email_verified_at' jika Anda tidak menggunakannya
            'password' => 'hashed',
        ];
    }
}