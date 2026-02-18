<?php

namespace App\Http\Controllers\Dashboard\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Pendaftar;
use App\Models\Pondok;
use App\Models\GelombangPpdb; // sesuaikan dengan nama model kamu

class SekolahDanPondokController extends Controller
{
    public function index()
    {
        $pendaftar = auth()->user()->pendaftar;

    if (!$pendaftar) {
        abort(403, 'Data pendaftar tidak ditemukan.');
    }

        // Ambil gelombang sekolah yang aktif
        $pilihan_sekolah = GelombangPpdb::with('sekolah')
            ->where('is_aktif', 1)
            ->get();

        // Ambil pondok sesuai jenis kelamin pendaftar (L/P)
        $pilihan_pondok = Pondok::where('is_aktif', 1)
            ->where('jenis', $pendaftar->jenis_kelamin)
            ->get();

        return view(
            'dashboard.pendaftar.sekolah-dan-pondok',
            compact('pendaftar', 'pilihan_sekolah', 'pilihan_pondok')
        );
    }
}
