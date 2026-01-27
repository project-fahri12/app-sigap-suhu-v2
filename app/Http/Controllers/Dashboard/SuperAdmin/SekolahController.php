<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use Illuminate\Support\Str;

class SekolahController extends Controller
{
    public function index()
    {
        return view('dashboard.superadmin.sekolah.index', [
            'sekolahs' => Sekolah::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang'      => 'required|string|max:20',
            'keterangan'   => 'required|in:wajib,tidak_wajib',
            'kode_sekolah' => 'nullable|unique:sekolahs,kode_sekolah',
        ]);

        Sekolah::create([
            // Jika kode_sekolah kosong di input, generate otomatis
            'kode_sekolah' => $request->kode_sekolah ?? 'UNIT-' . Str::upper(Str::random(5)),
            'nama_sekolah' => $validated['nama_sekolah'],
            'jenjang'      => $validated['jenjang'],
            'keterangan'   => $validated['keterangan'],
            'is_aktif'     => 1,
        ]);

        return back()->with('success', 'Unit sekolah berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang'      => 'required|string|max:20',
            'keterangan'   => 'required|in:wajib,tidak_wajib',
            'kode_sekolah' => "required|unique:sekolahs,kode_sekolah,$id",
        ]);

        $sekolah->update($validated);

        return back()->with('success', 'Unit sekolah berhasil diperbarui');
    }

    public function toggleStatus($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update([
            'is_aktif' => !$sekolah->is_aktif
        ]);

        return back()->with('success', 'Status sekolah berhasil diubah');
    }

    public function destroy($id)
    {
        Sekolah::findOrFail($id)->delete();
        return back()->with('success', 'Unit sekolah berhasil dihapus');
    }
}