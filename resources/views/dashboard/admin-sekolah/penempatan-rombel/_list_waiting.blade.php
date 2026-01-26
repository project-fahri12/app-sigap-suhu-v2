@forelse($siswaBelumPlot as $siswa)
<tr>
    <td class="ps-4">
        <input type="checkbox" value="{{ $siswa->id }}" class="form-check-input siswa-checkbox">
    </td>
    <td>
        <div class="fw-bold small text-dark text-uppercase">{{ $siswa->pendaftar->nama_lengkap }}</div>
        <small class="text-muted" style="font-size: 10px;">{{ $siswa->pendaftar->nisn ?? 'TANPA NISN' }}</small>
    </td>
    <td class="text-center small text-muted fw-bold">{{ $siswa->pendaftar->jenis_kelamin }}</td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center py-5">
        <div class="text-muted small">Data tidak ditemukan.</div>
    </td>
</tr>
@endforelse