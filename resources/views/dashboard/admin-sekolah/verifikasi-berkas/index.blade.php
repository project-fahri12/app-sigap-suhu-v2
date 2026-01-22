@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-800 text-dark mb-1">Verifikasi Dokumen</h4>
            <p class="text-muted small mb-0">Kelola validasi berkas pendaftaran santri.</p>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-4 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link active w-100 rounded-3 fw-bold" data-bs-toggle="pill" data-bs-target="#tab-pending" type="button">
                <i class="fas fa-clock me-2"></i>Menunggu Verifikasi ({{ $pending->count() }})
            </button>
        </li>
        <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100 rounded-3 fw-bold text-success" data-bs-toggle="pill" data-bs-target="#tab-lulus" type="button">
                <i class="fas fa-check-circle me-2"></i>Lulus Verifikasi ({{ $lulus->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="tab-pending">
            <div class="row g-4">
                @forelse($pending as $p)
                    @include('dashboard.admin-sekolah.verifikasi-berkas.partials.card-pendaftar', ['p' => $p])
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://illustrations.popsy.co/gray/data-analysis.svg" width="180" class="mb-3">
                        <p class="text-muted">Tidak ada pendaftar yang perlu diverifikasi.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="tab-lulus">
            <div class="row g-4">
                @forelse($lulus as $p)
                    @include('dashboard.admin-sekolah.verifikasi-berkas.partials.card-pendaftar', ['p' => $p])
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada pendaftar yang diluluskan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@foreach($pending->concat($lulus) as $p)
<div class="modal fade" id="modalVerif{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered p-md-5">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-800 mb-0">Review Berkas: {{ $p->nama_lengkap }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0 h-100">
                    <div class="col-lg-3 border-end bg-light p-4" style="height: 75vh; overflow-y: auto;">
                        <h6 class="small fw-bold text-muted text-uppercase mb-3">Daftar Dokumen</h6>
                        <div class="d-grid gap-2">
                            @foreach($p->berkas as $berkas)
                            <div class="card border-0 shadow-sm rounded-3 mb-2 berkas-item" id="berkas-{{ $berkas->id }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="x-small fw-bold text-primary">{{ strtoupper(str_replace('_', ' ', $berkas->jenis_berkas)) }}</span>
                                        <button type="button" class="btn btn-xs btn-primary py-0" onclick="previewFile('{{ asset('storage/' . $berkas->path_file) }}', '{{ $p->id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <select class="form-select form-select-sm mb-2" onchange="updateBerkasItem('{{ $berkas->id }}', this.value, document.getElementById('note-{{ $berkas->id }}').value)">
                                        <option value="pending" {{ $berkas->status_berkas == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="verified" {{ $berkas->status_berkas == 'verified' ? 'selected' : '' }}>🟢 Oke</option>
                                        <option value="rejected" {{ $berkas->status_berkas == 'rejected' ? 'selected' : '' }}>🔴 Tolak</option>
                                    </select>
                                    <input type="text" id="note-{{ $berkas->id }}" class="form-control form-control-sm" placeholder="Catatan..." value="{{ $berkas->keterangan }}" onblur="updateBerkasItem('{{ $berkas->id }}', this.previousElementSibling.value, this.value)">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-6 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center p-3">
                        <div id="preview-container-{{ $p->id }}" class="w-100 h-100 d-flex align-items-center justify-content-center border rounded-3 bg-white overflow-hidden">
                            <div class="text-center text-muted p-5">
                                <i class="fas fa-file-search fa-3x mb-3"></i>
                                <p>Klik ikon mata pada daftar berkas untuk melihat dokumen di sini</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 p-4">
                        <form action="{{ route('adminsekolah.verifikasi-berkas.final', $p->id) }}" method="POST">
                            @csrf @method('PUT')
                            <h6 class="small fw-bold text-muted text-uppercase mb-3">Keputusan Akhir</h6>
                            <div class="card border-0 bg-success bg-opacity-10 rounded-4 p-3 mb-3">
                                <label class="small fw-bold mb-2">Pilih Status Pendaftaran:</label>
                                <select name="status_pendaftaran" class="form-select mb-3">
                                    <option value="pending" {{ $p->status_pendaftaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="lulus_verifikasi" {{ $p->status_pendaftaran == 'lulus_verifikasi' ? 'selected' : '' }}>Lulus Verifikasi</option>
                                </select>
                                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">SIMPAN & SELESAI</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .nav-pills .nav-link { color: #64748b; padding: 12px; }
    .nav-pills .nav-link.active { background-color: #198754 !important; color: white !important; }
    .fw-800 { font-weight: 800; }
    .x-small { font-size: 10px; }
    .btn-xs { padding: 2px 8px; font-size: 10px; }
    .transition-hover:hover { transform: translateY(-3px); transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
</style>

<script>
// Fungsi Preview File di dalam Modal (Tanpa Blank Tab)
function previewFile(url, pendaftarId) {
    const container = document.getElementById('preview-container-' + pendaftarId);
    const extension = url.split('.').pop().toLowerCase();
    
    container.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';

    setTimeout(() => {
        if (extension === 'pdf') {
            container.innerHTML = `<iframe src="${url}" width="100%" height="100%" style="border:none;"></iframe>`;
        } else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
            container.innerHTML = `<img src="${url}" class="img-fluid" style="max-height: 100%; object-fit: contain;">`;
        } else {
            container.innerHTML = `<div class="text-center"><p class="mb-3">Format file tidak mendukung preview langsung.</p><a href="${url}" target="_blank" class="btn btn-primary">Unduh File</a></div>`;
        }
    }, 300);
}

// Update via AJAX
function updateBerkasItem(id, status, note) {
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