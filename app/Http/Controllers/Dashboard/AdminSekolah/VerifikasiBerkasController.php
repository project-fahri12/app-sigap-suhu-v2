<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\BerkasPath;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiBerkasController extends Controller
{
    public function index()
    {
        // Mengambil ID sekolah dari admin yang sedang login
        $sekolah_id = Auth::user()->sekolah_id;

        // Query data pendaftar yang hanya berasal dari sekolah tersebut
        $pendaftars = Pendaftar::with(['berkas', 'gelombang'])
            ->where('sekolah_id', $sekolah_id)
            ->latest()
            ->get();

        // Pisahkan data untuk Tab
        $pending = $pendaftars->where('status_pendaftaran', 'pending');
        $lulus = $pendaftars->where('status_pendaftaran', 'lulus_verifikasi');

        return view('dashboard.admin-sekolah.verifikasi-berkas.index', compact('pending', 'lulus'));
    }

    public function updateItem(Request $request, $id)
    {
        try {
            // Untuk keamanan, pastikan berkas yang diupdate milik sekolah si admin
            $sekolah_id = Auth::user()->sekolah_id;

            $berkas = BerkasPath::whereHas('pendaftar', function ($q) use ($sekolah_id) {
                $q->where('sekolah_id', $sekolah_id);
            })->findOrFail($id);

            $berkas->update([
                'status_berkas' => $request->status_berkas,
                'keterangan' => $request->keterangan,
            ]);

            return response()->json(['success' => true, 'message' => 'Tersimpan sementara']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan atau akses ditolak'], 500);
        }
    }

    public function updateFinal(Request $request, $id)
    {
        $request->validate([
            'status_pendaftaran' => 'required|in:pending,lulus_verifikasi',
        ]);

        $sekolah_id = Auth::user()->sekolah_id;

        // Memastikan pendaftar yang diupdate benar milik sekolah admin tersebut
        $pendaftar = Pendaftar::where('sekolah_id', $sekolah_id)->findOrFail($id);

        $pendaftar->update([
            'status_pendaftaran' => $request->status_pendaftaran,
            'status_berkas'      => 'lulus_verifikasi'
        ]);

        return back()->with('success', 'Status pendaftaran '.$pendaftar->nama_lengkap.' berhasil diperbarui.');
    }
}
