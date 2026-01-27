<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        // Mengambil 20 log terbaru beserta data user-nya
        $logs = AuditLog::with('user')->latest()->paginate(20);

        return view('dashboard.superadmin.audit-log.index', compact('logs'));
    }

    public function getLatest(Request $request)
    {
        $lastId = $request->get('last_id');

        // Ambil data yang LEBIH BARU dari ID terakhir di browser user
        $newLogs = AuditLog::with('user')
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc') // Penting agar ID terbaru ada di urutan terakhir koleksi
            ->get();

        if ($newLogs->isEmpty()) {
            return response()->json(['count' => 0]);
        }

        // Ambil ID terbesar dari data baru yang ditemukan
        $actualNewLastId = $newLogs->max('id');

        return response()->json([
            'count' => $newLogs->count(),
            // Kita reverse saat tampil di view agar yang paling baru di atas
            'html' => view('dashboard.superadmin.audit-log._list_rows', ['logs' => $newLogs->reverse()])->render(),
            'new_last_id' => $actualNewLastId,
        ]);
    }
}
