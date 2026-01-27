@extends('dashboard.layouts.app')

@section('title', 'Penempatan Rombel | SIGAP')

@section('content')
<div class="content-body" style="background-color: #f4f7f6;">
    <div class="container-fluid">
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 small">
                <li class="breadcrumb-item text-muted">Akademik</li>
                <li class="breadcrumb-item active text-success fw-bold">Penempatan Rombel</li>
            </ol>
        </nav>

        {{-- Header Section --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Penempatan Rombel</h4>
                <p class="text-muted small mb-0">Kelola distribusi siswa ke dalam kelas atau rombongan belajar.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex align-items-center bg-white border px-3 py-2 rounded-4 shadow-sm">
                    <i class="fas fa-user-clock text-warning me-2"></i>
                    <span class="small text-muted">Belum Plotting: <b class="text-dark" id="count-header">{{ $siswaBelumPlot->count() }}</b> Siswa</span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- KOLOM KIRI: DAFTAR TUNGGU --}}
            <div class="col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="fas fa-list-ul me-2 text-success"></i>Daftar Tunggu
                            </h6>
                            <div id="search-loader" class="spinner-border spinner-border-sm text-success d-none"></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-8">
                                <div class="input-group bg-light rounded-pill border-0 px-3 shadow-sm">
                                    <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" id="live-search" class="form-control bg-transparent border-0 small py-2" placeholder="Cari nama siswa...">
                                </div>
                            </div>
                            <div class="col-4">
                                <select id="filter-gender" class="form-select bg-light border-0 rounded-pill small">
                                    <option value="">Gender</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 450px; min-height: 350px;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr class="small text-muted fw-bold">
                                        <th class="ps-4" width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                        <th>NAMA SISWA</th>
                                        <th class="text-center">JK</th>
                                    </tr>
                                </thead>
                                <tbody id="waiting-list-body">
                                    @include('dashboard.admin-sekolah.penempatan-rombel._list_waiting')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top p-4">
                        <div class="p-3 bg-light rounded-4 border" style="border-style: dashed !important;">
                            <label class="small fw-bold text-muted mb-2 d-block text-uppercase">Proses Plotting Cepat:</label>
                            <select id="quickRombelSelect" class="form-select border-0 shadow-sm rounded-pill fw-bold text-success">
                                <option value="">-- Pilih Rombel Tujuan --</option>
                                @foreach($listRombel as $rombel)
                                    <option value="{{ $rombel->id }}">
                                        {{ $rombel->nama_rombel }} ({{ $rombel->kelas->nama_kelas ?? '-' }}) - [{{ $rombel->jenis_kelas }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: ANGGOTA ROMBEL --}}
            <div class="col-xl-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark">Anggota Rombel</h6>
                        <div class="dropdown">
                            <button class="btn btn-outline-success btn-sm rounded-pill px-4 dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                <i class="fas fa-door-open me-1"></i> {{ $rombelTerpilih ? $rombelTerpilih->nama_rombel : 'Pilih Rombel' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4">
                                @foreach($listRombel as $lr)
                                    <li><a class="dropdown-item py-2 small" href="?rombel_id={{ $lr->id }}">{{ $lr->nama_rombel }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($rombelTerpilih)
                            <div class="px-4 py-3 bg-success text-white mx-4 rounded-4 mb-4 mt-2 d-flex justify-content-between align-items-center shadow-sm">
                                <div>
                                    <small class="opacity-75 d-block small">Rombel Aktif (Tipe: {{ $rombelTerpilih->jenis_kelas }}):</small>
                                    <h5 class="fw-bold mb-0">{{ $rombelTerpilih->nama_rombel }}</h5>
                                </div>
                                <div class="text-end">
                                    <h3 class="fw-bold mb-0">{{ $anggotaRombel->count() }}</h3>
                                    <small class="opacity-75 small">Siswa</small>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="bg-light small text-muted fw-bold">
                                        <tr>
                                            <th class="ps-4">NAMA LENGKAP</th>
                                            <th class="text-center">NISN</th>
                                            <th class="text-end pe-4">OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($anggotaRombel as $anggota)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold small">{{ $anggota->pendaftar->nama_lengkap }}</div>
                                                <small class="text-muted" style="font-size: 10px;">{{ $anggota->pendaftar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                            </td>
                                            <td class="text-center small">{{ $anggota->pendaftar->nisn ?? '-' }}</td>
                                            <td class="text-end pe-4">
                                                {{-- FORM UNIK UNTUK TIAP BARIS --}}
                                                <form id="form-delete-{{ $anggota->id }}" action="{{ route('adminsekolah.penempatan-rombel.destroy', $anggota->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                {{-- MEMANGGIL FUNGSI GLOBAL confirmDelete --}}
                                                <button type="button" onclick="confirmDelete('form-delete-{{ $anggota->id }}')" class="btn btn-sm btn-light text-danger rounded-circle p-2 border-0 shadow-sm">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted small">Belum ada anggota di rombel ini.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 mt-5">
                                <i class="fas fa-users-viewfinder fa-4x text-muted opacity-25 mb-3"></i>
                                <p class="text-muted fw-bold">Pilih Rombel untuk melihat data anggota</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .sticky-top { top: 0; z-index: 10; }
    .form-check-input:checked { background-color: #198754; border-color: #198754; }
    #live-search:focus { box-shadow: none; outline: none; border-color: transparent; }
</style>

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Live Search & Filter
        function performSearch() {
            let search = $('#live-search').val();
            let gender = $('#filter-gender').val();
            $('#search-loader').removeClass('d-none');

            $.ajax({
                url: "{{ route('adminsekolah.penempatan-rombel.index') }}",
                type: 'GET',
                data: { search: search, gender: gender, ajax: 1 },
                success: function(res) {
                    $('#waiting-list-body').html(res.html);
                    $('#count-header').text(res.count);
                    $('#search-loader').addClass('d-none');
                }
            });
        }

        $('#live-search').on('keyup', performSearch);
        $('#filter-gender').on('change', performSearch);

        // 2. Select All Checkbox
        $(document).on('change', '#selectAll', function() {
            $('.siswa-checkbox').prop('checked', this.checked);
        });

        // 3. Quick Plotting via AJAX
        $('#quickRombelSelect').on('change', function() {
            let rombelId = $(this).val();
            let rombelName = $(this).find('option:selected').text();
            let selectedSiswa = $('.siswa-checkbox:checked').map(function() { return $(this).val(); }).get();

            if (!rombelId) return;
            if (selectedSiswa.length === 0) {
                Swal.fire('Info', 'Pilih siswa terlebih dahulu!', 'info');
                $(this).val('');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Plotting',
                text: `Pindahkan ${selectedSiswa.length} siswa ke ${rombelName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                confirmButtonText: 'Ya, Proses!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('adminsekolah.penempatan-rombel.store') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            siswa_ids: selectedSiswa,
                            rombel_id: rombelId
                        },
                        success: function(response) {
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Berhasil!', 
                                text: response.message, 
                                timer: 1500, 
                                showConfirmButton: false 
                            }).then(() => location.reload());
                        },
                        error: function(xhr) {
                            $('#quickRombelSelect').val('');
                            let msg = (xhr.status === 422) ? xhr.responseJSON.message : "Terjadi kesalahan sistem.";
                            Swal.fire({ icon: 'error', title: 'Gagal', html: msg });
                        }
                    });
                } else {
                    $(this).val('');
                }
            });
        });
    });
</script>
@endpush