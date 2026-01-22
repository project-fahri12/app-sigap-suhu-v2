<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $sekolah_id = Auth::user()->sekolah_id; 

        $data = Kelas::where('sekolah_id', $sekolah_id)
                     ->orderBy('nama_kelas', 'asc')
                     ->get();

        return view('dashboard.admin-sekolah.kelas.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'sekolah_id' => Auth::user()->sekolah_id, 
        ]);

        return redirect()->back()->with('success', 'Tingkat kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::where('id', $id)
                      ->where('sekolah_id', Auth::user()->sekolah_id)
                      ->firstOrFail();

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->back()->with('success', 'Tingkat kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::where('id', $id)
                      ->where('sekolah_id', Auth::user()->sekolah_id)
                      ->firstOrFail();
                      
        $kelas->delete();

        return redirect()->back()->with('success', 'Tingkat kelas berhasil dihapus.');
    }
}