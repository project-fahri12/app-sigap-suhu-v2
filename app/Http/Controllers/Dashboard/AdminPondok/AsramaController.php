<?php

namespace App\Http\Controllers\Dashboard\AdminPondok;

use App\Http\Controllers\Controller;
use App\Models\Asrama;
use Illuminate\Http\Request;

class AsramaController extends Controller
{
    public function index(Request $request)
    {
        $query = Asrama::query();

        // Fitur Search
        if ($request->has('search')) {
            $query->where('nama_asrama', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter JK
        if ($request->filled('jk')) {
            $query->where('jk', $request->jk);
        }

        $asramas = $query->latest()->paginate(10);
        
        return view('dashboard.admin-pondok.asrama.index', compact('asramas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_asrama'   => 'required|string|max:255',
            'jk'            => 'required|in:L,P',
            'status_asrama' => 'required|string',
        ]);

        Asrama::create($request->all());

        return redirect()->back()->with('success', 'Asrama baru berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_asrama'   => 'required|string|max:255',
            'jk'            => 'required|in:L,P',
            'status_asrama' => 'required|string',
        ]);

        $asrama = Asrama::findOrFail($id);
        $asrama->update($request->all());

        return redirect()->back()->with('success', 'Data asrama berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asrama = Asrama::findOrFail($id);
        $asrama->delete();
        
        return redirect()->back()->with('success', 'Asrama berhasil dihapus!');
    }
}