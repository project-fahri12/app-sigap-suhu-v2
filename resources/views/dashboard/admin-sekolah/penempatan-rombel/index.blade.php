@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Plotting Rombongan Belajar</h4>
            <p class="text-muted small">Kelola penempatan siswa ke dalam kelas/rombel yang sesuai.</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('adminsekolah.penempatan-rombel.index') }}" class="btn btn-light rounded-pill px-3 border me-2">
                <i class="fas fa-sync"></i> Refresh
            </a>
        </div>
    </div>

    <form action="{{ route('adminsekolah.penempatan-rombel.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 p-4">
                        <h6 class="fw-bold mb-3">Siswa Belum Ada Rombel</h6>
                        <div class="row g-2">
                            <div class="col-7">
                                <input type="text" name="search" class="form-control form-control-sm rounded-pill bg-light border-0" placeholder="Cari nama..." value="{{ request('search') }}">
                            </div>
                            <div class="col-5">
                                <select name="gender" class="form-select form-select-sm rounded-pill bg-light border-0" onchange="this.form.method='GET'; this.form.submit();">
                                    <option value="">Semua (L/P)</option>
                                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-subtle px-4 py-2 border-top border-bottom d-flex justify-content-between">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label small fw-bold" for="selectAll">Pilih Semua</label>
                        </div>
                        <small class="text-primary fw-bold">{{ $siswaBelumPlot->count() }} Tersedia</small>
                    </div>

                    <div class="card-body p-0 scrollable-list" style="max-height: 500px; overflow-y: auto;">
                        @forelse($siswaBelumPlot as $s)
                        <label class="p-3 border-bottom d-flex align-items-center list-item-siswa w-100 mb-0 pointer">
                            <div class="form-check me-3">
                                <input class="form-check-input check-siswa" type="checkbox" name="siswa_ids[]" value="{{ $s->id }}">
                            </div>
                            <div class="avatar-sm me-3 bg-white border text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                {{ strtoupper(substr($s->pendaftar->nama_lengkap, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small">{{ strtoupper($s->pendaftar->nama_lengkap) }}</div>
                                <div class="d-flex gap-2">
                                    <span class="text-muted" style="font-size: 10px;"><i class="fas fa-id-card me-1"></i>{{ $s->nis ?? 'NIS Belum Ada' }}</span>
                                    <span class="badge {{ $s->pendaftar->jenis_kelamin == 'L' ? 'bg-info' : 'bg-danger' }}" style="font-size: 8px;">{{ $s->pendaftar->jenis_kelamin }}</span>
                                </div>
                            </div>
                        </label>
                        @empty
                        <div class="p-5 text-center">
                            <i class="fas fa-user-check fa-3x text-light mb-3"></i>
                            <p class="text-muted small">Tidak ada siswa yang perlu diplot.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-1 d-none d-md-flex flex-column align-items-center justify-content-center">
                <button type="submit" class="btn btn-primary shadow rounded-circle p-3 mb-2" title="Masukkan ke Rombel">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label small fw-bold">Rombel Tujuan</label>
                        <select name="rombel_id" class="form-select border-2 py-2 fw-bold" required onchange="location.href='?rombel_id='+this.value">
                            <option value="">-- Pilih Rombel Tujuan --</option>
                            @foreach($listRombel as $r)
                                <option value="{{ $r->id }}" {{ request('rombel_id') == $r->id ? 'selected' : '' }}>
                                    [{{ $r->kelas->nama_kelas }}] {{ $r->nama_rombel }} (Kapasitas: {{ $r->kapasitas }})
                                </option>
                            @endforeach
                        </select>

                        @if($rombelTerpilih)
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1">
                                <span>Okupansi</span>
                                <span>{{ $anggotaRombel->count() }} / {{ $rombelTerpilih->kapasitas }} Siswa</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                @php $persen = ($anggotaRombel->count() / $rombelTerpilih->kapasitas) * 100; @endphp
                                <div class="progress-bar {{ $persen >= 100 ? 'bg-danger' : 'bg-success' }}" style="width: {{ $persen }}%"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @if($rombelTerpilih)
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3 px-4">
                        <h6 class="fw-bold mb-0">Anggota: {{ $rombelTerpilih->nama_rombel }}</h6>
                    </div>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small fw-bold">
                                    <th class="ps-4">No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggotaRombel as $index => $ag)
                                <tr>
                                    <td class="ps-4 small text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold small text-dark">{{ $ag->pendaftar->nama_lengkap }}</div>
                                        <small class="text-muted" style="font-size: 9px;">Gender: {{ $ag->pendaftar->jenis_kelamin }}</small>
                                    </td>
                                    <td><code class="text-primary">{{ $ag->nis ?? '-' }}</code></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link text-danger p-0" onclick="confirmDelete('{{ $ag->id }}')">
                                            <i class="fas fa-times-circle fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">Belum ada anggota di rombel ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>

<form id="form-delete" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    document.getElementById('selectAll').onclick = function() {
        var checkboxes = document.getElementsByName('siswa_ids[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    function confirmDelete(id) {
        if(confirm('Keluarkan siswa ini dari rombel?')) {
            let form = document.getElementById('form-delete');
            form.action = '/admin-sekolah/penempatan-rombel/' + id;
            form.submit();
        }
    }
</script>

<style>
    .fw-800 { font-weight: 800; }
    .avatar-sm { width: 35px; height: 35px; font-size: 12px; }
    .list-item-siswa:hover { background-color: #f8fafc; }
    .pointer { cursor: pointer; }
    .scrollable-list::-webkit-scrollbar { width: 4px; }
    .scrollable-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
@endsection