@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f4f7f6;">
    <div class="container-fluid">
        
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4 position-relative overflow-hidden">
                    <div class="row align-items-center position-relative" style="z-index: 2;">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="bg-white rounded-3 p-2 me-3 shadow-sm text-center" style="width: 60px;">
                                    <i class="fas fa-school text-dark fa-lg"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0 text-white">{{ auth()->user()->sekolah->nama_sekolah ?? 'SMA Terpadu Al-Ikhlas' }}</h3>
                                    <p class="mb-0 opacity-75">Sistem Database Terpusat Unit {{ auth()->user()->sekolah->singkatan ?? 'SMA' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <h2 id="liveClock" class="fw-bold mb-0">00:00:00</h2>
                            <p class="mb-0 small opacity-75" id="liveDate">Selasa, 27 Januari 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="row g-3 mb-4 text-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-bottom border-primary border-4 h-100">
                            <small class="text-muted fw-bold d-block mb-1">PENDAFTAR</small>
                            <h3 class="fw-bold mb-0 counter-value" data-target="156">0</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-bottom border-success border-4 h-100">
                            <small class="text-muted fw-bold d-block mb-1">SISWA AKTIF</small>
                            <h3 class="fw-bold mb-0 counter-value" data-target="842">0</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-bottom border-warning border-4 h-100">
                            <small class="text-muted fw-bold d-block mb-1">ALUMNI</small>
                            <h3 class="fw-bold mb-0 counter-value" data-target="2105">0</h3>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Antrian Verifikasi Berkas</h6>
                        <div class="input-group input-group-sm w-auto">
                            <input type="text" id="searchSiswa" class="form-control border-light bg-light rounded-pill px-3" placeholder="Cari pendaftar...">
                        </div>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table table-hover align-middle mb-0" id="tableSiswa">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th>NAMA</th>
                                    <th>STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="siswa-row">
                                    <td class="fw-bold small">Muhammad Fadhil<br><span class="text-muted" style="font-size: 10px;">REG-1029</span></td>
                                    <td><span class="badge bg-success-subtle text-success px-3 rounded-pill">Lengkap</span></td>
                                    <td class="text-center"><button class="btn btn-sm btn-light btn-detail"><i class="fas fa-eye"></i></button></td>
                                </tr>
                                <tr class="siswa-row">
                                    <td class="fw-bold small">Aisyah Zahra<br><span class="text-muted" style="font-size: 10px;">REG-1030</span></td>
                                    <td><span class="badge bg-warning-subtle text-warning px-3 rounded-pill">Menunggu</span></td>
                                    <td class="text-center"><button class="btn btn-sm btn-light btn-detail"><i class="fas fa-eye"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0">Modul Pengembangan (v2.0)</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="v2-card p-3 rounded-4 mb-3 border border-dashed bg-light pointer" onclick="showV2Info('Kenaikan Kelas Massal')">
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-2 rounded-3 me-3 text-primary shadow-sm">
                                    <i class="fas fa-level-up-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 small">Kenaikan Kelas</h6>
                                    <small class="text-muted" style="font-size: 10px;">Otomatisasi promosi tingkat</small>
                                </div>
                            </div>
                        </div>

                        <div class="v2-card p-3 rounded-4 mb-3 border border-dashed bg-light pointer" onclick="showV2Info('Database Alumni')">
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-2 rounded-3 me-3 text-success shadow-sm">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 small">Data Alumni</h6>
                                    <small class="text-muted" style="font-size: 10px;">Arsip digital lulusan</small>
                                </div>
                            </div>
                        </div>

                        <div class="v2-card p-3 rounded-4 border border-dashed bg-light pointer opacity-75" onclick="showV2Info('E-Rapot Digital')">
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-2 rounded-3 me-3 text-danger shadow-sm">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 small text-muted">E-Rapot & Absensi</h6>
                                    <small class="text-muted" style="font-size: 10px;">Integrasi nilai harian</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .pointer { cursor: pointer; transition: all 0.3s; }
    .v2-card:hover { border-color: #198754; background-color: #f0fff4 !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Live Clock
        function updateClock() {
            const clock = document.getElementById('liveClock');
            if(clock) clock.textContent = new Date().toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Counter Animation Statis
        const counters = document.querySelectorAll('.counter-value');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const updateCount = () => {
                const speed = target / 50;
                if (count < target) {
                    count = Math.ceil(count + speed);
                    counter.innerText = count.toLocaleString();
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            updateCount();
        });

        // 3. Notifikasi v2 Interaktif
        window.showV2Info = function(featureName) {
            Swal.fire({
                title: featureName,
                text: 'Modul ini sedang disinkronkan dengan database unit {{ auth()->user()->sekolah->singkatan ?? "Sekolah" }}. Rilis dijadwalkan pada semester berikutnya.',
                icon: 'info',
                confirmButtonText: 'Tunggu Info Lanjut',
                confirmButtonColor: '#198754',
                showClass: { popup: 'animate__animated animate__fadeInDown' }
            });
        };

        // 4. Search Tabel Statis
        const searchInput = document.getElementById('searchSiswa');
        const tableRows = document.querySelectorAll('.siswa-row');
        
        searchInput.addEventListener('keyup', function() {
            const term = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const name = row.innerText.toLowerCase();
                row.style.display = name.includes(term) ? '' : 'none';
            });
        });

        // 5. Button Detail Simulation
        document.querySelectorAll('.btn-detail').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire('Detail Siswa', 'Membuka profil pendaftar...', 'success');
            });
        });
    });
</script>
@endsection