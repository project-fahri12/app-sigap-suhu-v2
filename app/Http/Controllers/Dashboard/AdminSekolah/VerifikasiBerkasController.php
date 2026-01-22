<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\BerkasPath;

class VerifikasiBerkasController extends Controller
{
   public function index()
{
    $pendaftars = Pendaftar::with(['berkas', 'gelombang'])->latest()->get();
    
    // Pisahkan data untuk Tab
    $pending = $pendaftars->where('status_pendaftaran', 'pending');
    $lulus = $pendaftars->where('status_pendaftaran', 'lulus_verifikasi');

    return view('dashboard.admin-sekolah.verifikasi-berkas.index', compact('pending', 'lulus'));
}

    // Simpan perubahan berkas satu per satu via AJAX
    public function updateItem(Request $request, $id)
    {
        try {
            $berkas = BerkasPath::findOrFail($id);
            $berkas->update([
                'status_berkas' => $request->status_berkas,
                'keterangan' => $request->keterangan
            ]);

            return response()->json(['success' => true, 'message' => 'Tersimpan sementara']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Simpan status pendaftaran final (Lulus/Pending)
    public function updateFinal(Request $request, $id)
    {
        $request->validate(['status_pendaftaran' => 'required|in:pending,lulus_verifikasi']);

        $pendaftar = Pendaftar::findOrFail($id);
        $pendaftar->update([
            'status_pendaftaran' => $request->status_pendaftaran,
            'status_sekolah' => ($request->status_pendaftaran == 'lulus_verifikasi') ? 'terverifikasi' : 'proses'
        ]);

        return back()->with('success', 'Status pendaftaran ' . $pendaftar->nama_lengkap . ' berhasil diperbarui.');
    }
}