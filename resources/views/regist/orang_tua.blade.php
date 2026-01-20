<div class="tab-pane fade" id="tab2">
    <div class="form-section animate__animated animate__fadeIn">

        <div class="row">
            <div class="col-lg-6 border-end">
                <h5 class="section-title"><i class="fas fa-user-tie me-2"></i>I. Data Ayah Kandung</h5>
                <div class="row g-3 pe-lg-3">
                    <div class="col-md-12">
                        <label class="form-label">Nama Lengkap Ayah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ayah"
                            class="form-control @error('nama_ayah') is-invalid @enderror" placeholder="Nama sesuai KK"
                            value="{{ old('nama_ayah') }}" required>
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">NIK Ayah (16 Digit) <span class="text-danger">*</span></label>
                        <input type="number" name="nik_ayah"
                            class="form-control @error('nik_ayah') is-invalid @enderror" oninput="limitChar(this, 16)"
                            value="{{ old('nik_ayah') }}" required>
                        @error('nik_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                        <select name="pendidikan_terakhir_ayah"
                            class="form-select @error('pendidikan_terakhir_ayah') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Tidak Sekolah', 'SD/MI', 'SMP/MTs', 'SMA/MA/SMK', 'Diploma (D1/D2/D3)', 'Sarjana (S1)', 'Magister (S2)', 'Doktor (S3)'] as $pdk)
                                <option value="{{ $pdk }}"
                                    {{ old('pendidikan_terakhir_ayah') == $pdk ? 'selected' : '' }}>{{ $pdk }}
                                </option>
                            @endforeach
                        </select>
                        @error('pendidikan_terakhir_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status Ayah <span class="text-danger">*</span></label>
                        <select name="status_ayah" class="form-select @error('status_ayah') is-invalid @enderror"
                            required>
                            <option value="Hidup" {{ old('status_ayah') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="Meninggal Dunia"
                                {{ old('status_ayah') == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                        </select>
                        @error('status_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Ayah <span class="text-danger">*</span></label>
                        <input type="text" name="pekerjaan_ayah"
                            class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                            placeholder="Contoh: PNS / Wiraswasta" value="{{ old('pekerjaan_ayah') }}" required>
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Penghasilan Per Bulan <span class="text-danger">*</span></label>
                        <select name="penghasilan_ayah"
                            class="form-select @error('penghasilan_ayah') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['< Rp 1.000.000', 'Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', 'Rp 5.000.000 - Rp 10.000.000', '> Rp 10.000.000'] as $gaji)
                                <option value="{{ $gaji }}"
                                    {{ old('penghasilan_ayah') == $gaji ? 'selected' : '' }}>{{ $gaji }}
                                </option>
                            @endforeach
                        </select>
                        @error('penghasilan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h5 class="section-title ps-lg-4"><i class="fas fa-user-nurse me-2"></i>II. Data Ibu Kandung</h5>
                <div class="row g-3 ps-lg-4">
                    <div class="col-md-12">
                        <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ibu"
                            class="form-control @error('nama_ibu') is-invalid @enderror" placeholder="Nama sesuai KK"
                            value="{{ old('nama_ibu') }}" required>
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">NIK Ibu (16 Digit) <span class="text-danger">*</span></label>
                        <input type="number" name="nik_ibu" class="form-control @error('nik_ibu') is-invalid @enderror"
                            oninput="limitChar(this, 16)" value="{{ old('nik_ibu') }}" required>
                        @error('nik_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                        <select name="pendidikan_terakhir_ibu"
                            class="form-select @error('pendidikan_terakhir_ibu') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Tidak Sekolah', 'SD/MI', 'SMP/MTs', 'SMA/MA/SMK', 'Diploma (D1/D2/D3)', 'Sarjana (S1)', 'Magister (S2)', 'Doktor (S3)'] as $pdk)
                                <option value="{{ $pdk }}"
                                    {{ old('pendidikan_terakhir_ibu') == $pdk ? 'selected' : '' }}>{{ $pdk }}
                                </option>
                            @endforeach
                        </select>
                        @error('pendidikan_terakhir_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status Ibu <span class="text-danger">*</span></label>
                        <select name="status_ibu" class="form-select @error('status_ibu') is-invalid @enderror"
                            required>
                            <option value="Hidup" {{ old('status_ibu') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="Meninggal Dunia"
                                {{ old('status_ibu') == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                        </select>
                        @error('status_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Ibu <span class="text-danger">*</span></label>
                        <input type="text" name="pekerjaan_ibu"
                            class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                            placeholder="Contoh: Ibu Rumah Tangga" value="{{ old('pekerjaan_ibu') }}" required>
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Penghasilan Per Bulan <span class="text-danger">*</span></label>
                        <select name="penghasilan_ibu"
                            class="form-select @error('penghasilan_ibu') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Tidak Ada / IRT', '< Rp 1.000.000', 'Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000'] as $gaji)
                                <option value="{{ $gaji }}"
                                    {{ old('penghasilan_ibu') == $gaji ? 'selected' : '' }}>{{ $gaji }}
                                </option>
                            @endforeach
                        </select>
                        @error('penghasilan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab1')">
                <i class="fas fa-chevron-left me-2"></i> Kembali
            </button>
            <button type="button" class="btn btn-next px-5 shadow-sm bg-success text-white" onclick="nextTab('tab3')">
                Lanjut: Data Wali <i class="fas fa-chevron-right ms-2"></i>
            </button>
        </div>
    </div>
</div>
