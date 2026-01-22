@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Database Santri</h4>
                <p class="text-muted small mb-0">Total data santri yang terdaftar dalam sistem pendidikan asrama.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                    <button class="btn btn-success px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahSantri">
                        <i class="fas fa-plus me-2"></i>Tambah Santri
                    </button>
                    <button class="btn btn-white border-start px-3 text-muted bg-white"><i class="fas fa-file-export me-1"></i> Export</button>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group bg-light rounded-pill border-0 px-3">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control bg-transparent border-0 small py-2" placeholder="Cari Nama, NIS, atau Nama Orang Tua...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select border-0 bg-light rounded-pill small py-2">
                            <option selected>Pilih Jenjang</option>
                            <option>Mts Kelas VII</option>
                            <option>Mts Kelas VIII</option>
                            <option>Mts Kelas IX</option>
                            <option>MA / SMK</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select border-0 bg-light rounded-pill small py-2">
                            <option selected>Unit Asrama</option>
                            <option>Al-Kausar</option>
                            <option>Al-Firdaus</option>
                            <option>Darul Ulum</option>
                            <option>Darul Naim</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select border-0 bg-light rounded-pill small py-2">
                            <option selected>Status</option>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                            <option>Alumni</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-success rounded-pill w-100 py-2 fw-bold small">Terapkan Filter</button>
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
                                <th class="ps-4 py-3">IDENTITAS SANTRI</th>
                                <th>PENDIDIKAN</th>
                                <th>ASRAMA / KAMAR</th>
                                <th>WALI SANTRI</th>
                                <th class="text-end pe-4">OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $daftar_santri = [
                                    ['nama' => 'Ahmad Zaelani', 'nis' => '2425001', 'foto' => 'AZ', 'kelas' => 'VII-A (Mts)', 'asrama' => 'Al-Kausar', 'kamar' => 'K-01', 'wali' => 'Bpk. Hendra'],
                                    ['nama' => 'M. Sultan Syah', 'nis' => '2425002', 'foto' => 'MS', 'kelas' => 'X-SMK', 'asrama' => 'Darul Naim', 'kamar' => 'K-05', 'wali' => 'Ibu Maria'],
                                    ['nama' => 'Fahri Ramadhan', 'nis' => '2425003', 'foto' => 'FR', 'kelas' => 'VIII-C (Mts)', 'asrama' => 'Al-Firdaus', 'kamar' => 'K-02', 'wali' => 'Bpk. Yusuf'],
                                ];
                            @endphp

                            @foreach($daftar_santri as $ds)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 d-flex align-items-center justify-content-center bg-success text-white fw-bold rounded-circle" style="width: 40px; height: 40px; font-size: 12px;">
                                            {{ $ds['foto'] }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $ds['nama'] }}</div>
                                            <small class="text-muted">NIS: {{ $ds['nis'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-normal" style="font-size: 11px;">
                                        {{ $ds['kelas'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small fw-bold">{{ $ds['asrama'] }}</div>
                                    <small class="text-muted">No. Lemari {{ $ds['kamar'] }}</small>
                                </td>
                                <td class="small">{{ $ds['wali'] }}</td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-none" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="fas fa-eye me-2 text-info"></i> Profil Lengkap</a></li>
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="fas fa-edit me-2 text-warning"></i> Edit Data</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item py-2 small text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <small class="text-muted">Menampilkan 1-10 dari 452 Santri</small>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination pagination-sm mb-0 justify-content-md-end mt-2 mt-md-0">
                            <li class="page-item disabled"><a class="page-link rounded-circle border-0 px-3" href="#"><i class="fas fa-chevron-left"></i></a></li>
                            <li class="page-item active"><a class="page-link rounded-circle border-0 px-3 ms-1" href="#">1</a></li>
                            <li class="page-item"><a class="page-link rounded-circle border-0 px-3 ms-1" href="#">2</a></li>
                            <li class="page-item"><a class="page-link rounded-circle border-0 px-3 ms-1" href="#"><i class="fas fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    
    .table-hover tbody tr:hover {
        background-color: #f9fdfb !important;
        transition: 0.2s;
    }

    .dropdown-item:active {
        background-color: #198754;
    }

    /* Custom Form Select */
    .form-select:focus, .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
        background-color: #fff;
    }
</style>
@endsection