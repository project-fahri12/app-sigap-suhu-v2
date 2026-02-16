<?php

namespace App\Models;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'sekolah_id',
        'pondok_id',
        'pendaftar_id',
        'is_aktif',
        'nisn',
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
        return $this->belongsTo(Pondok::class, 'pondok_id');
    }

    public function pendaftar()
    {
        // Jika di tabel pendaftars kolomnya adalah user_id
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id', 'id');
    }

    // ================= HELPER ROLE =================

    public function isRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function getLabelAttribute()
    {
        if ($this->sekolah) {
            return $this->sekolah->nama_sekolah;
        }

        if ($this->role === 'super-admin') {
            return 'Super Admin';
        }

        if ($this->pondok) {
            return $this->pondok->nama_pondok;
        }

        return 'PENDAFTAR';
    }
}
