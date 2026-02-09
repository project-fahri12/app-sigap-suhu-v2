@forelse($logs as $log)
    @php
        $isError = strtoupper($log->action) === 'ERROR';
        $badgeClass = match(strtoupper($log->action)) {
            'ERROR'   => 'bg-danger',
            'CREATE'  => 'bg-success',
            'UPDATE'  => 'bg-warning text-dark',
            'DELETE'  => 'bg-dark',
            default   => 'bg-primary'
        };
    @endphp

    <tr class="audit-row {{ $isError ? 'table-danger-custom' : '' }}" 
        data-user="{{ $log->user->name ?? 'System' }}" 
        data-action="{{ strtoupper($log->action) }}"
        data-desc="{{ $log->description }}" 
        data-badge-color="{{ $badgeClass }}"
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
            <div class="text-muted" style="font-size: 9px;">{{ $log->ip_address }}</div>
        </td>
        <td>
            <span class="badge {{ $badgeClass }} rounded-pill px-3" style="font-size: 10px;">
                {{ strtoupper($log->action) }}
            </span>
        </td>
        <td>
            <div class="small text-truncate {{ $isError ? 'fw-bold text-danger' : '' }}" style="max-width: 350px;">
                {{ $log->description }}
            </div>
        </td>
        <td class="text-center font-monospace small text-muted">
            {{ $log->model ?? '-' }}
        </td>
    </tr>
@empty
@endforelse