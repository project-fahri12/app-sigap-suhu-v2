<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Pendaftar;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use App\Models\Romkam; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardAdminPondokController extends Controller
{
    public function index() {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;
        $pondokId = $user->pondok_id; 

        // 1. Ambil Tahun Ajaran Aktif
        $taAktif = TahunAjaran::where('is_aktif', true)->first();
        
        // 2. Data Ringkasan (Hanya milik sekolah ini)
        $totalSantri = Santri::where('sekolah_id', $pondokId)->count();
        $totalPendaftar = Pendaftar::where('sekolah_id', $pondokId)->count();
        
        // 3. Kapasitas Loker & Kamar (Berdasarkan total kapasitas di tabel Romkam)
        // Kita hitung total kapasitas dari semua romkam yang ada di pondok sekolah tersebut
        $totalKapasitasLoker = Romkam::where('pondok_id', $pondokId)->sum('kapasitas');
        $totalKamar = Romkam::where('pondok_id', $pondokId)->count();
        
        $lokerKosong = $totalKapasitasLoker - $totalSantri;

        // 4. Data Grafik (Pendaftar 6 bulan terakhir khusus sekolah ini)
        $months = [];
        $counts = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');
            $counts[] = Pendaftar::where('sekolah_id', $pondokId)
                                ->whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->count();
        }

        // 5. Data Monitoring Unit (Hanya menampilkan sekolah user tersebut)
        $units = Sekolah::where('id', $pondokId)
                        ->withCount(['santri' => function($query) use ($pondokId) {
                            $query->where('sekolah_id', $pondokId);
                        }])->get();

        return view('dashboard.admin-pondok.dashboard', compact(
            'totalSantri', 
            'totalPendaftar',
            'totalKamar', 
            'totalKapasitasLoker', 
            'lokerKosong',
            'months',
            'counts',
            'units',
            'taAktif'
        ));
    }
}