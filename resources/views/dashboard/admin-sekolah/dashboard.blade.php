@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="module-card border-0 shadow-sm p-3 bg-white border-start border-primary border-4">
                    <small class="text-muted fw-bold d-block">SIAP AKTIVASI</small>
                    <h4 class="fw-800 mb-0">24 <small class="fw-normal fs-6 text-muted">Siswa Lunas</small></h4>
                    <small class="text-primary" style="font-size: 11px;">Perlu ditentukan kelasnya</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="module-card border-0 shadow-sm p-3 bg-white border-start border-success border-4">
                    <small class="text-muted fw-bold d-block">SISWA AKTIF</small>
                    <h4 class="fw-800 mb-0">132 <small class="fw-normal fs-6 text-muted">Total</small></h4>
                    <small class="text-success" style="font-size: 11px;">Sudah masuk Rombel</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="module-card border-0 shadow-sm p-3 bg-white border-start border-warning border-4">
                    <small class="text-muted fw-bold d-block">PEMBAYARAN CICIL</small>
                    <h4 class="fw-800 mb-0">15 <small class="fw-normal fs-6 text-muted">Siswa</small></h4>
                    <small class="text-muted" style="font-size: 11px;">Menunggu pelunasan</small>
                </div>
            </div>
        </div>

        <div class="module-card shadow-sm p-0 overflow-hidden border-0 bg-white">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-800 mb-0">Aktivasi Siswa &amp; Penentuan Kelas</h6>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm border-2 bg-light rounded-pill px-3"
                        placeholder="Cari Nama/Kode...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light">
                        <tr style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                            <th class="ps-4 py-3">Nama Pendaftar</th>
                            <th>Kode Daftar</th>
                            <th>Status Bayar (Yayasan)</th>
                            <th>Status Siswa</th>
                            <th>Kelas / Rombel</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        <tr>
                            <td class="ps-4">
                                <div class="fw-800 text-dark">Zaidan Akbar</div>
                                <small class="text-muted">Lulusan SMPN 1</small>
                            </td>
                            <td><code class="fw-bold text-primary">REG-2025001</code></td>
                            <td>
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Lunas</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-muted px-3 py-1 rounded-pill">Calon
                                    Siswa</span>
                            </td>
                            <td><em class="text-muted small">Belum diatur</em></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-primary btn-sm fw-bold px-3 rounded-3 shadow-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalAktivasi">
                                    <i class="fas fa-user-check me-1"></i> Aktivasi
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
