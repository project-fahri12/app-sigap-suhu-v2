@extends('dashboard.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="content-body" style="background-color: #f4f7f6;">
    <div class="container-fluid">
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #1e4d3a, #198754); color: white;">
                    <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-1"><i class="fas fa-chart-pie me-2"></i>Pusat Kontrol Manajemen Santri</h3>
                            <p class="mb-0 opacity-75">Tahun Ajaran: {{ $taAktif->nama ?? 'N/A' }}</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0 bg-white bg-opacity-10 p-3 rounded-4 border border-white border-opacity-25">
                            <h2 class="mb-0 fw-bold" id="live-clock">00:00:00</h2>
                            <span class="small text-uppercase opacity-75" id="live-date">Memuat Tanggal...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-5 h-100">
            <small class="text-muted fw-bold text-uppercase">Santri Sekolah Ini</small>
            <h3 class="fw-bold text-success mb-0">{{ $totalSantri }} <small class="fs-6 text-muted fw-normal">Orang</small></h3>
        </div>
    </div>
    
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-primary border-5 h-100">
            <small class="text-muted fw-bold text-uppercase">Total Unit Kamar</small>
            <h3 class="fw-bold text-primary mb-0">{{ $totalKamar }} <small class="fs-6 text-muted fw-normal">Unit</small></h3>
        </div>
    </div>
    
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-info border-5 h-100">
            <small class="text-muted fw-bold text-uppercase">Total Kapasitas Loker</small>
            <h3 class="fw-bold text-info mb-0">{{ $totalKapasitasLoker }} <small class="fs-6 text-muted fw-normal">Slot</small></h3>
        </div>
    </div>
    
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-5 h-100">
            <small class="text-muted fw-bold text-uppercase">Loker Tersedia</small>
            <h3 class="fw-bold text-warning mb-0">{{ $lokerKosong < 0 ? 0 : $lokerKosong }} <small class="fs-6 text-muted fw-normal">Slot</small></h3>
        </div>
    </div>
</div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-user-plus me-2 text-success"></i>Statistik Pendaftaran Santri</h5>
                        <small class="text-muted">Data pendaftaran 6 bulan terakhir</small>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="registrationChart" height="120"></canvas>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative bg-light border border-dashed border-secondary">
                            <div class="coming-soon-overlay">
                                <span class="badge bg-dark rounded-pill shadow-lg py-2 px-3"><i class="fas fa-lock me-1"></i> COMING SOON</span>
                            </div>
                            <div class="card-body p-4 opacity-25">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-user-check me-2"></i>Absensi Kegiatan</h6>
                                <div class="mb-2 p-2 bg-white rounded-3 shadow-sm small">Jamaah Shalat</div>
                                <div class="mb-2 p-2 bg-white rounded-3 shadow-sm small">Setoran Kitab</div>
                                <div class="p-2 bg-white rounded-3 shadow-sm small">Absensi Malam</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative bg-light border border-dashed border-secondary">
                            <div class="coming-soon-overlay">
                                <span class="badge bg-dark rounded-pill shadow-lg py-2 px-3"><i class="fas fa-tools me-1"></i> UNDER DEV</span>
                            </div>
                            <div class="card-body p-4 opacity-25">
                                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-gavel me-2"></i>Catatan Pelanggaran</h6>
                                <div class="mb-2 p-2 bg-white rounded-3 shadow-sm small">Input Poin Kedisiplinan</div>
                                <div class="mb-2 p-2 bg-white rounded-3 shadow-sm small">Riwayat Sanksi</div>
                                <div class="p-2 bg-white rounded-3 shadow-sm small">Dashboard BK</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #fffbe6; border: 1px solid #ffe58f !important;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-download me-2 text-warning"></i>E-Brosur & Dokumen</h6>
                        <div class="list-group list-group-flush bg-transparent">
                            <a href="#" class="list-group-item list-group-item-action bg-transparent border-0 px-0 d-flex align-items-center">
                                <div class="bg-white p-2 rounded shadow-sm me-3"><i class="fas fa-file-pdf text-danger"></i></div>
                                <div class="small">Brosur Pendaftaran {{ date('Y') }}.pdf</div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action bg-transparent border-0 px-0 d-flex align-items-center">
                                <div class="bg-white p-2 rounded shadow-sm me-3"><i class="fas fa-file-word text-primary"></i></div>
                                <div class="small">Tata Tertib & Sanksi.docx</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-muted"><i class="fas fa-project-diagram me-2 text-success"></i>Pengembangan Bidang</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold text-dark"><i class="fas fa-shield-alt text-danger me-2"></i>Keamanan</span>
                                <span class="badge bg-light text-muted fw-normal" style="font-size: 9px;">TAHAP 1</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-danger" style="width: 20%"></div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. JAM LIVE
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${h}:${m}:${s}`;
        
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('live-date').textContent = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. GRAFIK PENDAFTARAN DINAMIS
    const ctx = document.getElementById('registrationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: {!! json_encode($counts) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#198754'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection