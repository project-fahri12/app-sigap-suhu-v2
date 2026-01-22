<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataSiswaController extends Controller
{
    public function index(Request $request) 
    {
        // Ambil data untuk filter drop-down
        $listKelas = Kelas::all();
        $listRombel = Rombel::all();

        $query = Siswa::with(['pendaftar', 'kelas', 'rombel', 'pondok']);

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

        $siswas = $query->latest()->paginate(10)->withQueryString();

        return view("dashboard.admin-sekolah.data-siswa.index", compact('siswas', 'listKelas', 'listRombel'));
    }
}