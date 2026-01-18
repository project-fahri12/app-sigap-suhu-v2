<?php

namespace App\Models;

use App\Models\UserSekolah;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    // SEKOLAH (langsung)
    public function sekolah()
    {
        return $this->belongsToMany(Sekolah::class, 'user_sekolah');
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
}
