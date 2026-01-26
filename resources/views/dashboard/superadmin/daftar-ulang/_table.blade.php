@forelse($pendaftars as $p)
    @php
        // 1. Logika Kalkulasi Keuangan
        $totalBayarSiswa = $p->total_dibayar ?? 0;
        $latest = $p->daftarUlang->last();
        $tagihanSiswa = $latest ? $latest->tagihan : $totalTagihanPerSiswa;
        $sisaTagihan = $tagihanSiswa - $totalBayarSiswa;

        // 2. Logika WhatsApp
        $noHP = $p->informasiKontak->no_hp_wali ?? '';
        $noWA = preg_replace('/^0/', '62', $noHP);
        $waMessage = "Assalamualaikum, Bapak/Ibu Wali dari *{$p->nama_lengkap}*.\n\nInformasi tagihan daftar ulang:\n- Total Tagihan: Rp " . number_format($tagihanSiswa, 0, ',', '.') . "\n- Terbayar: Rp " . number_format($totalBayarSiswa, 0, ',', '.') . "\n- Sisa Tagihan: *Rp " . number_format($sisaTagihan < 0 ? 0 : $sisaTagihan, 0, ',', '.') . "*\n\nTerima kasih.";
    @endphp

    <tr>
        <td class="text-center fw-bold text-muted" style="width: 50px;">
            {{ ($pendaftars->currentPage() - 1) * $pendaftars->perPage() + $loop->iteration }}
        </td>

        <td class="ps-4">
            <div class="fw-800 text-dark text-uppercase mb-0" style="font-size: 0.95rem;">{{ $p->nama_lengkap }}</div>
            <code class="text-primary fw-bold" style="font-size: 0.75rem;">{{ $p->kode_pendaftaran }}</code>
        </td>

        <td>
            <span class="text-dark fw-bold">Rp {{ number_format($tagihanSiswa, 0, ',', '.') }}</span>
        </td>

        <td>
            <span class="text-success fw-bold">Rp {{ number_format($totalBayarSiswa, 0, ',', '.') }}</span>
        </td>

        <td>
            @if ($sisaTagihan > 0)
                <span class="text-danger fw-bold">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span>
            @else
                <span class="badge bg-success-subtle text-success border border-success px-2 rounded-pill">LUNAS</span>
            @endif
        </td>

        <td>
            @if ($totalBayarSiswa <= 0)
                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger px-3">BELUM INPUT</span>
            @elseif($totalBayarSiswa >= $tagihanSiswa)
                <span class="badge rounded-pill bg-success text-white px-3 shadow-sm">LUNAS</span>
            @else
                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning px-3">CICILAN</span>
            @endif
        </td>

        <td class="text-end pe-4">
            <div class="btn-group shadow-sm rounded-pill overflow-hidden bg-white border">
                <button class="btn btn-white btn-sm px-3 border-0" 
                    title="Input Pembayaran"
                    {{ $totalBayarSiswa >= $tagihanSiswa ? 'disabled' : '' }}
                    data-bs-toggle="modal" data-bs-target="#modalBayar{{ $p->id }}">
                    <i class="fas fa-money-bill-wave text-primary"></i>
                </button>

                <a href="https://wa.me/{{ $noWA }}?text={{ urlencode($waMessage) }}" 
                    target="_blank" 
                    class="btn btn-white btn-sm px-3 border-start border-0" 
                    title="Kirim Tagihan WA">
                    <i class="fab fa-whatsapp text-success"></i>
                </a>

                <button onclick="window.print()" 
                    class="btn btn-white btn-sm px-3 border-start border-0" 
                    title="Cetak Bukti">
                    <i class="fas fa-print text-muted"></i>
                </button>
            </div>
        </td>
    </tr>

    <div class="modal fade" id="modalBayar{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-800 mb-0">Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.daftar-ulang.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pendaftar_id" value="{{ $p->id }}">
                    <div class="modal-body p-4">
                        <div class="p-3 mb-4 rounded-4 bg-light text-center">
                            <small class="text-muted d-block text-uppercase fw-bold">Nama Pendaftar</small>
                            <span class="h6 fw-800 text-dark">{{ $p->nama_lengkap }}</span>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">SET TOTAL TAGIHAN</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-2">Rp</span>
                                    <input type="number" name="tagihan" class="form-control border-2 fw-bold" value="{{ $tagihanSiswa }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-primary">NOMINAL BAYAR SEKARANG</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary border-primary text-white">Rp</span>
                                    <input type="number" name="dibayar" class="form-control border-primary border-2 fw-800 text-primary" placeholder="0" required autofocus>
                                </div>
                                <small class="text-muted italic">Sisa sebelumnya: Rp {{ number_format($sisaTagihan) }}</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">CATATAN / KETERANGAN</label>
                                <textarea name="keterangan" class="form-control border-2" rows="2" placeholder="Contoh: Pembayaran Tahap 1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> SIMPAN TRANSAKSI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@empty
    <tr>
        <td colspan="7" class="text-center py-5">
            <div class="text-muted">
                <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                <p class="mb-0">Tidak ada data pendaftar ditemukan.</p>
            </div>
        </td>
    </tr>
@endforelse

@if($pendaftars->hasPages() || $pendaftars->total() > 0)
<tr>
    <td colspan="7" class="px-4 py-3 bg-light">
        <div class="d-flex justify-content-between align-items-center ajax-pagination">
            <div class="small text-muted fw-bold">
                Menampilkan <span class="text-dark">{{ $pendaftars->firstItem() ?? 0 }}</span> - 
                <span class="text-dark">{{ $pendaftars->lastItem() ?? 0 }}</span> dari 
                <span class="text-dark">{{ $pendaftars->total() }}</span> siswa
            </div>
            <div>
                {{ $pendaftars->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </td>
</tr>
@endif