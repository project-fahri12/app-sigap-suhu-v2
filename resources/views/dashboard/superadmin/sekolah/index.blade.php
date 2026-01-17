@extends('dashboard.layouts.app')

@section('content')
      <div class="content-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Manajemen Unit Sekolah</h5>
                        <p class="small text-muted mb-0">Kelola daftar lembaga pendidikan dan status asrama.</p>
                    </div>
                    <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#modalUnit">
                        <i class="fas fa-plus me-2"></i> Tambah Unit
                    </button>
                </div>

                <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4"
                    role="alert">
                    <i class="fas fa-university me-3 fs-4"></i>
                    <div class="small">
                        Data unit sekolah menentukan tujuan pendaftaran calon santri. Unit dengan status <strong>"Wajib
                            Asrama"</strong> akan otomatis terintegrasi dengan sistem pengelolaan pondok.
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="module-card border-0 shadow-sm p-3 mb-0">
                            <small class="text-muted d-block mb-1 fw-bold">Total Unit</small>
                            <h4 class="fw-800 mb-0">12 <small class="fs-6 fw-normal text-muted">Lembaga</small></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="module-card border-0 shadow-sm p-3 mb-0">
                            <small class="text-muted d-block mb-1 fw-bold">Wajib Pondok</small>
                            <h4 class="fw-800 mb-0 text-success">8 <small class="fs-6 fw-normal text-muted">Unit</small>
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="module-card border-0 shadow-sm p-3 mb-0">
                            <small class="text-muted d-block mb-1 fw-bold">Non-Asrama</small>
                            <h4 class="fw-800 mb-0 text-warning">4 <small class="fs-6 fw-normal text-muted">Unit</small>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="module-card shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr
                                    style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <th class="ps-3">Nama Unit Sekolah</th>
                                    <th>Jenjang</th>
                                    <th>Status Kepemilikan</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">SMA Unggulan Terpadu</div>
                                        <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">ID:
                                            UNIT-001</div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">SMA</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-success fw-bold">
                                            <i class="fas fa-hotel me-2"></i> Wajib Diasrama
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-light btn-sm text-primary me-1" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#modalUnit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm text-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">SD IT Al-Hikmah</div>
                                        <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">ID:
                                            UNIT-005</div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill">SD</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-home me-2"></i> Non-Asrama
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-light btn-sm text-primary me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm text-danger" title="Hapus">
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

    <div class="modal fade" id="modalUnit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">Form Unit Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nama Unit Sekolah</label>
                            <input type="text" class="form-control form-control-lg fs-6 rounded-3"
                                placeholder="Contoh: SMA Terpadu Al-Ikhlas" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Jenjang Pendidikan</label>
                            <select class="form-select form-control-lg fs-6 rounded-3" required>
                                <option value="" selected disabled>Pilih Jenjang</option>
                                <option>TK / PAUD</option>
                                <option>SD / MI</option>
                                <option>SMP / MTs</option>
                                <option>SMA / MA / SMK</option>
                                <option>Sekolah Tinggi</option>
                            </select>
                        </div>

                        <div class="mb-2 mt-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Status Kepemilikan
                                Asrama</label>
                        </div>

                        <div class="list-group border-0">
                            <label class="list-group-item d-flex gap-3 py-3 border rounded-4 mb-2 shadow-sm"
                                style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0" type="radio" name="statusAsrama"
                                    id="asramaYa" value="1" checked>
                                <span class="pt-1">
                                    <strong class="d-block text-dark">Wajib Diasrama (Pondok)</strong>
                                    <small class="text-muted">Siswa wajib tinggal di lingkungan pesantren.</small>
                                </span>
                            </label>
                            <label class="list-group-item d-flex gap-3 py-3 border rounded-4 shadow-sm"
                                style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0" type="radio" name="statusAsrama"
                                    id="asramaTidak" value="0">
                                <span class="pt-1">
                                    <strong class="d-block text-dark">Non-Asrama (Pulang Pergi)</strong>
                                    <small class="text-muted">Siswa tidak menetap di asrama/pondok.</small>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold px-4 py-2 rounded-3"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3">Simpan Unit</button>
                    </div>
                </form>
            </div>
        </div>
@endsection