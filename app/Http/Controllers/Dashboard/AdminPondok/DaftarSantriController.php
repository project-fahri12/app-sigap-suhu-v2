<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class   DaftarSantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with(['pendaftar', 'sekolah', 'romkam.asrama']);

        // Pencarian Live
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nis', 'like', '%'.$request->search.'%')
                    ->orWhereHas('pendaftar', function ($sq) use ($request) {
                        $sq->where('nama_lengkap', 'like', '%'.$request->search.'%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_santri', $request->status);
        }

        $santris = $query->latest()->paginate(10)->appends($request->all());

        if ($request->ajax()) {
            return view('dashboard.admin-pondok.daftar-santri._table', compact('santris'))->render();
        }

        return view('dashboard.admin-pondok.daftar-santri.index', compact('santris'));
    }

             // export pfd
    public function exportPdf(Request $request)
{
    $user = Auth::user();
    $namaInstansi = "YAYASAN PONDOK PESANTREN";
    $instansi = null;

    if ($user->sekolah_id) {
        $instansi = \App\Models\Sekolah::find($user->sekolah_id);
        $namaInstansi = $instansi->nama_sekolah;
    } elseif ($user->pondok_id) {
        $instansi = \App\Models\Pondok::find($user->pondok_id);
        $namaInstansi = $instansi->nama_pondok;
    }

    $query = Santri::with(['pendaftar', 'sekolah', 'romkam.asrama']);

    // Filter Pencarian
    if ($request->filled('search')) {
        $query->whereHas('pendaftar', function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
        })->orWhere('nis', 'like', '%'.$request->search.'%');
    }

    // URUTKAN BERDASARKAN WAKTU MASUK (Awal ke Akhir)
    $santris = $query->orderBy('created_at', 'asc')->get();

    // Grouping per Asrama tetap dipertahankan
    $santriPerAsrama = $santris->groupBy(function($item) {
        return $item->romkam->asrama->nama_asrama ?? 'BELUM ADA ASRAMA';
    });

    $pdf = Pdf::loadView('dashboard.admin-pondok.daftar-santri.export.pdf', [
        'santriPerAsrama' => $santriPerAsrama,
        'namaInstansi' => $namaInstansi,
        'instansi' => $instansi
    ])->setPaper('a4', 'portrait');

    return $pdf->stream('Laporan-Santri-'.now()->format('Y-m-d').'.pdf');
}
}
