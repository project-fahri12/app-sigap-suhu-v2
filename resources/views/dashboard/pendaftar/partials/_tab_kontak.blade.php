<div class="p-4 tab-pane fade" id="tab-4" role="tabpanel">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="text-xs fw-bold text-success">WHATSAPP AKTIF (NOTIFIKASI AKAN DIKIRIM KE SINI)</label>
            <div class="input-group">
                <span class="input-group-text bg-success text-white border-success small">62</span>
                <input type="number" name="no_wa" class="form-control border-success" placeholder="812345..." value="{{ old('no_wa', $pendaftar->informasiKontak->no_wa ?? '') }}">
            </div>
        </div>
        <div class="col-md-6">
            <label class="text-xs fw-bold">EMAIL</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $pendaftar->informasiKontak->email ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="text-xs fw-bold">NOMOR HP AYAH</label>
            <input type="number" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah', $pendaftar->informasiKontak->no_hp_ayah ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="text-xs fw-bold">NOMOR HP IBU</label>
            <input type="number" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu', $pendaftar->informasiKontak->no_hp_ibu ?? '') }}">
        </div>
    </div>
</div>