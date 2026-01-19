<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiKontak extends Model
{
    protected $table = 'informasi_kontaks';
    protected $guarded = ['id'];

    public function pendaftar() {
        return $this->belongsTo(Pendaftar::class);
    }
}