<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'kode_sekolah',
        'nama_sekolah',
        'keterangan',
        'jenjang',
        'is_aktif'
    ];
}
