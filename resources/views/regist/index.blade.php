<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir PPDB Online | Yayasan Unggul</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --p-green: #198754;
            --s-green: #e9f5ee;
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-pills .nav-link {
            color: #6c757d;
            background: #fff;
            border: 1px solid #dee2e6;
            margin-right: 10px;
            border-radius: 10px;
            font-weight: 600;
            padding: 12px 20px;
        }

        .nav-pills .nav-link.active {
            background-color: var(--p-green);
            color: #fff;
            border-color: var(--p-green);
        }

        .form-section {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-top: 20px;
        }

        .section-title {
            border-left: 4px solid var(--p-green);
            padding-left: 15px;
            margin-bottom: 25px;
            color: var(--p-green);
            font-weight: 700;
        }

        .btn-success-gradient {
            background: linear-gradient(45deg, #198754, #28a745);
            color: white;
            border: none;
        }

        .btn-next,
        .btn-prev {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
            color: white;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pendaftaran Santri Baru</h2>
            <p class="text-muted">Tahun Pelajaran 2025/2026</p>
        </div>

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <ul class="nav nav-pills justify-content-center mb-4" id="ppdbTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="tab1-btn" data-bs-toggle="pill" data-bs-target="#tab1">1.
                    Santri</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tab2-btn" data-bs-toggle="pill" data-bs-target="#tab2">2. Orang
                    Tua</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tab3-btn" data-bs-toggle="pill" data-bs-target="#tab3">3. Wali</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tab4-btn" data-bs-toggle="pill" data-bs-target="#tab4">4. Kontak</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tab5-btn" data-bs-toggle="pill" data-bs-target="#tab5">5. Review</button>
            </li>
        </ul>

        <form id="ppdbForm" action="{{ route('regist.store') }}" method="POST">
            @csrf
            <div class="tab-content">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Mohon Maaf, Ada Kesalahan:</h6>
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @include('regist.pendaftar') {{-- Tab 1 --}}
                @include('regist.orang_tua') {{-- Tab 2 --}}
                @include('regist.wali') {{-- Tab 3 --}}
                @include('regist.info_kontak') {{-- Tab 4 --}}
                @include('regist.preview') {{-- Tab 5 --}}
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 1. Fungsi Navigasi Tab
        function nextTab(tabId) {
            const triggerEl = document.querySelector('#' + tabId + '-btn');
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }

        // 2. Batasi Input Angka (NIK/NISN)
        function limitChar(element, max) {
            if (element.value.length > max) {
                element.value = element.value.slice(0, max);
            }
        }

        // 3. Fungsi Generate Review Data
        function generateReview() {
            const summaryArea = document.getElementById('summaryArea');
            const form = document.getElementById('ppdbForm');
            const formData = new FormData(form);

            // Mapping data untuk ditampilkan di review
            const sections = {
                "Identitas Santri": {
                    "Nama": formData.get('nama_lengkap'),
                    "NIK": formData.get('nik'),
                    "Lembaga": formData.get('pilihan_lembaga')
                },
                "Orang Tua": {
                    "Ayah": formData.get('nama_ayah'),
                    "Ibu": formData.get('nama_ibu'),
                    "Pekerjaan Ayah": formData.get('pekerjaan_ayah')
                },
                "Kontak & Domisili": {
                    "No. WA": formData.get('no_wa'),
                    "Email": formData.get('email'),
                    "Domisili": formData.get('domisili_sekarang')
                }
            };

            let html = '<div class="row">';
            for (const [title, fields] of Object.entries(sections)) {
                html += `
                    <div class="col-md-4 mb-4">
                        <h6 class="fw-bold text-success border-bottom pb-2">${title}</h6>
                        <ul class="list-unstyled">`;
                for (const [label, value] of Object.entries(fields)) {
                    html += `
                        <li class="mb-2">
                            <small class="text-muted d-block">${label}</small>
                            <span class="fw-semibold">${value || '-'}</span>
                        </li>`;
                }
                html += `</ul></div>`;
            }
            html += '</div>';

            summaryArea.innerHTML = html;
            nextTab('tab5');
        }


        const apiWilayah = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        const provSelect = document.getElementById('provinsi');
        const kabSelect = document.getElementById('kabupaten');
        const kecSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa');

        // Load Provinsi
        fetch(`${apiWilayah}/provinces.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(item => {
                    let opt = document.createElement('option');
                    opt.value = item.name; // Simpan Nama
                    opt.dataset.id = item.id; // Simpan ID untuk fetch selanjutnya
                    opt.textContent = item.name;
                    provSelect.appendChild(opt);
                });
                // Logic Handle Old Value jika diperlukan (opsional)
            });

        // Event Change Provinsi
        provSelect.addEventListener('change', function() {
            const id = this.options[this.selectedIndex].dataset.id;
            clearOptions(kabSelect, "-- Pilih Kota --");
            clearOptions(kecSelect, "-- Pilih Kecamatan --");
            clearOptions(desaSelect, "-- Pilih Desa --");

            if (id) {
                fetch(`${apiWilayah}/regencies/${id}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kabSelect.disabled = false;
                        data.forEach(item => {
                            let opt = document.createElement('option');
                            opt.value = item.name;
                            opt.dataset.id = item.id;
                            opt.textContent = item.name;
                            kabSelect.appendChild(opt);
                        });
                    });
            }
        });

        // Event Change Kabupaten
        kabSelect.addEventListener('change', function() {
            const id = this.options[this.selectedIndex].dataset.id;
            clearOptions(kecSelect, "-- Pilih Kecamatan --");
            clearOptions(desaSelect, "-- Pilih Desa --");

            if (id) {
                fetch(`${apiWilayah}/districts/${id}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kecSelect.disabled = false;
                        data.forEach(item => {
                            let opt = document.createElement('option');
                            opt.value = item.name;
                            opt.dataset.id = item.id;
                            opt.textContent = item.name;
                            kecSelect.appendChild(opt);
                        });
                    });
            }
        });

        // Event Change Kecamatan
        kecSelect.addEventListener('change', function() {
            const id = this.options[this.selectedIndex].dataset.id;
            clearOptions(desaSelect, "-- Pilih Desa --");

            if (id) {
                fetch(`${apiWilayah}/villages/${id}.json`)
                    .then(res => res.json())
                    .then(data => {
                        desaSelect.disabled = false;
                        data.forEach(item => {
                            let opt = document.createElement('option');
                            opt.value = item.name;
                            opt.textContent = item.name;
                            desaSelect.appendChild(opt);
                        });
                    });
            }
        });

        function clearOptions(target, placeholder) {
            target.innerHTML = `<option value="">${placeholder}</option>`;
            target.disabled = true;
        }

        // Fungsi Limit Karakter
        function limitChar(element, max) {
            if (element.value.length > max) {
                element.value = element.value.slice(0, max);
            }
        }
    </script>
</body>

</html>
