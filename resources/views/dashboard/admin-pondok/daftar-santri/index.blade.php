@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body" style="background-color: #f8faf9;">
        <div class="container-fluid">

            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold text-dark mb-1">Database Santri</h4>
                    <p class="text-muted small mb-0">Manajemen status dan akademik santri secara dinamis.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                        <button id="btnExportPdf" class="btn btn-white bg-white text-muted border-0">
                            <i class="fas fa-file-pdf me-1 text-danger"></i> Export PDF
                        </button>
                        <button class="btn btn-success px-4 fw-bold border-start border-white">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="input-group bg-light rounded-pill border-0 px-3">
                                <span class="input-group-text bg-transparent border-0"><i
                                        class="fas fa-search text-muted"></i></span>
                                <input type="text" id="searchInput"
                                    class="form-control bg-transparent border-0 small py-2"
                                    placeholder="Cari Nama atau NIS..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-select border-0 bg-light rounded-pill small py-2">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Tamat">Tamat</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="Drop Out">Drop Out</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button onclick="refreshTable()" class="btn btn-success rounded-pill w-100 py-2 fw-bold">
                                <i class="fas fa-sync-alt me-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="ps-4 py-3" width="40"><input type="checkbox" class="form-check-input"
                                            id="checkAll"></th>
                                    <th>No</th>
                                    <th>NIS & Nama</th>
                                    <th>Pend. Formal</th>
                                    <th>Kamar</th>
                                    <th>Wali Santri</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="santriData">
                                @include('dashboard.admin-pondok.daftar-santri._table')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-success-subtle {
            background-color: #eaf6ed !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .table thead th {
            background-color: #f1f7f5 !important;
            border: none;
            font-size: 11px;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border: none;
            margin: 0 3px;
            border-radius: 50% !important;
            color: #6c757d;
        }

        .page-item.active .page-link {
            background-color: #198754;
            color: white;
        }
    </style>

    <script>
        function refreshTable(page = 1) {
            let search = document.getElementById('searchInput').value;
            let status = document.getElementById('statusFilter').value;
            let container = document.getElementById('santriData');

            container.style.opacity = '0.5';

            fetch(`{{ route('adminpondok.daftar-santri.index') }}?search=${search}&status=${status}&page=${page}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                });
        }

        // Live Search Logic (Debounce)
        let typingTimer;
        document.getElementById('searchInput').addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => refreshTable(), 500);
        });

        document.getElementById('statusFilter').addEventListener('change', () => refreshTable());

        // AJAX Pagination Handling
        document.addEventListener('click', function(e) {
            if (e.target.closest('.ajax-pagination a')) {
                e.preventDefault();
                let page = new URL(e.target.closest('.ajax-pagination a').href).searchParams.get('page');
                refreshTable(page);
            }
        });

        document.getElementById('btnExportPdf').addEventListener('click', function() {
            let search = document.getElementById('searchInput').value;
            let status = document.getElementById('statusFilter').value;

            // Redirect ke URL Export dengan membawa filter aktif
            window.location.href =
                `{{ route('adminpondok.daftar-santri.export-pdf') }}?search=${search}&status=${status}`;
        });
    </script>
@endsection
