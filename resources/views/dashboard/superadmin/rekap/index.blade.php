@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Rekapitulasi Pendaftaran</h4>
            <p class="text-muted small mb-0">Tahun Ajaran Aktif: <span class="badge bg-light text-dark border">2025/2026</span></p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white btn-sm shadow-sm border rounded-pill px-3">
                <i class="fas fa-sync-alt me-1 text-primary"></i> Refresh
            </button>
            <button class="btn btn-primary btn-sm shadow-sm rounded-pill px-3" onclick="window.print()">
                <i class="fas fa-file-export me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>

    {{-- Main Stats Cards --}}
    <div class="row g-3 mb-4">
        {{-- Total Card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-1">Total Pendaftar</h6>
                            <h2 class="fw-bold mb-0 count-up">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-box bg-primary-soft rounded-3">
                            <i class="fas fa-user-plus text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-soft-primary text-primary px-2 py-1 rounded-pill small">
                            <span class="pulse"></span> Live Update
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Verified Card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-hover border-start border-success border-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-1 text-success">Verified</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($stats['verifikasi']) }}</h2>
                        </div>
                        <div class="icon-box bg-success-soft rounded-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 6px;">
                        @php $percentV = $stats['total'] > 0 ? ($stats['verifikasi'] / $stats['total']) * 100 : 0 @endphp
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentV }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-hover border-start border-warning border-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase fw-bold mb-1 text-warning">Pending</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($stats['pending']) }}</h2>
                        </div>
                        <div class="icon-box bg-warning-soft rounded-3">
                            <i class="fas fa-hourglass-half text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 6px;">
                        @php $percentP = $stats['total'] > 0 ? ($stats['pending'] / $stats['total']) * 100 : 0 @endphp
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentP }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Distribution Tables --}}
    <div class="row g-4">
        {{-- Sekolah Table --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-school me-2 text-primary"></i>Distribusi Sekolah</h6>
                    <span class="badge bg-light text-primary border rounded-pill">{{ $rekapSekolah->count() }} Unit</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light sticky-top" style="z-index: 1;">
                                <tr class="small text-muted fw-bold">
                                    <th class="ps-4 py-3">NAMA SEKOLAH</th>
                                    <th class="text-center py-3">JUMLAH SISWA</th>
                                    <th class="pe-4 py-3 text-end">PROSENTASE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekapSekolah as $s)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $s->nama_sekolah }}</div>
                                        <small class="text-muted">Unit Pendidikan</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-3 fw-bold">
                                            {{ $s->pendaftar_count ?? $s->siswa_count }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        @php $sPercent = $stats['total'] > 0 ? (($s->pendaftar_count ?? $s->siswa_count) / $stats['total']) * 100 : 0 @endphp
                                        <small class="fw-bold text-muted">{{ number_format($sPercent, 1) }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pondok Table --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-mosque me-2 text-info"></i>Distribusi Pondok</h6>
                    <span class="badge bg-light text-info border rounded-pill">{{ $rekapPondok->count() }} Asrama</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light sticky-top" style="z-index: 1;">
                                <tr class="small text-muted fw-bold">
                                    <th class="ps-4 py-3">NAMA PONDOK</th>
                                    <th class="text-center py-3">JUMLAH SANTRI</th>
                                    <th class="pe-4 py-3 text-end">KAPASITAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekapPondok as $p)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $p->nama_pondok }}</div>
                                        <small class="text-muted text-xs">Pusat Asrama</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-soft-info text-info px-3 py-2 rounded-3 fw-bold">
                                            {{ $p->santri_count }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end text-muted small">
                                        N/A
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Soft Colors & Custom Styles */
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.08); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.08); }
    
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
    .card-hover { transition: transform 0.2s; }
    .card-hover:hover { transform: translateY(-5px); }
    
    .pulse {
        display: inline-block; width: 8px; height: 8px; border-radius: 50%;
        background: #0d6efd; margin-right: 5px; animation: pulse-blue 2s infinite;
    }

    @keyframes pulse-blue {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
    }

    .table thead th { font-size: 11px; letter-spacing: 0.5px; }
    .text-xs { font-size: 0.75rem; }

    @media print {
        .sidebar, .navbar, .btn, .pulse { display: none !important; }
        .content-body { padding: 0 !important; margin: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>
@endsection