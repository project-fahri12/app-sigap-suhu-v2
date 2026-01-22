@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h4 class="fw-800 text-dark mb-1">Manajemen Rombongan Belajar (Rombel)</h4>
            <p class="text-muted small mb-0">Kelola distribusi santri berdasarkan unit dan kapasitas kelas.</p>
        </div>
        <div class="col-md-5 text-end">
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahRombel">
                <i class="fas fa-plus-circle me-1"></i> Tambah Rombel Baru
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-primary border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-primary-subtle text-primary rounded-circle p-3 me-3">
                        <i class="fas fa-layer-group fa-lg"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold">Total Rombel</small>
                        <h4 class="fw-800 mb-0">{{ $total_rombel }} <span class="fs-6 text-muted fw-normal">Grup</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-warning-subtle text-warning rounded-circle p-3 me-3">
                        <i class="fas fa-chair fa-lg"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold">Total Kapasitas</small>
                        <h4 class="fw-800 mb-0">{{ $total_kapasitas }} <span class="fs-6 text-muted fw-normal">Kursi</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold text-uppercase">
                        <th class="ps-4">Nama Rombel / Grup</th>
                        <th>Tingkatan</th>
                        <th>Kapasitas</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $rombel)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-dark text-white rounded-3 p-2 me-3 fw-bold shadow-sm text-center" style="width: 45px;">
                                    {{ substr($rombel->nama_rombel, 0, 2) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark text-uppercase">{{ $rombel->nama_rombel }}</div>
                                    <small class="text-muted text-uppercase">
                                        {{ Auth::user()->sekolah->nama_sekolah }} 
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-primary px-3 rounded-pill">{{ $rombel->kelas->nama_kelas ?? 'N/A' }}</span></td>
                        <td><span class="fw-bold text-dark">{{ $rombel->kapasitas }}</span> <small class="text-muted">Kursi</small></td>
                        <td>
                            @if($rombel->jenis_kelas == 'L') <span class="badge border border-info text-info px-2">Laki-laki</span>
                            @elseif($rombel->jenis_kelas == 'P') <span class="badge border border-danger text-danger px-2">Perempuan</span>
                            @else <span class="badge border border-secondary text-secondary px-2">Campuran (LP)</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $rombel->status_rombel == 'BUKA' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border px-3">
                                {{ $rombel->status_rombel }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group">
                                <button class="btn btn-light btn-sm rounded-circle border me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $rombel->id }}">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                                <form action="{{ route('adminsekolah.kelola-rombel.destroy', $rombel->id) }}" method="POST" onsubmit="return confirm('Hapus rombel ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light btn-sm rounded-circle border"><i class="fas fa-trash text-danger"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $rombel->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header border-0 p-4 pb-0">
                                    <h5 class="fw-800 mb-0">Edit Rombel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('adminsekolah.kelola-rombel.update', $rombel->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Tingkat Kelas</label>
                                                <select name="kelas_id" class="form-select border-2 bg-light">
                                                    @foreach($list_kelas as $k)
                                                        <option value="{{ $k->id }}" {{ $rombel->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Kapasitas</label>
                                                <input type="number" name="kapasitas" class="form-control border-2 bg-light" value="{{ $rombel->kapasitas }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Nama Rombel</label>
                                            <input type="text" name="nama_rombel" class="form-control border-2 bg-light" value="{{ $rombel->nama_rombel }}">
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Jenis Kelas</label>
                                                <select name="jenis_kelas" class="form-select border-2 bg-light">
                                                    <option value="L" {{ $rombel->jenis_kelas == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                                    <option value="P" {{ $rombel->jenis_kelas == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                                                    <option value="LP" {{ $rombel->jenis_kelas == 'LP' ? 'selected' : '' }}>Campuran (LP)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Status</label>
                                                <select name="status_rombel" class="form-select border-2 bg-light">
                                                    <option value="BUKA" {{ $rombel->status_rombel == 'BUKA' ? 'selected' : '' }}>BUKA</option>
                                                    <option value="TUTUP" {{ $rombel->status_rombel == 'TUTUP' ? 'selected' : '' }}>TUTUP</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Update Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data rombel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahRombel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Konfigurasi Rombel Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('adminsekolah.kelola-rombel.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Pilih Tingkatan</label>
                            <select name="kelas_id" class="form-select border-2 bg-light" required>
                                <option value="" selected disabled>Pilih Kelas</option>
                                @foreach($list_kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kapasitas Maksimal</label>
                            <input type="number" name="kapasitas" class="form-control border-2 bg-light" placeholder="32" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Rombel / Grup</label>
                        <input type="text" name="nama_rombel" class="form-control border-2 bg-light" placeholder="Contoh: Abu Bakar Ash-Shiddiq" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Jenis Kelas</label>
                            <select name="jenis_kelas" class="form-select border-2 bg-light">
                                <option value="L">Laki-laki (L)</option>
                                <option value="P">Perempuan (P)</option>
                                <option value="LP">Campuran (LP)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status Rombel</label>
                            <select name="status_rombel" class="form-select border-2 bg-light">
                                <option value="BUKA">BUKA</option>
                                <option value="TUTUP">TUTUP</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Rombel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .icon-shape { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
    .table thead th { border: none; padding: 15px; font-size: 11px; letter-spacing: 0.05rem; }
    .table tbody td { padding: 18px 15px; border-color: #f1f5f9; }
</style>
@endsection