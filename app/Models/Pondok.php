<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pondok extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pondok',
        'nama_pondok',
        'yayasan_mitra',
        'jenis',
        'pengasuh',
        'is_aktif',
    ];

    
    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_pondok', 'pondok_id', 'user_id');
    }
}