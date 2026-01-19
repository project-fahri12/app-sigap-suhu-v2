<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GelombangPpdb extends Model
{
    protected $table = 'gelombang_ppdb';

    protected $fillable = ['sekolah_id', 'tahun_ajaran_id', 'nama_gelombang', 'tanggal_buka', 'tanggal_tutup', 'kuota', 'is_aktif'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pendaftar()
    {
        return $this->hasMany(pendaftar::class);
    }

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class, 'gelombang_id');
    }

    public function getStatusPendaftaran()
    {
        $sekarang = now();

        if ($this->pendaftars_count >= $this->kuota) {
            return 'FULL';
        }

        if ($sekarang < $this->tanggal_buka) {
            return 'SEGERA';
        }

        if ($sekarang >= $this->tanggal_buka && $sekarang <= $this->tanggal_tutup) {
            return 'BUKA';
        }

        return 'TUTUP';
    }
}
