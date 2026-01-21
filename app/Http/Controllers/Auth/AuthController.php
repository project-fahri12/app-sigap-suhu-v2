<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function storePendaftar(Request $request)
{
    $request->validate([
        'kode_pendaftaran' => 'required|string',
    ]);

    // Credential: email/username adalah kode_pendaftaran, password juga kode_pendaftaran
    $credentials = [
        'password'         => $request->kode_pendaftaran, 
        'role'             => 'pendaftar',
    ];

    if (Auth::attempt($credentials, $request->has('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('pendaftar.panduan.index');
    }

    return back()->withErrors([
        'kode_pendaftaran' => 'ID Pendaftaran tidak ditemukan atau tidak sesuai.',
    ])->withInput();
}

    // Login Admin / Staff
    public function authadmin()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole();
        }

        return view('auth.login-admin');
    }

    
    public function storeAdmin(Request $request)
    {
        // Validasi
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Login hanya pakai EMAIL (karena username tidak ada di DB)
        $credentials = [
            'email'    => $request->login,
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
            'super-admin'   => redirect()->route('superadmin.dashboard'),
            'admin-sekolah' => redirect()->route('adminsekolah.dashboard'),
            'admin-pondok'  => redirect()->route('adminpondok.dashboard'),
            // 'panitia-ppdb'  => redirect()->route('panitia.dashboard'),
            'pendaftar'     => redirect()->route('pendaftar.panduan.index'),
            default         => redirect()->route('home'),
        };
    }

    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.admin')
            ->with('success', 'Berhasil keluar dari sistem.');
    }

    public function logoutPendaftar(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('pendaftar.logout')
            ->with('success', 'Berhasil keluar dari sistem.');
    }
}
