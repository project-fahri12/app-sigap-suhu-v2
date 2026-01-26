@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f4f7f6;">
    <div class="container-fluid">
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #136a42, #198754); color: white;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h3 class="fw-bold mb-1"><i class="fas fa-house-user me-2"></i>Dashboard Hunian & Loker</h3>
                                <p class="mb-0 opacity-75">Sistem monitoring ketersediaan fasilitas asrama santri.</p>
                            </div>
                            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                <div class="d-inline-block text-center bg-white bg-opacity-10 p-2 px-4 rounded-4 border border-white border-opacity-25">
                                    <h4 class="mb-0 fw-bold" id="live-clock">00:00:00</h4>
                                    <small class="text-uppercase ls-1" id="live-date">Memuat Tanggal...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['title' => 'Gedung', 'value' => '4', 'unit' => 'Blok', 'icon' => 'fa-building', 'color' => 'success'],
                    ['title' => 'Kamar', 'value' => '48', 'unit' => 'Unit', 'icon' => 'fa-door-open', 'color' => 'primary'],
                    ['title' => 'Total Loker', 'value' => '480', 'unit' => 'Slot', 'icon' => 'fa-box', 'color' => 'info'],
                    ['title' => 'Tersedia', 'value' => '15', 'unit' => 'Slot', 'icon' => 'fa-check-circle', 'color' => 'warning']
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} p-3 rounded-4">
                                <i class="fas {{ $stat['icon'] }} fa-xl"></i>
                            </div>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">{{ $stat['title'] }}</h6>
                        <h3 class="fw-bold mb-0">{{ $stat['value'] }} <small class="fs-6 text-muted fw-normal">{{ $stat['unit'] }}</small></h3>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-th-large me-2 text-success"></i>Kapasitas Per Kamar</h5>
                        <button class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua</button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @for ($i = 1; $i <= 6; $i++)
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 transition-hover bg-white border-light shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Kamar 0{{ $i }}</span>
                                        <small class="text-muted"><i class="fas fa-users me-1"></i> {{ 10 - $i }}/10</small>
                                    </div>
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: {{ (10-$i)*10 }}%"></div>
                                    </div>
                                    <small class="text-muted d-block text-end" style="font-size: 10px;">{{ $i }} Slot Tersisa</small>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history me-2 text-success"></i>Plotting Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-muted small">
                                        <th class="ps-4">SANTRI</th>
                                        <th>GEDUNG/KAMAR</th>
                                        <th>NOMOR LOKER</th>
                                        <th class="text-end pe-4">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $activities = [
                                            ['name' => 'Ahmad Fauzi', 'room' => 'Gedung A / K01', 'loker' => 'L-001', 'status' => 'Aktif'],
                                            ['name' => 'M. Ridwan', 'room' => 'Gedung A / K03', 'loker' => 'L-045', 'status' => 'Aktif'],
                                            ['name' => 'Zaini Abid', 'room' => 'Gedung B / K02', 'loker' => 'L-102', 'status' => 'Pindah'],
                                        ];
                                    @endphp
                                    @foreach($activities as $act)
                                    <tr class="small">
                                        <td class="ps-4 fw-bold text-dark">{{ $act['name'] }}</td>
                                        <td>{{ $act['room'] }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $act['loker'] }}</span></td>
                                        <td class="text-end pe-4">
                                            <span class="badge {{ $act['status'] == 'Aktif' ? 'bg-success' : 'bg-warning' }} rounded-pill">
                                                {{ $act['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="bg-success p-3 text-white text-center">
                            <h6 class="mb-0 fw-bold" id="cal-month-year">Januari 2026</h6>
                        </div>
                        <div class="p-3">
                            <table class="table table-sm table-borderless text-center mb-0" id="calendar-table">
                                <thead>
                                    <tr class="text-muted small">
                                        <th>S</th> <th>S</th> <th>R</th> <th>K</th> <th>J</th> <th>S</th> <th>M</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td class="text-muted opacity-25">29</td><td class="text-muted opacity-25">30</td><td class="text-muted opacity-25">31</td><td>1</td><td>2</td><td>3</td><td>4</td>
                                    </tr>
                                    <tr>
                                        <td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td>
                                    </tr>
                                    <tr>
                                        <td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td>
                                    </tr>
                                    <tr>
                                        <td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td class="bg-success text-white rounded-circle">25</td>
                                    </tr>
                                    <tr>
                                        <td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td><td class="text-muted opacity-25">1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0 text-muted"><i class="fas fa-rocket me-2 text-success"></i>Fitur Pengembangan</h6>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-bold">E-Absensi Hunian</small>
                                <small class="text-success">85%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-bold">Manajemen Inventaris</small>
                                <small class="text-info">40%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-bold">Integrasi Perizinan</small>
                                <small class="text-warning">15%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light p-3 border-top text-center rounded-bottom-4">
                        <small class="text-muted"><i class="fas fa-sync fa-spin me-2"></i>Sinkronisasi Otomatis Aktif</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .bg-primary-subtle { background-color: #e3f2fd !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        border-color: #198754 !important;
    }

    #calendar-table th, #calendar-table td {
        padding: 10px 5px;
        width: 14.28%;
    }

    .progress {
        background-color: #edf2f7;
        border-radius: 10px;
        overflow: hidden;
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        
        // Jam
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds}`;
        
        // Tanggal
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('live-date').textContent = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateClock, 1000);
    updateClock(); // Jalankan langsung
</script>
@endsection