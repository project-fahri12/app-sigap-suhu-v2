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
            'sekolahs'      => Sekolah::latest()->get(),
            'total_sekolah' => Sekolah::count(),
            'tidak_wajib'   => Sekolah::where('keterangan', 'tidak_wajib')->count(),
            'wajib'         => Sekolah::where('keterangan', 'wajib')->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang'      => 'required|string|max:20',
            'keterangan'   => 'required|in:wajib,tidak_wajib',
        ]);

        Sekolah::create([
            'kode_sekolah' => 'unit-' . Str::upper(Str::random(5)),
            'nama_sekolah' => $request->nama_sekolah,
            'jenjang'      => $request->jenjang,
            'keterangan'   => $request->keterangan,
            'is_aktif'     => 1,
        ]);

        return back()->with('success', 'Unit sekolah berhasil ditambahkan');
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang'      => 'required|string|max:20',
            'keterangan'   => 'required|in:wajib,tidak_wajib',
            'is_aktif'     => 'required|boolean',
        ]);

        $sekolah->update($request->only([
            'nama_sekolah',
            'jenjang',
            'keterangan',
            'is_aktif'
        ]));

        return back()->with('success', 'Unit sekolah berhasil diperbarui');
    }

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();
        return back()->with('success', 'Unit sekolah berhasil dihapus');
    }
}
