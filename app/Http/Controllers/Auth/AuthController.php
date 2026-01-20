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
            'panitia-ppdb'  => redirect()->route('panitia.dashboard'),
            'pendaftar'     => redirect()->route('pendaftar.dashboard'),
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
}
