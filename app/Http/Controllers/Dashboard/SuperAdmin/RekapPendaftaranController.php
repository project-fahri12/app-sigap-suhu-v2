<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Pondok;
use App\Models\Sekolah;

class RekapPendaftaranController extends Controller
{
    public function index()
    {
        // Statistik Pendaftar
        $stats = [
            'total' => Pendaftar::count(),
            'verifikasi' => Pendaftar::where('status_pendaftaran', '=', 'terverifikasi')->count(),
            'pending' => Pendaftar::where('status_pendaftaran', '=', 'pending')->count(),
        ];

        // Menghitung jumlah pendaftar per sekolah
        $rekapSekolah = Sekolah::withCount(['pendaftar'])->get(['id', 'nama']);

        // Menghitung jumlah santri per pondok
        $rekapPondok = Pondok::withCount(['santri'])->get(['id', 'nama']);

        return view(
            'dashboard.superadmin.rekap.index',
            compact('stats', 'rekapSekolah', 'rekapPondok')
        );
    }

    // Laporan Global
    public function rekapGlobal()
    {
        $statsSekolah = [
            'total'       => Sekolah::count(),
            'wajib'       => Sekolah::where('keterangan', 'wajib')->count(),
            'tidak_wajib' => Sekolah::where('keterangan', 'tidak_wajib')->count(),
            'aktif'       => Sekolah::where('is_aktif', 1)->count(),
        ];

        $statsPondok = [
            'total'    => Pondok::count(),
            'putra'    => Pondok::where('jenis', 'L')->count(),
            'putri'    => Pondok::where('jenis', 'P')->count(),
            'yayasan'  => Pondok::where('yayasan_mitra', 'Yayasan')->count(),
        ];

       
        $dataSekolah = Sekolah::latest()->get([
            'id', 
            'nama_sekolah', 
            'kode_sekolah', 
            'jenjang', 
            'keterangan', 
            'is_aktif'
        ]);

        return view('dashboard.superadmin.rekap.global', compact('statsSekolah', 'statsPondok', 'dataSekolah'));
    }
}
