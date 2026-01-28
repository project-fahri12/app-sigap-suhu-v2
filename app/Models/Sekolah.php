<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use LogsActivity;

    protected $fillable = [
        'kode_sekolah',
        'nama_sekolah',
        'keterangan',
        'jenjang',
        'is_aktif',
    ];

    public function gelombang()
    {
        // Menghubungkan Sekolah ke banyak Gelombang PPDB
        return $this->hasMany(GelombangPPDB::class, 'sekolah_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class, 'sekolah_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'sekolah_id', 'id');
    }

     public function santri()
    {
        return $this->hasMany(Santri::class, 'pondok_id', 'id');
    }

}
