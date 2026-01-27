<nav class="nav-custom">

    @auth
        {{-- SUPER ADMIN --}}
        @if (auth()->user()->role === 'super-admin')
            {{-- DASHBOARD --}}
            <a href="{{ route('superadmin.dashboard') }}"
                class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            {{-- KONFIGURASI YAYASAN --}}
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

            {{-- PPDB YAYASAN --}}
            <div class="nav-header">PPDB Yayasan</div>

        

            {{-- MENU EXISTING --}}
            <a href="{{ route('superadmin.daftar-ulang.index') }}"
                class="nav-link {{ request()->routeIs('superadmin.daftar-ulang.*') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Daftar Ulang
            </a>

            {{-- DATA MASTER --}}
            <div class="nav-header">Data Master</div>

            <a href="{{ route('superadmin.manajemen-user.index') }}"
                class="nav-link {{ request()->routeIs('superadmin.manajemen-user.index') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> User & Role
            </a>

            {{-- MONITORING --}}
            <div class="nav-header">Monitoring & Laporan</div>

            <a href="{{ route('superadmin.rekap.index') }}" class="nav-link {{ request()->routeIs('superadmin.rekap.index') ? 'active' : '' }} ">
                <i class="fas fa-file-signature"></i> Rekap Pendaftaran
            </a>

            <a href="{{ route('superadmin.rekap-global.index') }}" class="nav-link {{ request()->routeIs('superadmin.rekap-global.index') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan Global
            </a>

            {{-- SISTEM --}}
            <div class="nav-header">Sistem</div>

            {{-- MENU BARU: Audit Log (href sementara) --}}
            <a href="{{ route('superadmin.audit.index') }}" class="nav-link {{ request()->routeIs('superadmin.audit.index') ? 'active' : '' }}">
                <i class="fas fa-shield-alt"></i> Audit Log
            </a>
        @endif


        {{-- ADMIN SEKOLAH --}}
        @if (auth()->user()->role === 'admin-sekolah')
            <a href="{{ route('adminsekolah.dashboard') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-header">Manajemen PPDB</div>

            <a href="{{ route('adminsekolah.verifikasi-berkas.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.verifikasi-berkas.index') ? 'active' : '' }}">
                <i class="fas fa-check-double"></i> Verifikasi Berkas
            </a>

            {{-- <a href="#" class="nav-link">
                <i class="fas fa-desktop"></i> Monitoring Pendaftar
            </a> --}}

            <a href="{{ route('adminsekolah.gelombang-ppdb.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.gelombang-ppdb.index') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Informasi Gelombang
            </a>

            <div class="nav-header">Akademik & Siswa</div>

            {{-- <a href="#" class="nav-link">
                <i class="fas fa-user-graduate"></i> Calon Siswa
            </a> --}}

            <a href="{{ route('adminsekolah.data-siswa.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.data-siswa.index') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Siswa (Dapodik)
            </a>

            <div class="nav-header">Rombel & Kelas</div>

            <a href="{{ route('adminsekolah.kelola-kelas.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.kelola-kelas.index') ? 'active' : '' }}">
                <i class="fas fa-school"></i> Kelola Kelas
            </a>

            <a href="{{ route('adminsekolah.kelola-rombel.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.kelola-rombel.index') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i> Kelola Rombel
            </a>

            <a href="{{ route('adminsekolah.penempatan-rombel.index') }}"
                class="nav-link {{ request()->routeIs('adminsekolah.penempatan-rombel.index') ? 'active' : '' }}">
                <i class="fas fa-user-tag"></i> Penempatan Rombel
            </a>

            <div class="nav-header">Laporan</div>

            <a href="{{ route('adminsekolah.laporan-sekolah') }}" class="nav-link {{ request()->routeIs('adminsekolah.laporan-sekolah') ? 'active' : ''}}">
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



        @if (auth()->user()->role == 'admin-pondok')
            @php
                $jumlahBelumPlot = \App\Models\Santri::whereNull('romkam_id')->count();
            @endphp

            <a href="{{ route('adminpondok.dashboard') }}"
                class="nav-link {{ request()->routeIs('adminpondok.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-header">Manajemen Kamar & Asrama</div>

            <a href="{{ route('adminpondok.asrama.index') }}"
                class="nav-link {{ request()->routeIs('adminpondok.asrama.index') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Data Asrama
            </a>

            <a href="{{ route('adminpondok.romkam.index') }}"
                class="nav-link {{ request()->routeIs('adminpondok.romkam.index') ? 'active' : '' }}">
                <i class="fas fa-door-closed"></i> Master Kamar
            </a>

            <a href="{{ route('adminpondok.plotting-kamar.index', ['type' => 'baru']) }}"
                class="nav-link {{ request()->routeIs('adminpondok.plotting-kamar.index') ? 'active' : '' }} d-flex align-items-center">
                <i class="fas fa-users-cog"></i>
                <span>Plotting Kamar SB</span>
                @if ($jumlahBelumPlot > 0)
                    <span
                        class="badge badge-sm bg-danger ms-auto shadow-sm animate__animated animate__pulse animate__infinite"
                        style="font-size: 0.7rem; border-radius: 50px;">
                        {{ $jumlahBelumPlot }}
                    </span>
                @endif
            </a>

            <div class="nav-header">Akademik Pesantren (Madin)</div>

            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-calendar-alt text-muted"></i> Jadwal Mengaji
            </a>
            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-book-open text-muted"></i> Kurikulum & Kitab
            </a>
            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-user-edit text-muted"></i> Absensi Santri
            </a>

            <div class="nav-header">Ketertiban & Keamanan</div>

            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-user-shield text-muted"></i> Poin Pelanggaran
            </a>
            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-exchange-alt text-muted"></i> Mutasi Kamar
            </a>
            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-key text-muted"></i> Perizinan Keluar
            </a>

            <div class="nav-header">Data & Pengaturan</div>

            <a href="{{ route('adminpondok.daftar-santri.index') }}"
                class="nav-link {{ request()->routeIs('adminpondok.daftar-santri.index') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Database Santri
            </a>

            <a href="javascript:void(0)" class="nav-link nav-disabled" title="Dalam Tahap Pengembangan">
                <i class="fas fa-sliders-h text-muted"></i> Pengaturan Situs
            </a>
        @endif

        <style>
            /* Style untuk menu yang sedang dikembangkan */
            .nav-disabled {
                opacity: 0.6;
                cursor: not-allowed !important;
                background-color: rgba(0, 0, 0, 0.02);
                position: relative;
            }

            .nav-disabled:hover {
                background-color: rgba(0, 0, 0, 0.02) !important;
                color: inherit !important;
            }

            .nav-disabled::after {
                content: 'Dev';
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 9px;
                background: #eee;
                padding: 1px 6px;
                border-radius: 10px;
                color: #888;
                font-weight: bold;
                border: 1px solid #ddd;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('click', function(e) {
                const disabledLink = e.target.closest('.nav-disabled');
                if (disabledLink) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Fitur Belum Tersedia',
                        text: 'Tersedia untuk V2.',
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        </script>

    @endauth

    <div style="height:20px"></div>
</nav>
