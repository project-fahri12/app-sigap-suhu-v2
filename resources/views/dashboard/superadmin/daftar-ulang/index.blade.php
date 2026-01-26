@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Kasir Daftar Ulang</h4>
            <p class="text-muted small mb-0">Manajemen tagihan otomatis dengan Live Search & Filter.</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border-0 bg-white w-75 d-inline-flex">
                <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="searchInput" class="form-control border-0 py-2" 
                       placeholder="Cari Nama atau Kode..." value="{{ request('search') }}">
            </div>
        </div>
    </div>

    <ul class="nav nav-pills nav-fill mb-4 bg-white p-2 rounded-4 shadow-sm border" id="tabFilter">
        <li class="nav-item">
            <a class="nav-link active" data-status="semua" href="javascript:void(0)">
                Semua <span class="badge rounded-pill bg-light text-dark ms-2 border">{{ $counts['semua'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-status="belum_input" href="javascript:void(0)">
                Belum Bayar <span class="badge rounded-pill bg-danger-subtle text-danger ms-2 border border-danger">{{ $counts['belum_input'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-status="cicilan" href="javascript:void(0)">
                Cicilan <span class="badge rounded-pill bg-warning-subtle text-warning ms-2 border border-warning">{{ $counts['cicilan'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-status="lunas" href="javascript:void(0)">
                Lunas <span class="badge rounded-pill bg-success-subtle text-success ms-2 border border-success">{{ $counts['lunas'] }}</span>
            </a>
        </li>
    </ul>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold text-uppercase">
                        <th class="ps-3" style="width: 50px;">No</th>
                        <th>Siswa</th>
                        <th>Tagihan</th>
                        <th>Total Bayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- Table content akan diisi via AJAX atau include --}}
                    @include('dashboard.superadmin.daftar-ulang._table')
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .nav-pills .nav-link { color: #64748b; font-weight: 600; border-radius: 12px; padding: 12px; transition: 0.3s; }
    .nav-pills .nav-link.active { background-color: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
    .nav-pills .nav-link.active .badge { background-color: rgba(255,255,255,0.2) !important; color: #fff !important; border: none !important; }
    
    .btn-white { background-color: #fff; color: #64748b; border: 1px solid #e2e8f0; transition: 0.3s; }
    .btn-white:hover { background-color: #f8fafc; color: #2563eb; }
    
    /* AJAX Pagination Style */
    .ajax-pagination .pagination { margin-bottom: 0; gap: 5px; }
    .ajax-pagination .page-link { border: none; padding: 8px 16px; border-radius: 8px; color: #64748b; background: #f1f5f9; }
    .ajax-pagination .page-item.active .page-link { background: #2563eb; color: #fff; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const tabs = document.querySelectorAll('#tabFilter .nav-link');
        
        let currentStatus = 'semua';
        let currentPage = 1;

        function fetchTable() {
            tableBody.style.opacity = '0.5';
            
            // Build URL dengan parameter Search dan Tab
            let searchValue = searchInput.value;
            let url = `{{ route('superadmin.daftar-ulang.index') }}?page=${currentPage}&search=${searchValue}&tab=${currentStatus}`;

            fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(res => res.text())
            .then(html => {
                tableBody.innerHTML = html;
                tableBody.style.opacity = '1';
            })
            .catch(err => {
                console.error(err);
                tableBody.style.opacity = '1';
            });
        }

        // 1. Event: Live Search (Debounce)
        let typingTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                currentPage = 1; // Reset ke hal 1 saat cari
                fetchTable();
            }, 500);
        });

        // 2. Event: Filter Tab
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                currentStatus = this.getAttribute('data-status');
                currentPage = 1;
                fetchTable();
            });
        });

        // 3. Event: Pagination (Delegation)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('.ajax-pagination a');
            if (link) {
                e.preventDefault();
                const urlParams = new URL(link.href).searchParams;
                currentPage = urlParams.get('page');
                fetchTable();
            }
        });
    });
</script>
@endsection