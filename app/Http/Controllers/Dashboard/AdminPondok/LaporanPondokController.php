<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Asrama;
use App\Models\Santri;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPondokController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        // 1. Statistik Utama
        $totalSantri = Santri::count();
        $totalKapasitas = \App\Models\Romkam::sum('kapasitas');
        $terisi = Santri::whereNotNull('romkam_id')->count();
        $sisaBedTotal = $totalKapasitas - $terisi;

        // 2. Data Grafik Distribusi Sekolah
        $rekapSekolah = Sekolah::withCount(['santri as siswa_count'])->get();

        // 3. Data Detail Asrama (Dinamis)
        $asramas = Asrama::with(['romkams'])->get()->map(function ($asrama) {
            $kapasitasGedung = $asrama->romkams->sum('kapasitas');

            // Hitung santri di asrama ini lewat relasi romkam
            $terisiGedung = Santri::whereHas('romkam', function ($q) use ($asrama) {
                $q->where('asrama_id', $asrama->id);
            })->count();

            return [
                'nama' => $asrama->nama_asrama,
                'jml_kamar' => $asrama->romkams->count(),
                'total_siswa' => $terisiGedung,
                'kapasitas' => $kapasitasGedung,
                'persen' => $kapasitasGedung > 0 ? round(($terisiGedung / $kapasitasGedung) * 100) : 0,
                'sisa' => $kapasitasGedung - $terisiGedung,
            ];
        });

        // 4. Data Santri Terbaru dengan Filter
        $santriTerbaru = Santri::with(['pendaftar', 'sekolah', 'romkam.asrama'])
            ->when($filter == 'd', fn ($q) => $q->whereDate('created_at', today()))
            ->when($filter == 'm', fn ($q) => $q->whereMonth('created_at', now()->month))
            ->when($filter == 'y', fn ($q) => $q->whereYear('created_at', now()->year))
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total' => $totalSantri,
            'verifikasi' => Santri::where('status_santri', 'Aktif')->count(),
            'pending' => Santri::where('status_santri', '!=', 'Aktif')->count(),
        ];

        // Query untuk Chart Tren (7 hari terakhir)
        $trenPendaftaran = Santri::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        // Kirim ke view
        return view('dashboard.admin-pondok.laporan.index', compact(
            'stats', 'totalKapasitas', 'sisaBedTotal',
            'rekapSekolah', 'asramas', 'trenPendaftaran', 'filter'
        ));
    }
}
