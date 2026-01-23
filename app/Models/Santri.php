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

    public function romkam() {
        return $this->belongsTo(Romkam::class, 'romka_id');
    }

    public function pendaftar() {
        return $this->hasMany(pendaftar::class);
    }
}
