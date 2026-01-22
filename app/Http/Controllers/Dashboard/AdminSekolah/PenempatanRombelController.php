<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa; 
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenempatanRombelController extends Controller
{
    public function index(Request $request)
    {
        $sekolah_id = Auth::user()->sekolah_id;

        // 1. Ambil Siswa yang BELUM punya Rombel
        $querySiswa = Siswa::whereHas('pendaftar', function($q) use ($sekolah_id) {
            $q->where('sekolah_id', $sekolah_id);
        })->whereNull('rombel_id');

        // Filter Gender & Pencarian
        if ($request->gender) {
            $querySiswa->whereHas('pendaftar', function($q) use ($request) {
                $q->where('jenis_kelamin', $request->gender);
            });
        }
        if ($request->search) {
            $querySiswa->whereHas('pendaftar', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $siswaBelumPlot = $querySiswa->with('pendaftar')->get();

        // 2. Ambil List Rombel untuk tujuan plotting
        $listRombel = Rombel::where('sekolah_id', $sekolah_id)->with('kelas')->get();

        // 3. Detail Rombel yang sedang dibuka/dilihat
        $rombelTerpilih = null;
        $anggotaRombel = collect();
        if ($request->rombel_id) {
            $rombelTerpilih = Rombel::with('kelas')->find($request->rombel_id);
            $anggotaRombel = Siswa::where('rombel_id', $request->rombel_id)->with('pendaftar')->get();
        }

        return view('dashboard.admin-sekolah.penempatan-rombel.index', compact(
            'siswaBelumPlot', 'listRombel', 'rombelTerpilih', 'anggotaRombel'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'rombel_id' => 'required|exists:rombels,id',
        ]);

        $rombel = Rombel::findOrFail($request->rombel_id);
        
        // Update massal: Masukkan ke rombel dan samakan tingkat kelasnya
        Siswa::whereIn('id', $request->siswa_ids)->update([
            'rombel_id' => $rombel->id,
            'kelas_id'  => $rombel->kelas_id,
        ]);

        return back()->with('success', count($request->siswa_ids) . ' Siswa berhasil diplot ke ' . $rombel->nama_rombel);
    }

    public function destroy($id)
    {
        // Keluarkan siswa dari rombel (set NULL)
        Siswa::where('id', $id)->update(['rombel_id' => null]);
        return back()->with('success', 'Siswa berhasil dikeluarkan dari rombel.');
    }
}