@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body" style="background-color: #f8fafc;">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle p-3 rounded-4 me-3">
                                <i class="fas fa-user-shield text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Pusat Kendali Sistem</h4>
                                <p class="text-muted small mb-0">Selamat Datang, <span
                                        class="fw-bold text-dark">{{ Auth::user()->name }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="fw-bold mb-1">Status PPDB Pusat</h5>
                                <p class="small text-muted mb-0">Kontrol akses pendaftaran untuk seluruh unit lembaga secara
                                    sekaligus.</p>
                            </div>
                        </div>

                        <div class="p-3 rounded-4 bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-2 rounded-3 shadow-sm me-3 text-center" style="min-width: 60px;">
                                    <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px;">TA</small>
                                    <span class="fw-bold text-primary">{{ $tahunAjaran }}</span>
                                </div>
                                <div>
                                    <small class="d-block text-muted">Tahun Ajaran Aktif</small>
                                    <span class="fw-bold text-dark">{{ $tahunAjaran }} - {{ $semester }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div
                        class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4 h-100 position-relative overflow-hidden">
                        <div class="position-absolute end-0 bottom-0 opacity-25 mb-n3 me-n3">
                            <i class="fas fa-chart-pie fa-6x"></i>
                        </div>
                        <h6 class="fw-bold small mb-3 text-uppercase opacity-75">Ringkasan Hak Akses</h6>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle me-2 text-info"></i>
                            <span class="fw-bold">Otoritas Penuh Sistem Pusat</span>
                        </div>
                        <div class="mt-auto pt-4">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <h3 class="fw-bold mb-0">{{ number_format($totalPendaftarGlobal) }}</h3>
                                    <small>Total Pendaftar Global</small>
                                </div>
                                <div class="text-end">
                                    <h3 class="fw-bold mb-0">{{ $totalSekolah }}</h3>
                                    <small>Sekolah/Unit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div
                            class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Monitoring Operasional Sekolah</h6>
                            <button class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua Sekolah</button>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small fw-bold text-uppercase">
                                        <tr>
                                            <th class="ps-3">Nama Sekolah</th>
                                            <th>Status Gelombang</th>
                                            <th class="text-center">Kapasitas</th>
                                            <th class="text-center">Pendaftar</th>
                                            <th style="width: 200px;">Okupansi</th>
                                            <th class="text-end pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sekolahList as $sekolah)
                                            <tr>
                                                <td class="ps-3">
                                                    {{-- Bagian Nama Sekolah tetap sama --}}
                                                    <span
                                                        class="fw-bold d-block text-dark">{{ $sekolah->nama_sekolah }}</span>
                                                </td>

                                                <td>
                                                    {{-- Ambil objek gelombang yang aktif --}}
                                                    @php
                                                        $aktif = $sekolah->gelombang->first();
                                                    @endphp

                                                    @if ($aktif)
                                                        <span
                                                            class="badge bg-success-subtle text-success rounded-pill px-3">Opened</span>
                                                    @else
                                                        <span
                                                            class="badge bg-danger-subtle text-danger rounded-pill px-3">Closed</span>
                                                    @endif
                                                </td>

                                                <td class="text-center fw-bold">
                                                    {{-- Tampilkan kuota dari gelombang yang aktif --}}
                                                    {{ $aktif->kuota ?? 0 }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $sekolah->pendaftar_count }}
                                                </td>

                                                <td>
                                                    @php
                                                        $kuota = $aktif->kuota ?? 0;
                                                        $pendaftar = $sekolah->pendaftar_count ?? 0;
                                                        $percent = $kuota > 0 ? ($pendaftar / $kuota) * 100 : 0;
                                                        $barColor =
                                                            $percent >= 100
                                                                ? 'bg-danger'
                                                                : ($percent >= 80
                                                                    ? 'bg-warning'
                                                                    : 'bg-primary');
                                                    @endphp
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2 small fw-bold">{{ round($percent) }}%</span>
                                                        <div class="progress flex-grow-1" style="height: 6px;">
                                                            <div class="progress-bar {{ $barColor }}"
                                                                style="width: {{ $percent > 100 ? 100 : $percent }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <button type="button"
                                                        class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalSekolah{{ $sekolah->id }}">
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="modalSekolah{{ $sekolah->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow rounded-4">
                                                        <div class="modal-header border-0 pt-4 px-4">
                                                            <h5 class="modal-title fw-bold">Detail Operasional</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body px-4 pb-4">
                                                            <div class="d-flex align-items-center mb-4">
                                                                <div class="bg-primary-subtle p-3 rounded-4 me-3">
                                                                    <i class="fas fa-school text-primary fa-lg"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-bold mb-0 text-dark">
                                                                        {{ $sekolah->nama_sekolah }}</h6>
                                                                    <small
                                                                        class="text-muted">{{ $sekolah->kode_sekolah ?? 'SCH-' . $sekolah->id }}</small>
                                                                </div>
                                                            </div>

                                                            <div class="row g-3">
                                                                <div class="col-6">
                                                                    <div class="p-3 rounded-3 bg-light text-center">
                                                                        <small class="text-muted d-block mb-1">Kuota
                                                                            Total</small>
                                                                        <span
                                                                            class="fw-bold h5 mb-0">{{ $aktif->kuota ?? 0 }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="p-3 rounded-3 bg-light text-center">
                                                                        <small
                                                                            class="text-muted d-block mb-1">Pendaftar</small>
                                                                        <span
                                                                            class="fw-bold h5 mb-0">{{ $sekolah->pendaftar_count }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mt-4 pt-2">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <span class="small fw-bold">Persentase Okupansi</span>
                                                                    <span
                                                                        class="small fw-bold text-primary">{{ round($percent) }}%</span>
                                                                </div>
                                                                <div class="progress" style="height: 10px;">
                                                                    <div class="progress-bar {{ $barColor }}"
                                                                        role="progressbar"
                                                                        style="width: {{ $percent > 100 ? 100 : $percent }}%">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr class="my-4 opacity-50">

                                                            <div class="d-grid">
                                                                <a href="/admin/sekolah/{{ $sekolah->id }}"
                                                                    class="btn btn-primary rounded-pill fw-bold">
                                                                    Kelola Unit Sekolah
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .rounded-4 {
            border-radius: 1rem !important;
        }

        .bg-primary-subtle {
            background-color: #e0ebff !important;
        }

        .bg-success-subtle {
            background-color: #dcfce7 !important;
        }

        .bg-danger-subtle {
            background-color: #fee2e2 !important;
        }

        .btn-white {
            background-color: #ffffff !important;
            color: #333;
        }

        .progress {
            border-radius: 10px;
            background-color: #f1f5f9;
        }

        .table thead th {
            border: none;
            padding: 15px 10px;
        }
    </style>
@endsection
