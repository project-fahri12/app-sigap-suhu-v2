<div class="tab-pane fade show active" id="tab1">
    <div class="form-section animate__animated animate__fadeIn">

        <h5 class="section-title"><i class="fas fa-user-graduate me-2"></i>I. Identitas Pribadi Santri</h5>
        <div class="row g-3 mb-5">
            <div class="col-md-12">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap"
                    class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Sesuai Ijazah/Akta"
                    value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">NIK Santri (16 Digit) <span class="text-danger">*</span></label>
                <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror"
                    oninput="limitChar(this, 16)" value="{{ old('nik') }}" required>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">NISN (10 Digit) <span class="text-danger">*</span></label>
                <input type="number" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                    oninput="limitChar(this, 10)" value="{{ old('nisn') }}" required>
                @error('nisn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Nomor Kartu Keluarga <span class="text-danger">*</span></label>
                <input type="number" name="nomor_kk" class="form-control @error('nomor_kk') is-invalid @enderror"
                    oninput="limitChar(this, 16)" value="{{ old('nomor_kk') }}" required>
                @error('nomor_kk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" name="tempat_lahir"
                    class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}"
                    required>
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_lahir"
                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                    value="{{ old('tanggal_lahir') }}" required>
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Anak Ke- <span class="text-danger">*</span></label>
                <input type="number" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror"
                    value="{{ old('anak_ke') }}" required>
                @error('anak_ke')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Jumlah Saudara <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_saudara"
                    class="form-control @error('jumlah_saudara') is-invalid @enderror"
                    value="{{ old('jumlah_saudara') }}" required>
                @error('jumlah_saudara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Berkebutuhan Khusus <span class="text-danger">*</span></label>
                <select name="berkebutuhan_khusus"
                    class="form-select @error('berkebutuhan_khusus') is-invalid @enderror" required>
                    <option value="Tidak" {{ old('berkebutuhan_khusus') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    <option value="Ya" {{ old('berkebutuhan_khusus') == 'Ya' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('berkebutuhan_khusus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <h5 class="section-title"><i class="fas fa-university me-2"></i>II. Data Kelembagaan</h5>
        <div class="row g-3 mb-5">
            <div class="col-md-4">
                <label class="form-label">Pilihan Lembaga <span class="text-danger">*</span></label>
                <input type="text" class="form-control bg-light" value="{{ $sekolah->nama_sekolah }}" readonly>
                <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Status Domisili <span class="text-danger">*</span></label>
                <select name="domisili_santri" class="form-select @error('domisili_santri') is-invalid @enderror"
                    required>
                    <option value="Mukim" {{ old('domisili_santri') == 'Mukim' ? 'selected' : '' }}>Mukim (Asrama)
                    </option>
                    <option value="Non Mukim" {{ old('domisili_santri') == 'Non Mukim' ? 'selected' : '' }}>Non Mukim
                    </option>
                </select>
                @error('domisili_santri')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Pilihan Pondok <span class="text-danger">*</span></label>
                <select name="pondok_id" class="form-select @error('pondok_id') is-invalid @enderror" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($pondoks as $p)
                        <option value="{{ $p->id }}" {{ old('pondok_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_pondok }}</option>
                    @endforeach
                </select>
                @error('pondok_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <h5 class="section-title"><i class="fas fa-map-marked-alt me-2"></i>III. Alamat Domisili Santri</h5>
        <div class="row g-3 mb-5">
            <div class="col-md-12">
                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2"
                    placeholder="Nama Jalan, Dusun, No. Rumah" required>{{ old('alamat_lengkap') }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">RT <span class="text-danger">*</span></label>
                <input type="text" name="rt" class="form-control" value="{{ old('rt') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">RW <span class="text-danger">*</span></label>
                <input type="text" name="rw" class="form-control" value="{{ old('rw') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                <select name="provinsi" id="provinsi" class="form-select @error('provinsi') is-invalid @enderror"
                    required>
                    <option value="">-- Pilih Provinsi --</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kabupaten / Kota <span class="text-danger">*</span></label>
                <select name="kabupaten" id="kabupaten" class="form-select @error('kabupaten') is-invalid @enderror"
                    required disabled>
                    <option value="">-- Pilih Kota --</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                <select name="kecamatan" id="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror"
                    required disabled>
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Desa / Kelurahan <span class="text-danger">*</span></label>
                <select name="desa" id="desa" class="form-select @error('desa') is-invalid @enderror"
                    required disabled>
                    <option value="">-- Pilih Desa --</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Kode Pos</label>
                <input type="number" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}">
            </div>
        </div>


        <h5 class="section-title"><i class="fas fa-school me-2"></i>IV. Riwayat Pendidikan Asal</h5>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Sekolah Asal <span class="text-danger">*</span></label>
                <input type="text" name="sekolah_asal"
                    class="form-control @error('sekolah_asal') is-invalid @enderror"
                    value="{{ old('sekolah_asal') }}" required>
                @error('sekolah_asal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">NPSN Sekolah Asal</label>
                <input type="number" name="npsn_sekolah"
                    class="form-control @error('npsn_sekolah') is-invalid @enderror"
                    value="{{ old('npsn_sekolah') }}">
                @error('npsn_sekolah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Status Sekolah <span class="text-danger">*</span></label>
                <select name="status_sekolah" class="form-select @error('status_sekolah') is-invalid @enderror"
                    required>
                    <option value="Negeri" {{ old('status_sekolah') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                    <option value="Swasta" {{ old('status_sekolah') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                </select>
                @error('status_sekolah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-end mt-5 pt-4 border-top">
            <button type="button" class="btn btn-next px-5 shadow-sm bg-success text-white"
                onclick="nextTab('tab2')">
                Lanjut <i class="fas fa-chevron-right ms-2"></i>
            </button>
        </div>
    </div>
</div>
