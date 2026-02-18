<?php

namespace App\Http\Controllers\Dashboard\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Pondok;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekolahdanPondokController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::findOrFail($user->pendaftar_id);
        $gender = $pendaftar->jenis_kelamin;

        $sekolah = Sekolah::where('is_aktif', 1)->get();
        $pondok = Pondok::where('is_aktif', 1)->whereIn('jenis', [$gender, 'LP'])->get();

        // Link brosur (sesuaikan dengan file Anda di folder public/assets/pdf/)
        $url_brosur = asset('assets/brosur/panduan_pendaftaran.pdf');

        return view('dashboard.pendaftar.sekolah-dan-pondok', compact('sekolah', 'pondok', 'pendaftar', 'url_brosur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'pondok_id' => 'required',
        ]);


        $user = Auth::user();
        $pendaftar = Pendaftar::findOrFail($user->pendaftar_id);

        $pendaftar->update([
            'sekolah_id' => $request->sekolah_id,
            'pondok_id' => $request->pondok_id == '0' ? null : $request->pondok_id,
            'pilih_lembaga' => 'selesai'
        ]);



        return redirect()->route('pendaftar.upload-berkas.index')
            ->with('success', 'Pilihan berhasil disimpan.');
    }
}
