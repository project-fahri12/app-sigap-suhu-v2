@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-800 text-dark mb-1">Verifikasi Dokumen</h4>
                <p class="text-muted small mb-0">Validasi berkas pendaftaran santri untuk menentukan kelulusan administrasi.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex gap-2">
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border-start border-4 border-warning">
                        <small class="text-muted d-block x-small fw-bold">ANTREAN</small>
                        <span class="fw-bold text-dark">{{ $pending->count() }} Jiwa</span>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-4 shadow-sm border-start border-4 border-success">
                        <small class="text-muted d-block x-small fw-bold">TERVERIFIKASI</small>
                        <span class="fw-bold text-dark">{{ $lulus->count() }} Jiwa</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="input-group bg-light rounded-pill border-0 px-3">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control bg-transparent border-0 small py-2" placeholder="Cari nama santri yang ingin diverifikasi...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100 rounded-pill fw-bold py-2 small">Cari Data</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @php $semuaPendaftar = $pending->concat($lulus); @endphp
            
            @forelse($semuaPendaftar as $p)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 transition-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-3 bg-{{ $p->status_pendaftaran == 'lulus_verifikasi' ? 'success' : 'warning' }}-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-check fa-lg text-{{ $p->status_pendaftaran == 'lulus_verifikasi' ? 'success' : 'warning' }}"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $p->nama_lengkap }}</h6>
                            <p class="text-muted x-small mb-3">Gelombang: {{ $p->gelombang->nama_gelombang ?? '-' }}</p>
                            
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-light text-dark border rounded-pill fw-normal x-small">
                                    <i class="fas fa-file-alt me-1 text-primary"></i> {{ $p->berkas->count() }} Berkas
                                </span>
                                @if($p->status_pendaftaran == 'lulus_verifikasi')
                                    <span class="badge bg-success-subtle text-success border-0 rounded-pill fw-bold x-small">Lulus</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border-0 rounded-pill fw-bold x-small">Pending</span>
                                @endif
                            </div>

                            <button class="btn btn-dark w-100 rounded-pill py-2 fw-bold small shadow-sm" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $p->id }}">
                                <i class="fas fa-search-plus me-2"></i> Periksa Berkas
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://illustrations.popsy.co/gray/data-analysis.svg" width="200" class="mb-3 opacity-50">
                    <h5 class="text-muted fw-bold">Belum Ada Data</h5>
                    <p class="text-muted small">Pendaftar yang masuk akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@foreach($semuaPendaftar as $p)
<div class="modal fade" id="modalVerif{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered p-md-5">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header border-0 bg-white px-4 pt-4 pb-0">
                <div>
                    <h5 class="fw-800 mb-0">Verifikasi Administrasi</h5>
                    <p class="text-muted small mb-0">{{ $p->nama_lengkap }} | {{ $p->id }}</p>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 mt-3">
                <div class="row g-0 h-100">
                    <div class="col-lg-3 border-end bg-light p-4" style="height: 70vh; overflow-y: auto;">
                        <h6 class="x-small fw-bold text-muted text-uppercase mb-3 letter-spacing-1">Lampiran Dokumen</h6>
                        <div class="d-grid gap-3">
                            @foreach($p->berkas as $berkas)
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden berkas-item" id="berkas-{{ $berkas->id }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="x-small fw-bold text-success">{{ strtoupper(str_replace('_', ' ', $berkas->jenis_berkas)) }}</span>
                                        <button type="button" class="btn btn-xs btn-success rounded-circle p-1" onclick="previewFile('{{ asset('storage/' . $berkas->path_file) }}', '{{ $p->id }}')">
                                            <i class="fas fa-eye mx-1"></i>
                                        </button>
                                    </div>
                                    <select class="form-select form-select-sm border-0 bg-light rounded-3 mb-2 small shadow-none" onchange="updateBerkasItem('{{ $berkas->id }}', this.value, document.getElementById('note-{{ $berkas->id }}').value)">
                                        <option value="pending" {{ $berkas->status_berkas == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="verified" {{ $berkas->status_berkas == 'verified' ? 'selected' : '' }}>🟢 Terverifikasi</option>
                                        <option value="rejected" {{ $berkas->status_berkas == 'rejected' ? 'selected' : '' }}>🔴 Tolak / Perbaiki</option>
                                    </select>
                                    <textarea id="note-{{ $berkas->id }}" class="form-control form-control-sm border-0 bg-light rounded-3 x-small" rows="2" placeholder="Catatan perbaikan..." onblur="updateBerkasItem('{{ $berkas->id }}', this.previousElementSibling.value, this.value)">{{ $berkas->keterangan }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-6 bg-dark bg-opacity-10 d-flex align-items-center justify-content-center p-3">
                        <div id="preview-container-{{ $p->id }}" class="w-100 h-100 d-flex align-items-center justify-content-center border-0 rounded-4 bg-white shadow-inner overflow-hidden">
                            <div class="text-center text-muted p-5">
                                <i class="fas fa-file-invoice fa-4x mb-3 opacity-25"></i>
                                <h6 class="fw-bold">Pratinjau Dokumen</h6>
                                <p class="small">Pilih ikon mata di samping daftar dokumen untuk memeriksa file.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 p-4 bg-white">
                        <form action="{{ route('adminsekolah.verifikasi-berkas.final', $p->id) }}" method="POST">
                            @csrf @method('PUT')
                            <h6 class="x-small fw-bold text-muted text-uppercase mb-3 letter-spacing-1">Hasil Verifikasi</h6>
                            
                            <div class="alert alert-info border-0 rounded-4 small mb-4">
                                <i class="fas fa-info-circle me-2"></i> Pastikan semua berkas wajib sudah bertanda <b>Oke</b> sebelum meluluskan santri.
                            </div>

                            <div class="mb-4">
                                <label class="small fw-bold text-dark mb-2">Status Akhir Pendaftaran:</label>
                                <div class="form-check custom-option mb-2">
                                    <input class="form-check-input" type="radio" name="status_pendaftaran" id="statusP{{ $p->id }}" value="pending" {{ $p->status_pendaftaran == 'pending' ? 'selected' : '' }}>
                                    <label class="form-check-label px-2 py-1" for="statusP{{ $p->id }}">
                                        <span class="fw-bold d-block small">Tahan / Pending</span>
                                        <span class="x-small text-muted">Belum memenuhi syarat verifikasi.</span>
                                    </label>
                                </div>
                                <div class="form-check custom-option active">
                                    <input class="form-check-input" type="radio" name="status_pendaftaran" id="statusL{{ $p->id }}" value="lulus_verifikasi" {{ $p->status_pendaftaran == 'lulus_verifikasi' ? 'selected' : '' }}>
                                    <label class="form-check-label px-2 py-1" for="statusL{{ $p->id }}">
                                        <span class="fw-bold d-block small text-success">Lulus Verifikasi</span>
                                        <span class="x-small text-muted">Berkas lengkap dan sesuai aturan.</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold py-3 rounded-4 shadow">
                                SIMPAN KEPUTUSAN <i class="fas fa-save ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .fw-800 { font-weight: 800; }
    .x-small { font-size: 11px; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-warning-subtle { background-color: #fff8e6 !important; }
    .transition-hover:hover { transform: translateY(-5px); transition: 0.3s; box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
    
    .custom-option {
        border: 2px solid #f1f1f1;
        padding: 10px;
        border-radius: 12px;
        transition: 0.2s;
    }
    .custom-option:has(.form-check-input:checked) {
        border-color: #198754;
        background-color: #f1fcf5;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>

<script>
function previewFile(url, pendaftarId) {
    const container = document.getElementById('preview-container-' + pendaftarId);
    const extension = url.split('.').pop().toLowerCase();
    
    container.innerHTML = '<div class="text-center"><div class="spinner-border text-success mb-2" role="status"></div><p class="x-small text-muted">Memuat Dokumen...</p></div>';

    setTimeout(() => {
        if (extension === 'pdf') {
            container.innerHTML = `<iframe src="${url}" width="100%" height="100%" style="border:none;"></iframe>`;
        } else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
            container.innerHTML = `<div class="p-4 w-100 h-100 d-flex align-items-center justify-content-center"><img src="${url}" class="img-fluid rounded shadow-sm" style="max-height: 100%; object-fit: contain;"></div>`;
        } else {
            container.innerHTML = `<div class="text-center p-5"><i class="fas fa-file-download fa-3x mb-3 text-muted"></i><p class="small">Format file ini tidak mendukung pratinjau langsung.</p><a href="${url}" target="_blank" class="btn btn-success btn-sm rounded-pill px-4">Unduh File Sekarang</a></div>`;
        }
    }, 400);
}

function updateBerkasItem(id, status, note) {
    // Tambahkan feedback visual sederhana jika perlu
    fetch(`/admin/sekolah/verifikasi-berkas/update-item/${id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status_berkas: status, keterangan: note })
    });
}
</script>
@endsection