<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarUlang extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pendaftar_id',
        'tagihan',
        'dibayar',
        'status_pembayaran',
        'keterangan'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }

    public function isLunas(): bool
    {
        return $this->status_pembayaran === 'lunas';
    }
}
