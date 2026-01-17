<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminPondok\DashboardAdminPondokController;
use App\Http\Controllers\Dashboard\AdminSekolah\DashboardAdminSekolahController;
use App\Http\Controllers\Dashboard\PanitiaPpdb\DashboardPanitiaPpdbController;
use App\Http\Controllers\Dashboard\SuperAdmin\DashboardSuperAdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\PondokController;
use App\Http\Controllers\Dashboard\SuperAdmin\SekolahController;
use App\Http\Controllers\Dashboard\SuperAdmin\TahunAjaranController;
use App\Http\Controllers\Dashboard\SuperAdmin\UserManajemenController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

//Route Public 
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/regist', [HomeController::class,'regist'])->name('regist');

//Auth
Route::get('auth/pendaftar', [AuthController::class,'authpendaftar'])->name('auth.pendaftar');
Route::get('auth/admin', [AuthController::class,'authadmin'])->name('auth.admin');

// daashboard 

Route::prefix('admin')->group(function () {
    
    // Super Admin
    Route::prefix('super')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardSuperAdminController::class, 'index'])->name('dashboard');
        Route::resource('/tahun-ajaran', TahunAjaranController::class)->only(['index']);
        Route::resource('/sekolah', SekolahController::class)->only(['index']);
        Route::resource('/pondok', PondokController::class)->only(['index']);
        Route::resource('/manajemen-user', UserManajemenController::class);
    });

    // Admin Sekolah
    Route::prefix('sekolah')->name('adminsekolah.')->group(function () {
        Route::get('/dashboard', [DashboardAdminSekolahController::class, 'index'])->name('dashboard');
    });

    // Admin Pondok
    Route::prefix('pondok')->name('adminpondok.')->group(function () {
        Route::get('/dashboard', [DashboardAdminPondokController::class, 'index'])->name('dashboard');
    });

    // Panitia PPDB
    Route::prefix('panitia')->name('panitia.')->group(function () {
        Route::get('/dashboard', [DashboardPanitiaPpdbController::class, 'index'])->name('dashboard');
    });
});


