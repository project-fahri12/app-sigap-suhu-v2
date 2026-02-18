@forelse ($pendaftar as $p)
<tr>
    <td class="ps-4">
        <div class="fw-bold text-dark text-xs text-uppercase">{{ $p->nama_lengkap }}</div>
        <div class="text-muted" style="font-size: 10px;">{{ $p->kode_pendaftaran }}</div>
    </td>
    <td>
        <div class="text-xs">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->no_wa) }}" target="_blank" class="text-success fw-bold text-decoration-none">
                <i class="fab fa-whatsapp me-1"></i>{{ $p->no_wa }}
            </a>
        </div>
    </td>
    <td>
        <span class="text-xs">{{ $p->pondok->nama_pondok ?? 'Laju' }}</span>
    </td>
    <td>
        {{-- Logika Status Pembayaran dari Tabel Relasi --}}
        @if(!$p->daftarUlang)
            <span class="badge bg-secondary rounded-pill" style="font-size: 9px;">BELUM ADA TAGIHAN</span>
        @elseif($p->daftarUlang->status_pembayaran == 'lunas')
            <span class="badge bg-success rounded-pill" style="font-size: 9px;">LUNAS</span>
        @else
            <span class="badge bg-danger rounded-pill" style="font-size: 9px;">BELUM BAYAR</span>
        @endif
    </td>
    <td class="pe-4 text-center">
        <div class="dropdown">
            <button class="btn btn-light btn-sm border dropdown-toggle text-xs" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                AKSI
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 text-xs">
                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-eye me-2"></i>Detail</a></li>
                @if(!$p->daftarUlang)
                    <li><a class="dropdown-item py-2 text-primary" href="#"><i class="fas fa-plus me-2"></i>Buat Tagihan</a></li>
                @endif
                <li><a class="dropdown-item py-2 text-success" href="#"><i class="fas fa-check me-2"></i>Terima Siswa</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fas fa-trash me-2"></i>Hapus</a></li>
            </ul>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-4 text-muted text-xs">Data pendaftar tidak ditemukan</td>
</tr>
@endforelse