@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h4 class="fw-800 text-dark mb-1">Pengaturan Tingkat Kelas</h4>
            <p class="text-muted small mb-0">Definisikan tingkatan kelas untuk masing-masing unit sekolah.</p>
        </div>
        <div class="col-md-5 text-end">
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                <i class="fas fa-plus me-1"></i> Tambah Tingkat Kelas
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white mb-4">
                <h5 class="fw-bold">Struktur Kelas</h5>
                <p class="small opacity-75">Tingkat kelas adalah kategori induk bagi Rombongan Belajar (Rombel).</p>
                <hr class="opacity-25">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">Total Tingkatan</span>
                    <span class="fw-bold">{{ $data->count() }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold text-uppercase">
                        <th class="ps-4">Tingkat Kelas</th>
                        <th>Unit Sekolah</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $kelas)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-800 text-dark fs-5 text-uppercase">{{ $kelas->nama_kelas }}</div>
                                <small class="text-muted">ID Kelas: #{{ $kelas->id }}</small>
                            </td>
                            <td>
                                    <span class="badge bg-success-subtle text-success border border-success px-3 text-uppercase">{{ auth()->user()->sekolah->nama_sekolah }}</span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm rounded-circle border me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit{{ $kelas->id }}">
                                        <i class="fas fa-edit text-primary"></i>
                                    </button>
                                    <form action="{{ route('adminsekolah.kelola-kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm rounded-circle border">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit{{ $kelas->id }}" ...> ... </div>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                                    <h6 class="fw-bold text-muted">Belum Ada Data Tingkat Kelas</h6>
                                    <p class="small text-muted mb-0">Klik tombol "Tambah Tingkat Kelas" untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    </div>
</div>

<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Tambah Tingkatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('adminsekolah.kelola-kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
    <div class="mb-3">
        <label class="form-label small fw-bold text-muted">Unit Sekolah</label>
        <input type="hidden" name="sekolah_id" value="{{ Auth::user()->sekolah_id }}">
        
        <div class="d-flex align-items-center bg-light p-2 rounded-3 border">
            <i class="fas fa-university text-primary me-2 ms-1"></i>
            <span class="fw-bold small text-uppercase">
                {{ Auth::user()->sekolah->nama_sekolah}}
            </span>
            <span class="ms-auto badge bg-primary-subtle text-primary" style="font-size: 10px;">Otomatis</span>
        </div>
    </div>
    <div class="mb-0">
        <label class="form-label small fw-bold">Nama Tingkat Kelas</label>
        <input type="text" name="nama_kelas" class="form-control border-2 bg-light rounded-3 shadow-sm" placeholder="Contoh: Kelas 7 atau Kelas X" required>
        <small class="text-muted" style="font-size: 10px;">*Gunakan format angka atau romawi sesuai kebijakan unit.</small>
    </div>
</div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection