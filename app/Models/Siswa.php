<?php
namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use LogsActivity;
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
    public function siswa() {
    return $this->hasMany(Siswa::class, 'sekolah_id');
}
}