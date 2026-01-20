<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
protected $fillable = [
        'pendaftaran_id', 
        'nama_ayah', 'nik_ayah', 'pendidikan_terakhir_ayah', 'status_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'nama_ibu', 'nik_ibu', 'pendidikan_terakhir_ibu', 'status_ibu', 'pekerjaan_ibu', 'penghasilan_ibu'
    ];
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftaran_id');
    }
}