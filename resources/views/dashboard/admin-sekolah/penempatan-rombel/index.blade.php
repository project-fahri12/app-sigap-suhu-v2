@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 small">
                <li class="breadcrumb-item text-muted">Akademik</li>
                <li class="breadcrumb-item active text-success fw-bold">Penempatan Rombel</li>
            </ol>
        </nav>

        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Penempatan Rombel</h4>
                <p class="text-muted small mb-0">Masukkan siswa ke dalam rombongan belajar (Kelas) yang tersedia.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex align-items-center bg-white border px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-info-circle text-success me-2"></i>
                    <span class="small text-muted">Total Belum Plotting: <b class="text-dark">{{ $siswaBelumPlot->count() }} Siswa</b></span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-5 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="fas fa-user-clock me-2 text-warning"></i>Daftar Tunggu</h6>
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Belum Ada Kelas</span>
                        </div>
                        
                        <form action="{{ route('adminsekolah.penempatan-rombel.index') }}" method="GET" class="row g-2">
                            <div class="col-8">
                                <div class="input-group bg-light rounded-pill border-0 px-2">
                                    <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control bg-transparent border-0 small" placeholder="Cari nama..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <select name="gender" class="form-select bg-light border-0 rounded-pill small" onchange="this.form.submit()">
                                    <option value="">Gender</option>
                                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>P</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <form action="{{ route('adminsekolah.penempatan-rombel.store') }}" method="POST">
                        @csrf
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 400px;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light sticky-top">
                                        <tr class="small text-muted fw-bold">
                                            <th class="ps-4" width="40">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>NAMA SISWA</th>
                                            <th class="text-center">JK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($siswaBelumPlot as $siswa)
                                        <tr>
                                            <td class="ps-4">
                                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" class="form-check-input">
                                            </td>
                                            <td>
                                                <div class="fw-bold small text-dark">{{ $siswa->pendaftar->nama_lengkap }}</div>
                                                <small class="text-muted" style="font-size: 10px;">{{ $siswa->pendaftar->nisn ?? 'Tanpa NISN' }}</small>
                                            </td>
                                            <td class="text-center small">{{ $siswa->pendaftar->jenis_kelamin }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <p class="text-muted mb-0 small">Semua siswa sudah masuk rombel.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top p-4">
                            <div class="p-3 bg-light rounded-4">
                                <label class="small fw-bold text-muted mb-2 d-block">PINDAHKAN KE ROMBEL:</label>
                                <div class="row g-2">
                                    <div class="col-8">
                                        <select name="rombel_id" class="form-select border-0 shadow-none rounded-pill small" required>
                                            <option value="">-- Pilih Rombel --</option>
                                            @foreach($listRombel as $rombel)
                                                <option value="{{ $rombel->id }}">{{ $rombel->nama_rombel }} ({{ $rombel->kelas->nama_kelas }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold small">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-7 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Anggota Rombel</h6>
                        <div class="dropdown">
                            <button class="btn btn-outline-success btn-sm rounded-pill px-3 dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                <i class="fas fa-door-open me-1"></i> {{ $rombelTerpilih ? $rombelTerpilih->nama_rombel : 'Pilih Rombel' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                @foreach($listRombel as $lr)
                                    <li><a class="dropdown-item py-2 small" href="?rombel_id={{ $lr->id }}">{{ $lr->nama_rombel }} ({{ $lr->kelas->nama_kelas }})</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($rombelTerpilih)
                            <div class="px-4 py-3 bg-success text-white mx-4 rounded-4 mb-4 mt-2 d-flex justify-content-between align-items-center shadow-sm">
                                <div>
                                    <small class="opacity-75 d-block">Kelas Aktif:</small>
                                    <h5 class="fw-bold mb-0">{{ $rombelTerpilih->nama_rombel }}</h5>
                                </div>
                                <div class="text-end">
                                    <h3 class="fw-bold mb-0">{{ $anggotaRombel->count() }}</h3>
                                    <small class="opacity-75 small">Siswa Terdaftar</small>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="bg-light small text-muted fw-bold">
                                        <tr>
                                            <th class="ps-4 py-3">NAMA SISWA</th>
                                            <th class="text-center">KELAS</th>
                                            <th class="text-end pe-4">OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($anggotaRombel as $anggota)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold small">{{ $anggota->pendaftar->nama_lengkap }}</div>
                                                <small class="text-muted" style="font-size: 10px;">{{ $anggota->pendaftar->nisn }}</small>
                                            </td>
                                            <td class="text-center small">
                                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-normal">{{ $rombelTerpilih->kelas->nama_kelas }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <button onclick="confirmDelete('{{ $anggota->id }}')" class="btn btn-sm btn-light text-danger rounded-circle border-0 p-2" title="Keluarkan">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 mt-5">
                                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                                    <i class="fas fa-users-viewfinder fa-3x text-muted opacity-25"></i>
                                </div>
                                <p class="text-muted fw-bold">Pilih Rombel Terlebih Dahulu</p>
                                <small class="text-muted d-block px-5">Klik tombol di pojok kanan atas untuk melihat siapa saja yang sudah masuk kelas.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form-delete" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // FUNGSI CHECK ALL
    document.getElementById('selectAll').onclick = function() {
        var checkboxes = document.getElementsByName('siswa_ids[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    // FUNGSI CONFIRM DELETE (LEPAS ROMBEL)
    function confirmDelete(id) {
        Swal.fire({
            title: 'Keluarkan Siswa?',
            text: "Siswa akan kembali ke daftar tunggu plotting.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluarkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('form-delete');
                form.action = "{{ url('sekolah/penempatan-rombel') }}/" + id;
                form.submit();
            }
        })
    }
</script>

<style>
    /* UTILS */
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-warning-subtle { background-color: #fff8e6 !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .sticky-top { top: 0; z-index: 10; }
    .table-hover tbody tr:hover { background-color: #f8faf9; }
    .form-check-input:checked { background-color: #198754; border-color: #198754; }
</style>
@endsection