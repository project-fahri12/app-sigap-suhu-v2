<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminPondok\DashboardAdminPondokController;
use App\Http\Controllers\Dashboard\AdminSekolah\DashboardAdminSekolahController;
use App\Http\Controllers\Dashboard\PanitiaPpdb\DashboardPanitiaPpdbController;
use App\Http\Controllers\Dashboard\SuperAdmin\DashboardSuperAdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\RoleController;
use App\Http\Controllers\Dashboard\SuperAdmin\PondokController;
use App\Http\Controllers\Dashboard\SuperAdmin\SekolahController;
use App\Http\Controllers\Dashboard\SuperAdmin\TahunAjaranController;
use App\Http\Controllers\Dashboard\SuperAdmin\UserManajemenController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

//Route Public 
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/regist', [HomeController::class, 'regist'])->name('regist');

//Auth
Route::get('auth/pendaftar', [AuthController::class, 'authpendaftar'])->name('auth.pendaftar');
Route::get('auth/admin', [AuthController::class, 'authadmin'])->name('auth.admin');
//Auth Post (Simpan ini di luar group admin)
Route::post('auth/admin', [AuthController::class, 'storeAdmin'])->name('auth.admin.store');

// Dashboard Group dengan Proteksi
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Super Admin (Hanya bisa diakses role 'superadmin')
    Route::middleware(['role:super-admin'])->prefix('super')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardSuperAdminController::class, 'index'])->name('dashboard');
        Route::resource('/tahun-ajaran', TahunAjaranController::class)->only(['index']);
        Route::resource('/sekolah', SekolahController::class)->only(['index', 'update', 'destroy', 'store']);
        Route::resource('/pondok', PondokController::class)->only(['index', 'destroy', 'update', 'store']);
        Route::patch('pondok/{id}/toggle', [PondokController::class, 'toggleStatus'])->name('pondok.toggle');
        Route::resource('/manajemen-user', UserManajemenController::class);
        Route::patch('/manajemen-user/{id}/toggle', [UserManajemenController::class, 'toggle'])->name('manajemen-user.toggle');
        Route::resource('role', RoleController::class);
    });

    // Admin Sekolah (Hanya bisa diakses role 'admin_sekolah')
    Route::middleware(['role:admin-sekolah'])->prefix('sekolah')->name('adminsekolah.')->group(function () {
        Route::get('/dashboard', [DashboardAdminSekolahController::class, 'index'])->name('dashboard');
    });

    // Admin Pondok (Hanya bisa diakses role 'admin_pondok')
    Route::middleware(['role:admin-pondok'])->prefix('pondok')->name('adminpondok.')->group(function () {
        Route::get('/dashboard', [DashboardAdminPondokController::class, 'index'])->name('dashboard');
    });

    // Panitia PPDB (Hanya bisa diakses role 'panitia')
    Route::middleware(['role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
        Route::get('/dashboard', [DashboardPanitiaPpdbController::class, 'index'])->name('dashboard');
    });
});


