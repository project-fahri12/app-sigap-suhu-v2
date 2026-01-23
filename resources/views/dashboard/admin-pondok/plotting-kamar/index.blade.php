@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Plotting Kamar Santri</h4>
                <p class="text-muted small mb-0">Kelola penempatan santri ke dalam kamar (Romkam).</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalPlotting">
                    <i class="fas fa-user-plus me-2"></i>Plotting Baru
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-primary border-0 rounded-4 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold">NAMA SANTRI</th>
                                <th class="py-3 text-muted small fw-bold">KAMAR (ROMKAM)</th>
                                <th class="py-3 text-muted small fw-bold">GEDUNG</th>
                                <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                                <th class="py-3 text-muted small fw-bold text-end pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plottings as $s)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $s->nama }}</div>
                                    <small class="text-muted">NIS: {{ $s->nis ?? '-' }}</small>
                                </td>
                                <td><div class="fw-bold text-primary">{{ $s->romkam->nama_romkam }}</div></td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="fas fa-building me-1"></i> {{ $s->romkam->asrama->nama_asrama ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                        {{ $s->status_santri ?? 'Mukim' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group border rounded-pill overflow-hidden bg-white shadow-sm">
                                        <button class="btn btn-white btn-sm border-0 py-2 px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}">
                                            <i class="fas fa-exchange-alt text-warning"></i>
                                        </button>
                                        <form action="{{ route('adminpondok.plotting-kamar.destroy', $s->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm border-0 py-2 px-3" onclick="return confirm('Keluarkan santri dari kamar ini?')">
                                                <i class="fas fa-sign-out-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4">
                                        <form action="{{ route('adminpondok.plotting-kamar.update', $s->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header border-0 pt-4 px-4">
                                                <h5 class="fw-bold mb-0">Pindah Kamar</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="p-3 bg-light rounded-3 mb-4 text-center">
                                                    <small class="text-muted d-block">Nama Santri:</small>
                                                    <span class="fw-bold">{{ $s->nama }}</span>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label small fw-bold text-muted">PILIH KAMAR BARU</label>
                                                    <select name="romkam_id" class="form-select rounded-3 border-0 bg-light py-2">
                                                        @foreach($romkams as $rk)
                                                            <option value="{{ $rk->id }}" {{ $s->romkam_id == $rk->id ? 'selected' : '' }}>
                                                                {{ $rk->nama_romkam }} ({{ $rk->asrama->nama_asrama }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">Simpan Perpindahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted small">Belum ada santri yang diplot ke kamar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $plottings->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPlotting" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <form action="{{ route('adminpondok.plotting-kamar.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Plotting Santri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">CARI SANTRI</label>
                        <select name="santri_id" class="form-select rounded-3 bg-light border-0 py-2" required>
                            <option value="" selected disabled>Pilih Santri...</option>
                            @foreach($santriBelumPlot as $sbp)
                                <option value="{{ $sbp->id }}">{{ $sbp->pendaftar->nama_lengkap }} (NIS: {{ $sbp->nis ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                        <small style="font-size: 10px;" class="text-muted mt-1">*Hanya menampilkan santri yang belum punya kamar.</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">PILIH KAMAR (ROMKAM)</label>
                        <select name="romkam_id" class="form-select rounded-3 bg-light border-0 py-2" required>
                            <option value="" selected disabled>Pilih Kamar...</option>
                            @foreach($romkams as $rk)
                                <option value="{{ $rk->id }}">{{ $rk->nama_romkam }} - {{ $rk->asrama->nama_asrama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">Simpan Penempatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .btn-white { background: #fff; border: 1px solid #eee; }
    .table thead th { 
        background-color: #f8f9fa !important; 
        border: none; 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 0.5px; 
    }
    .form-select:focus { box-shadow: none; border: 1px solid #0d6efd; }
</style>
@endsection