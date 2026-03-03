<div class="p-4 tab-pane fade show active" id="tab-1" role="tabpanel">
    <div class="row g-3">
        <h6 class="fw-bold text-success mt-3 small"><i class="fas fa-user-graduate me-2"></i>I. IDENTITAS PRIBADI</h6>
        
        <div class="col-md-12">
            <label class="text-xs fw-bold">NAMA LENGKAP</label>
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $pendaftar->nama_lengkap) }}" placeholder="Sesuai Ijazah">
            @error('nama_lengkap') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">NIK (16 DIGIT)</label>
            <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $pendaftar->nik) }}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="16">
            @error('nik') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">NISN (10 DIGIT)</label>
            <input type="number" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $pendaftar->nisn) }}" readonly>
            <small class="text-muted text-xs">NISN dikunci otomatis</small>
            @error('nisn') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">NOMOR KK</label>
            <input type="number" name="nomor_kk" class="form-control @error('nomor_kk') is-invalid @enderror" value="{{ old('nomor_kk', $pendaftar->nomor_kk) }}"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="16">
            @error('nomor_kk') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">TEMPAT LAHIR</label>
            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $pendaftar->tempat_lahir) }}">
            @error('tempat_lahir') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">TANGGAL LAHIR</label>
            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $pendaftar->tanggal_lahir) }}">
            @error('tanggal_lahir') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">JENIS KELAMIN</label>
            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                <option value="">-- Pilih --</option>
                <option value="L" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">ANAK KE</label>
            <input type="number" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror" value="{{ old('anak_ke', $pendaftar->anak_ke) }}">
            @error('anak_ke') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">JUMLAH SAUDARA</label>
            <input type="number" name="jumlah_saudara" class="form-control @error('jumlah_saudara') is-invalid @enderror" value="{{ old('jumlah_saudara', $pendaftar->jumlah_saudara) }}">
            @error('jumlah_saudara') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">DOMISILI SANTRI</label>
            <select name="domisili_santri" class="form-select @error('domisili_santri') is-invalid @enderror">
                <option value="">-- Pilih --</option>
                <option value="Asrama" {{ old('domisili_santri', $pendaftar->domisili_santri) == 'Asrama' ? 'selected' : '' }}>Asrama (Mondok)</option>
                <option value="Non-Asrama" {{ old('domisili_santri', $pendaftar->domisili_santri) == 'Non-Asrama' ? 'selected' : '' }}>Non-Asrama (Laju)</option>
            </select>
            @error('domisili_santri') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">KEBUTUHAN KHUSUS</label>
            <input type="text" name="berkebutuhan_khusus" class="form-control @error('berkebutuhan_khusus') is-invalid @enderror" value="{{ old('berkebutuhan_khusus', $pendaftar->berkebutuhan_khusus) }}" placeholder="Isi '-' jika tidak ada">
            @error('berkebutuhan_khusus') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <h6 class="fw-bold text-success mt-4 small"><i class="fas fa-school me-2"></i>II. DATA SEKOLAH ASAL</h6>
        
        <div class="col-md-6">
            <label class="text-xs fw-bold">NAMA SEKOLAH ASAL</label>
            <input type="text" name="sekolah_asal" class="form-control @error('sekolah_asal') is-invalid @enderror" value="{{ old('sekolah_asal', $pendaftar->sekolah_asal) }}">
            @error('sekolah_asal') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">NPSN SEKOLAH</label>
            <input type="number" name="npsn_sekolah" class="form-control @error('npsn_sekolah') is-invalid @enderror" value="{{ old('npsn_sekolah', $pendaftar->npsn_sekolah) }}">
            @error('npsn_sekolah') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">STATUS SEKOLAH</label>
            <select name="status_sekolah" class="form-select @error('status_sekolah') is-invalid @enderror">
                <option value="">-- Pilih --</option>
                <option value="NEGERI" {{ old('status_sekolah', $pendaftar->status_sekolah) == 'NEGERI' ? 'selected' : '' }}>NEGERI</option>
                <option value="SWASTA" {{ old('status_sekolah', $pendaftar->status_sekolah) == 'SWASTA' ? 'selected' : '' }}>SWASTA</option>
            </select>
            @error('status_sekolah') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <h6 class="fw-bold text-success mt-4 small"><i class="fas fa-map-marked-alt me-2"></i>III. ALAMAT DOMISILI</h6>
        
        <div class="col-12">
            <label class="text-xs fw-bold">ALAMAT LENGKAP (JALAN/DUSUN)</label>
            <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2">{{ old('alamat_lengkap', $pendaftar->alamat_lengkap) }}</textarea>
            @error('alamat_lengkap') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
            <label class="text-xs fw-bold">RT</label>
            <input type="number" name="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt', $pendaftar->rt) }}" placeholder="000">
            @error('rt') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
            <label class="text-xs fw-bold">RW</label>
            <input type="number" name="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw', $pendaftar->rw) }}" placeholder="000">
            @error('rw') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">KODE POS</label>
            <input type="number" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos', $pendaftar->kode_pos) }}">
            @error('kode_pos') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">PROVINSI</label>
            <select name="provinsi" id="provinsi" class="form-select @error('provinsi') is-invalid @enderror">
                <option value="{{ old('provinsi', $pendaftar->provinsi) }}">{{ old('provinsi', $pendaftar->provinsi) ?? '-- Pilih --' }}</option>
            </select>
            @error('provinsi') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">KABUPATEN</label>
            <select name="kabupaten" id="kabupaten" class="form-select @error('kabupaten') is-invalid @enderror">
                <option value="{{ old('kabupaten', $pendaftar->kabupaten) }}">{{ old('kabupaten', $pendaftar->kabupaten) ?? '-- Pilih --' }}</option>
            </select>
            @error('kabupaten') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">KECAMATAN</label>
            <select name="kecamatan" id="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror">
                <option value="{{ old('kecamatan', $pendaftar->kecamatan) }}">{{ old('kecamatan', $pendaftar->kecamatan) ?? '-- Pilih --' }}</option>
            </select>
            @error('kecamatan') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">DESA/KELURAHAN</label>
            <select name="desa" id="desa" class="form-select @error('desa') is-invalid @enderror">
                <option value="{{ old('desa', $pendaftar->desa) }}">{{ old('desa', $pendaftar->desa) ?? '-- Pilih --' }}</option>
            </select>
            @error('desa') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>
    </div>
</div>