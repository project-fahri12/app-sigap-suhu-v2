<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\DaftarUlang;
use Illuminate\Http\Request;

class DaftarUlangController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan nominal tagihan tetap (misal 5jt)
        $totalTagihanPerSiswa = 5000000;

        // 2. Query Pendaftar dengan total pembayaran yang dijumlahkan otomatis
        $query = Pendaftar::with(['informasiKontak'])
            ->withSum('daftarUlang as total_dibayar', 'dibayar');

        // Fitur Search
        if ($request->has('search')) {
            $query->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('kode_pendaftaran', 'like', "%{$request->search}%");
        }

        $pendaftars = $query->latest()->get();
        
        // 3. Statistik Global
        $totalMasuk = DaftarUlang::sum('dibayar');
        
        // Menghitung jumlah pendaftar yang sudah lunas (total_dibayar >= tagihan)
        $lunasCount = $pendaftars->filter(function($p) use ($totalTagihanPerSiswa) {
            return ($p->total_dibayar ?? 0) >= $totalTagihanPerSiswa;
        })->count();

        return view('dashboard.superadmin.daftar-ulang.index', compact(
            'pendaftars', 
            'totalMasuk', 
            'lunasCount', 
            'totalTagihanPerSiswa'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id',
            'dibayar' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Simpan transaksi baru
        DaftarUlang::create([
            'pendaftar_id' => $request->pendaftar_id,
            'dibayar' => $request->dibayar,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan!');
    }
}