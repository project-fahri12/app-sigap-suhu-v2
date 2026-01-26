<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DaftarUlang;
use App\Models\Pendaftar;
use App\Models\Santri;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarUlangController extends Controller
{
    public function index(Request $request)
    {
        $totalTagihanPerSiswa = 5000000;
        $statusTab = $request->get('tab', 'semua');

        $query = Pendaftar::with(['informasiKontak', 'daftarUlang'])
            ->withSum('daftarUlang as total_dibayar', 'dibayar');

        // Filter Berdasarkan Tab
        if ($statusTab === 'belum_input') {
            $query->doesntHave('daftarUlang');
        } elseif ($statusTab === 'cicilan') {
            $query->whereHas('daftarUlang')
                  ->having('total_dibayar', '>', 0)
                  ->having('total_dibayar', '<', $totalTagihanPerSiswa);
        } elseif ($statusTab === 'lunas') {
            $query->having('total_dibayar', '>=', $totalTagihanPerSiswa);
        }

        // Filter Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('kode_pendaftaran', 'like', "%{$request->search}%");
            });
        }

        // Urutan: Belum bayar (0) paling atas, lalu urutkan yang terbaru
        $pendaftars = $query->orderBy(DB::raw('COALESCE(total_dibayar, 0)'), 'asc')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Data Statistik & Counter Tab
        $totalMasuk = DaftarUlang::sum('dibayar');
        
        // Counter dinamis untuk badge di tab
        $counts = [
            'semua'       => Pendaftar::count(),
            'belum_input' => Pendaftar::doesntHave('daftarUlang')->count(),
            'cicilan'     => Pendaftar::whereHas('daftarUlang')
                                ->withSum('daftarUlang as total', 'dibayar')
                                ->get()->filter(fn($p) => $p->total > 0 && $p->total < $totalTagihanPerSiswa)->count(),
            'lunas'       => Pendaftar::withSum('daftarUlang as total', 'dibayar')
                                ->get()->filter(fn($p) => $p->total >= $totalTagihanPerSiswa)->count(),
        ];

        if ($request->ajax()) {
            return view('dashboard.superadmin.daftar-ulang._table', compact('pendaftars', 'totalTagihanPerSiswa'))->render();
        }

        return view('dashboard.superadmin.daftar-ulang.index', [
            'pendaftars' => $pendaftars,
            'totalMasuk' => $totalMasuk,
            'lunasCount' => $counts['lunas'],
            'counts' => $counts,
            'totalTagihanPerSiswa' => $totalTagihanPerSiswa,
            'statusTab' => $statusTab
        ]);
    }

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
            $status = ($totalSetelahBayarBaru >= $request->tagihan) ? 'lunas' : 'cicilan';

            DaftarUlang::create([
                'pendaftar_id' => $request->pendaftar_id,
                'tagihan' => $request->tagihan,
                'dibayar' => $request->dibayar,
                'status_pembayaran' => $status,
                'keterangan' => $request->keterangan,
            ]);

            $pendaftar = Pendaftar::lockForUpdate()->findOrFail($request->pendaftar_id);

            if ($status === 'lunas') {
                $pendaftar->update(['status_pendaftaran' => 'diterima']);
                $nis = $this->generateNis($pendaftar);

                Siswa::firstOrCreate(['pendaftar_id' => $pendaftar->id], [
                    'nis' => $nis,
                    'sekolah_id' => $pendaftar->sekolah_id,
                    'pondok_id' => $pendaftar->pondok_id,
                    'status_siswa' => 'Aktif',
                ]);

                Santri::firstOrCreate(['pendaftar_id' => $pendaftar->id], [
                    'pondok_id' => $pendaftar->pondok_id,
                    'sekolah_id' => $pendaftar->sekolah_id,
                    'nis' => $nis,
                    'status_santri' => 'Aktif',
                ]);
            } else {
                $pendaftar->update(['status_pendaftaran' => 'dispensasi pembayaran']);
            }
        });

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    private function generateNis(Pendaftar $pendaftar)
    {
        $tahun = date('Y');
        $sekolah = str_pad($pendaftar->sekolah_id, 3, '0', STR_PAD_LEFT);
        $urut = Siswa::whereHas('pendaftar', fn($q) => $q->where('sekolah_id', $pendaftar->sekolah_id))
            ->whereYear('created_at', $tahun)->count() + 1;

        return "{$tahun}{$sekolah}" . str_pad($urut, 4, '0', STR_PAD_LEFT);
    }
}