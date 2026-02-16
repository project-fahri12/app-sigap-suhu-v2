<div class=" p-4 tab-pane fade" id="tab-3" role="tabpanel">
    <div class="alert alert-info py-2 text-xs">
        <i class="fas fa-info-circle me-1"></i> Kosongkan jika wali adalah orang tua kandung.
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="text-xs fw-bold">NAMA WALI</label>
            <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $pendaftar->wali->nama_wali ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="text-xs fw-bold">HUBUNGAN DENGAN SANTRI</label>
            <input type="text" name="hubungan" class="form-control" placeholder="Cth: Paman, Kakek, Kakak" value="{{ old('hubungan', $pendaftar->wali->hubungan ?? '') }}">
        </div>
        <div class="col-md-12">
            <label class="text-xs fw-bold">NIK WALI (JIKA ADA)</label>
            <input type="number" name="nik_wali" class="form-control" value="{{ old('nik_wali', $pendaftar->wali->nik_wali ?? '') }}">
        </div>
        <div class="col-12">
            <label class="text-xs fw-bold">ALAMAT LENGKAP WALI</label>
            <textarea name="alamat_lengkap_wali" class="form-control" rows="2">{{ old('alamat_lengkap_wali', $pendaftar->wali->alamat_lengkap ?? '') }}</textarea>
        </div>
    </div>
</div>