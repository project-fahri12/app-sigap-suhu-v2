<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asrama extends Model
{
    protected $fillable = [
        'nama_asrama',
        'total_lemari',
        'jumlah_kamar',
        'status_asrama',
    ];

    public function romkas() {
        return $this->hasMany(Romkam::class, 'asrama_id');
    }
}
