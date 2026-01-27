<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Romkam extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pondok_id',
        'nis',
        'nama_romkam',
        'kapasitas',
        'status_romkam',
        'asrama_id',
        'jk',
    ];

    public function asrama()
    {
        return $this->belongsTo(Asrama::class, 'asrama_id');
    }

    public function santri()
    {
        return $this->hasMany(Santri::class, 'romkam_id');
    }
}
