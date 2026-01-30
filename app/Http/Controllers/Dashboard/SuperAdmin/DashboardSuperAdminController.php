<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar; // Pastikan model ini ada
use App\Models\Sekolah; // Pastikan model ini ada
use App\Models\TahunAjaran;

class DashboardSuperAdminController extends Controller
{
    public function index()
    {
        $totalPendaftarGlobal = Pendaftar::count();

        $totalSekolah = Sekolah::count();

        $sekolahList = Sekolah::with(['gelombang' => function ($query) {
            $query->where('is_aktif', 1);
        }])->withCount('pendaftar')->get();

        $ta = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaran = $ta ? $ta->nama : '-';
        $semester = 'Ganjil';

        return view('dashboard.superadmin.dashboard', compact(
            'totalPendaftarGlobal',
            'totalSekolah',
            'sekolahList',
            'tahunAjaran',
            'semester'
        ));
    }
}
