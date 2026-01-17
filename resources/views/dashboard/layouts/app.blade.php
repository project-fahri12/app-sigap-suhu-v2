
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin | Panel Kontrol Utama</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/admin/master.css', 'resources/js/app.js'])
    @stack('css')
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="layout-wrapper">
        <aside class="sidebar shadow-sm" id="mainSidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center text-success fw-800">
                    <i class="fas fa-shield-alt me-2 fs-4"></i> SUPER ADMIN
                </div>
            </div>

            <div class="sidebar-menu-container">
              @include('dashboard.layouts.partials._sidebar')
            </div>
            
        </aside>
        
        <main class="main-content">
            
            @include('dashboard.layouts.partials._navbar')

           @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('mainSidebar').classList.toggle('is-active');
            document.getElementById('sidebarOverlay').classList.toggle('is-active');
        }
    </script>
    @stack('js')
</body>

</html>