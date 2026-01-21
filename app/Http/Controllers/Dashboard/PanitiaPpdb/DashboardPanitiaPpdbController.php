<?php

namespace App\Http\Controllers\Dashboard\PanitiaPpdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPanitiaPpdbController extends Controller
{
    public function index() {
        return view("dashboard.panitia-ppdb.dashboard");
    }
}
