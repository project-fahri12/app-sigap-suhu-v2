
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir PPDB Online | Yayasan Unggul</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --p-green: #198754;
            --s-green: #e9f5ee;
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Tab Progress Indicator */
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

        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1.5px solid #e9ecef;
        }

        .form-control:focus {
            border-color: var(--p-green);
            box-shadow: none;
        }

        .section-title {
            border-left: 4px solid var(--p-green);
            padding-left: 15px;
            margin-bottom: 25px;
            color: var(--p-green);
            font-weight: 700;
        }

        .btn-next {
            background: var(--p-green);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
        }

        .btn-prev {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .nav-pills .nav-link {
                font-size: 12px;
                padding: 10px;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pendaftaran Santri Baru</h2>
            <p class="text-muted">Lengkapi data dengan teliti. Data dapat disimpan sebagai draft.</p>
        </div>

        <ul class="nav nav-pills justify-content-center mb-4" id="ppdbTab" role="tablist">
            <li class="nav-item"><button class="nav-link active" id="tab1-btn" data-bs-toggle="pill"
                    data-bs-target="#tab1">1. Data Santri</button></li>
            <li class="nav-item"><button class="nav-link" id="tab2-btn" data-bs-toggle="pill" data-bs-target="#tab2">2.
                    Orang Tua</button></li>
            <li class="nav-item"><button class="nav-link" id="tab3-btn" data-bs-toggle="pill" data-bs-target="#tab3">3.
                    Wali</button></li>
            <li class="nav-item"><button class="nav-link" id="tab4-btn" data-bs-toggle="pill" data-bs-target="#tab4">4.
                    Kontak</button></li>
            <li class="nav-item"><button class="nav-link" id="tab5-btn" data-bs-toggle="pill" data-bs-target="#tab5">5.
                    Review</button></li>
        </ul>

        <form id="ppdbForm">
            <div class="tab-content">
                <!-- tab 1 -->
            @include('regist.pendaftar')

                <!-- tab 2 -->
            @include('regist.orang_tua')

                <!-- tab 3 -->
            @include('regist.wali')

                <!-- tab 4 -->
            @include('regist.info_kontak')
                <!-- tab 5 -->
            @include('regist.preview')

            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navigasi Tab
        function nextTab(tabId) {
            var triggerEl = document.querySelector('#' + tabId + '-btn');
            bootstrap.Tab.getInstance(triggerEl).show();
            window.scrollTo(0, 0);
        }

        // Batasi karakter (NIK/NISN)
        function limitChar(element, max) {
            if (element.value.length > max) {
                element.value = element.value.slice(0, max);
            }
        }

        // Fungsi Generate Summary
        function generateSummary() {
            const form = document.getElementById('ppdbForm');
            const formData = new FormData(form);
            let html = '<div class="row">';

            html += `<div class="col-md-6 mb-3"><strong>Santri:</strong> ${formData.get('nama_lengkap')}</div>`;
            html += `<div class="col-md-6 mb-3"><strong>Lembaga:</strong> ${formData.get('pilihan_lembaga')}</div>`;
            html += `<div class="col-md-6 mb-3"><strong>NIK:</strong> ${formData.get('nik')}</div>`;
            html += `<div class="col-md-6 mb-3"><strong>WhatsApp:</strong> ${formData.get('no_wa')}</div>`;
            html += `<div class="col-md-6 mb-3"><strong>Status:</strong> <span class="badge bg-secondary">DRAFT</span></div>`;
            html += '</div>';

            document.getElementById('summaryArea').innerHTML = html;
            nextTab('tab5');
        }

        // Final Action
        document.getElementById('ppdbForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = document.getElementById('finalSubmit');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
            btn.disabled = true;

            setTimeout(() => {
                alert('Pendaftaran Berhasil Terkirim! Silakan login ke dashboard untuk upload berkas.');
                window.location.reload();
            }, 2000);
        });
    </script>

</body>

</html>