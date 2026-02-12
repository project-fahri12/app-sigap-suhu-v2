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
                        <img src="https://via.placeholder.com/50/00c853/ffffff?text=SH" alt="Logo">
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

                    <a href="#" class="login-button">LOGIN/MASUK</a>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero-wepper">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="banner-info shadow-md">
                        <img src="{{ asset('assets/kop/logo-kop-pondok.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

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
