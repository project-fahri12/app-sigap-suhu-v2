<?php

namespace App\Http\Controllers\Dashboard\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index() {
        return view("dashboard.pendaftar.panduan");
    }
}
