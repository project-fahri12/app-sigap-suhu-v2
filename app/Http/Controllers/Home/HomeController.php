<?php

namespace App\Http\Controllers\Home;

use App\Models\Sekolah;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua sekolah/lembaga beserta gelombang yang aktif/terbaru
        $lembagas = Sekolah::with(['gelombang' => function ($query) {
            $query->where('is_aktif', 1)
                ->withCount('pendaftar'); 
        }])->get();

        return view('home', compact('lembagas'));
    }

    public function regist()
    {
        return view('regist.index');
    }
}
