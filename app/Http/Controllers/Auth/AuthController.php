<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    $user = User::where('pendaftar_id', function ($q) use ($request) {
            $q->select('id')
              ->from('pendaftars')
              ->where('kode_pendaftaran', $request->kode_pendaftaran);
        })
        ->where('role', 'pendaftar')
        ->first();

    if (!$user) {
        return back()->withErrors([
            'kode_pendaftaran' => 'Kode pendaftaran tidak ditemukan',
        ]);
    }

    Auth::login($user);
    $user->update(['is_aktif' => 'aktif']); // ⭐ PENTING
    $request->session()->regenerate();

    return redirect()->route('pendaftar.panduan.index');
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
    $role = Auth::user()?->role; 

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($role === 'pendaftar') {
        return redirect()
            ->route('auth.pendaftar')
            ->with('success', 'Berhasil keluar dari sistem.');
    }

    return redirect()
        ->route('auth.admin')
        ->with('success', 'Berhasil keluar dari sistem.');
}

}
