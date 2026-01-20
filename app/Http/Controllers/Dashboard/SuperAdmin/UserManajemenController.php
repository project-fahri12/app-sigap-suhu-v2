<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\Pondok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManajemenController extends Controller
{
    public function index()
    {
        // Perbaikan: Tambahkan parameter arah 'asc' agar tidak error
        $users = User::with(['sekolah', 'pondok'])
            ->orderBy('name', 'asc') 
            ->get();

        $sekolahs = Sekolah::orderBy('nama_sekolah', 'asc')->get();
        $pondoks = Pondok::orderBy('nama_pondok', 'asc')->get();

        $roles = [
            'super-admin'   => 'Super Admin',
            'admin-sekolah' => 'Admin Sekolah',
            'admin-pondok'  => 'Admin Pondok',
            'panitia-ppdb'  => 'Panitia PPDB',
            'pendaftar'     => 'Pendaftar',
        ];

        return view('dashboard.superadmin.manajemenuser.index', compact(
            'users', 'roles', 'sekolahs', 'pondoks'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required',
            // Wajib pilih sekolah jika admin-sekolah atau panitia
            'sekolah_id' => 'required_if:role,admin-sekolah,panitia-ppdb|nullable|exists:sekolahs,id',
            // Wajib pilih pondok jika admin-pondok
            'pondok_id'  => 'required_if:role,admin-pondok|nullable|exists:pondoks,id',
        ], [
            'sekolah_id.required_if' => 'Unit Sekolah wajib dipilih untuk peran ini.',
            'pondok_id.required_if'  => 'Unit Pondok wajib dipilih untuk peran ini.',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            // Simpan ID sesuai role, lainnya null
            'sekolah_id' => in_array($request->role, ['admin-sekolah', 'panitia-ppdb']) ? $request->sekolah_id : null,
            'pondok_id'  => ($request->role === 'admin-pondok') ? $request->pondok_id : null,
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
            'sekolah_id' => 'required_if:role,admin-sekolah,panitia-ppdb|nullable|exists:sekolahs,id',
            'pondok_id'  => 'required_if:role,admin-pondok|nullable|exists:pondoks,id',
            'password'   => 'nullable|min:6',
        ], [
            'sekolah_id.required_if' => 'Unit Sekolah wajib dipilih.',
            'pondok_id.required_if'  => 'Unit Pondok wajib dipilih.',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'sekolah_id' => in_array($request->role, ['admin-sekolah', 'panitia-ppdb']) ? $request->sekolah_id : null,
            'pondok_id'  => ($request->role === 'admin-pondok') ? $request->pondok_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui');
    }

    /**
     * PERBAIKAN DELETE: 
     * Menggunakan ID langsung untuk menghindari konflik tipe data di editor
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah menghapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

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