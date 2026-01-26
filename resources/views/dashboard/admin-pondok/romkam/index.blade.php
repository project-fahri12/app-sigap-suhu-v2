@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">

        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Manajemen Kamar (Romkam)</h4>
                <p class="text-muted small mb-0">Kelola unit kamar, kapasitas santri, dan penempatan gedung asrama.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus me-2"></i>Tambah Kamar
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-primary border-0 rounded-4 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <form action="{{ route('adminpondok.romkam.index') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari nama kamar..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="asrama_id" class="form-select form-select-sm bg-light border-0">
                            <option value="">Semua Asrama</option>
                            @foreach($asramas as $asrama)
                                <option value="{{ $asrama->id }}" {{ request('asrama_id') == $asrama->id ? 'selected' : '' }}>{{ $asrama->nama_asrama }}</option>
                            @endforeach
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
                                <th class="ps-4 py-3 text-muted small fw-bold">NAMA KAMAR</th>
                                <th class="py-3 text-muted small fw-bold">GEDUNG ASRAMA</th>
                                <th class="py-3 text-muted small fw-bold text-center">JK</th>
                                <th class="py-3 text-muted small fw-bold text-center">KAPASITAS</th>
                                <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                                <th class="py-3 text-muted small fw-bold text-end pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($romkams as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->nama_romkam }}</div>
                                        <small class="text-muted">ID: #{{ $item->id }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                                            <i class="fas fa-building me-1 text-primary"></i>
                                            {{ $item->asrama->nama_asrama ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill {{ $item->jk == 'L' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning' }} px-3 py-2">
                                            {{ $item->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-bold">{{ $item->santri_count ?? 0 }} / {{ $item->kapasitas }}</div>
                                        <small class="text-muted">Terisi</small>
                                    </td>
                                    <td class="text-center">
                                        @php $sisa = $item->kapasitas - ($item->santri_count ?? 0); @endphp
                                        @if ($sisa > 0)
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                {{ $sisa }} Slot Tersedia
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">Penuh</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group border rounded-pill overflow-hidden bg-white shadow-sm">
                                            <button class="btn btn-white btn-sm border-0 py-2 px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                                <i class="fas fa-edit text-warning"></i>
                                            </button>
                                            <form action="{{ route('adminpondok.romkam.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-white btn-sm border-0 py-2 px-3" onclick="return confirm('Hapus data kamar ini?')">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4">
                                            <form action="{{ route('adminpondok.romkam.update', $item->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-header border-0 pt-4 px-4">
                                                    <h5 class="fw-bold mb-0">Edit Data Kamar</h5>
                                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-muted">NAMA KAMAR</label>
                                                        <input type="text" name="nama_romkam" class="form-control rounded-3 bg-light border-0 py-2" value="{{ $item->nama_romkam }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label small fw-bold text-muted">GEDUNG ASRAMA</label>
                                                            <select name="asrama_id" class="form-select rounded-3 bg-light border-0 py-2" required>
                                                                @foreach ($asramas as $a)
                                                                    <option value="{{ $a->id }}" {{ $item->asrama_id == $a->id ? 'selected' : '' }}>{{ $a->nama_asrama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label small fw-bold text-muted">JENIS KELAMIN</label>
                                                            <select name="jk" class="form-select rounded-3 bg-light border-0 py-2">
                                                                <option value="L" {{ $item->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="P" {{ $item->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label small fw-bold text-muted">KAPASITAS</label>
                                                            <input type="number" name="kapasitas" class="form-control rounded-3 bg-light border-0 py-2" value="{{ $item->kapasitas }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label small fw-bold text-muted">STATUS</label>
                                                            <select name="status_romkam" class="form-select rounded-3 bg-light border-0 py-2">
                                                                <option value="Tersedia" {{ $item->status_romkam == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                                <option value="Penuh" {{ $item->status_romkam == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm mt-2">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr><td colspan="6" class="text-center py-5 text-muted">Data kamar tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $romkams->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <form action="{{ route('adminpondok.romkam.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Tambah Kamar Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA KAMAR</label>
                        <input type="text" name="nama_romkam" class="form-control rounded-3 bg-light border-0 py-2 fw-bold" placeholder="Misal: Kamar 01 Abu Bakar" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">PILIH GEDUNG</label>
                            <select name="asrama_id" class="form-select rounded-3 bg-light border-0 py-2" required>
                                <option value="" selected disabled>Pilih Asrama...</option>
                                @foreach ($asramas as $a)
                                    <option value="{{ $a->id }}">{{ $a->nama_asrama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">PERUNTUKAN (JK)</label>
                            <select name="jk" class="form-select rounded-3 bg-light border-0 py-2" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-muted">KAPASITAS</label>
                            <input type="number" name="kapasitas" class="form-control rounded-3 bg-light border-0 py-2" placeholder="Contoh: 10" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-muted">STATUS</label>
                            <select name="status_romkam" class="form-select rounded-3 bg-light border-0 py-2">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Penuh">Penuh</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-info-subtle { background-color: #e7f1ff !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .text-success { color: #198754 !important; }
    .text-info { color: #0d6efd !important; }
    .text-warning { color: #856404 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .btn-white { background: #fff; }
    .table thead th { background-color: #f8f9fa !important; border: none; letter-spacing: 0.5px; font-size: 11px; }
    .form-control:focus, .form-select:focus { box-shadow: none; border: 1px solid #0d6efd !important; background-color: #fff !important; }
</style>
@endsection