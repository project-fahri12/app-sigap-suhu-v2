<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    use LogsActivity;
    protected $fillable = ['nama', 'tahun_mulai', 'tahun_selesai', 'is_aktif'];

    // Relasi ke Pendaftar
    public function pendaftars(): HasMany
    {
        return $this->hasMany(Pendaftar::class, 'tahun_ajaran_id');
    }
}