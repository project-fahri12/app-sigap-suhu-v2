<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftar extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Tahun Ajaran
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'pendaftaran_id');
    }

    public function informasiKontak() {
        return $this->hasOne(InformasiKontak::class);
    }

    public function berkas() {
        return $this->hasMany(BerkasPath::class);
    }
}