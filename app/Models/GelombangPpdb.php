<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class GelombangPPDB extends Model
{
    use LogsActivity;
    protected $table = 'gelombang_ppdbs';

    protected $fillable = [
        'sekolah_id',
        'tahun_ajaran_id',
        'nama_gelombang',
        'tanggal_buka',
        'tanggal_tutup',
        'kuota',
        'is_aktif',
    ];

    /* ================= RELASI ================= */

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class, 'gelombang_ppdb_id');
    }

    public function getStatusPendaftaranAttribute()
    {
        if ($this->is_aktif == 1) {
            return 'BUKA';
        }

        return 'TUTUP';
    }

}
