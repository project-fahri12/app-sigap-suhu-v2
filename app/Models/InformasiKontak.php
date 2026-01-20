<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiKontak extends Model
{
    protected $table = 'informasi_kontaks';

    protected $fillable = [
        'pendaftar_id',
        'no_hp_ayah', 'no_hp_ibu', 'no_hp_wali', 'no_wa', 'email',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
