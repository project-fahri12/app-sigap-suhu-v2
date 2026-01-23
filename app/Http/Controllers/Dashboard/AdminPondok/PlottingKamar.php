<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Models\Romkam;
use App\Models\Santri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlottingKamar extends Controller
{
    public function index()
    {
        // 1. Santri yang SUDAH memiliki kamar (romkam_id tidak NULL)
        $plottings = Santri::with(['romkam.asrama'])
            ->whereNotNull('romkam_id')
            ->latest()
            ->paginate(10);

        // 2. Daftar Kamar yang tersedia untuk pilihan dropdown
        $romkams = Romkam::with('asrama')->where('status_romkam', 'Tersedia')->get();

        // 3. Santri yang BELUM memiliki kamar (untuk modal plotting baru)
        $santriBelumPlot = Santri::whereNull('romkam_id')->get();

        return view('dashboard.admin-pondok.plotting-kamar.index', compact('plottings', 'romkams', 'santriBelumPlot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'romkam_id' => 'required|exists:romkams,id',
        ]);

        // Update data santri: masukkan romkam_id dan ubah status_santri
        $santri = Santri::findOrFail($request->santri_id);
        $santri->update([
            'romkam_id'     => $request->romkam_id,
            'status_santri' => 'Mukim',
            'updated_at'    => now()
        ]);

        return redirect()->back()->with('success', 'Santri berhasil ditempatkan ke kamar.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'romkam_id' => 'required|exists:romkams,id',
        ]);

        // Pindah kamar: cukup update romkam_id
        $santri = Santri::findOrFail($id);
        $santri->update([
            'romkam_id' => $request->romkam_id
        ]);

        return redirect()->back()->with('success', 'Lokasi kamar santri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Mengeluarkan santri: set romkam_id kembali ke NULL
        $santri = Santri::findOrFail($id);
        $santri->update([
            'romkam_id'     => null,
            'status_santri' => 'Non-Mukim'
        ]);

        return redirect()->back()->with('success', 'Santri telah dikeluarkan dari kamar.');
    }
}
