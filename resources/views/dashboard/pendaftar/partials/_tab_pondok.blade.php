<div class="row g-2">
    <div class="col-6 col-md-4 col-card" data-name="Tidak Bermukim Laju">
        <div class="guide-card shadow-sm h-100 d-flex flex-column border-dashed text-center p-2 justify-content-center bg-light">
            <div class="mb-2"><i class="fas fa-walking text-muted fs-4"></i></div>
            <h6 class="text-xs fw-800 mb-1">TIDAK BERMUKIM</h6>
            <p class="text-xs text-muted mb-3">(Laju / Pulang Pergi)</p>
            
            <input type="radio" class="btn-check" name="pondok_id" id="no_pondok" value="0"
                {{ ($pendaftar->sekolah_id && is_null($pendaftar->pondok_id)) ? 'checked' : '' }}
                {{ $pendaftar->pilih_lembaga == 'selesai' ? 'disabled' : '' }}>
            <label class="btn btn-outline-secondary btn-xs w-100 rounded-pill py-1 fw-bold text-xs" for="no_pondok">
                <span class="select-text">PILIH</span>
                <span class="selected-text"><i class="fas fa-check-circle"></i> TERPILIH</span>
            </label>
        </div>
    </div>

    @foreach ($pondok as $p)
    <div class="col-6 col-md-4 col-card" data-name="{{ $p->nama_pondok }}">
        <div class="guide-card shadow-sm h-100 d-flex flex-column mb-0">
            <img src="{{ asset('assets/images/pondok/' . ($p->foto ?? 'default.jpg')) }}" class="w-100" style="height: 85px; object-fit: cover;">
            
            <div class="p-2 flex-grow-1 text-center">
                <h6 class="text-xs fw-800 mb-1 text-truncate text-dark">{{ $p->nama_pondok }}</h6>
                <span class="badge bg-success-subtle text-success text-xs mb-2" style="font-size: 9px !important;">{{ $p->jenis }}</span>
                
                <div class="d-flex gap-1 mb-0 justify-content-center">
                    <button type="button" class="btn btn-link text-decoration-none text-xs p-0 text-primary fw-bold" 
                            data-bs-toggle="modal" data-bs-target="#detailPdk{{ $p->id }}">
                        Detail Profil
                    </button>
                </div>
            </div>

            <div class="p-2 pt-0">
                <input type="radio" class="btn-check" name="pondok_id" id="pdk_{{ $p->id }}" value="{{ $p->id }}" 
                       {{ $pendaftar->pondok_id == $p->id ? 'checked' : '' }}
                       {{ $pendaftar->pilih_lembaga == 'selesai' ? 'disabled' : '' }}>
                <label class="btn btn-outline-success btn-xs w-100 rounded-pill py-1 fw-bold text-xs" for="pdk_{{ $p->id }}">
                    <span class="select-text">PILIH</span>
                    <span class="selected-text"><i class="fas fa-check-circle"></i> TERPILIH</span>
                </label>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailPdk{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body p-3 text-center">
                    <h6 class="fw-bold text-sm-custom mb-2">{{ $p->nama_pondok }}</h6>
                    <p class="text-xs text-muted mb-0">{{ $p->keterangan ?? 'Info fasilitas pondok dapat ditanyakan ke Admin.' }}</p>
                    <hr class="my-2">
                    <button type="button" class="btn btn-dark btn-xs rounded-pill px-3" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>