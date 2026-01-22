@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 small">
                <li class="breadcrumb-item text-muted">Master Data</li>
                <li class="breadcrumb-item text-muted">Asrama</li>
                <li class="breadcrumb-item active text-success fw-bold">Plotting Hunian</li>
            </ol>
        </nav>

        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Plotting Kamar & Lemari</h4>
                <p class="text-muted small mb-0">Manajemen hunian berdasarkan jenjang pendidikan formal santri.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                    <button class="btn btn-primary px-3 small fw-bold" data-bs-toggle="tooltip" title="Fitur otomatisasi plotting akan segera hadir">
                        <i class="fas fa-magic me-1"></i> Plotting Cerdas <span class="badge bg-white text-primary ms-1" style="font-size: 8px;">SOON</span>
                    </button>
                    <button class="btn btn-success px-3 small fw-bold" data-bs-toggle="modal" data-bs-target="#modalManual">
                        <i class="fas fa-plus me-1"></i> Input Manual
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @php
                $asramas = [
                    ['nama' => 'Al-Kausar', 'kategori' => 'Santri Baru / VII', 'icon' => 'fa-baby', 'active' => true],
                    ['nama' => 'Al-Firdaus', 'kategori' => 'Kelas VIII', 'icon' => 'fa-user-tag', 'active' => false],
                    ['nama' => 'Darul Ulum', 'kategori' => 'Kelas IX', 'icon' => 'fa-user-graduate', 'active' => false],
                    ['nama' => 'Darul Naim', 'kategori' => 'SMK / MAN Lama', 'icon' => 'fa-briefcase', 'active' => false],
                ];
            @endphp

            @foreach($asramas as $asrama)
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 transition-hover {{ $asrama['active'] ? 'border-start border-4 border-success' : '' }}">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $asrama['active'] ? 'success' : 'light' }} text-{{ $asrama['active'] ? 'white' : 'muted' }} p-2 rounded-3 me-3">
                                <i class="fas {{ $asrama['icon'] }}"></i>
                            </div>
                            <div class="overflow-hidden">
                                <h6 class="fw-bold mb-0 {{ $asrama['active'] ? 'text-success' : 'text-dark' }}">{{ $asrama['nama'] }}</h6>
                                <small class="text-muted d-block text-truncate" style="font-size: 10px;">{{ $asrama['kategori'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-dark">Daftar Kamar</h6>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <div class="list-group list-group-flush border rounded-4 overflow-hidden">
                            @for($i=1; $i<=6; $i++)
                            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-0 {{ $i == 1 ? 'bg-success text-white' : '' }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-door-closed me-3 {{ $i == 1 ? 'text-white' : 'text-muted' }}"></i>
                                    <div>
                                        <div class="fw-bold small">Kamar K-0{{ $i }}</div>
                                        <small class="{{ $i == 1 ? 'text-white-50' : 'text-muted' }}" style="font-size: 10px;">Lantai 1</small>
                                    </div>
                                </div>
                                <span class="badge {{ $i == 1 ? 'bg-white text-success' : 'bg-light text-muted' }} rounded-pill">8/10</span>
                            </button>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-info text-white shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-question-circle fa-2x mb-3 opacity-50"></i>
                        <h6 class="fw-bold">Butuh Bantuan?</h6>
                        <p class="small mb-3 opacity-75">Panduan plotting manual dan otomatis dapat diakses melalui tombol di bawah.</p>
                        <a href="#" class="btn btn-white btn-sm rounded-pill px-4 fw-bold">Panduan Sistem</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Layout Lemari Kamar K-01</h5>
                            <span class="badge bg-success-subtle text-success small">Gedung Al-Kausar</span>
                        </div>
                        <div class="text-end">
                            <span class="text-muted small">Sisa Slot:</span>
                            <h5 class="fw-bold text-success mb-0">2</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="row g-3">
                            @for ($i = 1; $i <= 10; $i++)
                            <div class="col-md-6 col-xl-4">
                                @if($i <= 8)
                                <div class="card border-light bg-light rounded-4 border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge bg-white text-dark border fw-bold">{{ $i }}</span>
                                            <i class="fas fa-user-check text-success"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size: 13px;">Santri Baru #{{ $i }}</h6>
                                        <p class="text-muted mb-3" style="font-size: 10px;">MTs Kelas VII-A</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-white border w-100 py-1" title="Pindah"><i class="fas fa-exchange-alt text-warning"></i></button>
                                            <button class="btn btn-sm btn-white border w-100 py-1 text-danger" title="Lepas"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="card border-dashed-success rounded-4 d-flex align-items-center justify-content-center text-center p-3 h-100" style="min-height: 135px;">
                                    <div class="text-muted mb-2 small">Slot {{ $i }}</div>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalManual">
                                        Isi Manual
                                    </button>
                                </div>
                                @endif
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalManual" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0">Plotting Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-2 text-center">
                <i class="fas fa-info-circle text-primary fa-2x mb-3 opacity-25"></i>
                <p class="text-muted small px-4">Fitur ini memungkinkan Anda mencari santri satu per satu untuk dimasukkan ke dalam lemari terpilih.</p>
                <input type="text" class="form-control rounded-pill border-light bg-light py-2 text-center mb-4" placeholder="Cari Nama Santri VII...">
                <button class="btn btn-success rounded-pill px-5 py-2 fw-bold w-100">Cari & Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* UI UX Consistency Helper */
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .text-success { color: #198754 !important; }
    .border-dashed-success { 
        border: 2px dashed #19875440 !important; 
        background-color: transparent;
    }
    .rounded-4 { border-radius: 1rem !important; }
    .btn-white { background: #fff; border-color: #eee; }
    .btn-white:hover { background: #f8f9fa; }
    
    .transition-hover {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05) !important;
    }

    /* Mementingkan scannability */
    .list-group-item {
        transition: 0.2s;
    }
</style>

<script>
    // Initialize tooltips if needed
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection