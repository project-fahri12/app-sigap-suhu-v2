@forelse($logs as $log)
    <tr id="log-{{ $log->id }}">
        <td class="ps-4 small">
            {{-- l = Nama hari, d = Tanggal, F = Nama bulan, Y = Tahun --}}
            <span class="d-block fw-bold text-dark">
                {{ $log->created_at->translatedFormat('H:i:s') }}
            </span>
            <span class="text-muted" style="font-size: 10px;">
                {{ $log->created_at->translatedFormat('l, d F Y') }}
            </span>
        </td>
        <td>
            <div class="fw-bold small">{{ $log->user->name ?? 'System' }}</div>
            <div class="text-muted" style="font-size: 10px;">Role: {{ $log->user->role ?? '-' }}</div>
        </td>
        <td>
            @php
                $color = 'bg-primary';
                $action = strtolower($log->action);
                if (str_contains($action, 'delete') || str_contains($action, 'hapus')) {
                    $color = 'bg-danger';
                }
                if (str_contains($action, 'store') || str_contains($action, 'create')) {
                    $color = 'bg-success';
                }
                if (str_contains($action, 'update') || str_contains($action, 'edit')) {
                    $color = 'bg-warning text-dark';
                }
            @endphp
            <span class="badge {{ $color }} rounded-pill" style="font-size: 9px;">
                {{ strtoupper($log->action) }}
            </span>
        </td>
        <td class="small">
            <div class="text-dark" title="{{ $log->description }}">
                {{ Str::limit($log->description, 60) }}
            </div>
        </td>
        <td class="text-center small">
            <span class="badge bg-light text-muted border font-monospace">{{ $log->ip_address }}</span>
        </td>
    </tr>
@empty
    @if (!request()->ajax())
        <tr>
            <td colspan="5" class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                <p>Belum ada log aktivitas hari ini.</p>
            </td>
        </tr>
    @endif
@endforelse
