<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSuperAdminController extends Controller
{
    public function index() {
        return view("dashboard.superadmin.dashboard");
    }
}
