<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Asrama extends Model
{

use LogsActivity;

    protected $fillable = [
        'nama_asrama',
        'total_lemari',
        'jumlah_kamar',
        'status_asrama',
        'jk',
    ];

    public function romkams() {
        return $this->hasMany(Romkam::class, 'asrama_id');
    }
}
