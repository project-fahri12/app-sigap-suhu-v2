<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminPondok\DashboardAdminPondokController;
use App\Http\Controllers\Dashboard\AdminPondok\AsramaController;
use App\Http\Controllers\Dashboard\AdminPondok\DaftarSantriController;
use App\Http\Controllers\Dashboard\AdminPondok\AktivasiSantri;
use App\Http\Controllers\Dashboard\AdminPondok\PlottingKamar;
use App\Http\Controllers\Dashboard\AdminSekolah\DataSiswaController;
use App\Http\Controllers\Dashboard\AdminSekolah\GelombangPpdbController;
use App\Http\Controllers\Dashboard\AdminSekolah\KelasController;
use App\Http\Controllers\Dashboard\AdminSekolah\RombelController;
use App\Http\Controllers\Dashboard\AdminSekolah\PenempatanRombelController;
use App\Http\Controllers\Dashboard\AdminSekolah\VerifikasiBerkasController;
use App\Http\Controllers\Dashboard\PanitiaPpdb\DashboardPanitiaPpdbController;
use App\Http\Controllers\Dashboard\Pendaftar\PanduanController;
use App\Http\Controllers\Dashboard\Pendaftar\UploadBerkasController;
use App\Http\Controllers\Dashboard\SuperAdmin\DaftarUlangController;
use App\Http\Controllers\Dashboard\SuperAdmin\DashboardSuperAdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\PondokController;
use App\Http\Controllers\Dashboard\SuperAdmin\SekolahController;
use App\Http\Controllers\Dashboard\SuperAdmin\TahunAjaranController;
use App\Http\Controllers\Dashboard\SuperAdmin\UserManajemenController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

// Route Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/regist', [HomeController::class, 'regist'])->name('regist');
Route::post('/regist', [HomeController::class, 'registStore'])->name('regist.store');
// Route untuk menampilkan halaman sukses pendaftaran
Route::get('/pendaftaran/success/{kode}', [HomeController::class, 'registSuccess'])->name('pendaftaran.success');

// Auth
Route::get('auth/pendaftar', [AuthController::class, 'authpendaftar'])->name('auth.pendaftar');
Route::post('/login-pendaftar', [AuthController::class, 'storePendaftar'])->name('pendaftar.login.submit');
Route::get('auth/admin', [AuthController::class, 'authadmin'])->name('auth.admin');
Route::post('auth/admin', [AuthController::class, 'storeAdmin'])->name('auth.admin.store');

// Dashboard Group dengan Proteksi
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Super Admin (Hanya bisa diakses role 'superadmin')
    Route::middleware(['role:super-admin'])->prefix('super')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardSuperAdminController::class, 'index'])->name('dashboard');
        Route::resource('/tahun-ajaran', TahunAjaranController::class)->only(['index', 'store', 'destroy', 'update']);
        Route::resource('/sekolah', SekolahController::class)->only(['index', 'update', 'destroy', 'store']);
        Route::resource('/pondok', PondokController::class)->only(['index', 'destroy', 'update', 'store']);
        Route::patch('pondok/{id}/toggle', [PondokController::class, 'toggleStatus'])->name('pondok.toggle');
        Route::resource('/manajemen-user', UserManajemenController::class);
        Route::patch('/manajemen-user/{id}/toggle', [UserManajemenController::class, 'toggle'])->name('manajemen-user.toggle');
        Route::resource('daftar-ulang', DaftarUlangController::class);
    });

    // Admin Sekolah (Hanya bisa diakses role 'admin_sekolah')
    Route::middleware(['role:admin-sekolah'])->prefix('sekolah')->name('adminsekolah.')->group(function () {
        Route::get('/dashboard', [DashboardAdminSekolahController::class, 'index'])->name('dashboard');
        Route::resource('gelombang-ppdb', GelombangPpdbController::class);
        Route::get('verifikasi-berkas', [VerifikasiBerkasController::class, 'index'])->name('verifikasi-berkas.index');
        Route::patch('verifikasi-berkas/update-item/{id}', [VerifikasiBerkasController::class, 'updateItem'])->name('verifikasi-berkas.update-item');
        Route::put('verifikasi-berkas/final/{id}', [VerifikasiBerkasController::class, 'updateFinal'])->name('verifikasi-berkas.final');
        Route::resource('data-siswa', DataSiswaController::class);
        Route::resource('kelola-rombel', RombelController::class);
        Route::resource('kelola-kelas', KelasController::class);
        Route::resource('penempatan-rombel', PenempatanRombelController::class);

    });

    // Admin Pondok (Hanya bisa diakses role 'admin_pondok')
    Route::middleware(['role:admin-pondok'])->prefix('pondok')->name('adminpondok.')->group(function () {
        Route::get('/dashboard', [DashboardAdminPondokController::class, 'index'])->name('dashboard');
        Route::resource('asrama', AsramaController::class);
        Route::resource('daftar-santri', DaftarSantriController::class);
        Route::resource('aktifasi-santri', AktivasiSantri::class);
        Route::resource('plotting-kamar', PlottingKamar::class);
    });

});

// route Dashboad untuk pendaftar

Route::middleware(['role:pendaftar', 'auth'])->prefix('pendaftar')->name('pendaftar.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logoutPendaftar'])->name('logout');

    Route::resource('/panduan', PanduanController::class);
    Route::resource('/upload-berkas', UploadBerkasController::class);
});
