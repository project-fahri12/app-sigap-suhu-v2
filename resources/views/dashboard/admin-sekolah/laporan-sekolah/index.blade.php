@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8fafc;">
    <div class="container-fluid">
        
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="bg-success-subtle p-3 rounded-4 me-3">
                                <i class="fas fa-chart-line text-success fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Laporan Analitik Pendaftaran</h4>
                                <p class="text-muted small mb-0">Unit: <span class="badge bg-dark">{{ auth()->user()->sekolah->nama_sekolah ?? 'SMA Terpadu Al-Ikhlas' }}</span></p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success rounded-pill px-4" onclick="exportData('Excel')">
                                <i class="fas fa-file-excel me-1"></i> Export
                            </button>
                            <button class="btn btn-success rounded-pill px-4" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                        <h6 class="fw-bold mb-0">Tren Pendaftaran vs Daftar Ulang (30 Hari Terakhir)</h6>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">
                                Januari 2026
                            </button>
                            <ul class="dropdown-menu border-0 shadow-sm">
                                <li><a class="dropdown-item" href="#">Desember 2025</a></li>
                                <li><a class="dropdown-item" href="#">Januari 2026</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="height: 350px;">
                            <canvas id="chartLaporanFull"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                    <h6 class="fw-bold mb-4">Ringkasan Konversi</h6>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Total Pendaftar</span>
                            <span class="fw-bold">452</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Daftar Ulang (Lunas)</span>
                            <span class="fw-bold">312</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 69%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Belum Verifikasi Berkas</span>
                            <span class="fw-bold text-danger">45</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: 10%"></div>
                        </div>
                    </div>
                    <div class="alert alert-info border-0 rounded-4 mt-auto mb-0">
                        <small><i class="fas fa-info-circle me-1"></i> Data ini hanya mencakup unit <strong>{{ auth()->user()->sekolah->singkatan ?? 'SMA' }}</strong> saja.</small>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0">Data Siswa Per Jenjang</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small fw-bold text-uppercase">
                                <tr>
                                    <th>Jenjang/Kelas</th>
                                    <th class="text-center">Laki-laki</th>
                                    <th class="text-center">Perempuan</th>
                                    <th class="text-center">Total</th>
                                    <th>Kapasitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Kelas X (Sepuluh)</td>
                                    <td class="text-center">60</td>
                                    <td class="text-center">65</td>
                                    <td class="text-center text-primary fw-bold">125</td>
                                    <td>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-success" style="width: 85%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kelas XI (Sebelas)</td>
                                    <td class="text-center">55</td>
                                    <td class="text-center">58</td>
                                    <td class="text-center text-primary fw-bold">113</td>
                                    <td>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-warning" style="width: 75%"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-light border border-dashed p-4 h-100 opacity-75">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="fw-bold mb-0 text-muted">Laporan Kenaikan Kelas (v2)</h6>
                        <span class="badge bg-secondary">Coming Soon</span>
                    </div>
                    <p class="small text-muted">Modul untuk melihat statistik mutasi siswa antar kelas per tahun ajaran.</p>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill disabled w-auto">Lihat Preview</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-light border border-dashed p-4 h-100 opacity-75">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="fw-bold mb-0 text-muted">Laporan Alumni (v2)</h6>
                        <span class="badge bg-secondary">Coming Soon</span>
                    </div>
                    <p class="small text-muted">Pelacakan data lulusan dan statistik perguruan tinggi alumni.</p>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill disabled w-auto">Lihat Preview</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    @media print {
        .btn, .sidebar, .dropdown, .roadmap-v2 { display: none !important; }
        .card { border: 1px solid #ddd !important; shadow: none !important; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Logic
        const ctx = document.getElementById('chartLaporanFull').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1 Jan', '5 Jan', '10 Jan', '15 Jan', '20 Jan', '25 Jan', '27 Jan'],
                datasets: [
                    {
                        label: 'Pendaftaran Akun',
                        data: [50, 80, 150, 200, 320, 410, 452],
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Daftar Ulang Selesai',
                        data: [20, 40, 90, 120, 210, 280, 312],
                        borderColor: '#198754',
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 2] } }
                }
            }
        });

        // Export Simulation
        window.exportData = function(type) {
            Swal.fire({
                title: 'Export Laporan Unit',
                text: 'Menyiapkan file laporan pendaftaran untuk {{ auth()->user()->sekolah->singkatan ?? "Unit Ini" }}...',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            }).then(() => {
                Swal.fire('Berhasil!', 'File Laporan-Pendaftaran-' + type + '.xlsx telah diunduh.', 'success');
            });
        };
    });
</script>
@endsection