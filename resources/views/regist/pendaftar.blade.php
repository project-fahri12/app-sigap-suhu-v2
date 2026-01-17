   <div class="tab-pane fade show active" id="tab1">
                    <div class="form-section animate__animated animate__fadeIn">

                        <h5 class="section-title"><i class="fas fa-university me-2"></i>I. Data Kelembagaan</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <label class="form-label">Pilihan Lembaga <span class="text-danger">*</span></label>
                                <input type="text" name="pilihan_lembaga" class="form-control bg-light"
                                    value="Pondok Pesantren Terpadu" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pilihan Pondok <span class="text-danger">*</span></label>
                                <select name="pilihan_pondok" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option>Putra</option>
                                    <option>Putri</option>
                                    <option>Terpadu (Mix)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Domisili <span class="text-danger">*</span></label>
                                <select name="status_domisili" class="form-select" required>
                                    <option value="Mukim">Mukim (Asrama)</option>
                                    <option value="Non Mukim">Non Mukim</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gelombang Pendaftaran</label>
                                <input type="text" name="gelombang" class="form-control bg-light" value="Gelombang 1"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" class="form-control bg-light" value="2026/2027"
                                    readonly>
                            </div>
                        </div>

                        <h5 class="section-title"><i class="fas fa-user-graduate me-2"></i>II. Identitas Pribadi Santri
                        </h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-12">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control"
                                    placeholder="Sesuai Ijazah/Akta" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NIK Santri (16 Digit) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="nik_santri" class="form-control"
                                    oninput="limitChar(this, 16)" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NISN (10 Digit) <span class="text-danger">*</span></label>
                                <input type="number" name="nisn" class="form-control" oninput="limitChar(this, 10)"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nomor Kartu Keluarga <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="no_kk" class="form-control" oninput="limitChar(this, 16)"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jk" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Anak Ke- <span class="text-danger">*</span></label>
                                <input type="number" name="anak_ke" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah Saudara <span class="text-danger">*</span></label>
                                <input type="number" name="jml_saudara" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Berat Badan (kg)</label>
                                <input type="number" name="berat_badan" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Golongan Darah</label>
                                <select name="gol_darah" class="form-select">
                                    <option value="">-</option>
                                    <option>A</option>
                                    <option>B</option>
                                    <option>AB</option>
                                    <option>O</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Berkebutuhan Khusus <span class="text-danger">*</span></label>
                                <select name="kebutuhan_khusus" class="form-select" required>
                                    <option value="Tidak">Tidak</option>
                                    <option value="Ya">Ya</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="section-title"><i class="fas fa-map-marked-alt me-2"></i>III. Alamat Domisili Santri
                        </h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-12">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat_lengkap" class="form-control" rows="2"
                                    placeholder="Nama Jalan, Dusun, No. Rumah" required></textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="rt" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="rw" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select name="provinsi" class="form-select" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <option>Jawa Barat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kabupaten / Kota <span class="text-danger">*</span></label>
                                <select name="kota" class="form-select" required>
                                    <option value="">-- Pilih Kota --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <select name="kecamatan" class="form-select" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Desa / Kelurahan <span class="text-danger">*</span></label>
                                <select name="desa" class="form-select" required>
                                    <option value="">-- Pilih Desa --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kode Pos</label>
                                <input type="number" name="kode_pos" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Tempat Tinggal <span
                                        class="text-danger">*</span></label>
                                <select name="status_tinggal" class="form-select" required>
                                    <option>Orang Tua</option>
                                    <option>Wali</option>
                                    <option>Pondok</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="section-title"><i class="fas fa-school me-2"></i>IV. Riwayat Pendidikan Asal</h5>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Nama Sekolah Asal <span class="text-danger">*</span></label>
                                <input type="text" name="sekolah_asal" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NPSN Sekolah Asal</label>
                                <input type="number" name="npsn_asal" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Sekolah <span class="text-danger">*</span></label>
                                <select name="status_sekolah_asal" class="form-select" required>
                                    <option>Negeri</option>
                                    <option>Swasta</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun Lulus <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_lulus" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Ijazah</label>
                                <input type="text" name="no_ijazah" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor SKL</label>
                                <input type="text" name="no_skl" class="form-control">
                            </div>
                        </div>

                        <div class="text-end mt-5 pt-4 border-top">
                            <button type="button" class="btn btn-next px-5 shadow-sm" onclick="nextTab('tab2')">
                                Lanjut: Data Orang Tua <i class="fas fa-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>