<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        return view('dashboard.superadmin.role.index', [
            'roles' => Role::orderBy('name', 'asc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,name',
            'label' => 'required',
        ]);

        // Menggunakan Str::slug agar name role konsisten (misal: Admin Pondok jadi admin-pondok)
        Role::create([
            'name' => Str::slug($request->role),
            'label' => $request->label,
        ]);

        return back()->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role' => 'required|unique:roles,name,' . $id,
            'label' => 'required',
        ]);

        $role->update([
            'name' => Str::slug($request->role),
            'label' => $request->label,
        ]);

        return back()->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Proteksi: Jangan hapus role penting (Super Admin)
        if (in_array($role->name, ['super-admin', 'admin-lembaga', 'admin-pondok'])) {
            return back()->with('error', 'Role sistem tidak boleh dihapus!');
        }

        // Cek jika masih ada user yang pakai role ini
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak bisa dihapus karena masih digunakan oleh user.');
        }

        $role->delete();

        return back()->with('success', 'Role berhasil dihapus');
    }
}