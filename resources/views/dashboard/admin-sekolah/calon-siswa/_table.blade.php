@forelse ($pendaftar as $p)
<tr>
    <td class="ps-4">
        <div class="fw-bold text-dark text-xs text-uppercase">{{ $p->nama_lengkap }}</div>
        <div class="text-muted" style="font-size: 10px;">{{ $p->kode_pendaftaran }}</div>
    </td>
    <td>
        <div class="text-xs">
            @if($p->informasiKontak->no_wa)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->no_wa) }}" target="_blank" class="text-success fw-bold text-decoration-none">
                    <i class="fab fa-whatsapp me-1"></i>{{ $p->no_wa }}
                </a>
            @else
                <span class="text-muted small">Tidak ada WA</span>
            @endif
        </div>
    </td>
    <td>
        <span class="text-xs">{{ $p->pondok->nama_pondok ?? 'Laju' }}</span>
    </td>
    <td>
        @php
            $status = strtolower($p->status_pendaftaran);
            // Pemetaan warna berdasarkan status
            $colors = [
                'pendaftaran' => 'bg-info-subtle text-info border-info',
                'seleksi'     => 'bg-warning-subtle text-warning border-warning',
                'diterima'    => 'bg-success-subtle text-success border-success',
                'ditolak'     => 'bg-danger-subtle text-danger border-danger',
            ];
            $badgeStyle = $colors[$status] ?? 'bg-secondary-subtle text-secondary border-secondary';
        @endphp
        <span class="badge {{ $badgeStyle }} border px-2 py-1 rounded-pill text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">
            {{ $p->status_pendaftaran }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-5">
        <div class="text-muted">
            <i class="fas fa-user-slash fa-2x mb-2 opacity-25"></i>
            <p class="text-xs mb-0">Tidak ada calon siswa yang ditemukan</p>
        </div>
    </td>
</tr>
@endforelse

@if($pendaftar->hasPages())
<tr>
    <td colspan="5" class="p-3 border-0">
        <div class="d-flex justify-content-center">
            {{ $pendaftar->links('pagination::bootstrap-4') }}
        </div>
    </td>
</tr>
@endif