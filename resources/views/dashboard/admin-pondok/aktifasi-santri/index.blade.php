@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Aktivasi & Status Santri</h4>
                <p class="text-muted small mb-0">Kelola izin akses santri untuk plotting asrama dan sistem absensi.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                    <button class="btn btn-white btn-sm px-3 fw-bold active"><i class="fas fa-list me-1"></i> Semua</button>
                    <button class="btn btn-white btn-sm px-3 fw-bold text-success"><i class="fas fa-file-import me-1"></i> Import Excel</button>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-4 border-warning">
                    <div class="card-body p-3">
                        <small class="text-muted d-block mb-1 fw-bold">MENUNGGU AKTIVASI</small>
                        <h4 class="fw-bold mb-0 text-warning">24 <span class="small fw-normal text-muted" style="font-size: 12px;">Santri Baru</span></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-4 border-success">
                    <div class="card-body p-3">
                        <small class="text-muted d-block mb-1 fw-bold">SANTRI AKTIF</small>
                        <h4 class="fw-bold mb-0 text-success">452 <span class="small fw-normal text-muted" style="font-size: 12px;">Total</span></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-4 border-secondary">
                    <div class="card-body p-3">
                        <small class="text-muted d-block mb-1 fw-bold">ALUMNI / NON-AKTIF</small>
                        <h4 class="fw-bold mb-0 text-muted">12 <span class="small fw-normal text-muted" style="font-size: 12px;">Tahun ini</span></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group bg-light rounded-pill border-0 px-3">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control bg-transparent border-0 small" placeholder="Cari Nama atau NIS...">
                        </div>
                    </div>
                    <div class="col-md-8 text-md-end">
                        <select class="form-select d-inline-block border-0 bg-light rounded-pill small w-auto me-2">
                            <option>Semua Jenjang</option>
                            <option>MTs (Kelas VII, VIII, IX)</option>
                            <option>MA / SMK</option>
                        </select>
                        <button class="btn btn-light rounded-pill border-0 px-3 small"><i class="fas fa-filter me-1"></i> Filter</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">Santri</th>
                                <th>Pendidikan Formal</th>
                                <th>Status Akun</th>
                                <th>Terdaftar Pada</th>
                                <th class="text-end pe-4">Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $students = [
                                    ['nama' => 'M. Rizky Pratama', 'nis' => '2223001', 'kelas' => 'VII-A (MTs)', 'status' => 'Pending', 'date' => '20 Jan 2026'],
                                    ['nama' => 'Ahmad Fauzan', 'nis' => '2223045', 'kelas' => 'X-SMK', 'status' => 'Aktif', 'date' => '15 Jan 2026'],
                                    ['nama' => 'Zaidan Al-Khair', 'nis' => '2223089', 'kelas' => 'VIII-B (MTs)', 'status' => 'Pending', 'date' => '22 Jan 2026'],
                                ];
                            @endphp

                            @foreach($students as $s)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-{{ $s['status'] == 'Aktif' ? 'success' : 'warning' }}-subtle text-{{ $s['status'] == 'Aktif' ? 'success' : 'warning' }} rounded-circle d-flex align-items-center justify-content-center me-3 shadow-xs" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $s['nama'] }}</div>
                                            <small class="text-muted">NIS: {{ $s['nis'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark fw-normal border px-3 py-2 rounded-pill">{{ $s['kelas'] }}</span>
                                </td>
                                <td>
                                    @if($s['status'] == 'Aktif')
                                        <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Aktif</span>
                                    @else
                                        <span class="text-warning small fw-bold"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $s['date'] }}</td>
                                <td class="text-end pe-4">
                                    @if($s['status'] == 'Pending')
                                        <button class="btn btn-success btn-sm rounded-pill px-4 shadow-sm fw-bold" onclick="confirm('Aktifkan santri ini?')">
                                            Aktifkan
                                        </button>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 border-light shadow-none" title="Non-aktifkan">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4">
                <nav class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan 3 santri baru</small>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link rounded-circle border-0" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link rounded-circle border-0 ms-1" href="#">1</a></li>
                        <li class="page-item"><a class="page-link rounded-circle border-0 ms-1" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-warning-subtle { background-color: #fff9e6 !important; }
    .text-success { color: #198754 !important; }
    .text-warning { color: #f39c12 !important; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .rounded-4 { border-radius: 1rem !important; }
    
    /* Hover Effect pada Row */
    .table-hover tbody tr:hover {
        background-color: #f1f7f5 !important;
        transition: 0.2s;
    }

    .btn-white { background: #fff; color: #333; }
    .btn-white.active { background: #198754; color: #fff; border-color: #198754; }

    /* Custom Form Select */
    .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
    }
</style>
@endsection