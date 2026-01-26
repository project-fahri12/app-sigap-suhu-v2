@forelse($siswas as $s)
<tr>
    <td class="ps-4">
        <div class="d-flex align-items-center">
            <div class="avatar-sm me-3">
                @if($s->pendaftar && $s->pendaftar->foto)
                    <img src="{{ asset('storage/' . $s->pendaftar->foto) }}" class="rounded-circle w-100 h-100 object-fit-cover border shadow-sm">
                @else
                    <div class="w-100 h-100 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold border">
                        {{ strtoupper(substr($s->pendaftar->nama_lengkap ?? 'S', 0, 2)) }}
                    </div>
                @endif
            </div>
            <div>
                <div class="fw-bold text-dark text-uppercase small">{{ $s->pendaftar->nama_lengkap ?? 'Tanpa Nama' }}</div>
                <small class="text-muted">{{ $s->pendaftar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
            </div>
        </div>
    </td>
    <td><code class="fw-bold">{{ $s->nis ?? 'Belum Ada' }}</code></td>
    <td>
        <div class="fw-bold">{{ $s->kelas->nama_kelas ?? '-' }}</div>
        <small class="text-primary fw-bold">{{ $s->rombel->nama_rombel ?? 'Belum Diplot' }}</small>
    </td>
    <td class="small">{{ $s->pondok->nama_pondok ?? '-' }}</td>
    <td>
        @php $statusDU = $s->pendaftar->status_pendaftaran ?? ''; @endphp
        <span class="badge {{ $statusDU == 'diterima' ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info' }} border px-3">
            {{ $statusDU == 'diterima' ? 'Lunas' : 'Dispensasi' }}
        </span>
    </td>
    <td>
        <span class="badge {{ $s->status_santri == 'Aktif' ? 'bg-success-subtle text-success border-success' : 'bg-danger-subtle text-danger border-danger' }} border px-3 text-uppercase">
            {{ $s->status_santri }}
        </span>
    </td>
    <td class="text-center pe-4">
        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 border" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $s->id }}">
            <i class="fas fa-eye me-1"></i> Detail
        </button>
    </td>
</tr>
{{-- Sertakan Modal di sini agar tetap ter-load saat AJAX --}}
@include('dashboard.admin-sekolah.data-siswa._modal_detail', ['s' => $s])
@empty
<tr>
    <td colspan="7" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
</tr>
@endforelse

<tr>
    <td colspan="7" class="border-0">
        <div class="d-flex justify-content-between align-items-center p-3">
            <small class="text-muted">Menampilkan {{ $siswas->firstItem() }} - {{ $siswas->lastItem() }} dari {{ $siswas->total() }}</small>
            <div class="ajax-pagination">
                {{ $siswas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </td>
</tr>