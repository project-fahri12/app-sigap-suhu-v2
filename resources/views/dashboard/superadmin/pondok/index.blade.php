@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Data Pondok Pesantren</h5>
                <p class="small text-muted mb-0">Kelola daftar asrama dan pengasuh pondok terpusat.</p>
            </div>
            <button class="btn btn-success fw-bold px-4 rounded-pill shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalPondok" onclick="resetForm()">
                <i class="fas fa-plus me-2"></i> Tambah Pondok
            </button>
        </div>

        {{-- Info Alert --}}
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
            <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="small">
                <strong>Informasi:</strong> Data pondok ini akan terhubung dengan unit sekolah untuk sistem penempatan kamar
                santri otomatis.
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center border-bottom border-primary border-3">
                    <small class="text-muted d-block mb-1 fw-bold uppercase" style="font-size: 10px;">Total Pondok</small>
                    <h4 class="fw-bold mb-0">{{ $pondoks->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-primary d-block mb-1 fw-bold uppercase" style="font-size: 10px;">Putra (L)</small>
                    <h4 class="fw-bold mb-0">{{ $pondoks->where('jenis', 'L')->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-danger d-block mb-1 fw-bold uppercase" style="font-size: 10px;">Putri (P)</small>
                    <h4 class="fw-bold mb-0">{{ $pondoks->where('jenis', 'P')->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-success d-block mb-1 fw-bold uppercase" style="font-size: 10px;">Campuran
                        (L/P)</small>
                    <h4 class="fw-bold mb-0">{{ $pondoks->where('jenis', 'LP')->count() }}</h4>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light">
                        <tr style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                            <th class="ps-4 py-3">Nama Pondok / Kode</th>
                            <th>Pengasuh</th>
                            <th>Kepemilikan</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        @forelse ($pondoks as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $p->nama_pondok }}</div>
                                    <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">ID:
                                        {{ $p->kode_pondok }}</div>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-secondary">{{ $p->pengasuh ?? '-' }}</div>
                                </td>
                                <td>
                                    @if ($p->yayasan_mitra == 'Yayasan')
                                        <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill small">Milik
                                            Yayasan</span>
                                    @else
                                        <span class="badge bg-soft-warning text-warning px-3 py-2 rounded-pill small">Mitra
                                            / Luar</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('superadmin.pondok.toggle', $p->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input custom-switch" type="checkbox"
                                                onchange="this.form.submit()" {{ $p->is_aktif ? 'checked' : '' }}>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-light btn-sm text-primary rounded-3 me-1"
                                        onclick='editPondok(@json($p))' data-bs-toggle="modal"
                                        data-bs-target="#modalPondok">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form id="delete-form-{{ $p->id }}"
                                        action="{{ route('superadmin.pondok.destroy', $p->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-light btn-sm text-danger rounded-3"
                                            onclick="confirmDelete('delete-form-{{ $p->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada data pondok pesantren.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- UNIFIED MODAL (TAMBAH & EDIT) --}}
    <div class="modal fade" id="modalPondok" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0" id="modalTitle">Form Pondok Pesantren</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="pondokForm" method="POST" action="{{ route('superadmin.pondok.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Kode Pondok</label>
                                <input type="text" name="kode_pondok" id="kode_pondok" class="form-control rounded-3"
                                    placeholder="P01" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Pondok</label>
                                <input type="text" name="nama_pondok" id="nama_pondok" class="form-control rounded-3"
                                    placeholder="Nama Asrama" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Pengasuh /
                                    Kyai</label>
                                <input type="text" name="pengasuh" id="pengasuh" class="form-control rounded-3"
                                    placeholder="Contoh: KH. Ahmad ...">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-3">Kategori Santri</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="jenis" id="jenisL" value="L"
                                    checked>
                                <label class="btn btn-outline-primary flex-grow-1 rounded-3 py-2 fw-bold"
                                    for="jenisL">Putra (L)</label>

                                <input type="radio" class="btn-check" name="jenis" id="jenisP" value="P">
                                <label class="btn btn-outline-danger flex-grow-1 rounded-3 py-2 fw-bold"
                                    for="jenisP">Putri (P)</label>

                                <input type="radio" class="btn-check" name="jenis" id="jenisLP" value="LP">
                                <label class="btn btn-outline-success flex-grow-1 rounded-3 py-2 fw-bold"
                                    for="jenisLP">L/P</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Status
                                Kepemilikan</label>
                            <div class="list-group border-0">
                                <label
                                    class="list-group-item d-flex gap-3 py-3 border rounded-4 mb-2 cursor-pointer shadow-xs">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="yayasan_mitra"
                                        id="milikYayasan" value="Yayasan" checked>
                                    <span class="pt-1">
                                        <strong class="d-block text-dark small">Milik Yayasan</strong>
                                        <small class="text-muted" style="font-size: 11px;">Aset utama dan dikelola
                                            pusat.</small>
                                    </span>
                                </label>
                                <label class="list-group-item d-flex gap-3 py-3 border rounded-4 cursor-pointer shadow-xs">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="yayasan_mitra"
                                        id="milikMitra" value="Mitra">
                                    <span class="pt-1">
                                        <strong class="d-block text-dark small">Mitra / Asrama Luar</strong>
                                        <small class="text-muted" style="font-size: 11px;">Asrama rekanan atau kost
                                            santri.</small>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-success w-100 fw-bold py-3 rounded-4 shadow-sm">Simpan Data
                            Pondok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .bg-soft-success {
            background-color: #e8f5e9;
        }

        .bg-soft-warning {
            background-color: #fff8e1;
        }

        .custom-switch {
            width: 40px !important;
            height: 20px !important;
            cursor: pointer;
        }

        .shadow-xs {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .03);
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    @push('js')
        <script>
            /**
             * Reset modal ke kondisi "Tambah"
             */
            function resetForm() {
                const form = document.getElementById('pondokForm');
                form.reset();

                // Kembalikan action ke route STORE
                form.action = "{{ route('superadmin.pondok.store') }}";
                document.getElementById('modalTitle').innerText = 'Tambah Pondok Baru';

                // Hapus input _method PUT jika ada agar kembali menjadi POST
                const existingMethod = form.querySelector('input[name="_method"]');
                if (existingMethod) existingMethod.remove();
            }

            /**
             * Set modal ke kondisi "Edit" dan isi data
             */
            function editPondok(pondok) {
                resetForm(); // Bersihkan form & kembalikan ke default STORE dulu

                const form = document.getElementById('pondokForm');
                document.getElementById('modalTitle').innerText = 'Edit Pondok: ' + pondok.nama_pondok;

                // PERBAIKAN: Gunakan URL yang sesuai dengan route 'superadmin.pondok.update'
                // Kita ganti ID secara dinamis di dalam string URL
                let updateUrl = "{{ route('superadmin.pondok.update', ':id') }}";
                form.action = updateUrl.replace(':id', pondok.id);

                // Tambahkan input hidden _method="PUT" karena rute update menggunakan PUT/PATCH
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);

                // Map data ke field input
                document.getElementById('kode_pondok').value = pondok.kode_pondok;
                document.getElementById('nama_pondok').value = pondok.nama_pondok;
                document.getElementById('pengasuh').value = pondok.pengasuh || '';

                // Pilih Radio Kategori (L/P/LP)
                const jenisTarget = document.getElementById(`jenis${pondok.jenis}`);
                if (jenisTarget) jenisTarget.checked = true;

                // Pilih Radio Kepemilikan
                if (pondok.yayasan_mitra === 'Yayasan') {
                    document.getElementById('milikYayasan').checked = true;
                } else {
                    document.getElementById('milikMitra').checked = true;
                }
            }
        </script>
    @endpush
@endsection
