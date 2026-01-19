<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_aktif' => 'boolean',
    ];

    /* Relasi */

    // ROLE
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    // SEKOLAH (langsung)
    public function userSekolah()
    {
        return $this->hasOne(UserSekolah::class, 'user_id');
    }

    // PONDOK (langsung)
    public function pondok()
    {
        return $this->belongsToMany(
            Pondok::class,
            'user_pondoks'
        );
    }

    // helper untuk chek role dicntroler
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    // Helper Accessor untuk mendapatkan sekolah_id
    public function getSekolahIdAttribute()
    {
        // Memanggil relasi userSekolah lalu mengambil property sekolah_id
        return $this->userSekolah ? $this->userSekolah->sekolah_id : null;
    }
}
