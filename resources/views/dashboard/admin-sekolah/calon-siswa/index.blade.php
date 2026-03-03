@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="mb-3">
        <h5 class="fw-800 text-dark mb-1">Calon Siswa</h5>
        <p class="text-xs text-muted">Daftar pendaftar yang sedang dalam proses seleksi atau administrasi.</p>
    </div>

    <div class="mb-3">
        <div class="input-group bg-white shadow-sm rounded-3 border overflow-hidden">
            <span class="input-group-text border-0 bg-transparent ps-3">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" id="liveSearch" class="form-control border-0 py-2 text-sm shadow-none" 
                   placeholder="Cari nama atau nomor pendaftaran...">
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted text-xs fw-bold">
                        <th class="ps-4">NAMA / ID</th>
                        <th>KONTAK</th>
                        <th>ASRAMA</th>
                        <th>STATUS DAFTAR</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @include('dashboard.admin-sekolah.calon-siswa._table')
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('liveSearch').addEventListener('input', function(e) {
        let search = e.target.value;
        fetch(`{{ route('adminsekolah.calon-siswa.index') }}?search=${search}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('tableBody').innerHTML = html;
        });
    });
</script>
@endsection