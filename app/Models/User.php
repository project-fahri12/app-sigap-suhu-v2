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

    /* ================= RELATIONS ================= */

    // role user (via pivot model)
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',
            'user_id',
            'role_id'
        );
    }

    // sekolah yang diakses user
    public function userSekolah()
    {
        return $this->hasMany(UserSekolah::class, 'user_id');
    }

    // pondok yang diakses user
    public function userPondoks()
    {
        return $this->hasMany(UserPondok::class, 'user_id');
    }
}
