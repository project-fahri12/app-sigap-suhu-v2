<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftar;
use App\Models\InformasiKontak;
use App\Models\OrangTua;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DaftarController extends Controller
{
    public function index()
    {
        return view('daftar');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (No Reload)
        $validator = Validator::make($request->all(), [
            'nisn'          => 'required|numeric|digits:10|unique:users,nisn|unique:pendaftars,nisn',
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email|unique:informasi_kontaks,email',
            'whatsapp'      => 'required|numeric',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah'  => 'required',
        ], [
            'nisn.unique'   => 'NISN sudah terdaftar.',
            'email.unique'  => 'Email sudah digunakan.',
            'required'      => ':attribute wajib diisi.',
            'digits'        => 'NISN harus 10 digit.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Database Transaction
        DB::beginTransaction();

        try {
            // Ambil Tahun Ajaran Aktif (Wajib ada di DB)
            $tahunAjaran = DB::table('tahun_ajarans')->where('is_aktif', '1')->first();
            
            if (!$tahunAjaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran aktif belum diatur oleh Admin.'
                ], 422);
            }

            // A. Simpan ke tabel pendaftars
            $kodePendaftaran = 'PSB-' . date('Y') . '-' . strtoupper(Str::random(5));
            
            $pendaftar = Pendaftar::create([
                'kode_pendaftaran'   => $kodePendaftaran,
                'tahun_ajaran_id'    => $tahunAjaran->id,
                'nama_lengkap'       => strtoupper($request->nama),
                'nisn'               => $request->nisn,
                'tempat_lahir'       => $request->tempat_lahir,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'sekolah_asal'       => strtoupper($request->asal_sekolah),
                'status_pendaftaran' => 'draft',
                'status_berkas'      => 'belum',
            ]);

            InformasiKontak::create([
                'pendaftar_id' => $pendaftar->id,
                'no_wa'        => $request->whatsapp,
                'email'        => $request->email,
            ]);

            OrangTua::create([
                'pendaftar_id'   => $pendaftar->id,
            ]);

            Wali::create([
                'pendaftar_id' => $pendaftar->id
            ]);


            User::create([
                'nisn'         => $request->nisn,
                'name'         => strtoupper($request->nama),
                'email'        => $request->email,
                'password'     => Hash::make($request->nisn), 
                'role'         => 'pendaftar',
                'pendaftar_id' => $pendaftar->id,
                'is_aktif'     => 'non_aktif',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi Berhasil! Gunakan NISN sebagai password login Anda.',
                'redirect' => route('home') 
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}