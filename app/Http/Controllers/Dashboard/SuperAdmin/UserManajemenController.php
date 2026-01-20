<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManajemenController extends Controller
{
    public function index()
    {
        $users = User::with('sekolah')
            ->orderBy('name')
            ->get();

        $sekolahs = Sekolah::orderBy('nama_sekolah')->get();

        $roles = [
            'super-admin'   => 'Super Admin',
            'admin-sekolah' => 'Admin Sekolah',
            'admin-pondok'  => 'Admin Pondok',
            'panitia-ppdb'  => 'Panitia PPDB',
            'pendaftar'     => 'Pendaftar',
        ];

        return view('dashboard.superadmin.manajemenuser.index', compact(
            'users',
            'roles',
            'sekolahs'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required',
            'sekolah_id' => 'nullable|exists:sekolahs,id',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'sekolah_id' => $request->sekolah_id,
            'is_aktif'   => 'aktif',
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'       => 'required',
            'sekolah_id' => 'nullable|exists:sekolahs,id',
        ]);

        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'sekolah_id' => $request->sekolah_id,
        ]);

        return back()->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }

    public function toggle($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_aktif' => $user->is_aktif === 'aktif' ? 'non_aktif' : 'aktif'
        ]);

        return back()->with('success', 'Status user diperbarui');
    }
}
