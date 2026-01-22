<?php

namespace App\Http\Controllers\Dashboard\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadBerkasController extends Controller
{
    public function index()
    {
        // Daftar berkas yang diperlukan
        $docsConfig = [
            ['id' => 'kk', 'n' => 'KK', 'i' => 'fa-users'],
            ['id' => 'akta', 'n' => 'Akta Lahir', 'i' => 'fa-baby'],
            ['id' => 'foto', 'n' => 'Pas Foto', 'i' => 'fa-user-tie'],
            ['id' => 'ktp', 'n' => 'KTP Ortu', 'i' => 'fa-id-card'],
            ['id' => 'rapor', 'n' => 'Rapor', 'i' => 'fa-book'],
            ['id' => 'ijazah', 'n' => 'Ijazah', 'i' => 'fa-certificate'],
            ['id' => 'nisn', 'n' => 'NISN', 'i' => 'fa-fingerprint'],
            ['id' => 'pres', 'n' => 'Sertifikat', 'i' => 'fa-trophy'],
            ['id' => 'kps', 'n' => 'KPS/KIP', 'i' => 'fa-hand-holding-heart'],
        ];

        $user = Auth::user();

        // Pastikan user punya data pendaftar
        if (! $user->pendaftar_id) {
            return redirect()->back()->with('error', 'Data pendaftar tidak ditemukan.');
        }

        $pendaftarId = $user->pendaftar_id;

        // Ambil data berkas yang sudah diupload
        $uploadedDocs = DB::table('berkas_paths')
            ->where('pendaftar_id', $pendaftarId)
            ->get()
            ->keyBy('jenis_berkas');

        // Gabungkan config + data upload
        $finalDocs = collect($docsConfig)->map(function ($doc) use ($uploadedDocs) {
            $uploaded = $uploadedDocs->get($doc['id']);

            return [
                'id'         => $doc['id'],
                'n'          => $doc['n'],
                'i'          => $doc['i'],
                'path'       => $uploaded->path_file ?? null,
                'status'     => $uploaded->status_berkas ?? 'belum',
                'keterangan' => $uploaded->keterangan ?? null,
            ];
        });

        return view('dashboard.pendaftar.upload-berkas', compact('finalDocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_berkas' => 'required',
            'file_berkas'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $pendaftarId = Auth::user()->pendaftar_id;
        $jenis       = $request->jenis_berkas;

        // Cek apakah berkas sudah ada
        $existing = DB::table('berkas_paths')
            ->where('pendaftar_id', $pendaftarId)
            ->where('jenis_berkas', $jenis)
            ->first();

        // Upload file
        $file     = $request->file('file_berkas');
        $fileName = $jenis . '_' . $pendaftarId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('uploads/berkas', $fileName, 'public');

        if ($existing) {
            // Hapus file lama
            if ($existing->path_file) {
                Storage::disk('public')->delete($existing->path_file);
            }

            // Update data
            DB::table('berkas_paths')
                ->where('id', $existing->id)
                ->update([
                    'path_file'    => $path,
                    'status_berkas'=> 'pending',
                    'keterangan'   => null,
                    'updated_at'   => now(),
                ]);
        } else {
            // Insert baru
            DB::table('berkas_paths')->insert([
                'pendaftar_id'  => $pendaftarId,
                'jenis_berkas'  => $jenis,
                'path_file'     => $path,
                'status_berkas' => 'pending',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        DB::table('pendaftars')
            ->where('id', $pendaftarId)
            ->where('status_pendaftaran', '!=', 'pending')
            ->update([
                'status_pendaftaran' => 'pending',
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Berkas berhasil diunggah dan sedang diproses.');
    }
}
