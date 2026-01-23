<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Romkam extends Model
{
    use HasFactory;

    protected $fillable = [
        'pondok_id',
        'nis',
        'nama_romkam',
        'kapasitas',
        'status_romkam',
        'asrama_id'
    ];

    public function asrama()
    {
        return $this->belongsTo(Asrama::class, 'asrama_id');
    }
}