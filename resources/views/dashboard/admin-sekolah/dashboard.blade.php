@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body" style="background-color: #f8fafc;">
        <div class="container-fluid py-4">

            {{-- Header Card (Tetap Statis) --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4 overflow-hidden position-relative">
                        <div class="row align-items-center position-relative" style="z-index: 2;">
                            <div class="col-md-7">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-3 p-3 me-3 shadow-lg">
                                        <i class="fas fa-university fa-2x text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-800 mb-1 letter-spacing-1">
                                            {{ auth()->user()->sekolah->nama_sekolah ?? 'Unit Sekolah' }}</h4>
                                        <p class="mb-0 text-white-50 small fw-600">Manajemen Database Terpusat</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                <div
                                    class="bg-white bg-opacity-10 p-3 rounded-4 d-inline-block border border-white border-opacity-10">
                                    <h2 id="liveClock" class="fw-800 mb-0 font-monospace">00:00:00</h2>
                                    <p class="mb-0 small opacity-75 fw-bold" id="liveDate">
                                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-9">
                    {{-- Statistik Row --}}
                    <div class="row g-3 mb-4">
                        @php
                            $cards = [
                                [
                                    'label' => 'PENDAFTAR',
                                    'val' => $stats['pendaftar'],
                                    'color' => 'primary',
                                    'icon' => 'fa-user-plus',
                                ],
                                [
                                    'label' => 'SISWA AKTIF',
                                    'val' => $stats['siswa_aktif'],
                                    'color' => 'success',
                                    'icon' => 'fa-user-check',
                                ],
                                [
                                    'label' => 'TOTAL ALUMNI',
                                    'val' => $stats['alumni'],
                                    'color' => 'warning',
                                    'icon' => 'fa-user-graduate',
                                ],
                            ];
                        @endphp
                        @foreach ($cards as $item)
                            <div class="col-md-4">
                                <div
                                    class="card border-0 shadow-sm rounded-4 p-3 border-start border-{{ $item['color'] }} border-5 h-100 bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted fw-800 d-block mb-1 small">{{ $item['label'] }}</small>
                                            <h2 class="fw-800 mb-0 counter-value" data-target="{{ $item['val'] }}">0</h2>
                                        </div>
                                        <div
                                            class="bg-{{ $item['color'] }} bg-opacity-10 p-3 rounded-circle text-{{ $item['color'] }}">
                                            <i class="fas {{ $item['icon'] }} fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Table Card --}}
                    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                        <div
                            class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-800 mb-1 text-dark">Antrian Verifikasi Berkas</h6>
                                <small class="text-muted">Data pendaftaran unit
                                    {{ auth()->user()->sekolah->singkatan }}</small>
                            </div>
                            <div class="search-box position-relative">
                                <i class="fas fa-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" id="liveSearch"
                                    class="form-control border-0 bg-light rounded-pill ps-5 pe-4 py-2"
                                    placeholder="Cari nama atau kode..." autocomplete="off">
                            </div>
                        </div>

                        {{-- Scrollable Container dengan ID untuk prevent jump --}}
                        <div class="table-responsive" id="tableWrapper"
                            style="max-height: 500px; overflow-y: auto; scroll-behavior: smooth;">
                            <table class="table table-hover align-middle mb-0 custom-table">
                                <thead class="bg-light sticky-top" style="z-index: 10; top: -1px;">
                                    <tr class="text-muted small fw-800">
                                        <th class="ps-4">NAMA PENDAFTAR</th>
                                        <th>STATUS PPDB</th>
                                        <th>STATUS BERKAS</th>
                                        <th class="text-center pe-4">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody id="pendaftarTable">
                                    @forelse($antrian as $p)
                                        <tr class="siswa-row">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3">
                                                        {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}</div>
                                                    <div>
                                                        <div class="fw-800 text-dark small">{{ $p->nama_lengkap }}</div>
                                                        <div class="text-muted" style="font-size: 11px;">
                                                            {{ $p->kode_pendaftaran }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill fw-700 px-3 py-2 bg-{{ $p->status_pendaftaran == 'diterima' ? 'success' : 'warning' }}-subtle text-{{ $p->status_pendaftaran == 'diterima' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($p->status_pendaftaran) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($p->status_berkas == 'lulus_verifikasi')
                                                    <span class="text-success small fw-700"><i
                                                            class="fas fa-check-circle me-1"></i> Terverifikasi</span>
                                                @else
                                                    <span class="text-muted small fw-700"><i class="fas fa-clock me-1"></i>
                                                        Menunggu Verifikasi</span>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="btn-group shadow-sm rounded-3">
                                                    <a href="" class="btn btn-sm btn-white border px-3"
                                                        title="Detail">
                                                        <i class="fas fa-eye text-primary"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="confirmDelete(event, '{{ $p->id }}')"
                                                        class="btn btn-sm btn-white border px-3" title="Hapus">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="noDataStatic">
                                            <td colspan="4" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fas fa-folder-open fa-3x text-light mb-3 d-block"></i>
                                                    <p class="text-muted fw-600">Belum ada data pendaftar masuk.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse

                                    {{-- Row Pesan "Tidak Ditemukan" (Hidden by default) --}}
                                    <tr id="noResultsRow" style="display: none;">
                                        <td colspan="4" class="text-center py-5">
                                            <div class="py-4 text-center">
                                                <i class="fas fa-search fa-3x text-light mb-3 d-block"></i>
                                                <h6 class="text-dark fw-800">Data Tidak Ditemukan</h6>
                                                <p class="text-muted small">Coba cari dengan kata kunci lain.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    {{-- Info Panel --}}
                    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-800 mb-0 small">KONTROL CEPAT</h6>
                        </div>
                        <div class="card-body p-4">
                            <button class="btn btn-primary w-100 rounded-pill mb-3 fw-700 py-2 shadow-sm"
                                onclick="showV2Info('Tambah Pendaftar')">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Manual
                            </button>
                            <hr class="my-4 opacity-50">
                            <div class="v2-card p-3 rounded-4 border border-dashed text-center bg-light pointer"
                                onclick="showV2Info('Laporan Semester')">
                                <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                <h6 class="fw-800 mb-1 small">Laporan PDF</h6>
                                <p class="text-muted extra-small mb-0">Rekap pendaftaran unit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .fw-800 {
            font-weight: 800;
        }

        .fw-700 {
            font-weight: 700;
        }

        .fw-600 {
            font-weight: 600;
        }

        .letter-spacing-1 {
            letter-spacing: -0.5px;
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .avatar-circle {
            width: 38px;
            height: 38px;
            background: #f1f5f9;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 800;
            font-size: 13px;
            border: 2px solid #fff;
        }

        .custom-table thead th {
            border: none;
            font-size: 10.5px;
            color: #64748b;
            text-transform: uppercase;
        }

        .custom-table tbody tr {
            transition: background 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }

        .custom-table tbody tr:last-child {
            border-bottom: none;
        }

        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Scrollbar */
        .table-responsive::-webkit-scrollbar {
            width: 5px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .btn-white {
            background: white;
        }

        .v2-card:hover {
            transform: translateY(-3px);
            border-color: #3b82f6 !important;
            background: #fff !important;
        }

        .extra-small {
            font-size: 10px;
        }

        .pointer {
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Live Clock
            setInterval(() => {
                const now = new Date();
                const clockEl = document.getElementById('liveClock');
                if (clockEl) clockEl.textContent = now.toLocaleTimeString('id-ID', {
                    hour12: false
                });
            }, 1000);

            // 2. Counter Stats
            document.querySelectorAll('.counter-value').forEach(counter => {
                const target = +counter.dataset.target;
                let count = 0;
                const update = () => {
                    const inc = target / 40 || 1;
                    if (count < target) {
                        count = Math.ceil(count + inc);
                        counter.innerText = count.toLocaleString();
                        setTimeout(update, 25);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };
                update();
            });

            // 3. ANTI-JUMP LIVE SEARCH & EMPTY STATE
            const searchInput = document.getElementById('liveSearch');
            const rows = document.querySelectorAll('#pendaftarTable tr.siswa-row');
            const noResultsRow = document.getElementById('noResultsRow');

            searchInput.addEventListener('input', function(e) {
                const term = this.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(term)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Handle Empty State
                if (visibleCount === 0 && term !== "") {
                    noResultsRow.style.display = '';
                } else {
                    noResultsRow.style.display = 'none';
                }
            });
        });

        // Handle button clicks to prevent jumping to top
        function confirmDelete(event, id) {
            event.preventDefault(); // Mencegah reload/jump
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data ID " + id + " akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus'
            });
        }

        function showV2Info(name) {
            Swal.fire({
                title: name,
                text: 'Fitur ini sedang dalam tahap sinkronisasi unit.',
                icon: 'info',
                confirmButtonColor: '#0d6efd'
            });
        }
    </script>
@endsection
