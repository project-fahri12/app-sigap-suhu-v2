<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RombelController extends Controller
{
    public function index()
    {
        $sekolah_id = Auth::user()->sekolah_id;

        // Ambil data rombel yang berelasi dengan kelas
        $data = Rombel::with('kelas')
            ->where('sekolah_id', $sekolah_id)
            ->get();

        // Ambil data kelas untuk dropdown di modal
        $list_kelas = Kelas::where('sekolah_id', $sekolah_id)->get();

        // Hitung statistik ringkas
        $total_rombel = $data->count();
        $total_kapasitas = $data->sum('kapasitas');
        // Catatan: 'siswa_count' diasumsikan jika Anda sudah punya relasi siswa
        
        return view('dashboard.admin-sekolah.rombel.index', compact('data', 'list_kelas', 'total_rombel', 'total_kapasitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'nama_rombel' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'jenis_kelas' => 'required|in:L,P,LP',
            'status_rombel' => 'required'
        ]);

        Rombel::create([
            'sekolah_id' => Auth::user()->sekolah_id,
            'kelas_id' => $request->kelas_id,
            'nama_rombel' => $request->nama_rombel,
            'kapasitas' => $request->kapasitas,
            'jenis_kelas' => $request->jenis_kelas,
            'status_rombel' => $request->status_rombel,
        ]);

        return redirect()->back()->with('success', 'Rombel berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $rombel = Rombel::findOrFail($id);
        $rombel->update($request->all());

        return redirect()->back()->with('success', 'Data rombel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Rombel::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Rombel berhasil dihapus.');
    }
}
