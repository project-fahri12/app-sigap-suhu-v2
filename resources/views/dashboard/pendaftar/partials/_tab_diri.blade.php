<div class="p-4 tab-pane fade show active" id="tab-1" role="tabpanel">
    <div class="row g-3">
        <h6 class="fw-bold text-success mt-3 small"><i class="fas fa-user-graduate me-2"></i>I. IDENTITAS PRIBADI</h6>
        
        <div class="col-md-12">
            <label class="text-xs fw-bold">NAMA LENGKAP</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $pendaftar->nama_lengkap) }}" placeholder="Sesuai Ijazah">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">NIK (16 DIGIT)</label>
            <input type="number" name="nik" class="form-control" value="{{ old('nik', $pendaftar->nik) }}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="16">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">NISN (10 DIGIT)</label>
            <input type="number" name="nisn" class="form-control" value="{{ old('nisn', $pendaftar->nisn) }}" readonly>
            <small class="text-muted text-xs">NISN dikunci otomatis</small>
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">NOMOR KK</label>
            <input type="number" name="nomor_kk" class="form-control" value="{{ old('nomor_kk', $pendaftar->nomor_kk) }}"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="16">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">TEMPAT LAHIR</label>
            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $pendaftar->tempat_lahir) }}">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">TANGGAL LAHIR</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pendaftar->tanggal_lahir) }}">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">JENIS KELAMIN</label>
            <select name="jenis_kelamin" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="L" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">ANAK KE</label>
            <input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke', $pendaftar->anak_ke) }}">
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">JUMLAH SAUDARA</label>
            <input type="number" name="jumlah_saudara" class="form-control" value="{{ old('jumlah_saudara', $pendaftar->jumlah_saudara) }}">
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">DOMISILI SANTRI</label>
            <select name="domisili_santri" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="Asrama" {{ old('domisili_santri', $pendaftar->domisili_santri) == 'Asrama' ? 'selected' : '' }}>Asrama (Mondok)</option>
                <option value="Non-Asrama" {{ old('domisili_santri', $pendaftar->domisili_santri) == 'Non-Asrama' ? 'selected' : '' }}>Non-Asrama (Laju)</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">KEBUTUHAN KHUSUS</label>
            <input type="text" name="berkebutuhan_khusus" class="form-control" value="{{ old('berkebutuhan_khusus', $pendaftar->berkebutuhan_khusus) }}" placeholder="Isi '-' jika tidak ada">
        </div>

        <h6 class="fw-bold text-success mt-4 small"><i class="fas fa-school me-2"></i>II. DATA SEKOLAH ASAL</h6>
        
        <div class="col-md-6">
            <label class="text-xs fw-bold">NAMA SEKOLAH ASAL</label>
            <input type="text" name="sekolah_asal" class="form-control" value="{{ old('sekolah_asal', $pendaftar->sekolah_asal) }}">
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">NPSN SEKOLAH</label>
            <input type="number" name="npsn_sekolah" class="form-control" value="{{ old('npsn_sekolah', $pendaftar->npsn_sekolah) }}">
        </div>

        <div class="col-md-3">
            <label class="text-xs fw-bold">STATUS SEKOLAH</label>
            <select name="status_sekolah" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="NEGERI" {{ old('status_sekolah', $pendaftar->status_sekolah) == 'NEGERI' ? 'selected' : '' }}>NEGERI</option>
                <option value="SWASTA" {{ old('status_sekolah', $pendaftar->status_sekolah) == 'SWASTA' ? 'selected' : '' }}>SWASTA</option>
            </select>
        </div>

        <h6 class="fw-bold text-success mt-4 small"><i class="fas fa-map-marked-alt me-2"></i>III. ALAMAT DOMISILI</h6>
        
        <div class="col-12">
            <label class="text-xs fw-bold">ALAMAT LENGKAP (JALAN/DUSUN)</label>
            <textarea name="alamat_lengkap" class="form-control" rows="2">{{ old('alamat_lengkap', $pendaftar->alamat_lengkap) }}</textarea>
        </div>

        <div class="col-md-2">
            <label class="text-xs fw-bold">RT</label>
            <input type="number" name="rt" class="form-control" value="{{ old('rt', $pendaftar->rt) }}" placeholder="000">
        </div>

        <div class="col-md-2">
            <label class="text-xs fw-bold">RW</label>
            <input type="number" name="rw" class="form-control" value="{{ old('rw', $pendaftar->rw) }}" placeholder="000">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">KODE POS</label>
            <input type="number" name="kode_pos" class="form-control" value="{{ old('kode_pos', $pendaftar->kode_pos) }}">
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">PROVINSI</label>
            <select name="provinsi" id="provinsi" class="form-select">
                <option value="{{ $pendaftar->provinsi }}">{{ $pendaftar->provinsi ?? '-- Pilih --' }}</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">KABUPATEN</label>
            <select name="kabupaten" id="kabupaten" class="form-select">
                <option value="{{ $pendaftar->kabupaten }}">{{ $pendaftar->kabupaten ?? '-- Pilih --' }}</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">KECAMATAN</label>
            <select name="kecamatan" id="kecamatan" class="form-select">
                <option value="{{ $pendaftar->kecamatan }}">{{ $pendaftar->kecamatan ?? '-- Pilih --' }}</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="text-xs fw-bold">DESA/KELURAHAN</label>
            <select name="desa" id="desa" class="form-select">
                <option value="{{ $pendaftar->desa }}">{{ $pendaftar->desa ?? '-- Pilih --' }}</option>
            </select>
        </div>
    </div>
</div>