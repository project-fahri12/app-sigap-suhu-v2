@forelse($logs as $log)
    @php
        $action = strtoupper($log->action);
        $color = match($action) {
            'ERROR' => 'bg-danger',
            'WARN'  => 'bg-warning text-dark',
            'INFO'  => 'bg-success',
            default => 'bg-dark'
        };
    @endphp

    <tr class="audit-row {{ $action == 'ERROR' ? 'table-danger-custom' : '' }}" 
        data-user="{{ $log->user->name ?? 'System' }}" 
        data-action="{{ $action }}"
        data-desc="{{ $log->description }}" 
        data-badge-color="{{ $color }}"
        data-model="{{ $log->model ?? 'N/A' }}"
        data-modelid="{{ $log->model_id ?? '-' }}"
        data-fulltime="{{ $log->created_at->translatedFormat('d F Y, H:i:s') }}" 
        data-ip="{{ $log->ip_address }}">
        
        <td class="ps-4">
            <div class="fw-bold small">{{ $log->created_at->format('H:i:s') }}</div>
            <div class="text-muted" style="font-size: 10px;">{{ $log->created_at->format('d/m/Y') }}</div>
        </td>
        <td>
            <div class="small fw-bold">{{ $log->user->name ?? 'System' }}</div>
            <div class="text-muted" style="font-size: 9px;">{{ strtoupper($log->user->role ?? 'Server') }}</div>
        </td>
        <td><span class="badge {{ $color }} rounded-pill px-3" style="font-size: 10px;">{{ $action }}</span></td>
        <td><div class="small text-truncate" style="max-width: 300px;">{{ $log->description }}</div></td>
        <td class="text-center font-monospace small text-muted">{{ $log->ip_address }}</td>
    </tr>
@empty
@endforelse