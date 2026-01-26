@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Daftar Asrama</h4>
                <p class="text-muted small mb-0">Manajemen gedung asrama santri Putra & Putri.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-success rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus me-2"></i>Tambah Gedung
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <form action="{{ route('adminpondok.asrama.index') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari nama asrama..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="jk" class="form-select form-select-sm bg-light border-0">
                            <option value="">Semua JK</option>
                            <option value="L" {{ request('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-sm btn-dark rounded-3 w-100">Filter</button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small" style="width: 80px;">NO</th>
                                <th class="py-3 text-muted small">NAMA ASRAMA</th>
                                <th class="py-3 text-muted small text-center">JK</th>
                                <th class="py-3 text-muted small text-center">STATUS</th>
                                <th class="py-3 text-muted small text-end pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asramas as $index => $item)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $asramas->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="{{ $item->jk == 'L' ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }} p-2 rounded-3 me-3">
                                            <i class="fas fa-hotel"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $item->nama_asrama }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $item->jk == 'L' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning' }} px-3 py-2">
                                        {{ $item->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $item->status_asrama == 'Aktif' ? 'bg-success-subtle text-success' : 'bg-light text-muted' }} px-3 py-2">
                                        {{ $item->status_asrama }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group border rounded-pill overflow-hidden bg-white shadow-sm">
                                        <button class="btn btn-white btn-sm border-0 py-2 px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                            <i class="fas fa-edit text-warning"></i>
                                        </button>
                                        <form action="{{ route('adminpondok.asrama.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm border-0 py-2 px-3" onclick="return confirm('Hapus asrama {{ $item->nama_asrama }}?')">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4">
                                        <form action="{{ route('adminpondok.asrama.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header border-0 pt-4 px-4">
                                                <h5 class="fw-bold mb-0">Edit Asrama</h5>
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">NAMA ASRAMA</label>
                                                    <input type="text" name="nama_asrama" class="form-control rounded-3 bg-light border-0 py-2" value="{{ $item->nama_asrama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">JENIS KELAMIN</label>
                                                    <select name="jk" class="form-select rounded-3 bg-light border-0 py-2">
                                                        <option value="L" {{ $item->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ $item->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold">STATUS</label>
                                                    <select name="status_asrama" class="form-select rounded-3 bg-light border-0 py-2">
                                                        <option value="Aktif" {{ $item->status_asrama == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Non-Aktif" {{ $item->status_asrama == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-sm">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Data asrama tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $asramas->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <form action="{{ route('adminpondok.asrama.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark">Gedung Asrama Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA GEDUNG / ASRAMA</label>
                        <input type="text" name="nama_asrama" class="form-control rounded-3 bg-light border-0 py-2 fw-bold" placeholder="Misal: Al-Kausar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">PERUNTUKAN (JK)</label>
                        <select name="jk" class="form-select rounded-3 bg-light border-0 py-2" required>
                            <option value="L">Laki-laki (Putra)</option>
                            <option value="P">Perempuan (Putri)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">STATUS AWAL</label>
                        <select name="status_asrama" class="form-select rounded-3 bg-light border-0 py-2">
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-sm">Simpan Data Asrama</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .btn-white { background: #fff; }
    .table thead th { background-color: #f1f7f5 !important; border: none; letter-spacing: 0.5px; }
    .form-control:focus, .form-select:focus { background-color: #fff !important; border: 1px solid #198754 !important; box-shadow: none; }
</style>
@endsection