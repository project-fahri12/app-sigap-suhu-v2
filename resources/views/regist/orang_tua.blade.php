 <div class="tab-pane fade" id="tab2">
                    <div class="form-section animate__animated animate__fadeIn">

                        <div class="row">
                            <div class="col-lg-6 border-end">
                                <h5 class="section-title"><i class="fas fa-user-tie me-2"></i>I. Data Ayah Kandung</h5>
                                <div class="row g-3 pe-lg-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Nama Lengkap Ayah <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_ayah" class="form-control"
                                            placeholder="Nama sesuai KK" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">NIK Ayah (16 Digit) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="nik_ayah" class="form-control"
                                            oninput="limitChar(this, 16)" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Pendidikan Terakhir <span
                                                class="text-danger">*</span></label>
                                        <select name="pendidikan_ayah" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option>Tidak Sekolah</option>
                                            <option>SD/MI</option>
                                            <option>SMP/MTs</option>
                                            <option>SMA/MA/SMK</option>
                                            <option>Diploma (D1/D2/D3)</option>
                                            <option>Sarjana (S1)</option>
                                            <option>Magister (S2)</option>
                                            <option>Doktor (S3)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Ayah <span class="text-danger">*</span></label>
                                        <select name="status_ayah" class="form-select" required>
                                            <option>Hidup</option>
                                            <option>Meninggal Dunia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Pekerjaan Ayah <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="pekerjaan_ayah" class="form-control"
                                            placeholder="Contoh: PNS / Wiraswasta" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Penghasilan Per Bulan <span
                                                class="text-danger">*</span></label>
                                        <select name="penghasilan_ayah" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option>
                                                < Rp 1.000.000</option>
                                            <option>Rp 1.000.000 - Rp 3.000.000</option>
                                            <option>Rp 3.000.000 - Rp 5.000.000</option>
                                            <option>Rp 5.000.000 - Rp 10.000.000</option>
                                            <option>> Rp 10.000.000</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <h5 class="section-title ps-lg-4"><i class="fas fa-user-nurse me-2"></i>II. Data Ibu
                                    Kandung</h5>
                                <div class="row g-3 ps-lg-4">
                                    <div class="col-md-12">
                                        <label class="form-label">Nama Lengkap Ibu <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nama_ibu" class="form-control"
                                            placeholder="Nama sesuai KK" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">NIK Ibu (16 Digit) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="nik_ibu" class="form-control"
                                            oninput="limitChar(this, 16)" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Pendidikan Terakhir <span
                                                class="text-danger">*</span></label>
                                        <select name="pendidikan_ibu" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option>Tidak Sekolah</option>
                                            <option>SD/MI</option>
                                            <option>SMP/MTs</option>
                                            <option>SMA/MA/SMK</option>
                                            <option>Diploma (D1/D2/D3)</option>
                                            <option>Sarjana (S1)</option>
                                            <option>Magister (S2)</option>
                                            <option>Doktor (S3)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Ibu <span class="text-danger">*</span></label>
                                        <select name="status_ibu" class="form-select" required>
                                            <option>Hidup</option>
                                            <option>Meninggal Dunia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Pekerjaan Ibu <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="pekerjaan_ibu" class="form-control"
                                            placeholder="Contoh: Ibu Rumah Tangga" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Penghasilan Per Bulan <span
                                                class="text-danger">*</span></label>
                                        <select name="penghasilan_ibu" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option>Tidak Ada / IRT</option>
                                            <option>
                                                < Rp 1.000.000</option>
                                            <option>Rp 1.000.000 - Rp 3.000.000</option>
                                            <option>Rp 3.000.000 - Rp 5.000.000</option>
                                            <option>> Rp 5.000.000</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab1')">
                                <i class="fas fa-chevron-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-next px-5 shadow-sm" onclick="nextTab('tab3')">
                                Lanjut: Data Wali <i class="fas fa-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>