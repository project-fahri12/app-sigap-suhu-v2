<div class="tab-pane fade" id="tab3">
    <div class="form-section animate__animated animate__fadeIn">

        <h5 class="section-title"><i class="fas fa-user-friends me-2"></i>I. Data Wali (Opsional)</h5>
        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-info-circle me-3 fa-lg"></i>
            <div>
                Bagian ini <strong>hanya diisi</strong> jika calon santri tinggal bersama wali atau jika
                data wali berbeda dengan orang tua kandung.
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Lengkap Wali</label>
                <input type="text" name="nama_wali" 
                    class="form-control @error('nama_wali') is-invalid @enderror"
                    placeholder="Nama sesuai identitas resmi" value="{{ old('nama_wali') }}">
                @error('nama_wali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label">NIK Wali (16 Digit)</label>
                <input type="number" name="nik_wali" 
                    class="form-control @error('nik_wali') is-invalid @enderror" 
                    oninput="limitChar(this, 16)" value="{{ old('nik_wali') }}">
                @error('nik_wali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Hubungan dengan Santri</label>
                <select name="hubungan" class="form-select @error('hubungan') is-invalid @enderror">
                    <option value="">-- Pilih Hubungan --</option>
                    @foreach(['Kakek / Nenek', 'Paman / Bibi', 'Kakak Kandung', 'Lainnya'] as $hub)
                        <option value="{{ $hub }}" {{ old('hubungan') == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                    @endforeach
                </select>
                @error('hubungan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label class="form-label">Pendidikan Terakhir Wali</label>
                <select name="pendidikan_terakhir" class="form-select @error('pendidikan_terakhir') is-invalid @enderror">
                    <option value="">-- Pilih --</option>
                    @foreach(['SD/MI', 'SMP/MTs', 'SMA/MA/SMK', 'Diploma / Sarjana'] as $pdk)
                        <option value="{{ $pdk }}" {{ old('pendidikan_terakhir') == $pdk ? 'selected' : '' }}>{{ $pdk }}</option>
                    @endforeach
                </select>
                @error('pendidikan_terakhir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Pekerjaan Wali</label>
                <input type="text" name="pekerjaan_wali" 
                    class="form-control @error('pekerjaan_wali') is-invalid @enderror"
                    placeholder="Contoh: Buruh / Karyawan" value="{{ old('pekerjaan_wali') }}">
                @error('pekerjaan_wali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Penghasilan Wali</label>
                <select name="penghasilan_wali" class="form-select @error('penghasilan_wali') is-invalid @enderror">
                    <option value="">-- Pilih --</option>
                    @foreach(['< Rp 1.000.000', 'Rp 1.000.000 - Rp 3.000.000', '> Rp 3.000.000'] as $gaji)
                        <option value="{{ $gaji }}" {{ old('penghasilan_wali') == $gaji ? 'selected' : '' }}>{{ $gaji }}</option>
                    @endforeach
                </select>
                @error('penghasilan_wali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label">Alamat Lengkap Wali</label>
                <textarea name="alamat_lengkap" 
                    class="form-control @error('alamat_lengkap') is-invalid @enderror" 
                    rows="3" placeholder="Nama Jalan, RT/RW, Desa, Kecamatan, Kota/Kabupaten">{{ old('alamat_lengkap') }}</textarea>
                @error('alamat_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Tuliskan alamat domisili wali saat ini secara lengkap.</div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab2')">
                <i class="fas fa-chevron-left me-2"></i> Kembali
            </button>
            <button type="button" class="btn btn-next px-5 shadow-sm bg-success text-white" onclick="nextTab('tab4')">
                Lanjut <i class="fas fa-chevron-right ms-2"></i>
            </button>
        </div>
    </div>
</div>