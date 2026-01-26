<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenempatanRombelController extends Controller
{
    public function index(Request $request)
    {
        $sekolah_id = Auth::user()->sekolah_id;

        $querySiswa = Siswa::whereHas('pendaftar', function ($q) use ($sekolah_id) {
            $q->where('sekolah_id', $sekolah_id);
        })->whereNull('rombel_id');

        if ($request->gender) {
            $querySiswa->whereHas('pendaftar', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->gender);
            });
        }
        if ($request->search) {
            $querySiswa->whereHas('pendaftar', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
            });
        }

        $siswaBelumPlot = $querySiswa->with('pendaftar')->orderBy('created_at', 'desc')->get();

        // JIKA REQUEST ADALAH AJAX
        if ($request->ajax || $request->has('ajax')) {
            return response()->json([
                'html' => view('dashboard.admin-sekolah.penempatan-rombel._list_waiting', compact('siswaBelumPlot'))->render(),
                'count' => $siswaBelumPlot->count(),
            ]);
        }

        $listRombel = Rombel::where('sekolah_id', $sekolah_id)->with('kelas')->get();

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
        // Validasi input
        $request->validate([
            'siswa_ids' => 'required|array',
            'rombel_id' => 'required|exists:rombels,id',
        ]);

        try {
            $rombel = Rombel::findOrFail($request->rombel_id);

            // Update massal
            Siswa::whereIn('id', $request->siswa_ids)->update([
                'rombel_id' => $rombel->id,
                'kelas_id' => $rombel->kelas_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => count($request->siswa_ids).' Siswa berhasil masuk ke '.$rombel->nama_rombel,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Keluarkan siswa dari rombel (set NULL)
        Siswa::where('id', $id)->update(['rombel_id' => null]);

        return back()->with('success', 'Siswa berhasil dikeluarkan dari rombel.');
    }
}
