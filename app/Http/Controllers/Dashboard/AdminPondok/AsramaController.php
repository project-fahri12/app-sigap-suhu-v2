<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Asrama;
use Illuminate\Http\Request;

class AsramaController extends Controller
{
    public function index()
    {
        $asramas = Asrama::latest()->paginate(10);
        return view('dashboard.admin-pondok.asrama.index', compact('asramas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_asrama'   => 'required|string|max:255',
            'status_asrama' => 'nullable|string|max:255',
        ]);

        Asrama::create([
            'nama_asrama'   => $request->nama_asrama,
            'status_asrama' => $request->status_asrama ?? 'Aktif',
        ]);

        return redirect()->back()->with('success', 'Asrama baru berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_asrama'   => 'required|string|max:255',
            'status_asrama' => 'nullable|string|max:255',
        ]);

        $asrama = Asrama::findOrFail($id);
        $asrama->update($request->all());

        return redirect()->back()->with('success', 'Data asrama berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Asrama::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Asrama berhasil dihapus!');
    }
}