<div class="row g-2">
    @foreach ($sekolah as $s)
    <div class="col-6 col-md-4 col-card" data-name="{{ $s->nama_sekolah }}">
        <div class="guide-card shadow-sm h-100 d-flex flex-column mb-0">
            <div class="position-relative">
                <img src="{{ asset('assets/images/sekolah/' . ($s->foto ?? 'default.jpg')) }}" class="w-100" style="height: 85px; object-fit: cover;">
                <div class="position-absolute top-0 end-0 p-1">
                    <span class="badge bg-dark opacity-75 text-xs fw-bold">{{ $s->jenjang }}</span>
                </div>
            </div>

            <div class="p-2 flex-grow-1">
                <h6 class="text-xs fw-800 mb-1 text-truncate text-dark">{{ $s->nama_sekolah }}</h6>
                
                <div class="d-flex gap-1 mb-2">
                    <button type="button" class="btn btn-light btn-xs py-1 px-2 text-xs flex-grow-1 border" 
                            data-bs-toggle="modal" data-bs-target="#detailSch{{ $s->id }}">
                        <i class="fas fa-info-circle me-1 text-primary"></i>Detail
                    </button>
                    <a href="{{ asset('assets/pdf/brosur/'.$s->brosur) }}" target="_blank" 
                       class="btn btn-light btn-xs py-1 px-2 text-xs border">
                        <i class="fas fa-file-pdf text-danger"></i>
                    </a>
                </div>
            </div>

            <div class="p-2 pt-0">
                <input type="radio" class="btn-check" name="sekolah_id" id="sch_{{ $s->id }}" value="{{ $s->id }}" 
                       {{ $pendaftar->sekolah_id == $s->id ? 'checked' : '' }}
                       {{ $pendaftar->pilih_lembaga == 'selesai' ? 'disabled' : '' }}>
                <label class="btn btn-outline-success btn-xs w-100 rounded-pill py-1 fw-bold text-xs" for="sch_{{ $s->id }}">
                    <span class="select-text">PILIH</span>
                    <span class="selected-text"><i class="fas fa-check-circle"></i> TERPILIH</span>
                </label>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailSch{{ $s->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-sm-custom">Profil Sekolah</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 8px;"></button>
                </div>
                <div class="modal-body p-3">
                    <p class="text-xs text-muted mb-0">{{ $s->deskripsi ?? 'Informasi detail sekolah belum tersedia.' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>