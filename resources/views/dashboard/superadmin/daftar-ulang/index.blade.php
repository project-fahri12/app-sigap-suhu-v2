@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h4 class="fw-800 text-dark mb-1">Kasir Daftar Ulang</h4>
            <p class="text-muted small mb-0">Manajemen tagihan dan status pembayaran santri secara manual.</p>
        </div>
        <div class="col-md-6 text-end">
            <form action="{{ route('superadmin.daftar-ulang.index') }}" method="GET" class="d-inline-block w-75">
                <div class="input-group shadow-sm rounded-pill overflow-hidden border-0 bg-white">
                    <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 py-2" 
                           placeholder="Cari Nama atau Kode Pendaftaran..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <div>
                        <small class="d-block mb-1 fw-bold opacity-75">Total Kas Masuk</small>
                        <h3 class="fw-800 mb-0 text-white">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-wallet fa-2x opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-success border-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block mb-1 fw-bold">Pendaftar Lunas</small>
                        <h3 class="fw-800 mb-0 text-success">{{ $lunasCount }} <small class="text-muted fs-6">Siswa</small></h3>
                    </div>
                    <i class="fas fa-user-check fa-2x text-light"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold text-uppercase">
                        <th class="ps-4">Data Pendaftar</th>
                        <th>Tagihan</th>
                        <th>Total Bayar</th>
                        <th>Sisa</th>
                        <th>Status Akhir</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftars as $p)
                    @php
                        // Cek keberadaan data di tabel relasi daftarUlang
                        $hasData = $p->daftarUlang && $p->daftarUlang->isNotEmpty();
                        $latest = $hasData ? $p->daftarUlang->last() : null;
                        
                        // Ambil tagihan dari record terakhir, jika belum ada set 0
                        $tagihanSiswa = $latest ? $latest->tagihan : 0;
                        $totalBayarSiswa = $hasData ? $p->daftarUlang->sum('dibayar') : 0;
                        $sisaTagihan = $tagihanSiswa - $totalBayarSiswa;

                        // Nomor WA
                        $noHP = $p->informasiKontak->no_hp_wali ?? '';
                        $noWA = preg_replace('/^0/', '62', $noHP);
                        $waMessage = "Assalamualaikum Wr. Wb. Informasi tagihan daftar ulang ananda *{$p->nama_lengkap}*. Total Tagihan: Rp " . number_format($tagihanSiswa) . ", Telah Dibayar: Rp " . number_format($totalBayarSiswa) . ", Sisa: *Rp " . number_format($sisaTagihan) . "*.";
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark text-uppercase">{{ $p->nama_lengkap }}</div>
                            <small class="text-primary fw-bold">{{ $p->kode_pendaftaran }}</small>
                        </td>
                        <td><span class="text-dark fw-bold">Rp {{ number_format($tagihanSiswa, 0, ',', '.') }}</span></td>
                        <td><span class="text-success fw-bold">Rp {{ number_format($totalBayarSiswa, 0, ',', '.') }}</span></td>
                        <td><span class="text-danger fw-bold">Rp {{ number_format($sisaTagihan < 0 ? 0 : $sisaTagihan, 0, ',', '.') }}</span></td>
                        <td>
                            @if(!$hasData)
                                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger px-3">BELUM INPUT</span>
                            @elseif($latest->status_pembayaran == 'lunas')
                                <span class="badge rounded-pill bg-success text-white px-3">LUNAS</span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning px-3">CICILAN</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm rounded-pill overflow-hidden bg-white border">
                                <button class="btn btn-white btn-sm border-0 px-3" 
                                        data-bs-toggle="modal" data-bs-target="#modalBayar{{ $p->id }}" title="Input Manual">
                                    <i class="fas fa-edit text-primary"></i> Input
                                </button>
                                
                                <a href="https://wa.me/{{ $noWA }}?text={{ urlencode($waMessage) }}" 
                                   target="_blank" class="btn btn-white btn-sm border-0 px-3 border-start" title="Kirim WA">
                                    <i class="fab fa-whatsapp text-success"></i>
                                </a>

                                <button onclick="alert('Mencetak Nota untuk {{ $p->nama_lengkap }}...')" 
                                        class="btn btn-white btn-sm border-0 px-3 border-start" title="Cetak Nota">
                                    <i class="fas fa-print text-muted"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalBayar{{ $p->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 p-4 pb-0">
                                    <h5 class="fw-800 mb-0">Form Kasir Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('superadmin.daftar-ulang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pendaftar_id" value="{{ $p->id }}">
                                    <div class="modal-body p-4">
                                        <div class="mb-3 text-center bg-light p-2 rounded-3">
                                            <span class="small text-muted">Nama Siswa:</span><br>
                                            <span class="fw-bold">{{ $p->nama_lengkap }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">TOTAL TAGIHAN (RP)</label>
                                            <input type="number" name="tagihan" class="form-control border-2 fw-bold" 
                                                   value="{{ $tagihanSiswa }}" required placeholder="Contoh: 5000000">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted text-primary">NOMINAL BAYAR BARU (RP)</label>
                                            <input type="number" name="dibayar" class="form-control border-2 fw-bold text-primary" 
                                                   placeholder="0" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">STATUS PEMBAYARAN</label>
                                            <select name="status_pembayaran" class="form-select border-2 fw-bold">
                                                <option value="cicilan" {{ ($latest->status_pembayaran ?? '') == 'cicilan' ? 'selected' : '' }}>CICILAN</option>
                                                <option value="lunas" {{ ($latest->status_pembayaran ?? '') == 'lunas' ? 'selected' : '' }}>LUNAS</option>
                                            </select>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label small fw-bold text-muted">KETERANGAN</label>
                                            <textarea name="keterangan" class="form-control border-2" rows="2" placeholder="Catatan admin..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow">SIMPAN TRANSAKSI</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            Data pendaftar tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .btn-white { background-color: #fff; color: #64748b; }
    .btn-white:hover { background-color: #f8fafc; color: #000; }
    .table thead th { border: none; padding: 15px; font-size: 11px; letter-spacing: 0.05rem; color: #94a3b8; }
    .table tbody td { padding: 18px 15px; border-color: #f1f5f9; }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection