<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wali extends Model
{
    // Primary key ID biasa (Auto-increment)
    protected $primaryKey = 'id';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'pendaftar_id',
        'nama_wali',
        'nik_wali',
        'hubungan',
        'pendidikan_terakhir',
        'pekerjaan_wali',
        'penghasilan_wali',
        'alamat_lengkap',
    ];

    /**
     * Relasi: Wali milik satu Pendaftar.
     */
    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}