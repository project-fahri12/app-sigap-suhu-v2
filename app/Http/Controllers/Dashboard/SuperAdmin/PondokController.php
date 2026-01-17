<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PondokController extends Controller
{
    public function index() {
        return view("dashboard.superadmin.pondok.index");
    }
}
