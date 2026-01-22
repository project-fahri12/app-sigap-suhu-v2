<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'pendaftar_id', 
        'nis', 
        'kelas_id', 
        'rombel_id', 
        'pondok_id', 
        'status_santri'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pondok() 
    {
        return $this->belongsTo(Pondok::class);
    }
}