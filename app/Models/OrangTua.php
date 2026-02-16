<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use LogsActivity;
    protected $fillable = [
        'pendaftar_id',
        'nama_ayah', 'nik_ayah', 'pendidikan_terakhir_ayah', 'status_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'nama_ibu', 'nik_ibu', 'pendidikan_terakhir_ibu', 'status_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftaran_id');
    }
}
