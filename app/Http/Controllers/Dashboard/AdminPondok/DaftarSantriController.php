<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarSantriController extends Controller
{
    public function index() {
        return view('dashboard.admin-pondok.daftar-santri.index');
    }
}
