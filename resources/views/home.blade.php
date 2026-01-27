<!DOCTYPE html>
<html ng="id">

<head>
    <ma charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PPDB Terpadu | Yayasan Pendidikan Unggul</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <li nk
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Inter:wght@400;500;600&display=swap"
            rel="stylesheet">

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
            @vite(['resources/css/home.css'])

            <style>

            </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/ico/logo-sigap-brown.png') }}" height="60" alt="Logo">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="fas fa-bars text-success"></i>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lembaga">Lembaga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#alur">Alur PPDB</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('auth.pendaftar') }}" class="btn btn-outline-success rounded-pill px-4">Login</a>
                    <a href="#lembaga" class="btn btn-ppdb">Daftar PPDB</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 animate__animated animate__fadeInLeft">
                    <span class="badge bg-light text-success fw-bold px-3 py-2 mb-3">PENDAFTARAN T.A 2026/2027
                        DIBUKA</span>
                    <h1 class="hero-title mb-4">Wujudkan Generasi <br><span class="text-warning">Cerdas &
                            Berakhlak</span></h1>
                    <p class="lead mb-5 opacity-90">Satu sistem terpadu untuk pendaftaran seluruh lembaga pendidikan di
                        bawah naungan Yayasan Unggul. Cepat, Transparan, dan Modern.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#lembaga" class="btn btn-warning btn-lg px-5 fw-bold rounded-pill">Daftar Sekarang</a>
                        <a href="#alur" class="btn btn-outline-light btn-lg px-5 rounded-pill">Lihat Alur</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block animate__animated animate__zoomIn">
                    <img src="https://illustrations.popsy.co/white/reading-a-book.svg" class="img-fluid"
                        alt="Education">
                </div>
            </div>
        </div>
    </section>

    <section class="container" style="margin-top: -50px; position: relative; z-index: 10;">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-box shadow">
                    <div class="stat-number">5</div>
                    <div class="small fw-bold text-muted uppercase">Lembaga</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box shadow">
                    <div class="stat-number">1.2k</div>
                    <div class="small fw-bold text-muted">Pendaftar</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box shadow">
                    <div class="stat-number">350</div>
                    <div class="small fw-bold text-muted">Santri Baru</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box shadow">
                    <div class="stat-number">24/7</div>
                    <div class="small fw-bold text-muted">Support</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding py-5 mt-5" id="lembaga">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-success fw-bold">PILIH UNIT PENDIDIKAN</h6>
                <h2 class="fw-extrabold display-5">Lembaga Pendidikan</h2>
                <div class="mx-auto bg-success" style="width: 80px; height: 4px; border-radius: 2px;"></div>
            </div>

            <div class="row g-4">
                @forelse ($lembagas as $lembaga)
                    @php
                        $gelombang = $lembaga->gelombang->first();

                        if (!$gelombang) {
                            $status = 'BELUM_KONFIGURASI';
                        } elseif ($gelombang->is_aktif == 1) {
                            $status = 'BUKA';
                        } else {
                            $status = 'TUTUP';
                        }
                    @endphp


                    <div class="col-md-4">
                        <div class="card-lembaga p-4 position-relative">
                            @if ($status === 'BUKA')
                                <span class="status-badge bg-success text-white">🟢 Dibuka</span>
                            @elseif ($status === 'TUTUP')
                                <span class="status-badge bg-secondary text-white">⚪ Ditutup</span>
                            @else
                                <span class="status-badge bg-warning text-dark">🟡 Belum Konfigurasi</span>
                            @endif


                            <div class="mb-4 text-success">
                                <i class="fas {{ $lembaga->icon ?? 'fa-school' }} fa-3x"></i>
                            </div>

                            <h4 class="fw-bold">{{ $lembaga->nama_sekolah }}</h4>
                            <p class="text-muted small">
                                {{ $lembaga->deskripsi ?? 'Pendidikan berkualitas berbasis nilai Islami.' }}</p>
                            <hr>

                            <<div class="d-flex justify-content-between mb-3">
                                <span class="small text-muted">
                                    Kuota:
                                    <strong>{{ $gelombang->kuota ?? '-' }}</strong>
                                </span>
                                <span class="small text-muted">
                                    Sisa:
                                    <strong>
                                        {{ $gelombang ? max($gelombang->kuota - $gelombang->pendaftar_count, 0) : '-' }}
                                    </strong>
                                </span>
                        </div>


                        <div class="d-grid gap-2">
                            @if ($status == 'BUKA')
                                <a href="{{ route('regist', ['sekolah' => $lembaga->id]) }}"
                                    class="btn btn-success fw-bold">Daftar Unit</a>
                            @else
                                <button class="btn btn-secondary fw-bold" disabled>Belum Tersedia</button>
                            @endif

                            <a href="#" class="btn btn-outline-secondary btn-sm">Brosur & Biaya</a>
                        </div>
                    </div>
            </div>
        @empty
            <div class="alert alert-info mt-4 d-flex text-center  align-items-center rounded-pill px-4"
                role="alert">
                <i class="fas fa-info-circle me-3"></i>
                <div class="small">Tidak ada lembaga yang tersedia</div>
            </div>
            @endforelse
        </div>
        </div>
    </section>

    <section class="section-padding bg-white py-5 shadow-sm" id="statistik">
        <div class="container py-4">
            <div class="row g-4 text-center">
                <div class="col-lg-3 col-6">
                    <div class="p-4 rounded-4 border-bottom border-success border-4 bg-light shadow-sm h-100">
                        <i class="fas fa-users fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold text-dark mb-1 counter">1.450</h3>
                        <p class="text-muted small fw-bold text-uppercase mb-0">Total Pendaftar</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="p-4 rounded-4 border-bottom border-success border-4 bg-light shadow-sm h-100">
                        <i class="fas fa-user-check fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold text-dark mb-1 counter">892</h3>
                        <p class="text-muted small fw-bold text-uppercase mb-0">Terverifikasi</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="p-4 rounded-4 border-bottom border-success border-4 bg-light shadow-sm h-100">
                        <i class="fas fa-school fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold text-dark mb-1 counter">558</h3>
                        <p class="text-muted small fw-bold text-uppercase mb-0">Sisa Kuota</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="p-4 rounded-4 border-bottom border-success border-4 bg-light shadow-sm h-100">
                        <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold text-dark mb-1 counter">92%</h3>
                        <p class="text-muted small fw-bold text-uppercase mb-0">Kepuasan Layanan</p>
                    </div>
                </div>
            </div>
            <div class="alert alert-success mt-4 d-flex align-items-center rounded-pill px-4" role="alert">
                <i class="fas fa-info-circle me-3"></i>
                <div class="small">Data statistik diperbarui secara otomatis setiap 5 menit berdasarkan sistem
                    database pusat.</div>
            </div>
        </div>
    </section>

    <section class="section-padding py-5" id="pesantren">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-success fw-bold">KEUNGGULAN KURIKULUM</h6>
                <h2 class="fw-bold">Fokus Pendidikan Pesantren</h2>
                <p class="text-muted">Mencetak santri yang mutafaqqih fiddin dengan spesialisasi khusus.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-4 bg-success text-white text-center">
                            <i class="fas fa-book-open fa-3x mb-3"></i>
                            <h4 class="fw-bold mb-0">Tafaqquh Fiddin</h4>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-success">Fokus Kitab Kuning</h5>
                            <p class="small text-muted">Pendalaman literatur klasik (Turats) meliputi Nahwu, Shorof,
                                Fiqih, dan Ushul Fiqih untuk membentuk nalar hukum Islam yang kuat.</p>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Kajian Fathul Qorib
                                    & Imrithi</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Metode Sorogan &
                                    Bandongan</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden border-top border-success border-4">
                        <div class="p-4 bg-white text-center">
                            <i class="fas fa-quran fa-3x mb-3 text-success"></i>
                            <h4 class="fw-bold mb-0 text-success">Tahfidzul Qur'an</h4>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark">Fokus Al-Qur'an</h5>
                            <p class="small text-muted">Program akselerasi menghafal Al-Qur'an 30 Juz dengan tajwid
                                yang fasih dan pemahaman makna ayat (Tafsir).</p>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Target 30 Juz dalam
                                    3 Tahun</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Sanad Tahfidz Matan
                                    Jazari</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-4 bg-dark text-white text-center">
                            <i class="fas fa-praying-hands fa-3x mb-3 text-warning"></i>
                            <h4 class="fw-bold mb-0">Tarbiyatun Nufus</h4>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark">Fokus Thoriqoh & Adab</h5>
                            <p class="small text-muted">Pembersihan jiwa melalui riyadhoh, dzikir terstruktur, dan
                                penekanan adab (Akhlakul Karimah) di atas ilmu pengetahuan.</p>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Amaliyah Dzikir Pagi
                                    & Petang</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Bimbingan
                                    Mursyid/Kyai Langsung</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" id="brosur">
        <div class="container">
            <div class="bg-success rounded-5 p-5 position-relative overflow-hidden shadow-lg">
                <div class="position-absolute bg-white opacity-10 rounded-circle"
                    style="width: 300px; height: 300px; top: -150px; right: -150px;"></div>
                <div class="position-absolute bg-white opacity-10 rounded-circle"
                    style="width: 200px; height: 200px; bottom: -100px; left: -100px;"></div>

                <div class="row align-items-center position-relative">
                    <div class="col-lg-8 text-white">
                        <h2 class="fw-bold mb-3">Butuh Informasi Lebih Detail?</h2>
                        <p class="mb-0 opacity-90">Unduh brosur resmi kami untuk melihat rincian biaya pendidikan,
                            fasilitas asrama, dan kurikulum lengkap tiap jenjang pendidikan.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <a href="#" class="btn btn-warning btn-lg px-4 py-3 fw-bold rounded-pill shadow">
                            <i class="fas fa-file-pdf me-2"></i>Download Brosur (PDF)
                        </a>
                        <p class="text-white small mt-2 mb-0 opacity-75">Update Terakhir: Januari 2026</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-5 shadow-sm" id="alur">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5">Alur Pendaftaran Online</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h5>Registrasi Akun</h5>
                        <p class="small text-muted">Buat akun menggunakan Email & No. WhatsApp aktif.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h5>Lengkapi Biodata</h5>
                        <p class="small text-muted">Isi data calon siswa dan unggah dokumen pendukung.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h5>Validasi Data</h5>
                        <p class="small text-muted">Admin akan memverifikasi berkas dalam 2x24 jam.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <h5>Selesai</h5>
                        <p class="small text-muted">Cetak kartu ujian dan tunggu jadwal seleksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="parallax-cta text-center">
        <div class="container">
            <h2 class="display-4 fw-bold mb-4">Ayo Daftarkan Putra-Putri Anda!</h2>
            <p class="lead mb-5 px-lg-5">Bergabunglah bersama ribuan santri lainnya untuk mencetak masa depan yang
                gemilang di dunia dan akhirat.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#lembaga" class="btn btn-warning btn-lg px-5 rounded-pill fw-bold">Daftar Sekarang</a>
                <a href="https://wa.me/62812345678" class="btn btn-outline-light btn-lg px-5 rounded-pill"><i
                        class="fab fa-whatsapp me-2"></i>Hubungi Admin</a>
            </div>
        </div>
    </section>

    <section class="py-5" id="faq">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5">
                    <h2 class="fw-bold mb-4">Pertanyaan Sering <br><span class="text-success">Diajukan</span></h2>
                    <p class="text-muted">Masih bingung dengan proses pendaftaran? Berikut jawaban atas pertanyaan yang
                        paling sering muncul.</p>
                    <img src="https://illustrations.popsy.co/white/support.svg" width="300" alt="FAQ">
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden" id="ppdbFAQ">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f1">
                                    Bagaimana cara bayar biaya pendaftaran?
                                </button>
                            </h2>
                            <div id="f1" class="accordion-collapse collapse show" data-bs-parent="#ppdbFAQ">
                                <div class="accordion-body">Pembayaran dapat dilakukan melalui Virtual Account Bank
                                    Syariah Indonesia (BSI) yang muncul setelah Anda melakukan registrasi akun.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#f2">
                                    Apa saja dokumen yang harus diupload?
                                </button>
                            </h2>
                            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#ppdbFAQ">
                                <div class="accordion-body">Dokumen utama meliputi Kartu Keluarga, Akta Kelahiran, Pas
                                    Foto Berwarna, dan Ijazah terakhir/SKL.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body p-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Login Sistem PPDB</h4>
                        <p class="text-muted small">Pilih pintu masuk akses Anda</p>
                    </div>

                    <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab">
                        <li class="nav-item w-50">
                            <button class="nav-link active w-100 rounded-start-pill" data-bs-toggle="pill"
                                data-bs-target="#login-santri">Pendaftar</button>
                        </li>
                        <li class="nav-item w-50">
                            <button class="nav-link w-100 rounded-end-pill" data-bs-toggle="pill"
                                data-bs-target="#login-admin">Admin</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login-santri">
                            <form>
                                <div class="mb-3">
                                    <label class="small fw-bold">No. Pendaftaran</label>
                                    <input type="text" class="form-control rounded-pill"
                                        placeholder="PPDB2026xxxx">
                                </div>
                                <div class="mb-4">
                                    <label class="small fw-bold">Password (Tgl Lahir)</label>
                                    <input type="password" class="form-control rounded-pill" placeholder="DDMMYYYY">
                                </div>
                                <button class="btn btn-success w-100 rounded-pill py-2 fw-bold">MASUK
                                    DASHBOARD</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="login-admin">
                            <form>
                                <div class="mb-3">
                                    <label class="small fw-bold">Email Admin</label>
                                    <input type="email" class="form-control rounded-pill"
                                        placeholder="admin@yayasan.sch.id">
                                </div>
                                <div class="mb-4">
                                    <label class="small fw-bold">Password</label>
                                    <input type="password" class="form-control rounded-pill" placeholder="********">
                                </div>
                                <button class="btn btn-dark w-100 rounded-pill py-2 fw-bold">LOGIN PETUGAS</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <h5 class="text-uppercase">Tentang Yayasan</h5>
                    <p class="text-muted small">Yayasan Pendidikan Unggul berkomitmen mencetak generasi Qur'ani yang
                        menguasai ilmu pengetahuan dan teknologi modern.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5>Navigasi</h5>
                    <a href="#" class="footer-link">Lembaga</a>
                    <a href="#" class="footer-link">Alur Daftar</a>
                    <a href="#" class="footer-link">Biaya Pendidikan</a>
                    <a href="#" class="footer-link">Berita</a>
                </div>
                <div class="col-lg-2">
                    <h5>Layanan</h5>
                    <a href="#" class="footer-link">Download Brosur</a>
                    <a href="#" class="footer-link">Cek Status</a>
                    <a href="#" class="footer-link">Layanan Pengaduan</a>
                </div>
                <div class="col-lg-4" id="kontak">
                    <h5>Kontak Pusat</h5>
                    <p class="small text-muted"><i class="fas fa-map-marker-alt me-2 text-success"></i> Jl. Pendidikan
                        No. 123, Kota Pendidikan, Indonesia</p>
                    <p class="small text-muted"><i class="fas fa-phone me-2 text-success"></i> (021) 1234 5678</p>
                    <p class="small text-muted"><i class="fas fa-envelope me-2 text-success"></i>
                        info@yayasanunggul.sch.id</p>
                </div>
            </div>
            <hr class="mt-5 opacity-10">
            <div class="text-center small text-muted">
                &copy; 2026 Yayasan Pendidikan Unggul Terpadu. Build by Gemini AI.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth Scroll & Navbar change
        window.onscroll = function() {
            var nav = document.querySelector('.navbar');
            if (window.pageYOffset > 50) {
                nav.classList.add('scrolled', 'shadow');
            } else {
                nav.classList.remove('scrolled', 'shadow');
            }
        };

        // Smooth scrolling for links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
