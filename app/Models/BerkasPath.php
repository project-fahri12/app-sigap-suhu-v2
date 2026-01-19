<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPath extends Model
{
    protected $table = 'berkas_paths';
    protected $guarded = ['id'];

    public function pendaftar() {
        return $this->belongsTo(Pendaftar::class);
    }
}