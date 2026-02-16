<?php

namespace App\Http\Controllers\Dashboard\Pendaftar;

use App\Http\Controllers\Controller;

class DashboardPendaftar extends Controller
{
    public function index()
    {
        return view('dashboard.pendaftar.index');
    }
}
