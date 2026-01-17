@extends('dashboard.layouts.app')

@section('content')
     <div class="content-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-800 mb-1">Master Tahun Ajaran</h5>
                        <p class="small text-muted mb-0">Kelola periode pendaftaran dan akses sistem secara global.</p>
                    </div>
                    <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#modalTambahTA">
                         Tambah Tahun Ajaran
                    </button>
                </div>

                <div class="module-card shadow-sm p-0 overflow-hidden border-0 bg-white">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="bg-light">
                                <tr
                                    style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                                    <th class="ps-4 py-3">Tahun Ajaran</th>
                                    <th>Tahun Mulai</th>
                                    <th>Tahun Selesai</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 14px;">
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-800 text-dark">2025/2026</div>
                                        <small class="text-muted">Periode Aktif</small>
                                    </td>
                                    <td>2025</td>
                                    <td>2026</td>
                                   
                                    <td>
                                        <span class="badge bg-success px-3 py-1 rounded-pill">Aktif</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-light btn-sm text-primary rounded-3 me-1"
                                            data-bs-toggle="modal" data-bs-target="#modalEditTA">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm text-danger rounded-3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-800 text-muted">2024/2025</div>
                                        <small class="text-muted">Arsip Lama</small>
                                    </td>
                                    <td>2024</td>
                                    <td>2025</td>
                                        
                                    <td>
                                        <span class="badge bg-light text-muted px-3 py-1 rounded-pill">Non-Aktif</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-light btn-sm text-primary rounded-3 me-1"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-light btn-sm text-danger rounded-3"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalTambahTA" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-800 mb-0">Form Tahun Ajaran</h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                        </div>
                        <form>
                            <div class="modal-body p-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Tahun
                                            Mulai</label>
                                        <input type="number" class="form-control border-2 bg-light border-light py-2"
                                            style="border-radius: 12px;" placeholder="2025">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Tahun
                                            Selesai</label>
                                        <input type="number" class="form-control border-2 bg-light border-light py-2"
                                            style="border-radius: 12px;" placeholder="2026">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Akses Sistem
                                        (Admin Lembaga)</label>
                                    <select class="form-select border-2 bg-light border-light py-2"
                                        style="border-radius: 12px;">
                                        <option value="open">Terbuka (Dapat mengolah data)</option>
                                        <option value="locked">Terkunci (Hanya baca/Read-only)</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Status
                                        Global</label>
                                    <div class="d-flex gap-3 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusTA"
                                                id="statusAktif" checked>
                                            <label class="form-check-label small" for="statusAktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusTA"
                                                id="statusNonAktif">
                                            <label class="form-check-label small" for="statusNonAktif">Non-Aktif</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-light rounded-3 mb-4">
                                    <small class="text-muted" style="font-size: 11px;">
                                        <i class="fas fa-info-circle me-1 text-primary"></i>
                                        Menghapus Tahun Ajaran akan menghilangkan seluruh data transaksi dan pendaftaran
                                        yang terkait dengan periode tersebut secara permanen.
                                    </small>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success fw-800 py-3 shadow"
                                        style="border-radius: 15px;">
                                        Simpan Periode Ajaran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection