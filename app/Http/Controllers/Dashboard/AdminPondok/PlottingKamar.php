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
    // Tambahkan pendaftar ke dalam eager loading
    $plottings = Santri::with(['romkam.asrama', 'pendaftar'])
        ->whereNotNull('romkam_id')
        ->latest()
        ->paginate(10)->WithQueryString();

    // Ambil romkam yang statusnya tersedia
    $romkams = Romkam::with('asrama')->where('status_romkam', 'Tersedia')->get();

    // Pastikan pendaftar juga di-load di sini
    $santriBelumPlot = Santri::with('pendaftar')->whereNull('romkam_id')->get();

    return view('dashboard.admin-pondok.plotting-kamar.index', compact('plottings', 'romkams', 'santriBelumPlot'));
}

   public function store(Request $request)
{
    $request->validate([
        'santri_ids' => 'required|array',
        'santri_ids.*' => 'exists:santris,id',
        'romkam_id' => 'required|exists:romkams,id',
    ]);

    // Update masal
    Santri::whereIn('id', $request->santri_ids)->update([
        'romkam_id'     => $request->romkam_id,
        'status_santri' => 'Mukim',
        'updated_at'    => now()
    ]);

    return redirect()->back()->with('success', count($request->santri_ids) . ' Santri berhasil ditempatkan ke kamar.');
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
