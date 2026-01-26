@forelse($santris as $index => $s)
<tr class="santri-row">
    <td class="ps-4">
        <input type="checkbox" class="form-check-input select-item" value="{{ $s->id }}">
    </td>
    <td class="text-muted small">{{ $santris->firstItem() + $index }}</td>
    <td>
        <div class="fw-bold text-dark">{{ $s->pendaftar->nama_lengkap ?? 'N/A' }}</div>
        <small class="text-muted">{{ $s->nis }}</small>
    </td>
    <td>
        <div class="small fw-bold text-success text-uppercase">{{ $s->sekolah->nama_sekolah ?? 'Belum Diatur' }}</div>
        <div class="text-muted" style="font-size: 11px;"> {{ $s->sekolah->rumbel->nama_rumbel ?? 'Tidak diketahui' }}</div>
    </td>
    <td>
    <div class="d-flex align-items-center">
        <div class="bg-light text-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
            <i class="fas fa-door-open small"></i>
        </div>
        <div>
            @if($s->romkam)
                {{-- Menampilkan Nama Asrama & Nama Kamar --}}
                <div class="small fw-bold text-dark">
                    {{ $s->romkam->asrama->nama_asrama ?? 'Asrama Tdk Ditemukan' }}
                </div>
                <div class="text-muted" style="font-size: 11px;">
                    {{ $s->romkam->nama_romkam }}
                </div>
            @else
                {{-- Tampilan jika santri belum punya kamar (romkam_id null) --}}
                <div class="small fw-bold text-danger">Belum Plotting</div>
                <div class="text-muted" style="font-size: 10px;">Kamar Belum Diatur</div>
            @endif
        </div>
    </div>
</td>
    <td>
        <a href="https://wa.me/{{ $s->pendaftar->informasiKontak->no_wa ?? '' }}" target="_blank" class="btn btn-sm btn-light rounded-pill px-3 border text-success">
            <i class="fab fa-whatsapp me-1"></i> WA Ortu
        </a>
    </td>
    <td>
        @php
            $badgeColor = [
                'Aktif' => 'bg-success',
                'Lulus' => 'bg-primary',
                'Tamat' => 'bg-info',
                'Mutasi' => 'bg-warning',
                'Drop Out' => 'bg-danger'
            ];
        @endphp
        <span class="badge {{ $badgeColor[$s->status_santri] ?? 'bg-secondary' }} rounded-pill px-3 fw-normal">
            {{ $s->status_santri }}
        </span>
    </td>
    <td class="text-end pe-4">
        <div class="btn-group shadow-none">
            <button class="btn btn-light btn-sm text-muted"><i class="fas fa-lock"></i></button>
            <button class="btn btn-light btn-sm text-info"><i class="fas fa-eye"></i></button>
            <button class="btn btn-light btn-sm text-warning"><i class="fas fa-edit"></i></button>
            <button class="btn btn-light btn-sm text-danger"><i class="fas fa-print"></i></button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center py-5 text-muted">Data santri tidak ditemukan.</td>
</tr>
@endforelse

@if($santris->hasPages())
<tr>
    <td colspan="8" class="p-4 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Menampilkan {{ $santris->firstItem() }} - {{ $santris->lastItem() }} dari {{ $santris->total() }} Santri
            </div>
            <div class="ajax-pagination">
                {{ $santris->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </td>
</tr>
@endif