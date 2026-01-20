@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Data Pondok Pesantren</h5>
                <p class="small text-muted mb-0">Kelola daftar asrama dan pengasuh pondok terpusat.</p>
            </div>
            <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalPondok"
                onclick="resetForm()">
                <i class="fas fa-plus me-2"></i> Tambah Pondok
            </button>
        </div>

        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-mosque me-3 fs-4"></i>
            <div class="small">
                Data pondok ini akan terhubung dengan unit sekolah untuk penempatan kamar santri.
            </div>
        </div>

        {{-- STATISTIC CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="module-card border-0 shadow-sm p-3 text-center">
                    <small class="text-muted d-block mb-1 fw-bold">Total Pondok</small>
                    <h4 class="fw-800 mb-0">{{ $pondoks->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="module-card border-0 shadow-sm p-3 text-center">
                    <small class="text-muted d-block mb-1 fw-bold text-primary">Putra (L)</small>
                    <h4 class="fw-800 mb-0">{{ $pondoks->where('jenis', 'L')->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="module-card border-0 shadow-sm p-3 text-center border-bottom border-danger">
                    <small class="text-muted d-block mb-1 fw-bold text-danger">Putri (P)</small>
                    <h4 class="fw-800 mb-0">{{ $pondoks->where('jenis', 'P')->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="module-card border-0 shadow-sm p-3 text-center">
                    <small class="text-muted d-block mb-1 fw-bold text-success">Campuran</small>
                    <h4 class="fw-800 mb-0">{{ $pondoks->where('jenis', 'LP')->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="module-card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr style="font-size: 12px; color: #64748b; text-transform: uppercase;">
                            <th class="ps-3">Nama Pondok / Kode</th>
                            <th>Pengasuh</th>
                            <th>Kepemilikan</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px;">
                        @forelse ($pondoks as $p)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">{{ $p->nama_pondok }}</div>
                                    <div style="font-size: 11px;" class="text-muted text-uppercase fw-bold">ID:
                                        {{ $p->kode_pondok }}</div>
                                </td>
                                <td>
                                    <div class="small fw-bold">{{ $p->pengasuh ?? '-' }}</div>
                                </td>
                                <td>
                                    @if ($p->yayasan_mitra == 'Yayasan')
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Milik
                                            Yayasan</span>
                                    @else
                                        <span
                                            class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Mitra
                                            / Luar</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('superadmin.pondok.toggle', $p->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" onchange="this.form.submit()"
                                                {{ $p->is_aktif ? 'checked' : '' }}>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-light btn-sm text-primary me-1"
                                        onclick='editPondok(@json($p))' data-bs-toggle="modal"
                                        data-bs-target="#modalPondok">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('superadmin.pondok.destroy', $p->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-light btn-sm text-danger"
                                            onclick="return confirm('Hapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Data sekolah belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="modalPondok" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0" id="modalTitle">Form Pondok Pesantren</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="pondokForm" method="POST" action="{{ route('superadmin.pondok.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Pondok</label>
                                <input type="text" name="nama_pondok" id="nama_pondok" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Pengasuh</label>
                                <input type="text" name="pengasuh" id="pengasuh" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Kategori Santri</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="jenis" id="jenisL" value="L"
                                    checked>
                                <label class="btn btn-outline-primary flex-grow-1 rounded-3 py-2 fw-bold" for="jenisL">L
                                    (Putra)</label>

                                <input type="radio" class="btn-check" name="jenis" id="jenisP" value="P">
                                <label class="btn btn-outline-danger flex-grow-1 rounded-3 py-2 fw-bold" for="jenisP">P
                                    (Putri)</label>

                                <input type="radio" class="btn-check" name="jenis" id="jenisLP" value="LP">
                                <label class="btn btn-outline-success flex-grow-1 rounded-3 py-2 fw-bold"
                                    for="jenisLP">L/P (Campuran)</label>
                            </div>
                        </div>

                        <div class="mb-2"><label class="form-label small fw-bold text-muted text-uppercase">Status
                                Kepemilikan</label></div>
                        <div class="list-group border-0">
                            <label class="list-group-item d-flex gap-3 py-3 border rounded-4 mb-2 shadow-sm">
                                <input class="form-check-input flex-shrink-0" type="radio" name="yayasan_mitra"
                                    id="milikYayasan" value="Yayasan" checked>
                                <span class="pt-1">
                                    <strong class="d-block text-dark">Milik Yayasan</strong>
                                    <small class="text-muted">Aset dikelola penuh oleh lembaga pusat.</small>
                                </span>
                            </label>
                            <label class="list-group-item d-flex gap-3 py-3 border rounded-4 shadow-sm">
                                <input class="form-check-input flex-shrink-0" type="radio" name="yayasan_mitra"
                                    id="milikMitra" value="Mitra">
                                <span class="pt-1">
                                    <strong class="d-block text-dark">Bukan Milik Yayasan</strong>
                                    <small class="text-muted">Status mitra atau asrama luar/kost santri.</small>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-3">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function resetForm() {
            document.getElementById('pondokForm').reset();
            document.getElementById('pondokForm').action = "{{ route('superadmin.pondok.store') }}";
            document.getElementById('modalTitle').innerText = 'Tambah Pondok';
            const methodInput = document.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
        }

        function editPondok(pondok) {
            resetForm();
            document.getElementById('modalTitle').innerText = 'Edit Pondok';
            document.getElementById('pondokForm').action = `/superadmin/pondok/${pondok.id}`;

            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            document.getElementById('pondokForm').appendChild(method);

            document.getElementById('kode_pondok').value = pondok.kode_pondok;
            document.getElementById('nama_pondok').value = pondok.nama_pondok;
            document.getElementById('pengasuh').value = pondok.pengasuh;

            // Set Radio Jenis
            document.getElementById(`jenis${pondok.jenis}`).checked = true;

            // Set Radio Kepemilikan
            if (pondok.yayasan_mitra === 'Yayasan') {
                document.getElementById('milikYayasan').checked = true;
            } else {
                document.getElementById('milikMitra').checked = true;
            }
        }
    </script>
@endsection
