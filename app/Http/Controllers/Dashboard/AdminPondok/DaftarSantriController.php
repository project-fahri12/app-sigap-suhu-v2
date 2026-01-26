<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DaftarSantriController extends Controller
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
        $query = Santri::with(['pendaftar', 'sekolah', 'romkam.asrama']);

        // Gunakan filter yang sama dengan fungsi index
        if ($request->filled('search')) {
            $query->whereHas('pendaftar', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
            })->orWhere('nis', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('status')) {
            $query->where('status_santri', $request->status);
        }
        // Contoh urutan berdasarkan nama pendaftar (A-Z)
        $santris = $query->join('pendaftars', 'santris.pendaftar_id', '=', 'pendaftars.id')
            ->orderBy('pendaftars.nama_lengkap', 'asc')
            ->get();

        $pdf = Pdf::loadView('dashboard.admin-pondok.daftar-santri.export.pdf', compact('santris'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Data-Santri-'.now()->format('Y-m-d').'.pdf');
    }
}
