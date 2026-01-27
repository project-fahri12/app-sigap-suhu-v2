<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftar extends Model
{
    use LogsActivity;
    // app/Models/Pendaftar.php
    protected $fillable = [
        'kode_pendaftaran', 'tahun_ajaran_id', 'sekolah_id', 'pondok_id',
        'gelombang_ppdb_id', 'nama_lengkap', 'nik', 'nisn', 'nomor_kk',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'anak_ke',
        'jumlah_saudara', 'berkebutuhan_khusus', 'domisili_santri',
        'alamat_lengkap', 'rt', 'rw', 'provinsi', 'kabupaten',
        'kecamatan', 'desa', 'kode_pos', 'sekolah_asal',
        'npsn_sekolah', 'status_sekolah', 'status_pendaftaran',
    ];

    // Relasi ke Tahun Ajaran
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'pendaftaran_id');
    }

    public function informasiKontak()
    {
        return $this->hasOne(InformasiKontak::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPath::class, 'pendaftar_id', 'id');
    }

    public function gelombang()
    {
        return $this->belongsTo(GelombangPpdb::class);
    }

    public function daftarUlang()
    {
        // Pastikan nama tabel dan foreign key sesuai
        return $this->hasMany(DaftarUlang::class, 'pendaftar_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'pendaftar_id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
