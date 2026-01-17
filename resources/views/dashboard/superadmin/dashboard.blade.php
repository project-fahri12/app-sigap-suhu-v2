@extends('dashboard.layouts.app')

@section('content')
     <div class="content-body">
                <div class="row g-4 mb-4">
                    <div class="col-lg-7">
                        <div class="master-switch-card shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">Status PPDB Pusat</h5>
                                    <p class="small opacity-75 mb-0">Kontrol akses pendaftaran seluruh unit.</p>
                                </div>
                                <div class="form-check form-switch fs-4">
                                    <input class="form-check-input" type="checkbox" id="masterSwitch" checked>
                                </div>
                            </div>
                            <hr class="opacity-25">
                            <div class="d-flex align-items-center">
                                <div class="me-4">
                                    <small class="d-block opacity-75">Tahun Ajaran Aktif</small>
                                    <span class="fw-bold">2025/2026 - Ganjil</span>
                                </div>
                                <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold">Ubah Tahun</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div
                            class="module-card h-100 mb-0 d-flex flex-column justify-content-center border-start border-4 border-success">
                            <h6 class="fw-bold small mb-3 text-muted">RINGKASAN HAK AKSES</h6>
                            <div class="d-flex align-items-center mb-2 text-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <small class="fw-600">Otoritas Penuh Sistem Pusat</small>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Data Master & Konfigurasi Global</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="module-card shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">Monitoring Operasional Unit</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle" style="font-size: 13px;">
                            <thead class="table-light">
                                <tr>
                                    <th>Unit Lembaga</th>
                                    <th>Status Pusat</th>
                                    <th>Kapasitas</th>
                                    <th>Terisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-dark">SMA Unggulan Terpadu</td>
                                    <td><span class="badge bg-success">Opened</span></td>
                                    <td>200</td>
                                    <td>156</td>
                                    <td><button class="btn btn-light btn-sm fw-bold text-success">Detail</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@endsection