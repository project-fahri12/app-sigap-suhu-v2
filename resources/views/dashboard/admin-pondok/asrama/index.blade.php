@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Master Data Asrama</h4>
                <p class="text-muted small mb-0">Kelola data gedung, kamar, dan total unit lemari.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahGedung">
                    <i class="fas fa-plus me-2"></i>Tambah Gedung
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-uppercase text-muted small" style="width: 50px;">No</th>
                                        <th class="py-3 text-uppercase text-muted small">Informasi Gedung</th>
                                        <th class="py-3 text-uppercase text-muted small text-center">Jumlah Kamar</th>
                                        <th class="py-3 text-uppercase text-muted small text-center">Total Lemari</th>
                                        <th class="py-3 text-uppercase text-muted small text-center">Status</th>
                                        <th class="py-3 text-uppercase text-muted small text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">01</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success-subtle text-success p-2 rounded-3 me-3">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">Gedung A (Al-Khawarizmi)</div>
                                                    <small class="text-muted">Khusus Santri Putra - Lantai 1 & 2</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold">12 <span class="text-muted fw-normal">Unit</span></td>
                                        <td class="text-center fw-bold">120 <span class="text-muted fw-normal">Slot</span></td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Aktif</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                                <button class="btn btn-white btn-sm border-0 py-2 px-3" title="Kelola Kamar">
                                                    <i class="fas fa-door-open text-primary"></i>
                                                </button>
                                                <button class="btn btn-white btn-sm border-0 py-2 px-3" title="Edit Gedung">
                                                    <i class="fas fa-edit text-warning"></i>
                                                </button>
                                                <button class="btn btn-white btn-sm border-0 py-2 px-3" title="Hapus">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">02</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success-subtle text-success p-2 rounded-3 me-3">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">Gedung B (Az-Zahra)</div>
                                                    <small class="text-muted">Khusus Santri Putri - Lantai 1</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold">8 <span class="text-muted fw-normal">Unit</span></td>
                                        <td class="text-center fw-bold">80 <span class="text-muted fw-normal">Slot</span></td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Aktif</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded-pill">
                                                <button class="btn btn-white btn-sm border-0 py-2 px-3"><i class="fas fa-door-open text-primary"></i></button>
                                                <button class="btn btn-white btn-sm border-0 py-2 px-3"><i class="fas fa-edit text-warning"></i></button>
                                                <button class="btn btn-white btn-sm border-0 py-2 px-3"><i class="fas fa-trash text-danger"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-3 px-4">
                        <nav class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Menampilkan 2 dari 4 Gedung</small>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link rounded-circle me-1 border-0" href="#"><i class="fas fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link rounded-circle me-1 border-0" href="#">1</a></li>
                                <li class="page-item"><a class="page-link rounded-circle border-0" href="#"><i class="fas fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahGedung" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0">Tambah Data Gedung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Gedung</label>
                        <input type="text" class="form-control rounded-3 py-2 border-light bg-light" placeholder="Contoh: Gedung A">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Kategori</label>
                            <select class="form-select rounded-3 py-2 border-light bg-light">
                                <option>Putra</option>
                                <option>Putri</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Jumlah Lantai</label>
                            <input type="number" class="form-control rounded-3 py-2 border-light bg-light" value="1">
                        </div>
                    </div>
                    <div class="mb-4 text-center p-3 bg-success-subtle rounded-4">
                        <small class="text-success"><i class="fas fa-info-circle me-2"></i>Setelah membuat gedung, Anda bisa menambahkan detail kamar di halaman selanjutnya.</small>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success py-2 rounded-pill fw-bold">Simpan Data Gedung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* UI Table Styling */
    .table thead th {
        font-weight: 700;
        letter-spacing: 0.5px;
        background-color: #f1f7f5 !important;
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: #f9fdfb !important;
    }
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .text-success { color: #198754 !important; }
    .btn-white { background-color: #fff; }
    .page-link { color: #198754; padding: 0.5rem 0.75rem; }
    .page-item.active .page-link { background-color: #198754; }
    
    /* Input Styling */
    .form-control:focus, .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
        background-color: #fff;
    }
</style>
@endsection