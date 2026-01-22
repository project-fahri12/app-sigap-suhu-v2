<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    public function index(Request $request) 
{
    // 1. Ambil ID Sekolah user yang sedang login
    $sekolah_id = Auth::user()->sekolah_id;

    // 2. Filter data dropdown agar HANYA muncul kelas/rombel milik sekolah tersebut
    $listKelas = Kelas::where('sekolah_id', $sekolah_id)->get();
    $listRombel = Rombel::where('sekolah_id', $sekolah_id)->get();

    // 3. Query Siswa dengan pengaman sekolah_id
    // Pastikan query dasar sudah membatasi akses data
    $query = Siswa::with(['pendaftar', 'kelas', 'rombel', 'pondok'])
        ->whereHas('pendaftar', function($q) use ($sekolah_id) {
            $q->where('sekolah_id', $sekolah_id);
        });

    /** * Jika tabel 'siswas' Anda punya kolom sekolah_id langsung, 
     * gunakan: $query = Siswa::where('sekolah_id', $sekolah_id)...
     */

    // Fitur Pencarian (Nama atau NIS)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nis', 'like', "%{$search}%")
              ->orWhereHas('pendaftar', function($sq) use ($search) {
                  $sq->where('nama_lengkap', 'like', "%{$search}%");
              });
        });
    }

    // Fitur Filter
    if ($request->filled('kelas')) {
        $query->where('kelas_id', $request->kelas);
    }
    if ($request->filled('rombel')) {
        $query->where('rombel_id', $request->rombel);
    }
    if ($request->filled('status')) {
        $query->where('status_santri', $request->status);
    }

    // Ambil data dengan pagination
    $siswas = $query->latest()->paginate(10)->withQueryString();

    return view("dashboard.admin-sekolah.data-siswa.index", compact('siswas', 'listKelas', 'listRombel'));
}
}