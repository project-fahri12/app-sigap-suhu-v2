<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login Pendaftar
    public function authpendaftar()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole();
        }

        return view('auth.login-pendaftar');
    }

    public function authadmin()
    {
        return view('auth.login-admin');
    }

    public function storePendaftar(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'username' => 'required|numeric|digits:10', // Menambahkan digits:10 agar lebih ketat
        ], [
            'username.required' => 'NISN tidak boleh kosong',
            'username.numeric' => 'NISN harus berupa angka',
            'username.digits' => 'NISN harus berjumlah 10 digit',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('username'),
            ], 422);
        }

        // 2. Cari user berdasarkan kolom NISN
        // Kita gunakan kolom 'nisn' sesuai struktur database yang kamu kirim tadi
        $user = User::where('nisn', $request->username)
            ->where('role', 'pendaftar')
            ->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'NISN tidak terdaftar sebagai pendaftar',
            ], 404);
        }

        // 3. Proses Login
        // Menggunakan Auth::login agar session terbentuk
        Auth::login($user);

        // Update status menjadi aktif jika diperlukan
        $user->update(['is_aktif' => 'aktif']);

        // Proteksi session fixation
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil, selamat datang!',
            'redirect' => route('pendaftar.dashboard'),
        ]);
    }

    public function storeAdmin(Request $request)
    {
        // Validasi
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Login hanya pakai EMAIL (karena username tidak ada di DB)
        $credentials = [
            'email' => $request->login,
            'password' => $request->password,
            'is_aktif' => 'aktif',
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectUserByRole();
        }

        return back()->withErrors([
            'login' => 'Email / password salah atau akun belum aktif.',
        ])->withInput($request->only('login'));
    }

    protected function redirectUserByRole()
    {
        $user = Auth::user();

        return match ($user->role) {
            'super-admin' => redirect()->route('superadmin.dashboard'),
            'admin-sekolah' => redirect()->route('adminsekolah.dashboard'),
            'admin-pondok' => redirect()->route('adminpondok.dashboard'),
            // 'panitia-ppdb'  => redirect()->route('panitia.dashboard'),
            'pendaftar' => redirect()->route('pendaftar.panduan.index'),
            default => redirect()->route('home'),
        };
    }

    public function logout(Request $request)
    {
        $role = Auth::user()?->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'pendaftar') {
            return redirect()
                ->route('home')
                ->with('success', 'Berhasil keluar dari sistem.');
        }

        return redirect()
            ->route('auth.admin')
            ->with('success', 'Berhasil keluar dari sistem.');
    }
}
