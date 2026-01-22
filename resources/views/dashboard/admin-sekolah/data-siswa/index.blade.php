@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Data Siswa Aktif</h4>
            <p class="text-muted small mb-0">Manajemen informasi santri, penempatan kelas, dan rombel.</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-download me-2"></i>Export Excel
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('adminsekolah.data-siswa.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group bg-light rounded-pill border-0 px-3">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 py-2 text-sm" placeholder="Cari NIS atau Nama...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="kelas" class="form-select bg-light rounded-pill border-0 text-sm">
                            <option value="">Semua Kelas</option>
                            @foreach($listKelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="rombel" class="form-select bg-light rounded-pill border-0 text-sm">
                            <option value="">Semua Rombel</option>
                            @foreach($listRombel as $r)
                                <option value="{{ $r->id }}" {{ request('rombel') == $r->id ? 'selected' : '' }}>{{ $r->nama_rombel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select bg-light rounded-pill border-0 text-sm">
                            <option value="">Status</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Mutasi" {{ request('status') == 'Mutasi' ? 'selected' : '' }}>Mutasi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold text-sm">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold text-uppercase">
                        <th class="ps-4">Siswa</th>
                        <th>NIS</th>
                        <th>Kelas / Rombel</th>
                        <th>Pondok</th>
                        <th>Daftar Ulang</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $s)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                              <div class="avatar-sm me-3">
    @if($s->pendaftar && $s->pendaftar->foto)
        {{-- Jika ada foto di database --}}
        <img src="{{ asset('storage/' . $s->pendaftar->foto) }}" 
             alt="Foto {{ $s->pendaftar->nama_lengkap }}" 
             class="rounded-circle w-100 h-100 object-fit-cover border shadow-sm">
    @else
        {{-- Fallback ke Inisial jika foto kosong --}}
        <div class="w-100 h-100 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold border">
            {{ strtoupper(substr($s->pendaftar->nama_lengkap ?? 'S', 0, 2)) }}
        </div>
    @endif
</div>
                                <div>
                                    <div class="fw-bold text-dark text-uppercase">{{ $s->pendaftar->nama_lengkap ?? 'Tanpa Nama' }}</div>
                                    <small class="text-muted">{{ $s->pendaftar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code class="fw-bold">{{ $s->nis ?? 'Belum Ada' }}</code></td>
                        <td>
                            <div class="fw-bold">{{ $s->kelas->nama_kelas ?? '-' }}</div>
                            <small class="text-primary fw-bold">{{ $s->rombel->nama_rombel ?? 'Belum Diplot' }}</small>
                        </td>
                        <td>{{ $s->pondok->nama_pondok ?? '-' }}</td>
                        <td>
                            @php $statusDU = $s->pendaftar->status_pendaftaran ?? ''; @endphp
                            @if($statusDU == 'diterima')
                                <span class="badge bg-success-subtle text-success border border-success px-3">Lunas</span>
                            @else
                                <span class="badge bg-info-subtle text-info border border-info px-3">Dispensasi</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $s->status_santri == 'Aktif' ? 'bg-success-subtle text-success border-success' : 'bg-danger-subtle text-danger border-danger' }} border px-3 text-uppercase">
                                {{ $s->status_santri }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <button type="button" class="btn btn-light btn-sm rounded-pill px-3 border" 
                                    data-bs-toggle="modal" data-bs-target="#modalDetail{{ $s->id }}">
                                <i class="fas fa-eye me-1"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalDetail{{ $s->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow rounded-4">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="fw-800 text-dark">Informasi Detail Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <div class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3 mx-auto" style="width: 70px; height: 70px; font-size: 24px;">
                                            {{ strtoupper(substr($s->pendaftar->nama_lengkap ?? 'S', 0, 2)) }}
                                        </div>
                                        <h5 class="fw-bold mb-0">{{ $s->pendaftar->nama_lengkap }}</h5>
                                        <span class="text-muted">NIS: {{ $s->nis }}</span>
                                    </div>
                                    <ul class="list-group list-group-flush small">
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">NIK</span>
                                            <span class="fw-bold text-dark">{{ $s->pendaftar->nik ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Tempat, Tgl Lahir</span>
                                            <span class="fw-bold text-dark">{{ $s->pendaftar->tempat_lahir }}, {{ $s->pendaftar->tanggal_lahir }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Kelas / Rombel</span>
                                            <span class="fw-bold text-dark">{{ $s->kelas->nama_kelas ?? '-' }} / {{ $s->rombel->nama_rombel ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Status Santri</span>
                                            <span class="badge bg-success px-2">{{ $s->status_santri }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between px-0">
                                            <span class="text-muted">Wali Murid</span>
                                            <span class="fw-bold text-dark">{{ $s->pendaftar->informasiKontak->nama_wali ?? '-' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                    <a href="https://wa.me/{{ $s->pendaftar->informasiKontak->no_hp_wali ?? '' }}" target="_blank" class="btn btn-success rounded-pill px-4">Hubungi Wali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Menampilkan {{ $siswas->firstItem() }} sampai {{ $siswas->lastItem() }} dari {{ $siswas->total() }} siswa</small>
                <div>
                    {{ $siswas->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .text-sm { font-size: 13px; }
    .avatar-sm { width: 40px; height: 40px; font-size: 14px; }
    .table thead th { border: none; padding: 15px; font-size: 11px; letter-spacing: 0.05rem; }
    .table tbody td { padding: 15px; border-color: #f1f5f9; }
    /* Merapikan pagination agar bulat seperti desain awal */
    .pagination .page-item .page-link { border: none; margin: 0 4px; border-radius: 50% !important; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #444; }
    .pagination .page-item.active .page-link { background-color: #0d6efd !important; color: white; }
</style>
@endsection