@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-primary">Pilih Unit Pendidikan & Asrama</h5>
            </div>
            
            {{-- Form diarahkan ke method STORE milik resource --}}
            <form action="{{ route('pendaftar.pilih-sekolah-pondok.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    {{-- SEKSI SEKOLAH --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark border-start border-4 border-success ps-2 mb-3">1. PILIHAN SEKOLAH</h6>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">Pilih</th>
                                        <th>Nama Sekolah</th>
                                        <th>Jenjang</th>
                                        <th>Gelombang Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pilihan_sekolah as $gel)
                                    <tr>
                                        <td class="text-center">
                                            <input type="radio" name="gelombang_id" value="{{ $gel->id }}" {{ $pendaftar->gelombang_id == $gel->id ? 'checked' : '' }} required>
                                        </td>
                                        <td class="fw-bold">{{ $gel->sekolah->nama_sekolah }}</td>
                                        <td>{{ $gel->sekolah->jenjang }}</td>
                                        <td><span class="badge bg-soft-primary text-primary border border-primary">{{ $gel->nama_gelombang }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- SEKSI PONDOK --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark border-start border-4 border-primary ps-2 mb-3">2. PILIHAN PONDOK (Khusus {{ $pendaftar->jenis_kelamin == 'L' ? 'Putra' : 'Putri' }})</h6>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">Pilih</th>
                                        <th>Nama Pondok</th>
                                        <th>Yayasan / Mitra</th>
                                        <th>Pengasuh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pilihan_pondok as $pondok)
                                    <tr>
                                        <td class="text-center">
                                            <input type="radio" name="pondok_id" value="{{ $pondok->id }}" {{ $pendaftar->pondok_id == $pondok->id ? 'checked' : '' }}>
                                        </td>
                                        <td class="fw-bold">{{ $pondok->nama_pondok }}</td>
                                        <td><small>{{ $pondok->yayasan_mitra ?? '-' }}</small></td>
                                        <td>{{ $pondok->pengasuh ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">Pilihan pondok tidak tersedia untuk kategori ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white text-end py-3">
                    <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> SIMPAN PILIHAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling sederhana agar responsive di mobile */
    @media (max-width: 768px) {
        .table { font-size: 0.85rem; }
        .btn { width: 100%; }
        .card-header h5 { font-size: 1rem; }
    }
    /* Warna badge lembut */
    .bg-soft-primary { background-color: #eef2ff; }
</style>
@endsection