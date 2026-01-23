<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Romkam;
use App\Models\Asrama;
use Illuminate\Http\Request;

class RomkamController extends Controller
{
    public function index()
    {
        // Mengambil data romkam beserta relasi asramanya
        $romkams = Romkam::with('asrama')->latest()->paginate(10);
        $asramas = Asrama::all(); // Untuk dropdown di modal

        return view('dashboard.admin-pondok.romkam.index', compact('romkams', 'asramas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_romkam'   => 'required|string|max:255',
            'asrama_id'     => 'required|exists:asramas,id',
            'kapasitas'     => 'required|integer',
            'status_romkam' => 'required',
        ]);

        Romkam::create([
            'pondok_id'     => 1, // Sesuaikan dengan session pondok
            'nis'           => $request->nis ?? '0',
            'nama_romkam'   => $request->nama_romkam,
            'kapasitas'     => $request->kapasitas,
            'status_romkam' => $request->status_romkam,
            'asrama_id'     => $request->asrama_id,
        ]);

        return redirect()->back()->with('success', 'Kamar (Romkam) berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_romkam'   => 'required|string|max:255',
            'asrama_id'     => 'required|exists:asramas,id',
            'kapasitas'     => 'required|integer',
            'status_romkam' => 'required',
        ]);

        $romkam = Romkam::findOrFail($id);
        $romkam->update($request->all());

        return redirect()->back()->with('success', 'Data Kamar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Romkam::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kamar berhasil dihapus.');
    }
}