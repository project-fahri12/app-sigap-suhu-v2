@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Data Siswa Aktif</h4>
            <p class="text-muted small mb-0">Manajemen informasi santri, penempatan kelas, dan rombel.</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-download me-2"></i>Export Excel
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group bg-light rounded-pill border-0 px-3">
                        <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" name="search" class="form-control bg-transparent border-0 py-2 text-sm" placeholder="Cari NIS atau Nama...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="kelas" class="filter-select form-select bg-light rounded-pill border-0 text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($listKelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="rombel" class="filter-select form-select bg-light rounded-pill border-0 text-sm">
                        <option value="">Semua Rombel</option>
                        @foreach($listRombel as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_rombel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="filter-select form-select bg-light rounded-pill border-0 text-sm">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Mutasi">Mutasi</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" id="resetFilter" class="btn btn-outline-secondary w-100 rounded-pill fw-bold text-sm">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold text-uppercase">
                        <th class="ps-4">Siswa</th>
                        <th>NIS</th>
                        <th>Kelas / Rombel</th>
                        <th>Pondok</th>
                        <th>Daftar Ulang</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="siswaTableBody">
                    @include('dashboard.admin-sekolah.data-siswa._table')
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('siswaTableBody');
    const searchInput = document.getElementById('searchInput');
    const filterSelects = document.querySelectorAll('.filter-select');
    const resetBtn = document.getElementById('resetFilter');

    function fetchSiswa(page = 1) {
        tableBody.style.opacity = '0.5';
        
        // Ambil semua data dari form
        const formData = new FormData(document.getElementById('filterForm'));
        const params = new URLSearchParams(formData);
        params.append('page', page);

        fetch(`{{ route('adminsekolah.data-siswa.index') }}?${params.toString()}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(res => res.text())
        .then(html => {
            tableBody.innerHTML = html;
            tableBody.style.opacity = '1';
        })
        .catch(err => console.error(err));
    }

    // Live Search (Debounce)
    let typingTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => fetchSiswa(1), 500);
    });

    // Filter Selects
    filterSelects.forEach(select => {
        select.addEventListener('change', () => fetchSiswa(1));
    });

    // Pagination Click
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.ajax-pagination a');
        if (link) {
            e.preventDefault();
            const page = new URL(link.href).searchParams.get('page');
            fetchSiswa(page);
        }
    });

    // Reset Filter
    resetBtn.addEventListener('click', () => {
        document.getElementById('filterForm').reset();
        fetchSiswa(1);
    });
});
</script>
@endsection