<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlottingKamar extends Controller
{
    public function index() {
        return view('dashboard.admin-pondok.plotting-kamar.index');
    }
}
