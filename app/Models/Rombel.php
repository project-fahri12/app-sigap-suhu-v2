<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use LogsActivity;
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