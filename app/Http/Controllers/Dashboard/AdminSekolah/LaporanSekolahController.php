<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanSekolahController extends Controller
{
    public function index() {
        return view('dashboard.admin-sekolah.laporan-sekolah.index');
    }
}
