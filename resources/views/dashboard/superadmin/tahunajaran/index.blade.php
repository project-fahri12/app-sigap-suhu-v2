@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-800 mb-1">Master Tahun Ajaran</h5>
            <p class="small text-muted mb-0">Kelola periode pendaftaran dan akses sistem secara global.</p>
        </div>
        <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded-pill" data-bs-toggle="modal"
            data-bs-target="#modalTambahTA">
            Tambah Tahun Ajaran
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="module-card shadow-sm p-0 overflow-hidden border-0 bg-white">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="bg-light">
                    <tr style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                        <th class="ps-4 py-3">Tahun Ajaran</th>
                        <th>Tahun Mulai</th>
                        <th>Tahun Selesai</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px;">
                    @forelse($tahunAjarans as $ta)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-800 {{ $ta->is_aktif ? 'text-dark' : 'text-muted' }}">{{ $ta->nama }}</div>
                                <small class="text-muted">{{ $ta->is_aktif ? 'Periode Berjalan' : 'Arsip' }}</small>
                            </td>
                            <td>{{ $ta->tahun_mulai }}</td>
                            <td>{{ $ta->tahun_selesai }}</td>
                            <td>
                                @if($ta->is_aktif)
                                    <span class="badge bg-success px-3 py-1 rounded-pill">Aktif</span>
                                @else
                                    <span class="badge bg-light text-muted px-3 py-1 rounded-pill">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-light btn-sm text-primary rounded-3 me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $ta->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('superadmin.tahun-ajaran.destroy', $ta->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm text-danger rounded-3" 
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $ta->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-header border-0 p-4 pb-0">
                                        <h5 class="fw-800 mb-0">Edit Tahun Ajaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('superadmin.tahun-ajaran.update', $ta->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted">TAHUN MULAI</label>
                                                    <input type="number" name="tahun_mulai" class="form-control" value="{{ $ta->tahun_mulai }}" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted">TAHUN SELESAI</label>
                                                    <input type="number" name="tahun_selesai" class="form-control" value="{{ $ta->tahun_selesai }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label small fw-bold text-muted">STATUS GLOBAL</label>
                                                <select name="is_aktif" class="form-select">
                                                    <option value="1" {{ $ta->is_aktif ? 'selected' : '' }}>Aktif</option>
                                                    <option value="0" {{ !$ta->is_aktif ? 'selected' : '' }}>Non-Aktif</option>
                                                </select>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary fw-800 py-3 rounded-4">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada data tahun ajaran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahTA" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Tambah Tahun Ajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('superadmin.tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">TAHUN MULAI</label>
                            <input type="number" name="tahun_mulai" class="form-control" placeholder="2025" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">TAHUN SELESAI</label>
                            <input type="number" name="tahun_selesai" class="form-control" placeholder="2026" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">STATUS GLOBAL</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_aktif" value="1" id="addAktif">
                                <label class="form-check-label" for="addAktif">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_aktif" value="0" id="addNon" checked>
                                <label class="form-check-label" for="addNon">Non-Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success fw-800 py-3 rounded-4 shadow">Simpan Periode</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection