<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarUlang extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'tagihan',
        'dibayar',
        'status_pembayaran',
        'keterangan'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftar_id');
    }

    public function isLunas(): bool
    {
        return $this->status_pembayaran === 'lunas';
    }
}
