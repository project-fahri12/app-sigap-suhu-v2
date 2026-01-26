<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $fillable = [
        'pondok_id',
        'pendaftar_id',
        'sekolah_id',
        'romkam_id',
        'nis',
        'status_santri',
    ];

<<<<<<< HEAD
    public function romkam()
    {
        return $this->belongsTo(Romkam::class, 'romkam_id');
    }

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }

    public function sekolah() 
    {
        return $this->belongsTo(Sekolah::class,'sekolah_id');
    }

    
=======
    public function pendaftar()
{
    return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
}

public function romkam()
{
    return $this->belongsTo(Romkam::class, 'romkam_id');
}
>>>>>>> 2b7298b4caabe6b918d24deb5a98e188364485b5
}
