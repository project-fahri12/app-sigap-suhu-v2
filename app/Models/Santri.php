<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $fillable = [
        'pondok_id',
        'pendaftar_id',
        'sekolah_id',
        'romkam_id',
        'nis',
        'status_santri',
    ];

    // =====================
    // RELATIONS
    // =====================

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function romkam()
    {
        return $this->belongsTo(Romkam::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function pondok()
    {
        return $this->belongsTo(Pondok::class);
    }
}
