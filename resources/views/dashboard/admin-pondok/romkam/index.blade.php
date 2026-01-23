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

        @if(session('success'))
        <div class="alert alert-primary border-0 rounded-4 shadow-sm mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold">NAMA KAMAR</th>
                                <th class="py-3 text-muted small fw-bold">GEDUNG ASRAMA</th>
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
                                    <small class="text-muted">NIS: {{ $item->nis ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                                        <i class="fas fa-building me-1 text-primary"></i> {{ $item->asrama->nama_asrama ?? 'Belum Diatur' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $item->kapasitas }}</span> <small class="text-muted">Orang</small>
                                </td>
                                <td class="text-center">
                                    @if($item->status_romkam == 'Tersedia')
                                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Tersedia</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">Penuh</span>
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

                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4">
                                        <form action="{{ route('adminpondok.romkam.update', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header border-0 pt-4 px-4">
                                                <h5 class="fw-bold mb-0">Edit Data Kamar</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-muted">NAMA KAMAR</label>
                                                    <input type="text" name="nama_romkam" class="form-control rounded-3 bg-light border-0 py-2" value="{{ $item->nama_romkam }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-7 mb-3">
                                                        <label class="form-label small fw-bold text-muted">ASRAMA</label>
                                                        <select name="asrama_id" class="form-select rounded-3 bg-light border-0 py-2" required>
                                                            @foreach($asramas as $a)
                                                                <option value="{{ $a->id }}" {{ $item->asrama_id == $a->id ? 'selected' : '' }}>{{ $a->nama_asrama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label small fw-bold text-muted">KAPASITAS</label>
                                                        <input type="number" name="kapasitas" class="form-control rounded-3 bg-light border-0 py-2" value="{{ $item->kapasitas }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold text-muted">STATUS</label>
                                                    <select name="status_romkam" class="form-select rounded-3 bg-light border-0 py-2">
                                                        <option value="Tersedia" {{ $item->status_romkam == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                        <option value="Penuh" {{ $item->status_romkam == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">Update Kamar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">Belum ada data kamar tersedia.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $romkams->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <form action="{{ route('adminpondok.romkam.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pondok_id" value="1">
                <input type="hidden" name="nis" value="0">
                
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <h5 class="fw-bold mb-0">Tambah Kamar Baru</h5>
                    <p class="text-muted small">Inputkan data kamar baru untuk asrama.</p>
                </div>
                <div class="modal-body p-4 pt-2">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA KAMAR</label>
                        <input type="text" name="nama_romkam" class="form-control rounded-3 bg-light border-0 py-2 fw-bold" placeholder="Contoh: Kamar 01 Abu Bakar" required>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label class="form-label small fw-bold text-muted">PILIH GEDUNG</label>
                            <select name="asrama_id" class="form-select rounded-3 bg-light border-0 py-2" required>
                                <option value="" selected disabled>Pilih Asrama...</option>
                                @foreach($asramas as $a)
                                    <option value="{{ $a->id }}">{{ $a->nama_asrama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label small fw-bold text-muted">KAPASITAS</label>
                            <input type="number" name="kapasitas" class="form-control rounded-3 bg-light border-0 py-2" placeholder="Jumlah" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">STATUS AWAL</label>
                        <select name="status_romkam" class="form-select rounded-3 bg-light border-0 py-2">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Penuh">Penuh</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* UI Palette */
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-warning-subtle { background-color: #fff8ec !important; }
    .text-success { color: #198754 !important; }
    .text-warning { color: #f39c12 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .btn-white { background: #fff; }
    
    /* Table Styling */
    .table thead th { 
        background-color: #f8f9fa !important; 
        border: none; 
        letter-spacing: 0.5px; 
        font-size: 11px; 
        text-transform: uppercase;
    }
    .table tbody tr { transition: all 0.2s; }
    .table tbody tr:hover { background-color: #fcfdfe; }

    /* Form Styling */
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border: 1px solid #0d6efd !important;
        background-color: #fff !important;
    }
</style>
@endsection