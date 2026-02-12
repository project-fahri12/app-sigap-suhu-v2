    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PSB | Yayasan Subulul Huda</title>

        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600;700&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        @vite(['resources/css/home/home.css', 'resources/js/home.js'])

    </head>

    <body>

        <header>
            <div class="top-bar">
                <div class="container">
                    <div class="top-wrapper">
                        <div class="logo-area">
                            <img src="{{ asset('assets/kop/logo-kop-pondok.png') }}" alt="Logo">
                            <div class="brand-info">
                                <span class="psb-brand">PSB</span>
                                <span class="instansi-brand">YAYASAN SUBULUL HUDA</span>
                            </div>
                        </div>

                        <div class="contact-area">
                            <div class="contact-box">
                                <p>Admin Pendaftaran 1</p>
                                <div class="phone-link">
                                    <a href="#">089 603 761 528</a>
                                    <div class="icon-circle"><i class="fa-solid fa-phone"></i></div>
                                </div>
                            </div>
                            <div class="contact-box">
                                <p>Admin Pendaftaran 2</p>
                                <div class="phone-link">
                                    <a href="#">089 603 761 529</a>
                                    <div class="icon-circle"><i class="fa-solid fa-phone"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="main-navigation">
                <div class="container">
                    <div class="nav-card">
                        <div class="mobile-toggle" id="mobile-menu">
                            <i class="fa-solid fa-bars"></i>
                        </div>

                        <ul class="nav-list" id="nav-list">
                            <li><a href="#" class="active">Home</a></li>
                            <li><a href="#">Alur</a></li>
                            <li><a href="#">Tutorial</a></li>
                            <li><a href="#">Jenjang</a></li>
                            <li><a href="#">Masih Bingung?</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <section class="hero-wrapper py-5">
            <div class="container">
                <div class="row g-4 d-flex align-items-stretch">

                    <div class="col-lg-8">
                        <div class="banner-container h-100">
                            <div class="banner-outline shadow-sm">
                                <img src="{{ asset('assets/img/banner-hero-psb.jpg') }}" alt="Banner PPDB"
                                    class="img-fluid banner-img">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex flex-column gap-3 h-100">
                            <form action="{{ route('pendaftar.login.submit') }}" method="POST">
                                @csrf
                                <div
                                    class="login-card-mini shadow-sm border bg-white h-100 d-flex flex-column justify-content-center">
                                    <h6><i class="fa fa-lock me-1 text-primary"></i> LOGIN PPDB</h6>
                                    <hr>
                                    <div class="mb-3 text-start"> <label
                                            class="form-label small fw-bold text-secondary text-uppercase">NISN /
                                            Username</label>

                                        <input type="text" name="username"
                                            class="form-control form-control-lg fs-6 @error('username') is-invalid @enderror"
                                            placeholder="Masukkan NISN anda" value="{{ old('username') }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>

                                        @error('username')
                                            <div class="invalid-feedback fw-bold" style="font-size: 11px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn-custom btn-login w-100">
                                                <i class="fa fa-sign-in-alt me-1"></i> MASUK
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="#"
                                                class="btn-custom btn-register-small w-100 text-center text-decoration-none">
                                                <i class="fa fa-user-plus me-1"></i> DAFTAR
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- <a href="#" class="btn-custom btn-info-cabang shadow-sm">
                                <i class="fa fa-list me-2"></i> PILIH CABANG PESANTREN
                            </a> --}}

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="info-layanan py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-uppercase" style="font-family: 'Montserrat';">Informasi & Layanan PSB</h2>
                    <div style="width: 80px; height: 4px; background: #00c853; margin: 0 auto;"></div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card h-100 shadow-sm border-0 info-card">
                            <div class="card-header bg-dark text-white p-3 fw-bold d-flex align-items-center gap-2">
                                <i class="fa fa-building text-success"></i> LAYANAN OFFLINE
                            </div>
                            <div class="card-body p-4">
                                <p class="small text-secondary mb-4">Datang langsung ke kantor pusat pelayanan
                                    pendaftaran di lokasi berikut:</p>
                                <ul class="list-unstyled d-flex flex-column gap-3">
                                    <li class="d-flex gap-3">
                                        <i class="fa fa-map-marker-alt text-danger mt-1"></i>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Kantor Pusat PSB</h6>
                                            <p class="small m-0">Jl. Raya Ponorogo-Madiun, Kertobaten, Madiun</p>
                                        </div>
                                    </li>
                                    <li class="d-flex gap-3">
                                        <i class="fa fa-clock text-primary mt-1"></i>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Jam Operasional</h6>
                                            <p class="small m-0">Senin - Sabtu: 08.00 - 15.00 WIB</p>
                                            <p class="small m-0 text-danger font-italic">*Jumat Libur</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card h-100 shadow-sm border-0 info-card">
                            <div class="card-header bg-dark text-white p-3 fw-bold d-flex align-items-center gap-2">
                                <i class="fa fa-globe text-primary"></i> LAYANAN ONLINE
                            </div>
                            <div class="card-body p-4">
                                <p class="small text-secondary mb-4">Layanan bantuan melalui platform digital dan pesan
                                    instan:</p>
                                <div class="d-grid gap-3">
                                    <a href="#"
                                        class="btn btn-outline-success d-flex align-items-center justify-content-between p-3 rounded-3">
                                        <span class="fw-bold"><i class="fab fa-whatsapp me-2"></i> WhatsApp Admin
                                            1</span>
                                        <i class="fa fa-chevron-right small"></i>
                                    </a>
                                    <a href="#"
                                        class="btn btn-outline-success d-flex align-items-center justify-content-between p-3 rounded-3">
                                        <span class="fw-bold"><i class="fab fa-whatsapp me-2"></i> WhatsApp Admin
                                            2</span>
                                        <i class="fa fa-chevron-right small"></i>
                                    </a>
                                    <a href="#"
                                        class="btn btn-outline-primary d-flex align-items-center justify-content-between p-3 rounded-3">
                                        <span class="fw-bold"><i class="fa fa-envelope me-2"></i> Email Support</span>
                                        <i class="fa fa-chevron-right small"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card h-100 shadow-sm border-0 info-card">
                            <div class="card-header bg-success text-white p-3 fw-bold d-flex align-items-center gap-2">
                                <i class="fa fa-download"></i> DOWNLOAD BROSUR
                            </div>
                            <div class="card-body p-4">
                                <p class="small text-secondary mb-4">Unduh detail informasi jenjang sekolah & pondok
                                    pesantren:</p>
                                <div class="d-flex flex-column gap-2">
                                    <div
                                        class="p-3 border rounded-3 d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box-small me-3 bg-light text-success"><i
                                                    class="fa fa-file-pdf"></i></div>
                                            <span class="small fw-bold">Brosur Unit Sekolah</span>
                                        </div>
                                        <a href="#" class="text-success"><i class="fa fa-download"></i></a>
                                    </div>
                                    <div
                                        class="p-3 border rounded-3 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box-small me-3 bg-light text-primary"><i
                                                    class="fa fa-file-pdf"></i></div>
                                            <span class="small fw-bold">Brosur Unit Ponpes</span>
                                        </div>
                                        <a href="#" class="text-primary"><i class="fa fa-download"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="tutorial-section py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-uppercase" style="font-family: 'Montserrat';">Tutorial Pendaftaran</h2>
                    <p class="text-secondary">Simak video panduan langkah demi langkah pendaftaran santri baru berikut
                        ini.</p>
                    <div style="width: 80px; height: 4px; background: #5c6bc0; margin: 0 auto;"></div>
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-lg-8">
                        <div class="video-container shadow-lg p-2 bg-light border rounded-4">
                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                                <iframe src="https://www.youtube.com/embed/YVymgctc4JY?si=6ggXbDly3qxJ7RUi"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="ps-lg-4">
                            <h4 class="fw-bold mb-4 text-primary">Panduan Singkat</h4>
                            <div class="step-guide">
                                <div class="d-flex gap-3 mb-4">
                                    <div class="step-num">1</div>
                                    <p class="small m-0">Siapkan berkas seperti <b>NISN</b>, NIK, dan Kartu Keluarga.
                                    </p>
                                </div>
                                <div class="d-flex gap-3 mb-4">
                                    <div class="step-num">2</div>
                                    <p class="small m-0">Klik tombol <b>Daftar Sekarang</b> dan isi formulir dengan
                                        lengkap.</p>
                                </div>
                                <div class="d-flex gap-3 mb-4">
                                    <div class="step-num">3</div>
                                    <p class="small m-0">Lakukan pembayaran biaya pendaftaran sesuai instruksi.</p>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="step-num">4</div>
                                    <p class="small m-0">Login kembali untuk mencetak kartu ujian & memantau status
                                        seleksi.</p>
                                </div>
                            </div>

                            <a href="https://wa.me/6289603761528"
                                class="btn btn-primary w-100 mt-5 py-3 fw-bold rounded-pill shadow">
                                <i class="fab fa-whatsapp me-2"></i> KONSULTASI PENDAFTARAN
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="parallax-join">
            <div class="parallax-overlay"></div>
            <div class="container position-relative z-index-1">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center text-white">
                        <h3 class="fw-bold mb-4 text-uppercase tracking-wider">Gabung Sekarang</h3>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="#" class="btn btn-success btn-custom-join px-4">
                                <i class="fa fa-user-plus me-2"></i> DAFTAR PPDB
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="main-footer pt-5">
            <div class="container pb-4">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-info">
                            <img src="{{ asset('assets/kop/logo-kop-pondok.png') }}" alt="Logo" class="mb-3"
                                style="width: 50px;">
                            <h5 class="fw-bold text-white mb-3">YAYASAN SUBULUL HUDA</h5>
                            <p class="small text-secondary-light">
                                Mewujudkan lembaga pendidikan Islam yang unggul, moderat, dan berorientasi pada
                                kemandirian santri serta penguasaan teknologi.
                            </p>
                            <div class="social-links d-flex gap-2 mt-4">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-tiktok"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-6">
                        <h6 class="text-white fw-bold mb-3">Pendaftaran</h6>
                        <ul class="footer-links list-unstyled">
                            <li><a href="#">Alur Pendaftaran</a></li>
                            {{-- <li><a href="#">Syarat & Ketentuan</a></li> --}}
                            {{-- <li><a href="#">Biaya Pendidikan</a></li> --}}
                            {{-- <li><a href="#">Cek Kelulusan</a></li> --}}
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 col-6">
                        <h6 class="text-white fw-bold mb-3">Jenjang</h6>
                        <ul class="footer-links list-unstyled">
                            <li><a href="#">SMP Subulul Huda</a></li>
                            <li><a href="#">SMA Subulul Huda</a></li>
                            <li><a href="#">Madrasah Diniyah</a></li>
                            <li><a href="#">Tahfidzul Qur'an</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <h6 class="text-white fw-bold mb-3">Kontak Kami</h6>
                        <ul class="footer-contact list-unstyled">
                            <li class="d-flex gap-3 mb-2">
                                <i class="fa fa-map-marker-alt text-success"></i>
                                <span class="small text-secondary-light">Jl. Raya Ponorogo-Madiun, Kertobaten, Kec.
                                    Geger, Kabupaten Madiun, Jawa Timur</span>
                            </li>
                            <li class="d-flex gap-3 mb-2">
                                <i class="fa fa-phone text-success"></i>
                                <span class="small text-secondary-light">089 603 761 528</span>
                            </li>
                            <li class="d-flex gap-3">
                                <i class="fa fa-envelope text-success"></i>
                                <span class="small text-secondary-light">info@subululhuda.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="copyright-bar py-3 border-top border-secondary">
                <div
                    class="container text-center text-md-between d-md-flex justify-content-between align-items-center">
                    <p class="m-0 small text-secondary-light">© 2026 Yayasan Subulul Huda. All Rights Reserved.</p>
                    <p class="m-0 small text-secondary-light mt-2 mt-md-0">Developed by <a
                            href="https://instagram.com/kmfffaa" class="text-white fw-bold">Fahri</a></p>
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const menuToggle = document.getElementById('mobile-menu');
            const navList = document.getElementById('nav-list');

            menuToggle.addEventListener('click', () => {
                navList.classList.toggle('active');
            });
        </script>

    </body>

    </html>
