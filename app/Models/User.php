<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'sekolah_id',
        'pondok_id',
        'pendaftar_id',
        'is_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ================= RELASI =================

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function pondok() 
    {
        return $this->belongsTo(Pondok::class,'pondok_id');
    }

    public function pendaftar()
{
    // Jika di tabel pendaftars kolomnya adalah user_id
    return $this->hasOne(Pendaftar::class, 'pendaftar_id', 'id');
}

    // ================= HELPER ROLE =================

    public function isRole(string $role): bool
    {
        return $this->role === $role;
    }
}
