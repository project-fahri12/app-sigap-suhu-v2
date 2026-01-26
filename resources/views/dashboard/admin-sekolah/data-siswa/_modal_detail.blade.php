<div class="modal fade" id="modalDetail{{ $s->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4 p-4">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg me-3">
                        @if($s->pendaftar && $s->pendaftar->foto)
                            <img src="{{ asset('storage/' . $s->pendaftar->foto) }}" 
                                 class="rounded-circle border border-white shadow-sm object-fit-cover" 
                                 style="width: 60px; height: 60px;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                 style="width: 60px; height: 60px; font-size: 22px;">
                                {{ strtoupper(substr($s->pendaftar->nama_lengkap ?? 'S', 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 class="modal-title fw-800 text-dark mb-0">{{ $s->pendaftar->nama_lengkap }}</h5>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 rounded-pill mt-1">
                            NIS: {{ $s->nis ?? '-' }}
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted text-uppercase mb-3 small" style="letter-spacing: 1px;">Data Pribadi</h6>
                        <div class="d-flex flex-column gap-3">
                            <div class="info-item">
                                <label class="text-muted d-block small">NIK</label>
                                <span class="fw-bold text-dark">{{ $s->pendaftar->nik ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <label class="text-muted d-block small">NISN</label>
                                <span class="fw-bold text-dark">{{ $s->pendaftar->nisn ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <label class="text-muted d-block small">Tempat, Tanggal Lahir</label>
                                <span class="fw-bold text-dark">{{ $s->pendaftar->tempat_lahir }}, {{ $s->pendaftar->tanggal_lahir }}</span>
                            </div>
                            <div class="info-item">
                                <label class="text-muted d-block small">Alamat Lengkap</label>
                                <span class="fw-bold text-dark small">{{ $s->pendaftar->alamat_lengkap ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted text-uppercase mb-3 small" style="letter-spacing: 1px;">Akademik & Asrama</h6>
                        <div class="bg-light p-3 rounded-4 border border-dashed border-primary-subtle">
                            <div class="d-flex flex-column gap-3">
                                <div class="info-item">
                                    <label class="text-muted d-block small">Kelas & Rombel</label>
                                    <span class="fw-bold text-primary">{{ $s->kelas->nama_kelas ?? '-' }} / {{ $s->rombel->nama_rombel ?? 'Belum Diplot' }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="text-muted d-block small">Pondok / Asrama</label>
                                    <span class="fw-bold text-dark">{{ $s->pondok->nama_pondok ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <label class="text-muted d-block small">Status Keaktifan</label>
                                    <span class="badge {{ $s->status_santri == 'Aktif' ? 'bg-success' : 'bg-danger' }} px-3 rounded-pill">
                                        {{ $s->status_santri }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold text-muted text-uppercase mt-4 mb-3 small" style="letter-spacing: 1px;">Kontak Wali</h6>
                        <div class="d-flex align-items-center bg-white p-2 border rounded-pill">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 35px; height: 35px;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 10px;">No. WhatsApp Wali</label>
                                <span class="fw-bold text-dark small">{{ $s->pendaftar->informasiKontak->no_wa ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 p-4">
                <button type="button" class="btn btn-light rounded-pill px-4 border shadow-sm fw-bold" data-bs-dismiss="modal">Tutup</button>
                <a href="https://wa.me/{{ $s->pendaftar->informasiKontak->no_wa }}" target="_blank" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fab fa-whatsapp me-2"></i>Hubungi Wali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .info-item label {
        margin-bottom: 2px;
        font-weight: 500;
    }
    .modal-content {
        animation: modalFadeIn 0.3s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .border-dashed {
        border-style: dashed !important;
    }
</style>