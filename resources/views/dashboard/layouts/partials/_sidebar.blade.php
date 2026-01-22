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
    {{-- MENU BARU: DAFTAR ULANG --}}
    <a href="{{ route('superadmin.daftar-ulang.index') }}" 
        class="nav-link {{ request()->routeIs('superadmin.daftar-ulang.*') ? 'active' : '' }}">
        <i class="fas fa-user-check"></i> Daftar Ulang
    </a>

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

    <div class="nav-header">Manajemen PPDB</div>
    
    <a href="{{ route('adminsekolah.verifikasi-berkas.index') }}" class="nav-link {{ request()->routeIs('adminsekolah.verifikasi-berkas.index') ? 'active' : '' }}">
        <i class="fas fa-check-double"></i> Verifikasi Berkas
    </a>

            <a href="#" class="nav-link">
                <i class="fas fa-desktop"></i> Monitoring Pendaftar
            </a>

            <a href="{{ route('adminsekolah.gelombang-ppdb.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.gelombang-ppdb.index') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Informasi Gelombang
            </a>

            <div class="nav-header">Akademik & Siswa</div>

            {{-- <a href="#" class="nav-link">
                <i class="fas fa-user-graduate"></i> Calon Siswa
            </a> --}}

            <a href="{{ route('adminsekolah.data-siswa.index') }}" class="nav-link {{ request()->routeIs('adminsekolah.data-siswa.index') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Siswa (Dapodik)
            </a>

            <div class="nav-header">Rombel & Kelas</div>

            <a href="#" class="nav-link">
                <i class="fas fa-school"></i> Data Kelas
            </a>

            <a href="{{ route('adminsekolah.kelola-rombel.index') }}" class="nav-link">
                <i class="fas fa-door-open"></i> Data Rombel
            </a>

            <a href="#" class="nav-link">
                <i class="fas fa-user-tag"></i> Tentukan Rombel
            </a>

            <div class="nav-header">Laporan</div>

            <a href="#" class="nav-link">
                <i class="fas fa-print"></i> Laporan PPDB
            </a>
        @endif

        @if (auth()->user()->role == 'pendaftar')
            <a href="{{ route('pendaftar.panduan.index') }}"
                class="nav-link {{ request()->routeIs('pendaftar.panduan*') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Panduan
            </a>
            <a href="{{ route('pendaftar.upload-berkas.index') }}"
                class="nav-link {{ request()->routeIs('pendaftar.upload-berkas*') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Upload Berkas
            </a>
        @endif

    @endauth

    <div style="height:20px"></div>
</nav>
