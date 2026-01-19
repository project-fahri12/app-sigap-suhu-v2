<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $fillable = ['nama', 'tahun_mulai', 'tahun_selesai', 'is_aktif'];

    // Relasi ke Pendaftar
    public function pendaftars(): HasMany
    {
        return $this->hasMany(Pendaftar::class, 'tahun_ajaran_id');
    }
}