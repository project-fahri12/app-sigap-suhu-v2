<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pondok;
use Illuminate\Http\Request;

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
            'nama_pondok' => 'required',
            'jenis' => 'required|in:L,P,LP',
            'yayasan_mitra' => 'required',
            'pengasuh' => 'nullable',
        ]);

        // generate slug berdasarkan jenis
        $kodePondok = match ($validated['jenis']) {
            'L' => 'pondok-putra',
            'P' => 'pondok-putri',
            'LP' => 'pondok-putra-putri',
        };

        Pondok::create([
            'kode_pondok' => $kodePondok,
            'nama_pondok' => $validated['nama_pondok'],
            'jenis' => $validated['jenis'],
            'yayasan_mitra' => $validated['yayasan_mitra'],
            'pengasuh' => $validated['pengasuh'] ?? null,
        ]);

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
            'pengasuh' => 'nullable',
        ]);

        $pondok->update($validated);

        return back()->with('success', 'Data pondok berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $pondok = Pondok::findOrFail($id);
        // tinyint(1) di MySQL akan menerima 0 atau 1
        $pondok->update(['is_aktif' => ! $pondok->is_aktif]);

        return back()->with('success', 'Status operasional diperbarui.');
    }

    public function destroy($id)
    {
        Pondok::findOrFail($id)->delete();

        return back()->with('success', 'Pondok berhasil dihapus.');
    }
}
