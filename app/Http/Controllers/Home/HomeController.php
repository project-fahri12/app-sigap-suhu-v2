<?php

namespace App\Http\Controllers\Home;

use App\Models\Sekolah;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $lembagas = Sekolah::with([
            'gelombang' => function ($query) {
                $query->where('is_aktif', 1)
                    ->latest()
                    ->withCount('pendaftar');
            }
        ])->get();

        return view('home', compact('lembagas'));
    }


    public function regist()
    {
        return view('regist.index');
    }
}
