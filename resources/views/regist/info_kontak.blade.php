<div class="tab-pane fade" id="tab4">
    <div class="form-section animate__animated animate__fadeIn">

        <h5 class="section-title"><i class="fas fa-address-book me-2"></i>I. Informasi Kontak Person</h5>
        <div class="row g-3 mb-5">
            <div class="col-md-6">
                <label class="form-label">Nomor HP Ayah <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-phone"></i></span>
                    <input type="number" name="no_hp_ayah" 
                        class="form-control @error('no_hp_ayah') is-invalid @enderror" 
                        placeholder="08xxxxxxxxxx" value="{{ old('no_hp_ayah') }}" required>
                    @error('no_hp_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nomor HP Ibu <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-phone"></i></span>
                    <input type="number" name="no_hp_ibu" 
                        class="form-control @error('no_hp_ibu') is-invalid @enderror" 
                        placeholder="08xxxxxxxxxx" value="{{ old('no_hp_ibu') }}" required>
                    @error('no_hp_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nomor HP Wali (Jika Ada)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-phone"></i></span>
                    <input type="number" name="no_hp_wali" 
                        class="form-control @error('no_hp_wali') is-invalid @enderror" 
                        placeholder="08xxxxxxxxxx" value="{{ old('no_hp_wali') }}">
                    @error('no_hp_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nomor WhatsApp Aktif (Notifikasi) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-success text-white"><i class="fab fa-whatsapp"></i></span>
                    <input type="number" name="no_wa" 
                        class="form-control border-success @error('no_wa') is-invalid @enderror"
                        placeholder="08xxxxxxxxxx" value="{{ old('no_wa') }}" required>
                    @error('no_wa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text text-success" style="font-size: 0.75rem;">* Digunakan untuk kirim info kelulusan & jadwal tes.</div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Email Aktif (Orang Tua / Wali) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="nama@email.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <h5 class="section-title"><i class="fas fa-home me-2"></i>II. Detail Domisili Saat Ini</h5>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Alamat Domisili Saat Ini <span class="text-danger">*</span></label>
                <textarea name="domisili_sekarang" class="form-control" rows="3"
                    placeholder="Alamat tinggal sekarang jika berbeda dengan alamat KTP" required>{{ old('domisili_sekarang') }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Domisili <span class="text-danger">*</span></label>
                <div class="mt-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="status_domisili_saat_ini"
                            id="dom1" value="Tetap" {{ old('status_domisili_saat_ini', 'Tetap') == 'Tetap' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="dom1">Milik Sendiri / Tetap</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_domisili_saat_ini"
                            id="dom2" value="Sementara" {{ old('status_domisili_saat_ini') == 'Sementara' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="dom2">Sewa / Sementara</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab3')">
                <i class="fas fa-chevron-left me-2"></i> Kembali
            </button>
            <button type="button" class="btn btn-next px-5 shadow-sm bg-success text-white" onclick="generateReview()">
                Preview Ringkasan <i class="fas fa-eye ms-2"></i>
            </button>
        </div>
    </div>
</div>