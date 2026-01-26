<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 500px;">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light sticky-top">
                    <tr>
                        <th class="ps-4 py-3" width="50">
                            <input type="checkbox" class="form-check-input border-success check-all" id="checkAll{{ $gender }}">
                        </th>
                        <th class="py-3 text-muted small">NAMA SANTRI</th>
                        <th class="py-3 text-muted small text-center">JK</th>
                        <th class="py-3 text-muted small">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $sb)
                    <tr>
                        <td class="ps-4">
                            <input type="checkbox" name="santri_ids[]" value="{{ $sb->id }}" class="form-check-input border-success check-item">
                        </td>
                        <td>
                            <div class="fw-bold text-dark small">{{ $sb->pendaftar->nama_lengkap }}</div>
                            <div style="font-size: 10px;" class="text-muted">NIS: {{ $sb->nis ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $sb->pendaftar->jenis_kelamin == 'L' ? 'bg-info-subtle text-info' : 'bg-danger-subtle text-danger' }} rounded-pill px-2">
                                {{ $sb->pendaftar->jenis_kelamin }}
                            </span>
                        </td>
                        <td><span class="badge bg-warning-subtle text-warning small">Belum Plotting</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">Tidak ada antrian santri.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>