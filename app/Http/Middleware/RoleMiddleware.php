<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Belum login
        if (!Auth::check()) {
            return redirect()->route('auth.admin');
        }

        $user = Auth::user();

        // Cek apakah role user termasuk salah satu role yang diizinkan
        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Tidak punya otorisasi
        abort(403, 'Anda tidak memiliki otoritas untuk mengakses halaman ini.');
    }
}
