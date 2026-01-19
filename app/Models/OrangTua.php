<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tuas';
    protected $guarded = ['id'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftaran_id');
    }
}