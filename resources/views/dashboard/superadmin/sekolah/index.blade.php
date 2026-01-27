@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Manajemen Unit Sekolah</h5>
            <p class="small text-muted mb-0">Kelola unit sekolah berdasarkan jenjang dan status asrama</p>
        </div>
        <button class="btn btn-success fw-bold px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUnit" onclick="resetForm()">
            <i class="fas fa-plus me-2"></i> Tambah Sekolah
        </button>
    </div>

    {{-- ALERT INFO --}}
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
        <i class="fas fa-university me-3 fs-4"></i>
        <div class="small">
            <strong>Informasi:</strong> Unit sekolah dengan status <strong>Wajib Asrama</strong> akan terhubung otomatis dengan sistem pondok.
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-bottom border-primary border-3">
                <small class="text-muted fw-bold d-block mb-1">Total Sekolah</small>
                <h4 class="fw-800 mb-0">{{ $sekolahs->count() }} <small class="fs-6 text-muted">Unit</small></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-bottom border-success border-3">
                <small class="text-muted fw-bold d-block mb-1">Wajib Asrama</small>
                <h4 class="fw-800 mb-0 text-success">{{ $sekolahs->where('keterangan', 'wajib')->count() }} <small class="fs-6 text-muted">Unit</small></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 border-bottom border-warning border-3">
                <small class="text-muted fw-bold d-block mb-1">Non Asrama</small>
                <h4 class="fw-800 mb-0 text-warning">{{ $sekolahs->where('keterangan', 'tidak_wajib')->count() }} <small class="fs-6 text-muted">Unit</small></h4>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light">
                    <tr class="text-uppercase text-muted" style="font-size:11px; letter-spacing: 1px;">
                        <th class="ps-4 py-3">Unit Sekolah</th>
                        <th>Jenjang</th>
                        <th>Status Asrama</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px;">
                    @forelse($sekolahs as $s)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark text-uppercase">{{ $s->nama_sekolah }}</div>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">KODE: {{ $s->kode_sekolah }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                    {{ $s->jenjang }}
                                </span>
                            </td>
                            <td>
                                @if ($s->keterangan === 'wajib')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                        <i class="fas fa-home me-1"></i> Wajib Asrama
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                        <i class="fas fa-door-open me-1"></i> Non Asrama
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{-- TOGGLE STATUS PATCH --}}
                                {{-- <form action="{{ route('superadmin.sekolah.toggle', $s->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                            onchange="this.form.submit()" {{ $s->is_aktif ? 'checked' : '' }} 
                                            style="cursor: pointer; width: 35px; height: 18px;">
                                    </div>
                                </form> --}}
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-light btn-sm text-primary rounded-3 me-1" 
                                    onclick='editSekolah(@json($s))'
                                    data-bs-toggle="modal" data-bs-target="#modalUnit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form id="delete-form-{{ $s->id }}" action="{{ route('superadmin.sekolah.destroy', $s->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-light btn-sm text-danger rounded-3"
                                        onclick="confirmDelete('delete-form-{{ $s->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Data sekolah belum tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- UNIFIED MODAL (CREATE & EDIT) --}}
<div class="modal fade" id="modalUnit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form id="sekolahForm" action="{{ route('superadmin.sekolah.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0" id="modalTitle">Tambah Unit Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    {{-- KODE SEKOLAH (Optional: Jika ingin diedit manual) --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Kode Sekolah</label>
                        <input type="text" name="kode_sekolah" id="kode_sekolah" class="form-control" placeholder="Contoh: SMA-01">
                    </div>

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control form-control-lg" required>
                    </div>

                    {{-- JENJANG --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jenjang</label>
                        <select name="jenjang" id="jenjang" class="form-select form-control-lg" required>
                            <option value="" disabled selected>Pilih Jenjang</option>
                            <option value="PAUD">PAUD / TK</option>
                            <option value="SD">SD / MI</option>
                            <option value="SMP">SMP / MTs</option>
                            <option value="SMA">SMA / MA / SMK</option>
                        </select>
                    </div>

                    {{-- KETERANGAN --}}
                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">Status Asrama</label>
                    <div class="bg-light p-3 rounded-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="keterangan" id="statusWajib" value="wajib" checked>
                            <label class="form-check-label fw-semibold" for="statusWajib">Wajib Asrama</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="keterangan" id="statusTidakWajib" value="tidak_wajib">
                            <label class="form-check-label fw-semibold" for="statusTidakWajib">Non Asrama</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    /**
     * Reset Modal untuk Tambah Data
     */
    function resetForm() {
        const form = document.getElementById('sekolahForm');
        form.reset();
        form.action = "{{ route('superadmin.sekolah.store') }}";
        document.getElementById('modalTitle').innerText = 'Tambah Unit Sekolah';
        
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
    }

    /**
     * Set Modal untuk Edit Data
     */
    function editSekolah(sekolah) {
        resetForm();
        const form = document.getElementById('sekolahForm');
        document.getElementById('modalTitle').innerText = 'Edit Unit Sekolah';
        
        // Ubah action ke route update
        let updateUrl = "{{ route('superadmin.sekolah.update', ':id') }}";
        form.action = updateUrl.replace(':id', sekolah.id);

        // Tambah method PUT
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        // Isi field
        document.getElementById('nama_sekolah').value = sekolah.nama_sekolah;
        document.getElementById('kode_sekolah').value = sekolah.kode_sekolah;
        document.getElementById('jenjang').value = sekolah.jenjang;

        // Set Radio Button
        if (sekolah.keterangan === 'wajib') {
            document.getElementById('statusWajib').checked = true;
        } else {
            document.getElementById('statusTidakWajib').checked = true;
        }
    }
</script>
@endpush
@endsection