<div class="p-4 tab-pane fade" id="tab-2" role="tabpanel">
    <div class="row g-3">
        <div class="col-md-6 border-end">
            <h6 class="fw-bold text-success mb-3 small"><i class="fas fa-male me-2"></i>DATA AYAH</h6>
            
            <label class="text-xs fw-bold">NAMA LENGKAP AYAH</label>
            <input type="text" name="nama_ayah" class="form-control mb-2" value="{{ old('nama_ayah', $pendaftar->orangTua->nama_ayah ?? '') }}" placeholder="Nama Lengkap">
            
            <label class="text-xs fw-bold mt-2">NIK AYAH (16 DIGIT)</label>
            <input type="number" name="nik_ayah" class="form-control mb-2" value="{{ old('nik_ayah', $pendaftar->orangTua->nik_ayah ?? '') }}" maxlength="16">
            
            <label class="text-xs fw-bold mt-2">PENDIDIKAN TERAKHIR</label>
            <select name="pendidikan_terakhir_ayah" class="form-select mb-2">
                <option value="">-- Pilih Pendidikan --</option>
                @foreach(['SD', 'SMP', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Sekolah'] as $pnd)
                    <option value="{{ $pnd }}" {{ (old('pendidikan_terakhir_ayah', $pendaftar->orangTua->pendidikan_terakhir_ayah ?? '')) == $pnd ? 'selected' : '' }}>{{ $pnd }}</option>
                @endforeach
            </select>

            <label class="text-xs fw-bold mt-2">PEKERJAAN AYAH</label>
            @php
                $pekerjaanList = ['PNS', 'TNI/POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Buruh', 'Guru/Dosen', 'Dokter/Tenaga Medis', 'Pedagang'];
                $pekerjaanAyah = old('pekerjaan_ayah', $pendaftar->orangTua->pekerjaan_ayah ?? '');
                $isAyahLainnya = !empty($pekerjaanAyah) && !in_array($pekerjaanAyah, $pekerjaanList);
            @endphp
            <select class="form-select mb-2 select-pekerjaan" data-target="#input_lainnya_ayah">
                <option value="">-- Pilih Pekerjaan --</option>
                @foreach($pekerjaanList as $pj)
                    <option value="{{ $pj }}" {{ $pekerjaanAyah == $pj ? 'selected' : '' }}>{{ $pj }}</option>
                @endforeach
                <option value="Lainnya" {{ $isAyahLainnya ? 'selected' : '' }}>Lainnya...</option>
            </select>
            <input type="text" name="pekerjaan_ayah" id="input_lainnya_ayah" 
                   class="form-control mb-2 {{ $isAyahLainnya ? '' : 'd-none' }}" 
                   value="{{ $pekerjaanAyah }}" placeholder="Sebutkan pekerjaan ayah...">
            
            <label class="text-xs fw-bold mt-2">PENGHASILAN PER BULAN</label>
            <select name="penghasilan_ayah" class="form-select mb-2">
                <option value="">-- Pilih Penghasilan --</option>
                <option value="< 1.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '< 1.000.000' ? 'selected' : '' }}> < Rp 1.000.000</option>
                <option value="1.000.000 - 2.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '1.000.000 - 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                <option value="2.000.000 - 5.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '2.000.000 - 5.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 5.000.000</option>
                <option value="> 5.000.000" {{ (old('penghasilan_ayah', $pendaftar->orangTua->penghasilan_ayah ?? '')) == '> 5.000.000' ? 'selected' : '' }}> > Rp 5.000.000</option>
            </select>

            <label class="text-xs fw-bold mt-2">STATUS AYAH</label>
            <select name="status_ayah" class="form-select">
                <option value="Masih Ada" {{ (old('status_ayah', $pendaftar->orangTua->status_ayah ?? '')) == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                <option value="Meninggal" {{ (old('status_ayah', $pendaftar->orangTua->status_ayah ?? '')) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
        </div>

        <div class="col-md-6">
            <h6 class="fw-bold text-success mb-3 small"><i class="fas fa-female me-2"></i>DATA IBU</h6>
            
            <label class="text-xs fw-bold">NAMA LENGKAP IBU</label>
            <input type="text" name="nama_ibu" class="form-control mb-2" value="{{ old('nama_ibu', $pendaftar->orangTua->nama_ibu ?? '') }}" placeholder="Nama Lengkap">
            
            <label class="text-xs fw-bold mt-2">NIK IBU (16 DIGIT)</label>
            <input type="number" name="nik_ibu" class="form-control mb-2" value="{{ old('nik_ibu', $pendaftar->orangTua->nik_ibu ?? '') }}" maxlength="16">
            
            <label class="text-xs fw-bold mt-2">PENDIDIKAN TERAKHIR</label>
            <select name="pendidikan_terakhir_ibu" class="form-select mb-2">
                <option value="">-- Pilih Pendidikan --</option>
                @foreach(['SD', 'SMP', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Sekolah'] as $pnd)
                    <option value="{{ $pnd }}" {{ (old('pendidikan_terakhir_ibu', $pendaftar->orangTua->pendidikan_terakhir_ibu ?? '')) == $pnd ? 'selected' : '' }}>{{ $pnd }}</option>
                @endforeach
            </select>

            <label class="text-xs fw-bold mt-2">PEKERJAAN IBU</label>
            @php
                $pekerjaanIbu = old('pekerjaan_ibu', $pendaftar->orangTua->pekerjaan_ibu ?? '');
                $isIbuLainnya = !empty($pekerjaanIbu) && !in_array($pekerjaanIbu, $pekerjaanList) && $pekerjaanIbu != 'Ibu Rumah Tangga';
                // Tambahkan IRT khusus untuk Ibu
                if(!in_array('Ibu Rumah Tangga', $pekerjaanList)) $pekerjaanList[] = 'Ibu Rumah Tangga';
            @endphp
            <select class="form-select mb-2 select-pekerjaan" data-target="#input_lainnya_ibu">
                <option value="">-- Pilih Pekerjaan --</option>
                @foreach($pekerjaanList as $pj)
                    <option value="{{ $pj }}" {{ $pekerjaanIbu == $pj ? 'selected' : '' }}>{{ $pj }}</option>
                @endforeach
                <option value="Lainnya" {{ $isIbuLainnya ? 'selected' : '' }}>Lainnya...</option>
            </select>
            <input type="text" name="pekerjaan_ibu" id="input_lainnya_ibu" 
                   class="form-control mb-2 {{ $isIbuLainnya ? '' : 'd-none' }}" 
                   value="{{ $pekerjaanIbu }}" placeholder="Sebutkan pekerjaan ibu...">
            
            <label class="text-xs fw-bold mt-2">PENGHASILAN PER BULAN</label>
            <select name="penghasilan_ibu" class="form-select mb-2">
                <option value="">-- Pilih Penghasilan --</option>
                <option value="Tidak Berpenghasilan" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                <option value="< 1.000.000" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == '< 1.000.000' ? 'selected' : '' }}> < Rp 1.000.000</option>
                <option value="1.000.000 - 2.000.000" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == '1.000.000 - 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                <option value="> 2.000.000" {{ (old('penghasilan_ibu', $pendaftar->orangTua->penghasilan_ibu ?? '')) == '> 2.000.000' ? 'selected' : '' }}> > Rp 2.000.000</option>
            </select>

            <label class="text-xs fw-bold mt-2">STATUS IBU</label>
            <select name="status_ibu" class="form-select">
                <option value="Masih Ada" {{ (old('status_ibu', $pendaftar->orangTua->status_ibu ?? '')) == 'Masih Ada' ? 'selected' : '' }}>Masih Ada</option>
                <option value="Meninggal" {{ (old('status_ibu', $pendaftar->orangTua->status_ibu ?? '')) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
        </div>
    </div>
</div>

{{-- Tambahkan script ini di bagian bawah file utama atau di push('js') --}}
<script>
document.querySelectorAll('.select-pekerjaan').forEach(select => {
    select.addEventListener('change', function() {
        const targetInput = document.querySelector(this.dataset.target);
        if (this.value === 'Lainnya') {
            targetInput.classList.remove('d-none');
            targetInput.value = ''; // Kosongkan agar user isi manual
            targetInput.focus();
            // Penting: input teks harus punya atribut 'name' agar terkirim
            targetInput.setAttribute('name', this.previousElementSibling.previousElementSibling.getAttribute('name')); 
        } else {
            targetInput.classList.add('d-none');
            targetInput.value = this.value;
            // Jika pilih opsi yg ada di list, pastikan input hidden mengikuti value select
        }
    });
});
</script>