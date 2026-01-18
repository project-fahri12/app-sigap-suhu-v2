<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Models\Role;
use App\Models\User;
use App\Models\Pondok;
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
        // Ambil user + relasi yang dipakai di blade
        $users = User::with([
            'roles:id,name,label',
            'sekolah:id,nama_sekolah',
            'pondok:id,nama_pondok',
        ])->orderBy('name')->get();

        // Data untuk modal
        $roles = Role::select('id', 'name', 'label')->orderBy('label')->get();
        $sekolahs = Sekolah::select('id', 'nama_sekolah')->orderBy('nama_sekolah')->get();
        $pondoks = Pondok::select('id', 'nama_pondok')->orderBy('nama_pondok')->get();

        return view('dashboard.superadmin.manajemenuser.index', compact(
            'users',
            'roles',
            'sekolahs',
            'pondoks'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_aktif' => 1,
            ]);

            // Gunakan relasi Many-to-Many sync/attach
            $user->roles()->attach($request->role_id);

            if ($request->sekolah_id) {
                $user->sekolah()->attach($request->sekolah_id);
            }

            if ($request->pondok_id) {
                $user->pondok()->attach($request->pondok_id);
            }
        });

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // sync() akan menghapus data lama dan memasukkan data baru secara otomatis
            $user->roles()->sync([$request->role_id]);

            // Jika ada sekolah_id, sinkronkan. Jika kosong, hapus akses sekolah.
            $user->sekolah()->sync($request->sekolah_id ? [$request->sekolah_id] : []);

            // Jika ada pondok_id, sinkronkan. Jika kosong, hapus akses pondok.
            $user->pondok()->sync($request->pondok_id ? [$request->pondok_id] : []);
        });

        return back()->with('success', 'Data dan akses user berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            // Hapus relasi di tabel pivot otomatis sebelum user dihapus
            $user->roles()->detach();
            $user->sekolah()->detach();
            $user->pondok()->detach();

            $user->delete();
        });

        return back()->with('success', 'User berhasil dihapus dari sistem');
    }

    public function toggle($id)
    {
        $user = User::findOrFail($id);

        $newStatus = ($user->is_aktif == '1') ? '0' : '1';

        $user->update(['is_aktif' => $newStatus]);

        return back()->with('success', 'Status user berhasil diperbarui.');
    }
}