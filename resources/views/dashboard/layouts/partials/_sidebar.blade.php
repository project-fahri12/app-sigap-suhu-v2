<nav class="nav-custom">

@auth
    {{-- SUPER ADMIN --}}
    @if (auth()->user()->role === 'super-admin')
        <a href="{{ route('superadmin.dashboard') }}"
           class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="nav-header">Konfigurasi Yayasan</div>
        <a href="{{ route('superadmin.tahun-ajaran.index') }}"
           class="nav-link {{ request()->routeIs('superadmin.tahun-ajaran.index') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Tahun Ajaran
        </a>
        <a href="{{ route('superadmin.sekolah.index') }}"
           class="nav-link {{ request()->routeIs('superadmin.sekolah.index') ? 'active' : '' }}">
            <i class="fas fa-school"></i> Unit Sekolah
        </a>
        <a href="{{ route('superadmin.pondok.index') }}"
           class="nav-link {{ request()->routeIs('superadmin.pondok.index') ? 'active' : '' }}">
            <i class="fas fa-mosque"></i> Pondok Pesantren
        </a>

        <div class="nav-header">Data Master</div>
        <a href="{{ route('superadmin.manajemen-user.index') }}"
           class="nav-link {{ request()->routeIs('superadmin.manajemen-user.index') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i> User Manajemen
        </a>

        <div class="nav-header">Monitoring & Laporan</div>
        <a href="#" class="nav-link">
            <i class="fas fa-file-signature"></i> Rekap Pendaftaran
        </a>
        <a href="#" class="nav-link">
            <i class="fas fa-chart-line"></i> Laporan Global
        </a>
    @endif

    {{-- ADMIN SEKOLAH --}}
    @if (auth()->user()->role === 'admin-sekolah')
        <a href="{{ route('adminsekolah.dashboard') }}"
           class="nav-link {{ request()->routeIs('adminsekolah.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="nav-header">Pendaftaran</div>
        <a href="#" class="nav-link">
            <i class="fas fa-file-signature"></i> Monitoring Pendaftar
        </a>

        <div class="nav-header">Informasi</div>
        <a href="{{ route('adminsekolah.gelombang-ppdb.index') }}"
           class="nav-link {{ request()->routeIs('adminsekolah.gelombang-ppdb.index') ? 'active' : '' }}">
            <i class="fas fa-wave-square"></i> Informasi Gelombang
        </a>
    @endif
@endauth

<div style="height:20px"></div>
</nav>
