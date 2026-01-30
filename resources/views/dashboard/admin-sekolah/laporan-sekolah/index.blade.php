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
                            <div class="dropdown">
                                <button class="btn btn-outline-success rounded-pill px-4 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-file-excel me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu border-0 shadow-sm">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="exportData('full')">Export Semua Siswa</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="exportData('baru')">Export Siswa Baru (Aktif)</a></li>
                                </ul>
                            </div>
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
                        <h6 class="fw-bold mb-0">Tren Pendaftaran vs Daftar Ulang Lunas (7 Hari Terakhir)</h6>
                        <span class="badge bg-primary-subtle text-primary rounded-pill">{{ date('F Y') }}</span>
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
                            <span class="fw-bold">{{ $totalPendaftar }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Daftar Ulang (Lunas)</span>
                            <span class="fw-bold">{{ $lunasDaftarUlang }}</span>
                        </div>
                        @php $persenLunas = $totalPendaftar > 0 ? ($lunasDaftarUlang / $totalPendaftar) * 100 : 0; @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $persenLunas }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Belum Verifikasi Berkas</span>
                            <span class="fw-bold text-danger">{{ $belumVerifikasi }}</span>
                        </div>
                        @php $persenBelum = $totalPendaftar > 0 ? ($belumVerifikasi / $totalPendaftar) * 100 : 0; @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ $persenBelum }}%"></div>
                        </div>
                    </div>
                    <div class="alert alert-info border-0 rounded-4 mt-auto mb-0">
                        <small><i class="fas fa-info-circle me-1"></i> Data mencakup unit <strong>{{ auth()->user()->sekolah->singkatan ?? 'SMA' }}</strong> tahun ajaran aktif.</small>
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
                                @forelse($dataKelas as $kelas)
                                <tr>
                                    <td class="fw-bold">{{ $kelas->nama_kelas }}</td>
                                    <td class="text-center">{{ $kelas->laki_laki }}</td>
                                    <td class="text-center">{{ $kelas->perempuan }}</td>
                                    <td class="text-center text-primary fw-bold">{{ $kelas->laki_laki + $kelas->perempuan }}</td>
                                    <td>
                                        @php 
                                            $kapasitas = 40; // Sesuaikan jika ada kolom kapasitas di tabel kelas
                                            $totalSiswa = $kelas->laki_laki + $kelas->perempuan;
                                            $persenIsi = ($totalSiswa / $kapasitas) * 100;
                                        @endphp
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar {{ $persenIsi > 90 ? 'bg-danger' : ($persenIsi > 70 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $persenIsi }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted italic">Belum ada data kelas atau siswa.</td>
                                </tr>
                                @endforelse
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
        .btn, .sidebar, .dropdown, .roadmap-v2, .card-header .dropdown { display: none !important; }
        .card { border: 1px solid #ddd !important; box-shadow: none !important; }
        .content-body { padding: 0 !important; background-color: white !important; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartLaporanFull').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Pendaftaran Akun',
                        data: {!! json_encode($chartDaftar) !!},
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Daftar Ulang Lunas',
                        data: {!! json_encode($chartLunas) !!},
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
                    y: { beginAtZero: true, grid: { borderDash: [2, 2] }, ticks: { stepSize: 1 } }
                }
            }
        });

        window.exportData = function(mode) {
            Swal.fire({
                title: 'Konfirmasi Export',
                text: mode === 'baru' ? "Export data siswa baru tahun ajaran aktif?" : "Export seluruh data siswa di unit ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                confirmButtonText: 'Ya, Download'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Pastikan route ini sesuai dengan route export Anda
                    window.location.href = "{{ route('adminsekolah.data-siswa.export') }}?type=" + mode;
                }
            });
        };
    });
</script>
@endsection