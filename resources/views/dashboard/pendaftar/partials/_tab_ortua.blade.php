<div class="p-4 tab-pane fade" id="tab-2" role="tabpanel">
    <div class="row g-3">
        <div class="col-md-6 border-end">
            <h6 class="fw-bold text-success mb-3 small"><i class="fas fa-male me-2"></i>DATA AYAH</h6>
            
            <label class="text-xs fw-bold">NAMA LENGKAP AYAH</label>
            <input type="text" name="nama_ayah" class="form-control mb-2 @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $pendaftar->orangTua->nama_ayah ?? '') }}" placeholder="Nama Lengkap">
            @error('nama_ayah') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror
            
            <label class="text-xs fw-bold mt-2">NIK AYAH (16 DIGIT)</label>
            <input type="number" name="nik_ayah" class="form-control mb-2 @error('nik_ayah') is-invalid @enderror" 
                   value="{{ old('nik_ayah', $pendaftar->orangTua->nik_ayah ?? '') }}" 
                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                   maxlength="16">
            @error('nik_ayah') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror
            
            <label class="text-xs fw-bold mt-2">PENDIDIKAN TERAKHIR</label>
            <select name="pendidikan_terakhir_ayah" class="form-select mb-2 @error('pendidikan_terakhir_ayah') is-invalid @enderror">
                <option value="">-- Pilih Pendidikan --</option>
                @foreach(['SD', 'SMP', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Sekolah'] as $pnd)
                    <option value="{{ $pnd }}" {{ (old('pendidikan_terakhir_ayah', $pendaftar->orangTua->pendidikan_terakhir_ayah ?? '')) == $pnd ? 'selected' : '' }}>{{ $pnd }}</option>
                @endforeach
            </select>
            @error('pendidikan_terakhir_ayah') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror

            <label class="text-xs fw-bold mt-2">PEKERJAAN AYAH</label>
            @php
                $pekerjaanList = ['PNS', 'TNI/POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter/Tenaga Medis', 'Pedagang'];
                $pekerjaanAyah = old('pekerjaan_ayah', $pendaftar->orangTua->pekerjaan_ayah ?? '');
                $isAyahLainnya = !empty($pekerjaanAyah) && !in_array($pekerjaanAyah, $pekerjaanList);
            @endphp
            <select class="form-select mb-2 select-pekerjaan @error('pekerjaan_ayah') is-invalid @enderror" data-target="#input_lainnya_ayah">
                <option value="">-- Pilih Pekerjaan --</option>
                @foreach($pekerjaanList as $pj)
                    <option value="{{ $pj }}" {{ $pekerjaanAyah == $pj ? 'selected' : '' }}>{{ $pj }}</option>
                @endforeach
                <option value="Lainnya" {{ $isAyahLainnya ? 'selected' : '' }}>Lainnya...</option>
            </select>
            <input type="text" name="pekerjaan_ayah" id="input_lainnya_ayah" 
                   class="form-control mb-2 {{ $isAyahLainnya ? '' : 'd-none' }} @error('pekerjaan_ayah') is-invalid @enderror" 
                   value="{{ $pekerjaanAyah }}" placeholder="Sebutkan pekerjaan ayah...">
            @error('pekerjaan_ayah') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror
            
            <label class="text-xs fw-bold mt-2">PENGHASILAN PER BULAN</label>
            <select name="penghasilan_ayah" class="form-select mb-2 @error('penghasilan_ayah') is-invalid @enderror">
                <option value="">-- Pilih Penghasilan --</option>
                <option value="< 1.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '< 1.000.000' ? 'selected' : '' }}> < Rp 1.000.000</option>
                <option value="1.000.000 - 2.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '1.000.000 - 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                <option value="2.000.000 - 5.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '2.000.000 - 5.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 5.000.000</option>
                <option value="> 5.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '> 5.000.000' ? 'selected' : '' }}> > Rp 5.000.000</option>
            </select>
            @error('penghasilan_ayah') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror

            <label class="text-xs fw-bold mt-2">STATUS AYAH</label>
            <select name="status_ayah" class="form-select @error('status_ayah') is-invalid @enderror">
                <option value="Masih Ada" {{ (old('status_ayah', $pendaftar->orangTua->status_ayah ?? '')) == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                <option value="Meninggal" {{ (old('status_ayah', $pendaftar->orangTua->status_ayah ?? '')) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
            @error('status_ayah') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <h6 class="fw-bold text-success mb-3 small"><i class="fas fa-female me-2"></i>DATA IBU</h6>
            
            <label class="text-xs fw-bold">NAMA LENGKAP IBU</label>
            <input type="text" name="nama_ibu" class="form-control mb-2 @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $pendaftar->orangTua->nama_ibu ?? '') }}" placeholder="Nama Lengkap">
            @error('nama_ibu') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror
            
            <label class="text-xs fw-bold mt-2">NIK IBU (16 DIGIT)</label>
            <input type="number" name="nik_ibu" class="form-control mb-2 @error('nik_ibu') is-invalid @enderror" 
                   value="{{ old('nik_ibu', $pendaftar->orangTua->nik_ibu ?? '') }}" 
                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                   maxlength="16">
            @error('nik_ibu') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror
            
            <label class="text-xs fw-bold mt-2">PENDIDIKAN TERAKHIR</label>
            <select name="pendidikan_terakhir_ibu" class="form-select mb-2 @error('pendidikan_terakhir_ibu') is-invalid @enderror">
                <option value="">-- Pilih Pendidikan --</option>
                @foreach(['SD', 'SMP', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Sekolah'] as $pnd)
                    <option value="{{ $pnd }}" {{ (old('pendidikan_terakhir_ibu', $pendaftar->orangTua->pendidikan_terakhir_ibu ?? '')) == $pnd ? 'selected' : '' }}>{{ $pnd }}</option>
                @endforeach
            </select>
            @error('pendidikan_terakhir_ibu') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror

            <label class="text-xs fw-bold mt-2">PEKERJAAN IBU</label>
            @php
                $pekerjaanIbu = old('pekerjaan_ibu', $pendaftar->orangTua->pekerjaan_ibu ?? '');
                if(!in_array('Ibu Rumah Tangga', $pekerjaanList)) $pekerjaanList[] = 'Ibu Rumah Tangga';
                $isIbuLainnya = !empty($pekerjaanIbu) && !in_array($pekerjaanIbu, $pekerjaanList);
            @endphp
            <select class="form-select mb-2 select-pekerjaan @error('pekerjaan_ibu') is-invalid @enderror" data-target="#input_lainnya_ibu">
                <option value="">-- Pilih Pekerjaan --</option>
                @foreach($pekerjaanList as $pj)
                    <option value="{{ $pj }}" {{ $pekerjaanIbu == $pj ? 'selected' : '' }}>{{ $pj }}</option>
                @endforeach
                <option value="Lainnya" {{ $isIbuLainnya ? 'selected' : '' }}>Lainnya...</option>
            </select>
            <input type="text" name="pekerjaan_ibu" id="input_lainnya_ibu" 
                   class="form-control mb-2 {{ $isIbuLainnya ? '' : 'd-none' }} @error('pekerjaan_ibu') is-invalid @enderror" 
                   value="{{ $pekerjaanIbu }}" placeholder="Sebutkan pekerjaan ibu...">
            @error('pekerjaan_ibu') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror
            
            <label class="text-xs fw-bold mt-2">PENGHASILAN PER BULAN</label>
            <select name="penghasilan_ibu" class="form-select mb-2 @error('penghasilan_ibu') is-invalid @enderror">
                <option value="">-- Pilih Penghasilan --</option>
                <option value="Tidak Berpenghasilan" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                <option value="< 1.000.000" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == '< 1.000.000' ? 'selected' : '' }}> < Rp 1.000.000</option>
                <option value="1.000.000 - 2.000.000" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == '1.000.000 - 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                <option value="> 2.000.000" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == '> 2.000.000' ? 'selected' : '' }}> > Rp 2.000.000</option>
            </select>
            @error('penghasilan_ibu') <div class="invalid-feedback mb-2 small">{{ $message }}</div> @enderror

            <label class="text-xs fw-bold mt-2">STATUS IBU</label>
            <select name="status_ibu" class="form-select @error('status_ibu') is-invalid @enderror">
                <option value="Masih Ada" {{ (old('status_ibu', $pendaftar->orangTua->status_ibu ?? '')) == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                <option value="Meninggal" {{ (old('status_ibu', $pendaftar->orangTua->status_ibu ?? '')) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
            @error('status_ibu') <div class="invalid-feedback small">{{ $message }}</div> @enderror
        </div>
    </div>
</div>