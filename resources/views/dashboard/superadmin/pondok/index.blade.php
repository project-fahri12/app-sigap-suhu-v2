@extends('dashboard.layouts.app')

@section('content')
              <div class="content-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Data Pondok Pesantren</h5>
                        <p class="small text-muted mb-0">Kelola daftar asrama dan pengasuh pondok terpusat.</p>
                    </div>
                    <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#modalPondok">
                        <i class="fas fa-plus me-2"></i> Tambah Pondok
                    </button>
                </div>

                <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4"
                    role="alert">
                    <i class="fas fa-mosque me-3 fs-4"></i>
                    <div class="small">
                        Data pondok ini akan terhubung dengan unit sekolah yang memiliki status <strong>"Wajib
                            Asrama"</strong> untuk penempatan kamar santri.
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="module-card border-0 shadow-sm p-3 mb-0 text-center">
                            <small class="text-muted d-block mb-1 fw-bold">Total Pondok</small>
                            <h4 class="fw-800 mb-0">6</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="module-card border-0 shadow-sm p-3 mb-0 text-center">
                            <small class="text-muted d-block mb-1 fw-bold text-primary">Putra (L)</small>
                            <h4 class="fw-800 mb-0">2</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="module-card border-0 shadow-sm p-3 mb-0 text-center border-bottom border-danger">
                            <small class="text-muted d-block mb-1 fw-bold text-danger">Putri (P)</small>
                            <h4 class="fw-800 mb-0">3</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="module-card border-0 shadow-sm p-3 mb-0 text-center">
                            <small class="text-muted d-block mb-1 fw-bold text-success">Campuran</small>
                            <h4 class="fw-800 mb-0">1</h4>
                        </div>
                    </div>
                </div>

                <div class="module-card shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr
                                    style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <th class="ps-3">Nama Pondok / Unit</th>
                                    <th>Pengasuh</th>
                                    <th>Kepemilikan</th>
                                    <th>Kategori L/P</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">Pondok Pusat Al-Manshur</div>
                                        <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">Unit:
                                            SMA Unggulan</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="small fw-bold">KH. Ahmad Dahlan</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Milik
                                            Yayasan</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                            <i class="fas fa-mars me-1 text-primary"></i> Putra (L)
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-light btn-sm text-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#modalPondok">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm text-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">Asrama Tahfizh Putri</div>
                                        <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">Unit:
                                            SMP IT</div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold">Ustadzah Maryam</div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Mitra
                                            / Luar</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                            <i class="fas fa-venus me-1 text-danger"></i> Putri (P)
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-light btn-sm text-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm text-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="modalPondok" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">Form Pondok Pesantren</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#">
                    <div class="modal-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Pondok /
                                    Asrama</label>
                                <input type="text" class="form-control form-control-lg fs-6 rounded-3"
                                    placeholder="Contoh: Pondok Darussalam 1" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Pengasuh /
                                    Mudir</label>
                                <input type="text" class="form-control form-control-lg fs-6 rounded-3"
                                    placeholder="Nama lengkap gelar..." required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Kategori Santri</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="kategoriLp" id="lpL" checked>
                                <label class="btn btn-outline-primary flex-grow-1 rounded-3 py-2 fw-bold" for="lpL">L
                                    (Putra)</label>

                                <input type="radio" class="btn-check" name="kategoriLp" id="lpP">
                                <label class="btn btn-outline-danger flex-grow-1 rounded-3 py-2 fw-bold" for="lpP">P
                                    (Putri)</label>

                                <input type="radio" class="btn-check" name="kategoriLp" id="lpLP">
                                <label class="btn btn-outline-success flex-grow-1 rounded-3 py-2 fw-bold" for="lpLP">L/P
                                    (Campuran)</label>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted text-uppercase">Status Kepemilikan</label>
                        </div>
                        <div class="list-group border-0">
                            <label class="list-group-item d-flex gap-3 py-3 border rounded-4 mb-2 shadow-sm"
                                style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0" type="radio" name="statusMilik"
                                    id="milikYayasan" value="1" checked>
                                <span class="pt-1">
                                    <strong class="d-block text-dark">Milik Yayasan</strong>
                                    <small class="text-muted">Aset dikelola penuh oleh lembaga pusat.</small>
                                </span>
                            </label>
                            <label class="list-group-item d-flex gap-3 py-3 border rounded-4 shadow-sm"
                                style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0" type="radio" name="statusMilik"
                                    id="milikLuar" value="0">
                                <span class="pt-1">
                                    <strong class="d-block text-dark">Bukan Milik Yayasan</strong>
                                    <small class="text-muted">Status mitra atau asrama luar/kost santri.</small>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold px-4 py-2 rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
@endsection