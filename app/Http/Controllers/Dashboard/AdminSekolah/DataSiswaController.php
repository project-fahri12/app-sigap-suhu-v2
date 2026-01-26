<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    public function index(Request $request)
    {
        $sekolah_id = Auth::user()->sekolah_id;
        $listKelas = Kelas::where('sekolah_id', $sekolah_id)->get();
        $listRombel = Rombel::where('sekolah_id', $sekolah_id)->get();

        $query = Siswa::with(['pendaftar', 'kelas', 'rombel', 'pondok'])
            ->whereHas('pendaftar', function ($q) use ($sekolah_id) {
                $q->where('sekolah_id', $sekolah_id);
            });

        // Search & Filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nis', 'like', "%{$request->search}%")
                    ->orWhereHas('pendaftar', function ($sq) use ($request) {
                        $sq->where('nama_lengkap', 'like', "%{$request->search}%");
                    });
            });
        }
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

        if ($request->ajax()) {
            return view('dashboard.admin-sekolah.data-siswa._table', compact('siswas'))->render();
        }

        return view('dashboard.admin-sekolah.data-siswa.index', compact('siswas', 'listKelas', 'listRombel'));
    }
}
