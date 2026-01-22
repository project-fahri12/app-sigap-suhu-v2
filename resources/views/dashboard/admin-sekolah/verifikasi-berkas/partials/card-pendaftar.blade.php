<div class="col-xl-3 col-md-6">
    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white transition-hover">
        <div class="card-body p-3 text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama_lengkap) }}&background=f8fafc&color=198754&bold=true" class="rounded-circle mb-3 border" width="60">
            <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $p->nama_lengkap }}</h6>
            <p class="x-small text-muted mb-3">{{ $p->kode_pendaftaran }}</p>
            
            <button class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalVerif{{ $p->id }}">
                <i class="fas fa-search me-1"></i> Periksa Dokumen
            </button>
        </div>
    </div>
</div>