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
                                <input type="text" name="nama_wali" class="form-control"
                                    placeholder="Nama sesuai identitas resmi">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NIK Wali (16 Digit)</label>
                                <input type="number" name="nik_wali" class="form-control" oninput="limitChar(this, 16)">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Hubungan dengan Santri</label>
                                <select name="hubungan_wali" class="form-select">
                                    <option value="">-- Pilih Hubungan --</option>
                                    <option>Kakek / Nenek</option>
                                    <option>Paman / Bibi</option>
                                    <option>Kakak Kandung</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tempat Lahir Wali</label>
                                <input type="text" name="tempat_lahir_wali" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Lahir Wali</label>
                                <input type="date" name="tanggal_lahir_wali" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pendidikan Terakhir Wali</label>
                                <select name="pendidikan_wali" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option>SD/MI</option>
                                    <option>SMP/MTs</option>
                                    <option>SMA/MA/SMK</option>
                                    <option>Diploma / Sarjana</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pekerjaan Wali</label>
                                <input type="text" name="pekerjaan_wali" class="form-control"
                                    placeholder="Contoh: Buruh / Karyawan">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Penghasilan Wali</label>
                                <select name="penghasilan_wali" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option>
                                        < Rp 1.000.000</option>
                                    <option>Rp 1.000.000 - Rp 3.000.000</option>
                                    <option>> Rp 3.000.000</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Alamat Lengkap Wali</label>
                                <textarea name="alamat_wali" class="form-control" rows="3"
                                    placeholder="Nama Jalan, RT/RW, Desa, Kecamatan, Kota/Kabupaten"></textarea>
                                <div class="form-text">Tuliskan alamat domisili wali saat ini secara lengkap.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab2')">
                                <i class="fas fa-chevron-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-next px-5 shadow-sm" onclick="nextTab('tab4')">
                                Lanjut: Kontak <i class="fas fa-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>