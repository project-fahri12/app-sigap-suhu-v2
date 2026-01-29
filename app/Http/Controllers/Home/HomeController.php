<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\GelombangPpdb;
use App\Models\InformasiKontak;
use App\Models\OrangTua;
use App\Models\Pendaftar;
use App\Models\Pondok;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

        $tahunAjaranId = TahunAjaran::where('is_aktif', 1)->value('id');

        $stastistik = [
            'total_pendaftar' => $tahunAjaranId
                ? Pendaftar::where('tahun_ajaran_id', $tahunAjaranId)->count()
                : 0,

            'total_pendidikan_formal' => Sekolah::where('is_aktif', 1)->count(),
            'total_unit_ponpes' => Pondok::where('is_aktif', 1)->count(),
        ];

        return view('home', compact('lembagas', 'stastistik', 'tahunAjaranId'));
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
        DB::beginTransaction();

        try {
            $gelombang = GelombangPpdb::where('sekolah_id', $request->sekolah_id)
                ->where('is_aktif', 1)
                ->first();

            $tahunAjaran = TahunAjaran::where('is_aktif', 1)->first();

            $kodePendaftaran = 'YYPPSH-'.date('Y').strtoupper(Str::random(5));

            // 1. Simpan Pendaftar
            $pendaftar = Pendaftar::create([
                'kode_pendaftaran' => $kodePendaftaran,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'gelombang_ppdb_id' => $gelombang->id ?? null,
                'domisili_santri' => ($request->domisili_santri == 'Mukim') ? 'tetap' : 'nduduk',
                'status_pendaftaran' => 'pendaftar',
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'nomor_kk' => $request->nomor_kk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara' => $request->jumlah_saudara,
                'berkebutuhan_khusus' => $request->berkebutuhan_khusus,
                'sekolah_id' => $request->sekolah_id,
                'pondok_id' => $request->pondok_id,
                'alamat_lengkap' => $request->alamat_lengkap ?? '-',
                'rt' => $request->rt,
                'rw' => $request->rw,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'kode_pos' => $request->kode_pos,
                'sekolah_asal' => $request->sekolah_asal,
                'npsn_sekolah' => $request->npsn_sekolah ?? '-',
                'status_sekolah' => $request->status_sekolah,
            ]);

            // 2. Simpan Orang Tua
            OrangTua::create([
                'pendaftaran_id' => $pendaftar->id, // Sesuaikan dengan nama kolom di migration
                'nama_ayah' => $request->nama_ayah,
                'nik_ayah' => $request->nik_ayah,
                'pendidikan_terakhir_ayah' => $request->pendidikan_terakhir_ayah,
                'status_ayah' => $request->status_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'penghasilan_ayah' => $request->penghasilan_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'pendidikan_terakhir_ibu' => $request->pendidikan_terakhir_ibu,
                'status_ibu' => $request->status_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'penghasilan_ibu' => $request->penghasilan_ibu,
            ]);

            // 3. Simpan Wali (Jika nama_wali diisi)
            if ($request->filled('nama_wali')) {
                Wali::create([
                    'pendaftar_id' => $pendaftar->id,
                    'nama_wali' => $request->nama_wali,
                    'nik_wali' => $request->nik_wali,
                    'hubungan' => $request->hubungan,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'pekerjaan_wali' => $request->pekerjaan_wali,
                    'penghasilan_wali' => $request->penghasilan_wali,
                    'alamat_lengkap' => $request->domisili_sekarang ?? '-',
                ]);
            }

            // 4. Simpan Kontak
            InformasiKontak::create([
                'pendaftar_id' => $pendaftar->id,
                'no_hp_ayah' => $request->no_hp_ayah,
                'no_hp_ibu' => $request->no_hp_ibu,
                'no_hp_wali' => $request->no_hp_wali,
                'no_wa' => $request->no_wa,
                'email' => $request->email,
            ]);

            User::create([
                'pendaftar_id' => $pendaftar->id,
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($kodePendaftaran),
            ]);

            DB::commit();

            return redirect()->route('pendaftaran.success', ['kode' => $pendaftar->kode_pendaftaran])
                ->with('success', 'Pendaftaran Berhasil!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            // Log error untuk debug
            Log::error('Gagal Simpan Pendaftaran: '.$e->getMessage());

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage())->withInput();
        }
    }

    public function registSuccess($kode)
    {
        // Cari data pendaftaran berdasarkan kode pendaftaran
        $pendaftaran = Pendaftar::where('kode_pendaftaran', $kode)->firstOrFail();

        return view('regist.success', compact('pendaftaran'));
    }
}
