<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilan login pendaftar
    public function authpendaftar() {
        return view("auth.login-pendaftar");
    }

    // Tampilan login admin/staff
    public function authadmin() {
        if (Auth::check()) {
            return $this->redirectUserByRole();
        }
        return view("auth.login-admin");
    }

    // Proses Autentikasi Admin/Staff
    public function storeAdmin(Request $request)
    {
        // 1. Validasi Input (Support Email atau Username)
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Deteksi apakah input login adalah email atau username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Eksekusi Login
        if (Auth::attempt([$loginField => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            // 4. Redirect berdasarkan Role
            return $this->redirectUserByRole();
        }

        // Jika Gagal Login
        return back()->withErrors([
            'login' => 'Maaf, akun tidak ditemukan atau password salah.',
        ])->withInput($request->only('auth.admin'));
    }

    /**
     * Helper Function untuk Redirect User Berdasarkan Role.
     * Menggunakan penamaan route yang sesuai dengan web.php Anda.
     */
    protected function redirectUserByRole()
    {
        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            return redirect()->route('superadmin.dashboard');
        } 
        
        if ($user->hasRole('admin-sekolah')) {
            return redirect()->route('adminsekolah.dashboard');
        }

        if ($user->hasRole('admin-pondok')) {
            return redirect()->route('adminpondok.dashboard');
        }

        if ($user->hasRole('panitia')) {
            return redirect()->route('panitia.dashboard');
        }

        // Default jika tidak punya role khusus
        return redirect()->route('home');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin')->with('success', 'Berhasil keluar sistem.');
    }
}