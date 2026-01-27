@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-800 mb-1">Master Gelombang PPDB</h5>
            <p class="small text-muted mb-0">Kelola kuota dan masa pendaftaran siswa baru.</p>
        </div>
        <button class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded-pill" data-bs-toggle="modal"
            data-bs-target="#modalTambahGelombang">
            <i class="fas fa-plus me-2"></i>Tambah Gelombang
        </button>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-sm border-0 bg-white" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="bg-light">
                    <tr style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                        <th class="ps-4 py-3">Gelombang</th>
                        <th>TA</th>
                        <th>Periode</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px;">
                    @forelse($gelombangs as $g)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-800 text-dark">{{ $g->nama_gelombang }}</div>
                            </td>
                            <td>{{ $g->tahunAjaran->nama ?? '-' }}</td>
                            <td>
                                <small class="text-muted d-block">
                                    <i class="far fa-calendar-check me-1"></i>
                                    {{ \Carbon\Carbon::parse($g->tanggal_buka)->format('d M Y') }}
                                </small>
                                <small class="text-muted d-block">
                                    <i class="far fa-calendar-times me-1"></i>
                                    {{ \Carbon\Carbon::parse($g->tanggal_tutup)->format('d M Y') }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info px-3">{{ $g->kuota }} Kursi</span>
                            </td>
                            <td>
                                @if($g->is_aktif)
                                    <span class="badge bg-success px-3 py-1 rounded-pill">Aktif</span>
                                @else
                                    <span class="badge bg-light text-muted px-3 py-1 rounded-pill border">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                {{-- Tombol Edit --}}
                                <button class="btn btn-light btn-sm text-primary rounded-3 me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $g->id }}" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- Form & Tombol Hapus --}}
                                <form id="delete-form-{{ $g->id }}" 
                                      action="{{ route('adminsekolah.gelombang-ppdb.destroy', $g->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-light btn-sm text-danger rounded-3" 
                                        onclick="confirmDelete('delete-form-{{ $g->id }}')" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDIT (Per Baris) --}}
                        <div class="modal fade" id="modalEdit{{ $g->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-header border-0 p-4 pb-0">
                                        <h5 class="fw-800 mb-0">Edit Gelombang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('adminsekolah.gelombang-ppdb.update', $g->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">TAHUN AJARAN</label>
                                                <select name="tahun_ajaran_id" class="form-select shadow-none" required>
                                                    @foreach($tahunAjarans as $ta)
                                                        <option value="{{ $ta->id }}" {{ $g->tahun_ajaran_id == $ta->id ? 'selected' : '' }}>
                                                            {{ $ta->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">NAMA GELOMBANG</label>
                                                <input type="text" name="nama_gelombang" class="form-control shadow-none" value="{{ $g->nama_gelombang }}" required>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted">TGL BUKA</label>
                                                    <input type="date" name="tanggal_buka" class="form-control shadow-none" value="{{ $g->tanggal_buka }}" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted">TGL TUTUP</label>
                                                    <input type="date" name="tanggal_tutup" class="form-control shadow-none" value="{{ $g->tanggal_tutup }}" required>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted">KUOTA</label>
                                                    <input type="number" name="kuota" class="form-control shadow-none" value="{{ $g->kuota }}" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted">STATUS</label>
                                                    <select name="is_aktif" class="form-select shadow-none">
                                                        <option value="1" {{ $g->is_aktif ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ !$g->is_aktif ? 'selected' : '' }}>Non-Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-grid mt-4">
                                                <button type="submit" class="btn btn-primary fw-800 py-3 rounded-4 shadow-sm">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-2 fa-2x opacity-25"></i>
                                Belum ada data gelombang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahGelombang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Tambah Gelombang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('adminsekolah.gelombang-ppdb.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TAHUN AJARAN</label>
                        <select name="tahun_ajaran_id" class="form-select shadow-none" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA GELOMBANG</label>
                        <input type="text" name="nama_gelombang" class="form-control shadow-none" placeholder="Contoh: Gelombang I" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">TGL BUKA</label>
                            <input type="date" name="tanggal_buka" class="form-control shadow-none" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">TGL TUTUP</label>
                            <input type="date" name="tanggal_tutup" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">KUOTA</label>
                            <input type="number" name="kuota" class="form-control shadow-none" placeholder="0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">AKTIFKAN?</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_aktif" value="1" id="switchAktif" checked>
                                <label class="form-check-label" for="switchAktif">Ya, Aktifkan</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success fw-800 py-3 rounded-4 shadow">Simpan Gelombang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection