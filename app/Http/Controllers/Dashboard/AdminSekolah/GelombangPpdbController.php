<?php

namespace App\Http\Controllers\Dashboard\AdminSekolah;

use App\Http\Controllers\Controller;
use App\Models\GelombangPPDB;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GelombangPpdbController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $gelombangs = GelombangPPDB::with('tahunAjaran')
            ->withCount('pendaftar') // Ini akan menciptakan variabel pendaftars_count
            ->where('sekolah_id', $user->sekolah_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $tahunAjarans = TahunAjaran::where('is_aktif', true)->get();

        return view('dashboard.admin-sekolah.gelombang-ppdb.index', compact('gelombangs', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nama_gelombang' => 'required|string|max:255',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
            'kuota' => 'required|integer|min:1',
        ]);

        // Jika is_aktif dicentang, nonaktifkan gelombang lain di sekolah yang sama
        if ($request->is_aktif) {
            GelombangPPDB::where('sekolah_id', Auth::user()->sekolah_id)->update(['is_aktif' => 0]);
        }
        $user = Auth::user();

        GelombangPPDB::create([
            'sekolah_id' => $user->sekolah_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'nama_gelombang' => $request->nama_gelombang,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'kuota' => $request->kuota,
            'is_aktif' => $request->is_aktif ?? 0,
        ]);

        return back()->with('success', 'Gelombang PPDB berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $gelombang = GelombangPPDB::findOrFail($id);

        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nama_gelombang' => 'required|string|max:255',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
            'kuota' => 'required|integer|min:1',
        ]);

        if ($request->is_aktif) {
            GelombangPPDB::where('sekolah_id', Auth::user()->sekolah_id)
                ->where('id', '!=', $id)
                ->update(['is_aktif' => 0]);
        }

        $gelombang->update([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'nama_gelombang' => $request->nama_gelombang,
            'tanggal_buka' => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'kuota' => $request->kuota,
            'is_aktif' => $request->is_aktif ?? 0,
        ]);

        return back()->with('success', 'Gelombang PPDB berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gelombang = GelombangPPDB::findOrFail($id);
        $gelombang->delete();

        return back()->with('success', 'Gelombang PPDB berhasil dihapus.');
    }
}
