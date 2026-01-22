<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = [
        'sekolah_id', 
        'kelas_id', 
        'nama_rombel', 
        'kapasitas', 
        'status_rombel',
        'jenis_kelas'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}