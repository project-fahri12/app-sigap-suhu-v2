<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['sekolah_id', 'nama_kelas'];

    public function rombels()
    {
        return $this->hasMany(Rombel::class);
    }
}