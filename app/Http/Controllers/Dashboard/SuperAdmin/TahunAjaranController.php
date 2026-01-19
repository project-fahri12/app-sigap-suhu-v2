<?php
namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TahunAjaranController extends Controller
{
    public function index() {
        return view("dashboard.superadmin.tahunajaran.index", [
            "tahunAjarans" => TahunAjaran::orderBy('tahun_mulai', 'desc')->get()
        ]);
    }

    public function store(Request $request) {
        $nama = $request->tahun_mulai . '/' . $request->tahun_selesai;

        // 1. Cek Duplikat
        if (TahunAjaran::where('nama', $nama)->exists()) {
            return back()->with('error', "Tahun Ajaran $nama sudah ada!");
        }

        // 2. Jika diset Aktif, matikan yang lain
        if ($request->is_aktif == 1) {
            TahunAjaran::query()->update(['is_aktif' => 0]);
        }

        TahunAjaran::create([
            'nama' => $nama,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'is_aktif' => $request->is_aktif
        ]);

        return back()->with('success', 'Berhasil ditambah!');
    }

    public function update(Request $request, $id) {
        $ta = TahunAjaran::findOrFail($id);
        $nama = $request->tahun_mulai . '/' . $request->tahun_selesai;

        // 1. Cek Duplikat (kecuali dirinya sendiri)
        if (TahunAjaran::where('nama', $nama)->where('id', '!=', $id)->exists()) {
            return back()->with('error', "Tahun Ajaran $nama sudah ada!");
        }

        // 2. Jika diubah jadi Aktif, matikan yang lain
        if ($request->is_aktif == 1) {
            TahunAjaran::where('id', '!=', $id)->update(['is_aktif' => 0]);
        }

        $ta->update([
            'nama' => $nama,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'is_aktif' => $request->is_aktif
        ]);

        return back()->with('success', 'Berhasil diubah!');
    }

    public function destroy($id) {
        $ta = TahunAjaran::findOrFail($id);

        // 3. Proteksi: Jika Aktif dilarang hapus
        if ($ta->is_aktif) {
            return back()->with('error', 'Tahun aktif tidak boleh dihapus!');
        }

        $ta->delete();
        return back()->with('success', 'Berhasil dihapus!');
    }
}