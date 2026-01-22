<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DaftarUlang;
use App\Models\Pendaftar;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarUlangController extends Controller
{
    public function index(Request $request)
    {
        $totalTagihanPerSiswa = 5000000;

        $query = Pendaftar::with(['informasiKontak'])
            ->withSum('daftarUlang as total_dibayar', 'dibayar');

        if ($request->has('search')) {
            $query->where('nama_lengkap', 'like', "%{$request->search}%")
                ->orWhere('kode_pendaftaran', 'like', "%{$request->search}%");
        }

        $pendaftars = $query->latest()->get();

        $totalMasuk = DaftarUlang::sum('dibayar');

        $lunasCount = $pendaftars->filter(function ($p) use ($totalTagihanPerSiswa) {
            return ($p->total_dibayar ?? 0) >= $totalTagihanPerSiswa;
        })->count();

        return view('dashboard.superadmin.daftar-ulang.index', compact(
            'pendaftars',
            'totalMasuk',
            'lunasCount',
            'totalTagihanPerSiswa'
        ));
    }

    // ... bagian atas controller tetap sama

    public function store(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id',
            'tagihan' => 'required|numeric|min:1',
            'dibayar' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $sudahDibayar = DaftarUlang::where('pendaftar_id', $request->pendaftar_id)->sum('dibayar');
            $totalSetelahBayarBaru = $sudahDibayar + $request->dibayar;

            // Tentukan status berdasarkan nominal tagihan
            $status = ($totalSetelahBayarBaru >= $request->tagihan) ? 'lunas' : 'cicilan';

            // 1. Simpan Transaksi Pembayaran
            DaftarUlang::create([
                'pendaftar_id' => $request->pendaftar_id,
                'tagihan' => $request->tagihan,
                'dibayar' => $request->dibayar,
                'status_pembayaran' => $status,
                'keterangan' => $request->keterangan,
            ]);

            $pendaftar = Pendaftar::lockForUpdate()->findOrFail($request->pendaftar_id);

            if ($status === 'lunas') {
                // 2a. Update status jadi Diterima
                $pendaftar->update(['status_pendaftaran' => 'diterima']);

                // 3. Buat Data Siswa
                Siswa::firstOrCreate(
                    ['pendaftar_id' => $pendaftar->id],
                    [
                        'nis' => $this->generateNis($pendaftar),
                        'pondok_id' => $pendaftar->pondok_id,
                        'status_santri' => 'Aktif',
                    ]
                );
            } else {
                // 2b. Jika masih cicilan, update status jadi Dispensasi Pembayaran
                $pendaftar->update(['status_pendaftaran' => 'dispensasi pembayaran']);
            }
        });

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    private function generateNis(Pendaftar $pendaftar)
    {
        $tahun = date('Y');

        // Ambil ID sekolah, misal ID 1 jadi 001
        $sekolah = str_pad($pendaftar->sekolah_id, 3, '0', STR_PAD_LEFT);

        // PERBAIKAN: Hitung urutan dari tabel SISWAS, bukan PENDAFTARS
        $urut = Siswa::whereHas('pendaftar', function ($q) use ($pendaftar) {
            $q->where('sekolah_id', $pendaftar->sekolah_id);
        })
            ->whereYear('created_at', $tahun)
            ->count() + 1;

        $noUrut = str_pad($urut, 4, '0', STR_PAD_LEFT);

        return "{$tahun}{$sekolah}{$noUrut}";
    }
}
