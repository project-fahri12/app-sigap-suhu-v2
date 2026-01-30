<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use LogsActivity;
    protected $fillable = ['sekolah_id', 'nama_kelas'];

    public function rombels()
    {
        return $this->hasMany(Rombel::class);
    }

    public function siswa() 
    {
        return $this->hasMany(Siswa::class);
    }
}