@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    {{-- HEADER DENGAN FILTER DUMMY --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-1">Analisis Global Infrastruktur</h4>
                    <p class="text-muted small mb-0">Laporan statistik periodik (Data Simulasi)</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                        <input type="text" id="dummySearch" class="form-control form-control-sm rounded-pill px-3" placeholder="Cari unit sekolah..." style="max-width: 250px;">
                        <select class="form-select form-select-sm rounded-pill" style="max-width: 150px;">
                            <option>Tahun 2025</option>
                            <option>Tahun 2024</option>
                        </select>
                        <button class="btn btn-primary btn-sm rounded-pill px-3" onclick="window.print()">
                            <i class="fas fa-file-export me-1"></i> Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK ANALISIS --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">Tren Pertumbuhan Kapasitas Santri</h6>
                </div>
                <div class="card-body">
                    <canvas id="growthChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">Rasio Gender Global</h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <canvas id="genderPieChart" style="max-height: 220px;"></canvas>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Dominasi: <strong>Santri Putra (58%)</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL RINCIAN DUMMY --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h6 class="fw-bold mb-0">Rincian Operasional per Unit</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="dummyTable">
                <thead class="bg-light">
                    <tr class="text-muted small">
                        <th class="ps-4">UNIT SEKOLAH</th>
                        <th>JENJANG</th>
                        <th>KAPASITAS</th>
                        <th>STATUS ASRAMA</th>
                        <th class="text-center">SKOR AKREDITASI</th>
                        <th class="text-end pe-4">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Dummy 1 --}}
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">SMA Unggulan Amanah</div>
                            <small class="text-muted">KODE: SCH-001</small>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">SMA</span></td>
                        <td>850 / 1000</td>
                        <td><span class="text-success small"><i class="fas fa-check-circle me-1"></i> Wajib</span></td>
                        <td class="text-center"><span class="badge bg-warning text-dark">A+</span></td>
                        <td class="text-end pe-4 text-success fw-bold">Aktif</td>
                    </tr>
                    {{-- Data Dummy 2 --}}
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">SMP Islam Terpadu Madani</div>
                            <small class="text-muted">KODE: SCH-002</small>
                        </td>
                        <td><span class="badge bg-info-subtle text-info">SMP</span></td>
                        <td>520 / 600</td>
                        <td><span class="text-success small"><i class="fas fa-check-circle me-1"></i> Wajib</span></td>
                        <td class="text-center"><span class="badge bg-light text-dark">A</span></td>
                        <td class="text-end pe-4 text-success fw-bold">Aktif</td>
                    </tr>
                    {{-- Data Dummy 3 --}}
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">SDIT Al-Ikhlas (Laju)</div>
                            <small class="text-muted">KODE: SCH-003</small>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary">SD</span></td>
                        <td>300 / 450</td>
                        <td><span class="text-muted small"><i class="fas fa-times-circle me-1"></i> Laju</span></td>
                        <td class="text-center"><span class="badge bg-light text-dark">B+</span></td>
                        <td class="text-end pe-4 text-danger fw-bold">Maintenance</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPTS UNTUK GRAFIK --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Grafik Batang/Line Tren Pertumbuhan
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            datasets: [{
                label: 'Pendaftaran Baru',
                data: [120, 190, 150, 250, 220, 310, 400],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    // 2. Grafik Pie Gender
    const ctxPie = document.getElementById('genderPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Putra', 'Putri'],
            datasets: [{
                data: [580, 420],
                backgroundColor: ['#4e73df', '#e74a3b'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // 3. Simple Search Filter Dummy
    document.getElementById('dummySearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dummyTable tbody tr');
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
</script>

<style>
    canvas { width: 100% !important; }
    .bg-primary-subtle { background-color: #e0e7ff; }
    .bg-info-subtle { background-color: #e0f2fe; }
    .bg-secondary-subtle { background-color: #f3f4f6; }
</style>
@endsection