<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminSekolahController extends Controller
{
    public function index() 
{
    $sekolah_id = Auth::user()->sekolah_id;

    $stats = [
        'pendaftar'   => Pendaftar::where('sekolah_id', $sekolah_id)->count(),
        'siswa_aktif' => Siswa::whereHas('pendaftar', function($q) use ($sekolah_id) {
                            $q->where('sekolah_id', $sekolah_id);
                         })->where('status_santri', 'Aktif')->count(),
        'alumni'      => Siswa::whereHas('pendaftar', function($q) use ($sekolah_id) {
                            $q->where('sekolah_id', $sekolah_id);
                         })->where('status_santri', 'Alumni')->count(),
    ];

    // Ambil 100 data terbaru untuk antrian verifikasi
    $antrian = Pendaftar::where('sekolah_id', $sekolah_id)
                ->where('status_berkas', 'pending')
                ->latest()
                ->limit(100)
                ->get();

    return view('dashboard.admin-sekolah.dashboard', compact('stats', 'antrian'));
}
}