<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pondok;

class PondokController extends Controller
{
    public function index()
    {
        $pondoks = Pondok::all();
        return view('dashboard.superadmin.pondok.index', compact('pondoks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pondok' => 'required|unique:pondoks,kode_pondok',
            'nama_pondok' => 'required',
            'jenis' => 'required',
            'yayasan_mitra' => 'required',
            'pengasuh' => 'nullable'
        ]);

        Pondok::create($validated);
        return back()->with('success', 'Pondok berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pondok = Pondok::findOrFail($id);
        $validated = $request->validate([
            'kode_pondok' => 'required|unique:pondoks,kode_pondok,'.$id,
            'nama_pondok' => 'required',
            'jenis' => 'required',
            'yayasan_mitra' => 'required',
            'pengasuh' => 'nullable'
        ]);

        $pondok->update($validated);
        return back()->with('success', 'Data pondok berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $pondok = Pondok::findOrFail($id);
        // tinyint(1) di MySQL akan menerima 0 atau 1
        $pondok->update(['is_aktif' => !$pondok->is_aktif]);
        
        return back()->with('success', 'Status operasional diperbarui.');
    }

    public function destroy($id)
    {
        Pondok::findOrFail($id)->delete();
        return back()->with('success', 'Pondok berhasil dihapus.');
    }
}
