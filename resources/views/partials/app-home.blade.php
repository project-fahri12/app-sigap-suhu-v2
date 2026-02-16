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
        @stack('css')

    </head>

    <body>

     {{-- Include navbar element --}}
     @include('partials._navbar')

       <main>
        @yield('content')
       </main>

      {{-- Inlclude footer element --}}
      @include('partials._footer')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const menuToggle = document.getElementById('mobile-menu');
            const navList = document.getElementById('nav-list');

            menuToggle.addEventListener('click', () => {
                navList.classList.toggle('active');
            });
        </script>
        @stack('js')
    </body>

    </html>
