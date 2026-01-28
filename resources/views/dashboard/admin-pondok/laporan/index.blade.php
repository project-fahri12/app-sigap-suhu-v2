@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body p-4" style="background: #f8f9fa; min-height: 100vh;">
        {{-- Header & Filter --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Laporan Analitik Pondok</h4>
                <p class="text-muted small mb-0">Visualisasi Data Real-time</p>
            </div>
            <div class="d-flex gap-2">
                <form action="" method="GET" class="d-flex gap-2">
                    <select name="filter" class="form-select form-select-sm rounded-pill shadow-sm border-0 px-3"
                        onchange="this.form.submit()">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="d" {{ request('filter') == 'd' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="m" {{ request('filter') == 'm' ? 'selected' : '' }}>Bulan Ini</option>
                    </select>
                </form>
                {{-- <a href="{{ route('adminpondok.laporan-pondok.index') }}"
                    class="btn btn-white btn-sm rounded-pill px-3 shadow-sm border">
                    <i class="fas fa-file-pdf me-1 text-danger"></i> PDF
                </a> --}}
            </div>
        </div>

        {{-- Stats Cards (3 Utama) --}}
        <div class="row g-3 mb-4 text-white text-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-primary p-4 h-100 position-relative overflow-hidden">
                    <div class="position-relative" style="z-index: 2;">
                        <small class="opacity-75 fw-bold">TOTAL SANTRI</small>
                        <h1 class="fw-bold mb-0 mt-1 text-white">{{ number_format($stats['total']) }}</h1>
                    </div>
                    <i class="fas fa-user-graduate position-absolute opacity-25"
                        style="right: -10px; bottom: -10px; font-size: 80px;"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-dark p-4 h-100 position-relative overflow-hidden">
                    <div class="position-relative" style="z-index: 2;">
                        <small class="opacity-75 fw-bold">OKUPANSI BED</small>
                        @php $persenTotal = $totalKapasitas > 0 ? ($stats['total'] / $totalKapasitas) * 100 : 0 @endphp
                        <h1 class="fw-bold mb-0 mt-1 text-white">{{ number_format($persenTotal, 1) }}%</h1>
                    </div>
                    <i class="fas fa-bed position-absolute opacity-25"
                        style="right: -10px; bottom: -10px; font-size: 80px;"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-danger p-4 h-100 position-relative overflow-hidden">
                    <div class="position-relative" style="z-index: 2;">
                        <small class="opacity-75 fw-bold">SISA BED KOSONG</small>
                        <h1 class="fw-bold mb-0 mt-1 text-white">{{ number_format($sisaBedTotal) }}</h1>
                    </div>
                    <i class="fas fa-door-open position-absolute opacity-25"
                        style="right: -10px; bottom: -10px; font-size: 80px;"></i>
                </div>
            </div>
        </div>

        {{-- Section Chart Utama --}}
        <div class="row g-4 mb-4">
            {{-- Chart 1: Tren Pendaftaran (Ganti Tabel Santri) --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between mb-4">
                        <h6 class="fw-bold text-dark"><i class="fas fa-chart-line me-2 text-primary"></i>Tren Pendaftaran
                            Santri Baru</h6>
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3">7 Hari Terakhir</span>
                    </div>
                    <canvas id="trenChart" style="max-height: 320px;"></canvas>
                </div>
            </div>

            {{-- Chart 2: Distribusi Sekolah --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-bold text-dark mb-4"><i class="fas fa-school me-2 text-success"></i>Proporsi Sekolah</h6>
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="sekolahDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Asrama (Tetap Tabel tapi dengan Visual Progress yang lebih Kuat) --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-50">
            <div class="card-header bg-white border-0 p-4">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-hotel me-2 text-warning"></i>Analitik Okupansi Per
                    Gedung Asrama</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4 py-3 border-0">GEDUNG ASRAMA</th>
                            <th class="border-0 text-center">JUMLAH KAMAR</th>
                            <th class="border-0 text-center">TERISI</th>
                            <th class="border-0" style="width: 30%;">VISUALISASI KAPASITAS</th>
                            <th class="border-0 text-end pe-4">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asramas as $a)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">{{ $a['nama'] }}</span>
                                </td>
                                <td class="text-center text-muted">{{ $a['jml_kamar'] }} Kamar</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border rounded-pill px-3">{{ $a['total_siswa'] }}
                                        Santri</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress rounded-pill flex-grow-1" style="height: 10px;">
                                            <div class="progress-bar {{ $a['persen'] > 90 ? 'bg-danger' : 'bg-primary' }}"
                                                style="width: {{ $a['persen'] }}%"></div>
                                        </div>
                                        <span class="ms-2 small fw-bold text-muted">{{ $a['persen'] }}%</span>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    @if ($a['sisa'] == 0)
                                        <span class="badge bg-danger rounded-pill px-3 small">Penuh</span>
                                    @else
                                        <span class="text-success small fw-bold">Tersedia {{ $a['sisa'] }} Bed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .bg-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
        }

        canvas {
            width: 100% !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Line Chart: Tren Pendaftaran (Data dari Controller)
            const trenCtx = document.getElementById('trenChart').getContext('2d');
            new Chart(trenCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($trenPendaftaran->pluck('date')) !!},
                    datasets: [{
                        label: 'Santri Terdaftar',
                        data: {!! json_encode($trenPendaftaran->pluck('total')) !!},
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 2. Doughnut Chart: Proporsi Sekolah
            const sekolahCtx = document.getElementById('sekolahDoughnutChart').getContext('2d');
            new Chart(sekolahCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($rekapSekolah->pluck('nama_sekolah')) !!},
                    datasets: [{
                        data: {!! json_encode($rekapSekolah->pluck('siswa_count')) !!},
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#0dcaf0', '#6610f2'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
@endsection
