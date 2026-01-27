<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Santri extends Model
{
    // Mengatur kolom yang boleh diisi secara massal
    protected $fillable = [
        'pondok_id',
        'pendaftar_id',
        'sekolah_id',
        'romkam_id',
        'nis',
        'status_santri',
    ];

    /**
     * Relasi ke model Romkam (Rombongan Kamar)
     */
    public function romkam(): BelongsTo
    {
        return $this->belongsTo(Romkam::class, 'romkam_id');
    }

    /**
     * Relasi ke model Pendaftar
     */
    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }

    /**
     * Relasi ke model Sekolah
     */
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    /**
     * Relasi ke model Pondok (Tambahan jika diperlukan)
     */
    public function pondok(): BelongsTo
    {
        return $this->belongsTo(Pondok::class, 'pondok_id');
    }
}