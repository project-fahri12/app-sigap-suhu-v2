  <nav class="nav-custom">

      @if (auth()->user()->hasRole('super-admin'))
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
          <a href="{{ route('superadmin.role.index') }}"
              class="nav-link {{ request()->routeIs('superadmin.role.index') ? 'active' : '' }} }}">
              <i class="fas fa-users-cog"></i> Role Manajemen
          </a>
          <a href="{{ route('superadmin.manajemen-user.index') }}"
              class="nav-link {{ request()->routeIs('superadmin.manajemen-user.index') ? 'active' : '' }} }}">
              <i class="fas fa-users-cog"></i> User Manajemen
          </a>

          <div class="nav-header">Monitoring & Laporan</div>
          <a href="rekap-pendaftaran.html" class="nav-link">
              <i class="fas fa-file-signature"></i> Rekap Pendaftaran
          </a>
          <a href="laporan-global.html" class="nav-link">
              <i class="fas fa-chart-line"></i> Laporan Global
          </a>
          <a href="laporan-akhir.html" class="nav-link">
              <i class="fas fa-print"></i> Laporan Akhir
          </a>

          <div class="nav-header">Administrasi</div>
          <a href="daftar-ulang.html" class="nav-link">
              <i class="fas fa-user-check"></i> Daftar Ulang
          </a>

          <div class="nav-header">Kesantrian</div>
          <a href="data-calon-santri.html" class="nav-link">
              <i class="fas fa-user-clock"></i> Data Calon Santri
          </a>
          <a href="data-santri.html" class="nav-link">
              <i class="fas fa-user-graduate"></i> Data Santri
          </a>
      @endif

      {{-- Admin Sekolah --}}

      @if (auth()->user()->hasRole('admin-sekolah'))
          <a href="{{ route('adminsekolah.dashboard') }}"
              class="nav-link {{ request()->routeIs('adminsekolah.dashboard') ? 'active' : '' }}">
              <i class="fas fa-th-large"></i> Dashboard
          </a>

          <!-- Data Pendaftaran -->
          <div class="nav-header">Pendaftaran</div>
          <a href="monitoring-pendaftar.html" class="nav-link ">
              <i class="fas fa-file-signature"></i> Monitoring Pendaftar
          </a>
          <a href="aktivasi-siswa.html" class="nav-link">
              <i class="fas fa-user-check"></i> Aktivasi Siswa Aktif
          </a>

          <!-- Manajemen Akademik -->
          <div class="nav-header">Manajemen Akademik</div>
          <a href="daftar-siswa-aktif.html" class="nav-link">
              <i class="fas fa-users"></i> Daftar Siswa Aktif
          </a>
          <a href="penentuan-rombel.html" class="nav-link">
              <i class="fas fa-chalkboard-teacher"></i> Penentuan Rombel
          </a>

          <!-- Data Master Akademik -->
          <div class="nav-header">Data Master Akademik</div>
          <a href="kelas.html" class="nav-link">
              <i class="fas fa-school"></i> Kelas
          </a>
          <a href="rombel.html" class="nav-link">
              <i class="fas fa-layer-group"></i> Rombel
          </a>

          <!-- Informasi (Read Only) -->
          <div class="nav-header">Informasi</div>
          <a href="{{ route('adminsekolah.gelombang-ppdb.index') }}" class="nav-link {{ request()->routeIs('adminsekolah.gelombang-ppdb.index') ? 'active' : ''}}">
              <i class="fas fa-wave-square"></i> Informasi Gelombang
          </a>
          <a href="kuota-unit.html" class="nav-link">
              <i class="fas fa-chart-pie"></i> Kuota Unit
          </a>

          <!-- Laporan -->
          <div class="nav-header">Laporan Akademik</div>
          <a href="laporan-akademik.html" class="nav-link">
              <i class="fas fa-file-alt"></i> Laporan Akademik
          </a>
      @endif

      <div style="height:20px"></div>
  </nav>
