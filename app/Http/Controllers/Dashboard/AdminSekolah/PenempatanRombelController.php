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

        // Query siswa yang belum punya rombel
        $querySiswa = Siswa::whereHas('pendaftar', function ($q) use ($sekolah_id) {
            $q->where('sekolah_id', $sekolah_id);
        })->whereNull('rombel_id');

        // Filter Gender
        if ($request->gender) {
            $querySiswa->whereHas('pendaftar', function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->gender);
            });
        }

        // Search Nama
        if ($request->search) {
            $querySiswa->whereHas('pendaftar', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
            });
        }

        $siswaBelumPlot = $querySiswa->with('pendaftar')->orderBy('created_at', 'desc')->get();

        // Handle AJAX Request untuk list waiting
        if ($request->ajax()) {
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
        // 1. Validasi dasar input
        $request->validate([
            'siswa_ids' => 'required|array',
            'rombel_id' => 'required|exists:rombels,id',
        ]);

        try {
            $rombel = Rombel::findOrFail($request->rombel_id);
            $jenisRombel = strtoupper($rombel->jenis_kelas); // L, P, atau LP

            // 2. Ambil data siswa dengan relasi pendaftar
            $siswas = Siswa::whereIn('id', $request->siswa_ids)->with('pendaftar')->get();

            // 3. Validasi Jenis Kelamin (Hanya jika rombel bukan Campuran/LP)
            if ($jenisRombel !== 'LP') {
                foreach ($siswas as $siswa) {
                    // Pastikan data pendaftar ada untuk menghindari error "Trying to get property of non-object"
                    if (! $siswa->pendaftar) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Data pendaftar untuk Siswa ID #{$siswa->id} tidak ditemukan.",
                        ], 422);
                    }

                    $genderSiswa = strtoupper($siswa->pendaftar->jenis_kelamin); // L atau P

                    // Cek ketidakcocokan
                    if ($genderSiswa !== $jenisRombel) {
                        $labelGenderSiswa = ($genderSiswa == 'L') ? 'Laki-laki' : 'Perempuan';
                        $labelGenderRombel = ($jenisRombel == 'L') ? 'Laki-laki' : 'Perempuan';

                        return response()->json([
                            'status' => 'error',
                            'message' => "Gagal! Siswa <strong>{$siswa->pendaftar->nama_lengkap}</strong> ({$labelGenderSiswa}) tidak bisa dimasukkan ke Rombel Khusus {$labelGenderRombel}.",
                        ], 422);
                    }
                }
            }

            // 4. Jika lolos validasi, lakukan update
            Siswa::whereIn('id', $request->siswa_ids)->update([
                'rombel_id' => $rombel->id,
                'kelas_id' => $rombel->kelas_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => count($request->siswa_ids)." Siswa berhasil ditempatkan ke {$rombel->nama_rombel}.",
            ]);

        } catch (\Exception $e) {
            // Mengembalikan pesan error teknis jika terjadi kegagalan database
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan teknis: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Siswa::where('id', $id)->update([
                'rombel_id' => null,
                'kelas_id' => null,
            ]);

            return back()->with('success', 'Siswa berhasil dikeluarkan dari rombel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengeluarkan siswa.');
        }
    }
}
