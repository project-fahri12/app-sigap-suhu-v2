@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Manajemen Unit Sekolah</h5>
            <p class="small text-muted mb-0">
                Kelola unit sekolah berdasarkan jenjang dan status asrama
            </p>
        </div>
        <button class="btn btn-success fw-bold px-4 rounded-pill"
                data-bs-toggle="modal"
                data-bs-target="#modalUnit">
            <i class="fas fa-plus me-2"></i> Tambah Sekolah
        </button>
    </div>

    {{-- ALERT INFO --}}
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
        <i class="fas fa-university me-3 fs-4"></i>
        <div class="small">
            Unit sekolah dengan status <strong>Wajib Asrama</strong>
            akan terhubung otomatis dengan sistem pondok.
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="module-card border-0 shadow-sm p-3">
                <small class="text-muted fw-bold">Total Sekolah</small>
                <h4 class="fw-800 mb-0">
                    {{ $sekolahs->count() }}
                    <small class="fs-6 text-muted">Unit</small>
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="module-card border-0 shadow-sm p-3">
                <small class="text-muted fw-bold">Wajib Asrama</small>
                <h4 class="fw-800 mb-0 text-success">
                    {{ $sekolahs->where('keterangan','wajib')->count() }}
                    <small class="fs-6 text-muted">Unit</small>
                </h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="module-card border-0 shadow-sm p-3">
                <small class="text-muted fw-bold">Non Asrama</small>
                <h4 class="fw-800 mb-0 text-warning">
                    {{ $sekolahs->where('keterangan','tidak_wajib')->count() }}
                    <small class="fs-6 text-muted">Unit</small>
                </h4>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="module-card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-uppercase text-muted" style="font-size:12px">
                        <th class="ps-3">Unit Sekolah</th>
                        <th>Jenjang</th>
                        <th>Status Asrama</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sekolahs as $s)
                    <tr>
                        {{-- NAMA --}}
                        <td class="ps-3">
                            <div class="fw-bold text-uppercase">
                                {{ $s->nama_sekolah }}
                            </div>
                            <small class="text-muted fw-bold text-uppercase">
                                KODE : {{ $s->kode_sekolah }}
                            </small>
                        </td>

                        {{-- JENJANG --}}
                        <td>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                {{ $s->jenjang }}
                            </span>
                        </td>

                        {{-- KETERANGAN --}}
                        <td>
                            @if($s->keterangan === 'wajib')
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-home me-1"></i> Wajib Asrama
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                    <i class="fas fa-door-open me-1"></i> Non Asrama
                                </span>
                            @endif
                        </td>

                        {{-- STATUS AKTIF --}}
                        <td>
                            @if($s->is_aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="text-end pe-3">
                            <form action="{{ route('superadmin.sekolah.destroy',$s->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus unit sekolah ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Data sekolah belum tersedia
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="modalUnit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <form action="{{ route('superadmin.sekolah.store') }}" method="POST">
            @csrf

            <div class="modal-header border-0">
                <h5 class="fw-bold">Tambah Unit Sekolah</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">NAMA SEKOLAH</label>
                    <input type="text" name="nama_sekolah"
                           class="form-control form-control-lg" required>
                </div>

                {{-- JENJANG --}}
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">JENJANG</label>
                    <select name="jenjang" class="form-select form-control-lg" required>
                        <option value="" disabled selected>Pilih Jenjang</option>
                        <option value="PAUD">PAUD / TK</option>
                        <option value="SD">SD / MI</option>
                        <option value="SMP">SMP / MTs</option>
                        <option value="SMA">SMA / MA / SMK</option>
                    </select>
                </div>

                {{-- KETERANGAN --}}
                <label class="form-label small fw-bold text-muted">STATUS ASRAMA</label>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio"
                           name="keterangan" value="wajib" checked>
                    <label class="form-check-label">
                        Wajib Asrama
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio"
                           name="keterangan" value="tidak_wajib">
                    <label class="form-check-label">
                        Non Asrama
                    </label>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success fw-bold">Simpan</button>
            </div>

            </form>
        </div>
    </div>
</div>
@endsection
