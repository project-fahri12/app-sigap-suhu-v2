<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminPondok\AktivasiSantri;
use App\Http\Controllers\Dashboard\AdminPondok\AsramaController;
use App\Http\Controllers\Dashboard\AdminPondok\DaftarSantriController;
use App\Http\Controllers\Dashboard\AdminPondok\DashboardAdminPondokController;
use App\Http\Controllers\Dashboard\AdminPondok\LaporanPondokController;
use App\Http\Controllers\Dashboard\AdminPondok\LogPindahKamarController;
use App\Http\Controllers\Dashboard\AdminPondok\PlottingKamar;
use App\Http\Controllers\Dashboard\AdminPondok\RomkamController;
use App\Http\Controllers\Dashboard\AdminSekolah\DashboardAdminSekolahController;
use App\Http\Controllers\Dashboard\AdminSekolah\DataSiswaController;
use App\Http\Controllers\Dashboard\AdminSekolah\GelombangPpdbController;
use App\Http\Controllers\Dashboard\AdminSekolah\KelasController;
use App\Http\Controllers\Dashboard\AdminSekolah\LaporanSekolahController;
use App\Http\Controllers\Dashboard\AdminSekolah\PenempatanRombelController;
use App\Http\Controllers\Dashboard\AdminSekolah\RombelController;
use App\Http\Controllers\Dashboard\AdminSekolah\VerifikasiBerkasController;
use App\Http\Controllers\Dashboard\Pendaftar\PanduanController;
use App\Http\Controllers\Dashboard\Pendaftar\UploadBerkasController;
use App\Http\Controllers\Dashboard\SuperAdmin\AuditLogController;
use App\Http\Controllers\Dashboard\SuperAdmin\DaftarUlangController;
use App\Http\Controllers\Dashboard\SuperAdmin\DashboardSuperAdminController;
use App\Http\Controllers\Dashboard\SuperAdmin\PondokController;
use App\Http\Controllers\Dashboard\SuperAdmin\RekapPendaftaranController;
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
    // Super Admin (Hanya bisa diakses role 'superadmin')
    Route::middleware(['role:super-admin'])->prefix('super')->name('superadmin.')->group(function () {

        Route::get('/dashboard', [DashboardSuperAdminController::class, 'index'])->name('dashboard');

        // --- Tahun Ajaran ---
        Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
        Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
        Route::put('/tahun-ajaran/{id}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
        Route::delete('/tahun-ajaran/{id}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');

        // --- Sekolah ---
        Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::put('/sekolah/{id}', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::delete('/sekolah/{id}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');

        // --- Pondok ---
        Route::get('/pondok', [PondokController::class, 'index'])->name('pondok.index');
        Route::post('/pondok', [PondokController::class, 'store'])->name('pondok.store');
        Route::put('/pondok/{id}', [PondokController::class, 'update'])->name('pondok.update');
        Route::delete('/pondok/{id}', [PondokController::class, 'destroy'])->name('pondok.destroy');
        Route::patch('/pondok/{id}/toggle', [PondokController::class, 'toggleStatus'])->name('pondok.toggle');

        // --- Manajemen User ---
        Route::get('/manajemen-user', [UserManajemenController::class, 'index'])->name('manajemen-user.index');
        Route::get('/manajemen-user/create', [UserManajemenController::class, 'create'])->name('manajemen-user.create');
        Route::post('/manajemen-user', [UserManajemenController::class, 'store'])->name('manajemen-user.store');
        Route::get('/manajemen-user/{id}', [UserManajemenController::class, 'show'])->name('manajemen-user.show');
        Route::get('/manajemen-user/{id}/edit', [UserManajemenController::class, 'edit'])->name('manajemen-user.edit');
        Route::put('/manajemen-user/{id}', [UserManajemenController::class, 'update'])->name('manajemen-user.update');
        Route::delete('/manajemen-user/{id}', [UserManajemenController::class, 'destroy'])->name('manajemen-user.destroy');
        Route::patch('/manajemen-user/{id}/toggle', [UserManajemenController::class, 'toggle'])->name('manajemen-user.toggle');

        // --- Daftar Ulang ---
        Route::get('/daftar-ulang', [DaftarUlangController::class, 'index'])->name('daftar-ulang.index');
        Route::get('/daftar-ulang/create', [DaftarUlangController::class, 'create'])->name('daftar-ulang.create');
        Route::post('/daftar-ulang', [DaftarUlangController::class, 'store'])->name('daftar-ulang.store');
        Route::get('/daftar-ulang/{id}', [DaftarUlangController::class, 'show'])->name('daftar-ulang.show');
        Route::get('/daftar-ulang/{id}/edit', [DaftarUlangController::class, 'edit'])->name('daftar-ulang.edit');
        Route::put('/daftar-ulang/{id}', [DaftarUlangController::class, 'update'])->name('daftar-ulang.update');
        Route::delete('/daftar-ulang/{id}', [DaftarUlangController::class, 'destroy'])->name('daftar-ulang.destroy');

        // --- Audit & Rekap ---
        Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit.index');
        Route::get('/audit-log/latest', [AuditLogController::class, 'getLatest'])->name('audit.getLatest');
        Route::get('/rekap-pendaftaran', [RekapPendaftaranController::class, 'index'])->name('rekap.index');
        Route::get('/laporan-global', [RekapPendaftaranController::class, 'rekapGlobal'])->name('rekap-global.index');
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
        Route::get('laporan-sekolah', [LaporanSekolahController::class, 'index'])->name('laporan-sekolah');

    });

    // Admin Pondok (Hanya bisa diakses role 'admin_pondok')
    Route::middleware(['role:admin-pondok'])->prefix('pondok')->name('adminpondok.')->group(function () {
        Route::get('/dashboard', [DashboardAdminPondokController::class, 'index'])->name('dashboard');
        Route::resource('asrama', AsramaController::class);
        Route::resource('daftar-santri', DaftarSantriController::class);
        Route::resource('aktifasi-santri', AktivasiSantri::class);
        Route::resource('plotting-kamar', PlottingKamar::class);
        Route::resource('romkam', RomkamController::class);
        Route::get('admin-pondok/daftar-santri/export-pdf', [DaftarSantriController::class, 'exportPdf'])->name('daftar-santri.export-pdf');
        Route::get('laporan-pondok', [LaporanPondokController::class, 'index'])->name('laporan-pondok.index');

    });

});

// route Dashboad untuk pendaftar

Route::middleware(['role:pendaftar', 'auth'])->prefix('pendaftar')->name('pendaftar.')->group(function () {
    Route::resource('/panduan', PanduanController::class);
    Route::resource('/upload-berkas', UploadBerkasController::class);
});
