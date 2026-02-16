<?php

namespace App\Http\Controllers\Dashboard\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataPendaftar extends Controller
{
    /**
     * Menampilkan halaman formulir pendaftaran
     */
    public function index()
    {
        // Ambil data pendaftar berdasarkan User yang login
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['orangTua', 'wali', 'informasiKontak'])->find($user->pendaftar_id);

        if (!$pendaftar) {
            return redirect()->route('logout')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Jika status sudah pending/dikunci, user tidak boleh edit lagi (Opsional)
        // if ($pendaftar->status_pendaftaran !== 'draft') {
        //     return redirect()->route('pendaftar.dashboard')->with('info', 'Pendaftaran Anda sudah difinalisasi.');
        // }

        return view('dashboard.pendaftar.data-pendaftar', compact('pendaftar'));
    }

    /**
     * Menyimpan progres setiap tab (via AJAX Next)
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $pendaftar = Pendaftar::findOrFail($id);

            // 1. Update Data Utama Pendaftar
            $dataUtama = array_filter($request->only([
                'nama_lengkap', 'nisn', 'tempat_lahir', 'tanggal_lahir', 'nik', 'nomor_kk',
                'jenis_kelamin', 'anak_ke', 'jumlah_saudara', 'domisili_santri',
                'berkebutuhan_khusus', 'alamat_lengkap', 'rt', 'rw', 'provinsi',
                'kabupaten', 'kecamatan', 'desa', 'kode_pos', 'sekolah_asal',
                'npsn_sekolah', 'status_sekolah', 
            ]), fn ($value) => $value !== null);

            // Update kolom last_step berdasarkan input dari JS
            if ($request->has('current_step')) {
                $dataUtama['last_step'] = $request->current_step;
            }

            $pendaftar->update($dataUtama);

            // 2. Update Data Orang Tua
            $dataOrangTua = array_filter($request->only([
                'nama_ayah', 'nik_ayah', 'pendidikan_terakhir_ayah', 'status_ayah',
                'pekerjaan_ayah', 'penghasilan_ayah', 'nama_ibu', 'nik_ibu',
                'pendidikan_terakhir_ibu', 'status_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
            ]), fn ($value) => $value !== null);

            if (!empty($dataOrangTua)) {
                $pendaftar->orangTua()->updateOrCreate(['pendaftar_id' => $pendaftar->id], $dataOrangTua);
            }

            // 3. Update Data Wali (Opsional)
            if ($request->filled('nama_wali')) {
                $dataWali = array_filter($request->only([
                    'nama_wali', 'nik_wali', 'hubungan', 'pendidikan_terakhir',
                    'pekerjaan_wali', 'penghasilan_wali', 'alamat_lengkap_wali',
                ]), fn ($value) => $value !== null);

                $pendaftar->wali()->updateOrCreate(['pendaftar_id' => $pendaftar->id], $dataWali);
            }

            // 4. Update Informasi Kontak
            $dataKontak = array_filter($request->only([
                'no_hp_ayah', 'no_hp_ibu', 'no_hp_wali', 'no_wa', 'email',
            ]), fn ($value) => $value !== null);

            if (!empty($dataKontak)) {
                $pendaftar->informasiKontak()->updateOrCreate(['pendaftar_id' => $pendaftar->id], $dataKontak);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Progres berhasil disimpan ke tahap ' . $request->current_step,
                'last_step' => $pendaftar->last_step
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Finalisasi Pendaftaran (Step Akhir)
     */
    public function finalisasi(Request $request)
    {
        try {
            $pendaftar = Auth::user()->pendaftar;

            // Validasi checkbox persetujuan
            if (!$request->has('checkFinal')) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda harus menyetujui pernyataan kebenaran data.'
                ], 422);
            }

            // Update status menjadi pending dan set last_step ke tahap akhir (5)
            $pendaftar->update([
                'status_pendaftaran' => 'pending',
                'last_step' => 5
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Anda berhasil difinalisasi! Silakan tunggu proses verifikasi berkas.',
                'redirect' => route('pendaftar.dashboard')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat finalisasi: ' . $e->getMessage()
            ], 500);
        }
    }
}