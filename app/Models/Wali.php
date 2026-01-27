<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wali extends Model
{
    use LogsActivity;

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
