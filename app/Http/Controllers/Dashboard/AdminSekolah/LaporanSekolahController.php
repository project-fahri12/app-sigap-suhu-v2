<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftar;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class LaporanSekolahController extends Controller
{
    public function index()
    {
        $sekolah_id = Auth::user()->sekolah_id;

        // Mengambil Tahun Ajaran yang sedang Aktif
        $tahunAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahun_id = $tahunAktif->id ?? 0;

        // 1. Total Pendaftar Tahun Ini
        $totalPendaftar = Pendaftar::where('sekolah_id', $sekolah_id)
            ->where('tahun_ajaran_id', $tahun_id)
            ->count();

        // 2. Daftar Ulang (Status Lunas)
        $lunasDaftarUlang = Pendaftar::where('sekolah_id', $sekolah_id)
            ->where('tahun_ajaran_id', $tahun_id)
            ->whereHas('daftarUlang', function ($q) {
                $q->where('status_pembayaran', 'lunas');
            })->count();

        // 3. Belum Verifikasi Berkas
        $belumVerifikasi = Pendaftar::where('sekolah_id', $sekolah_id)
            ->where('tahun_ajaran_id', $tahun_id)
            ->where('status_berkas', 'belum')
            ->count();

        // 4. Data Per Kelas (Gunakan count siswa dari pendaftar tahun aktif)
        $dataKelas = Kelas::where('sekolah_id', $sekolah_id)
            ->withCount([
                'siswa as laki_laki' => function ($q) use ($tahun_id) {
                    $q->whereHas('pendaftar', fn ($sq) => $sq->where('jenis_kelamin', 'L')->where('tahun_ajaran_id', $tahun_id));
                },
                'siswa as perempuan' => function ($q) use ($tahun_id) {
                    $q->whereHas('pendaftar', fn ($sq) => $sq->where('jenis_kelamin', 'P')->where('tahun_ajaran_id', $tahun_id));
                },
            ])->get();

        // 5. Data Chart (7 Hari Terakhir)
        $chartLabels = [];
        $chartDaftar = [];
        $chartLunas = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');

            // Query Pendaftar
            $chartDaftar[] = \App\Models\Pendaftar::where('sekolah_id', $sekolah_id)
                ->whereDate('created_at', $date)
                ->count();

            // PERBAIKAN DI SINI:
            // Gunakan Model DaftarUlang agar bisa menggunakan whereHas
            $chartLunas[] = \App\Models\DaftarUlang::whereHas('pendaftar', function ($q) use ($sekolah_id) {
                $q->where('sekolah_id', $sekolah_id);
            })
                ->where('status_pembayaran', 'lunas')
                ->whereDate('created_at', $date)
                ->count();
        }

        return view('dashboard.admin-sekolah.laporan-sekolah.index', compact(
            'totalPendaftar', 'lunasDaftarUlang', 'belumVerifikasi',
            'dataKelas', 'chartLabels', 'chartDaftar', 'chartLunas', 'tahunAktif'
        ));
    }
}
