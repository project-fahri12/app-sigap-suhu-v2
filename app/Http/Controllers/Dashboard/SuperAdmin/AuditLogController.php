<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AuditLogController extends Controller
{
     public function index(Request $request)
    {
        // Ambil 50 data terbaru untuk loading pertama
        $logs = AuditLog::with('user')->latest()->limit(50)->get();
        return view('dashboard.superadmin.audit-log.index', compact('logs'));
    }

    public function getLatest(Request $request)
    {
        $query = AuditLog::with('user')->where('id', '>', $request->last_id);

        // Filter pencarian di sisi server untuk data baru
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('ip_address', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $logs = $query->latest()->get();

        return response()->json([
            'count' => $logs->count(),
            'new_last_id' => $logs->first()->id ?? $request->last_id,
            'html' => view('dashboard.superadmin.audit-log._list_rows', compact('logs'))->render()
        ]);
    }

    public function clear()
    {
        AuditLog::truncate();
        return response()->json(['status' => 'success']);
    }   
}
