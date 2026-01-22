@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f1f7f5;">
    <div class="container-fluid">
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(45deg, #198754, #20c997); color: white;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-1"><i class="fas fa-boxes me-2"></i>Manajemen Loker & Hunian</h3>
                            <p class="mb-0 opacity-75">Manajemen plotting santri berdasarkan ketersediaan unit lemari di asrama.</p>
                        </div>
                        <i class="fas fa-mosque fa-4x opacity-25 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 border-bottom border-4 border-success h-100">
                    <div class="card-body p-3 p-lg-4 text-center">
                        <div class="bg-success-subtle text-success p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase">Blok Asrama</h6>
                        <h3 class="fw-bold text-success mb-0">4 <small class="fs-6 text-muted fw-normal">Gedung</small></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 border-bottom border-4 border-primary h-100">
                    <div class="card-body p-3 p-lg-4 text-center">
                        <div class="bg-primary-subtle text-primary p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-door-closed fa-2x"></i>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase">Total Kamar</h6>
                        <h3 class="fw-bold text-primary mb-0">48 <small class="fs-6 text-muted fw-normal">Unit</small></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 border-bottom border-4 border-info h-100">
                    <div class="card-body p-3 p-lg-4 text-center">
                        <div class="bg-info-subtle text-info p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-archive fa-2x"></i>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase">Total Lemari</h6>
                        <h3 class="fw-bold text-info mb-0">480 <small class="fs-6 text-muted fw-normal">Slot</small></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 border-bottom border-4 border-warning h-100">
                    <div class="card-body p-3 p-lg-4 text-center">
                        <div class="bg-warning-subtle text-warning p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase">Lemari Kosong</h6>
                        <h3 class="fw-bold text-warning mb-0">15 <small class="fs-6 text-muted fw-normal">Tersedia</small></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-0"><i class="fas fa-border-all me-2 text-success"></i>Kapasitas Lemari: Gedung A</h5>
                            <small class="text-muted">Menampilkan sebaran unit lemari di setiap kamar</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-success dropdown-toggle rounded-pill px-3" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter Gedung
                            </button>
                            <ul class="dropdown-menu border-0 shadow">
                                <li><a class="dropdown-item" href="#">Gedung A (Putra)</a></li>
                                <li><a class="dropdown-item" href="#">Gedung B (Putri)</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @for ($i = 1; $i <= 12; $i++)
                            <div class="col-md-4 col-6">
                                <div class="p-3 border rounded-4 position-relative transition-hover bg-white border-success-subtle">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-success shadow-sm">Kamar {{ $i }}</span>
                                        <i class="fas fa-archive text-success opacity-50"></i>
                                    </div>
                                    <div class="d-flex align-items-end mb-1">
                                        <h4 class="fw-bold mb-0 me-2">{{ $i == 3 ? '10' : '8' }}</h4>
                                        <small class="text-muted pb-1">/ 10 Lemari</small>
                                    </div>
                                    <div class="progress mb-2" style="height: 6px; border-radius: 10px;">
                                        <div class="progress-bar bg-success rounded-pill" style="width: {{ $i == 3 ? '100%' : '80%' }}"></div>
                                    </div>
                                    <div class="d-flex justify-content-between" style="font-size: 11px;">
                                        <span class="text-muted">Terisi: <b>{{ $i == 3 ? '10' : '8' }}</b></span>
                                        <span class="{{ $i == 3 ? 'text-danger' : 'text-success' }} fw-bold">{{ $i == 3 ? 'Penuh' : 'Sisa 2' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="mt-4 p-3 bg-light rounded-4 border-start border-4 border-success">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-3 text-success fa-lg"></i>
                                <small class="text-muted">Data di atas merepresentasikan jumlah <b>unit lemari aktif</b>. Setiap lemari hanya diperuntukkan bagi 1 santri mukim.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-muted"><i class="fas fa-layer-group me-2 text-success"></i>Manajemen Lanjutan</h6>
                    </div>
                    <div class="card-body p-4 pt-0">
                        
                        <div class="d-flex align-items-start p-3 mb-3 bg-light rounded-4 opacity-75 grayscale-filter border border-dashed">
                            <div class="bg-white p-2 rounded shadow-sm me-3 text-secondary"><i class="fas fa-clipboard-check"></i></div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small fw-bold text-dark">Kedisiplinan & Absensi</h6>
                                <ul class="list-unstyled mb-2" style="font-size: 10px; line-height: 1.6;">
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Absensi Malam (Ba'da Isya)</li>
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Absensi Shalat Berjamaah</li>
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Kontrol Kebersihan Kamar</li>
                                </ul>
                                <span class="badge bg-secondary-subtle text-secondary py-1" style="font-size: 8px;">COMING SOON</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 mb-3 bg-light rounded-4 opacity-75 grayscale-filter border border-dashed">
                            <div class="bg-white p-2 rounded shadow-sm me-3 text-secondary"><i class="fas fa-shuttle-van"></i></div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small fw-bold text-dark">Perizinan / Pesiar</h6>
                                <ul class="list-unstyled mb-2" style="font-size: 10px; line-height: 1.6;">
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Pengajuan Izin Keluar</li>
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Log Riwayat Kepulangan</li>
                                </ul>
                                <span class="badge bg-secondary-subtle text-secondary py-1" style="font-size: 8px;">COMING SOON</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 bg-light rounded-4 opacity-75 grayscale-filter border border-dashed">
                            <div class="bg-white p-2 rounded shadow-sm me-3 text-secondary"><i class="fas fa-tools"></i></div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small fw-bold text-dark">Fasilitas & Inventaris</h6>
                                <ul class="list-unstyled mb-2" style="font-size: 10px; line-height: 1.6;">
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Cek Kerusakan Lemari</li>
                                    <li><i class="fas fa-circle-notch me-1 text-success"></i> Inventaris Kunci Kamar</li>
                                </ul>
                                <span class="badge bg-secondary-subtle text-secondary py-1" style="font-size: 8px;">COMING SOON</span>
                            </div>
                        </div>

                    </div>
                    <div class="bg-light p-3 border-top">
                         <div class="d-flex align-items-center justify-content-center text-success">
                            <div class="spinner-grow spinner-grow-sm me-2" role="status"></div>
                            <small class="fw-bold">Menunggu Sinkronisasi Data...</small>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Theme Colors & Mixins */
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-primary-subtle { background-color: #e3f2fd !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1.25rem !important; }
    
    /* Hover Effects */
    .transition-hover {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background-color: #ffffff;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        border-color: #198754 !important;
        z-index: 10;
    }

    /* Grayscale for Coming Soon */
    .grayscale-filter {
        filter: grayscale(1);
        border: 1px dashed #ced4da !important;
    }
    
    .list-unstyled li {
        margin-bottom: 3px;
    }
</style>
@endsection