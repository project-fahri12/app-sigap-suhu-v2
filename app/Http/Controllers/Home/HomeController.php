<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\GelombangPpdb;
use App\Models\Pendaftar;
use App\Models\Pondok;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $lembagas = Sekolah::with([
            'gelombang' => function ($query) {
                $query->where('is_aktif', 1)
                    ->latest()
                    ->withCount('pendaftar');
            },
        ])->get();

        return view('home', compact('lembagas'));
    }

    public function regist(Request $request)
    {
        $sekolahId = $request->query('sekolah');
        if (! $sekolahId) {
            abort(404);
        }

        $gelombang = GelombangPpdb::where('sekolah_id', $sekolahId)
            ->where('is_aktif', true)
            ->select('nama_gelombang', 'id')
            ->first();
        $sekolah = Sekolah::findOrFail($sekolahId);
        $pondoks = Pondok::orderBy('nama_pondok', 'asc')->get();

        return view('regist.index', compact('sekolah', 'pondoks', 'gelombang'));
    }

    public function registStore(Request $request)
    {
        // // 1. Validasi Data
        // $validated = $request->validate([
        //     'nama_lengkap' => 'required|string|max:255',
        //     'nik' => 'required|digits:16',
        //     'nisn' => 'required|digits:10',
        //     'nomor_kk' => 'required|digits:16',
        //     'tempat_lahir' => 'required|string|max:255',
        //     'tanggal_lahir' => 'required|date',
        //     'jenis_kelamin' => 'required|in:L,P',
        //     'anak_ke' => 'required|numeric',
        //     'jumlah_saudara' => 'required|numeric',
        //     'sekolah_id' => 'required|exists:sekolahs,id',
        //     'pondok_id' => 'nullable|exists:pondoks,id',
        //     'alamat_lengkap' => 'required|string',
        //     'rt' => 'required|max:5',
        //     'rw' => 'required|max:5',
        //     'provinsi' => 'required|string',
        //     'kabupaten' => 'required|string',
        //     'kecamatan' => 'required|string',
        //     'desa' => 'required|string',
        //     'kode_pos' => 'nullable|digits:5',
        //     'sekolah_asal' => 'required|string|max:255',
        //     'status_sekolah' => 'required|string',
        //     'nama_ayah' => 'required|string|max:255',
        //     'nik_ayah' => 'required|digits:16',
        //     'nama_ibu' => 'required|string|max:255',
        //     'nik_ibu' => 'required|digits:16',
        //     'no_wa' => 'required|string|max:15',
        //     'email' => 'required|email|max:255',
        // ]);


        $gelombang = GelombangPpdb::where('sekolah_id', $request->sekolah_id)
            ->where('is_aktif', 1)
            ->first();

        Pendaftar::create([
            'kode_pendaftaran' => 'YYPPSH-'.date('Y').strtoupper(Str::random(5)),
            'tahun_ajaran_id' => TahunAjaran::where('is_aktif', 1),
            'gelombang_ppdb_id' => $gelombang->id ?? null,
            'domisili_santri' => ($request->domisili_santri == 'Mukim') ? 'tetap' : 'nduduk',
            'status_pendaftaran' => 'pendaftar',
            'nama_lengkap'=> $request->nama_lengkap,
            'nik'=> $request->nik,
            'nisn'=> $request->nisn,
            'nomor_kk'=> $request->nomor_kk,
            'tempat_lahir'=> $request->tempat_lahir,
            'tanggal_lahir'=> $request->tanggal_lahir,
            'jenis_kelamin'=> $request->jenis_kelamin,
            'anak_ke'=> $request->anak_ke,
            'jumlah_saudara'=> $request->jumlah_saudara,
            'berkebutuhan_khusus'=> $request->berkebutuhan_khusus,
            'sekolah_id'=> $request->sekolah_id,
            'pondok_id'=> $request->pondok_id,
            'alamat_lengkap'=> $request->alamat_lengkap,
            'provinsi'=> $request->provinsi,
            'kabupaten'=> $request->kabupaten,
            'kecamatan'=> $request->kecamatan,
            'desa'=> $request->desa,
            'kode_pos'=> $request->kode_pos,
            'sekolah_asal'=> $request->sekolah_asal,
            'npsn_sekolah'=> $request->npsn_sekolah,
            'status_sekolah'=> $request->status_sekolah,
        ]);

        return redirect()->back()->with('success','selamat, anda berhasil terdaftar disistem kami');

    }

    public function registSuccess($kode)
    {
        // Cari data pendaftaran berdasarkan kode pendaftaran
        $pendaftaran = Pendaftar::where('kode_pendaftaran', $kode)->firstOrFail();

        return view('regist.success', compact('pendaftaran'));
    }
}
