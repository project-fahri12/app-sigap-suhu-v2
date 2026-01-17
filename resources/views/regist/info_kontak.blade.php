<div class="tab-pane fade" id="tab4">
                    <div class="form-section animate__animated animate__fadeIn">

                        <h5 class="section-title"><i class="fas fa-address-book me-2"></i>I. Informasi Kontak Person
                        </h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Nomor HP Ayah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i
                                            class="fas fa-phone"></i></span>
                                    <input type="number" name="hp_ayah" class="form-control" placeholder="08xxxxxxxxxx"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor HP Ibu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i
                                            class="fas fa-phone"></i></span>
                                    <input type="number" name="hp_ibu" class="form-control" placeholder="08xxxxxxxxxx"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor HP Wali (Jika Ada)</label>
                                <input type="number" name="hp_wali" class="form-control" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor WhatsApp Aktif (Notifikasi) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white"><i
                                            class="fab fa-whatsapp"></i></span>
                                    <input type="number" name="no_wa_aktif" class="form-control border-success"
                                        placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div class="form-text text-success" style="font-size: 0.75rem;">* Digunakan untuk kirim
                                    info kelulusan & jadwal tes.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Email Aktif (Orang Tua / Wali) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i
                                            class="fas fa-envelope"></i></span>
                                    <input type="email" name="email_aktif" class="form-control"
                                        placeholder="nama@email.com" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title"><i class="fas fa-home me-2"></i>II. Detail Domisili Saat Ini</h5>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Alamat Domisili Saat Ini <span
                                        class="text-danger">*</span></label>
                                <textarea name="domisili_sekarang" class="form-control" rows="3"
                                    placeholder="Alamat tinggal sekarang jika berbeda dengan alamat KTP"
                                    required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Domisili <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="status_domisili_saat_ini"
                                            id="dom1" value="Tetap" checked required>
                                        <label class="form-check-label" for="dom1">Milik Sendiri / Tetap</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_domisili_saat_ini"
                                            id="dom2" value="Sementara" required>
                                        <label class="form-check-label" for="dom2">Sewa / Sementara</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                            <button type="button" class="btn btn-prev px-5 shadow-sm" onclick="nextTab('tab3')">
                                <i class="fas fa-chevron-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-next px-5 shadow-sm" onclick="generateReview()">
                                Preview Ringkasan <i class="fas fa-eye ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
