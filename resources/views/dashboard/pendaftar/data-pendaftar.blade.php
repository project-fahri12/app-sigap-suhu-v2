@extends('dashboard.layouts.app')

@if ($pendaftar->status_pendaftaran == 'draft')
    @push('css')
        <style>
            /* Container Stepper */
            .stepper-wrapper {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px;
                position: relative;
            }

            .stepper-item {
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                flex: 1;
                z-index: 2;
            }

            /* Garis Penghubung antar Step */
            .stepper-wrapper::before {
                content: "";
                position: absolute;
                top: 20px;
                left: 10%;
                right: 10%;
                height: 2px;
                background: #e0e0e0;
                z-index: 1;
            }

            .step-counter {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e0e0e0;
                display: flex;
                justify-content: center;
                align-items: center;
                font-weight: bold;
                color: white;
                margin-bottom: 6px;
                transition: all 0.3s ease;
                font-size: 14px;
            }

            .step-name {
                color: #9e9e9e;
                font-weight: 600;
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Status: Sedang Aktif (Biru) */
            .stepper-item.active .step-counter {
                background-color: #0d6efd;
                box-shadow: 0 0 0 5px rgba(13, 110, 253, 0.2);
                transform: scale(1.1);
            }

            .stepper-item.active .step-name {
                color: #0d6efd;
            }

            /* Status: Sudah Selesai (Hijau) */
            .stepper-item.completed .step-counter {
                background-color: #198754;
            }

            .stepper-item.completed .step-name {
                color: #198754;
            }

            /* Validasi Error */
            .is-invalid {
                border-color: #dc3545 !important;
                background-image: none !important;
            }

            .text-xs {
                font-size: 0.75rem;
            }

            @media (max-width: 576px) {
                .step-counter {
                    width: 30px;
                    height: 30px;
                    font-size: 12px;
                }

                .step-name {
                    font-size: 0.6rem;
                }

                .stepper-wrapper::before {
                    top: 15px;
                }
            }
        </style>
    @endpush
    @section('content')
        <div class="content-body">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-5 px-4">
                    <div class="stepper-wrapper">
                        @foreach (['Diri', 'Orang Tua', 'Wali', 'Kontak', 'Final'] as $index => $label)
                            <div class="stepper-item" id="step-{{ $index + 1 }}-indicator">
                                <div class="step-counter">{{ $index + 1 }}</div>
                                <div class="step-name">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>

                    <ul class="nav nav-tabs d-none" id="pendaftaranTab" role="tablist">
                        @for ($i = 1; $i <= 5; $i++)
                            <li class="nav-item">
                                <button class="nav-link" id="t-{{ $i }}" data-bs-toggle="tab"
                                    data-bs-target="#tab-{{ $i }}"></button>
                            </li>
                        @endfor
                    </ul>
                </div>

                <form id="formPendaftaran">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pendaftar->id }}">

                    <div class="tab-content">
                        @include('dashboard.pendaftar.partials._tab_diri') {{-- Harus id="tab-1" --}}
                        @include('dashboard.pendaftar.partials._tab_ortua') {{-- Harus id="tab-2" --}}
                        @include('dashboard.pendaftar.partials._tab_wali') {{-- Harus id="tab-3" --}}
                        @include('dashboard.pendaftar.partials._tab_kontak') {{-- Harus id="tab-4" --}}
                        <div class="tab-pane fade" id="tab-5" role="tabpanel">
                            <div class="text-center py-5 ">
                                <i class="fas fa-check-circle text-success mb-4" style="font-size: 4rem;"></i>
                                <h4 class="fw-bold">Finalisasi Data</h4>
                                <p class="text-muted">Pastikan semua data sudah benar sebelum mengirim.</p>
                                <div class="form-check d-inline-block mt-3 text-start border p-3 m-4 rounded bg-light">
                                    <input class="form-check-input mt-2" type="checkbox" name="checkFinal" id="checkFinal"
                                        value="1">
                                    <label class="form-check-label fw-bold" for="checkFinal">
                                        Saya menyatakan data yang diinput adalah benar dan valid sesuai dokumen asli.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" card-footer bg-light border-0 py-3 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold" id="btnPrev"
                            style="display: none;">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </button>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" id="btnNext">
                                Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                            <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold" id="btnSubmit"
                                style="display: none;">
                                <i class="fas fa-save me-1"></i> SIMPAN & FINALISASI
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $(document).ready(function() {
                // === 1. KONFIGURASI AWAL ===

                // Mengambil last_step dari DB, pastikan minimal adalah 1
                let lastStepDb = parseInt("{{ $pendaftar->last_step }}");
                let currentStep = lastStepDb > 0 ? lastStepDb : 1;
                const totalSteps = 5;

                // Fungsi Sinkronisasi UI (Stepper, Tab, dan Tombol)
                function updateUI() {
                    // Sembunyikan semua tab, tampilkan yang aktif
                    $('.tab-pane').removeClass('show active');
                    $(`#tab-${currentStep}`).addClass('show active');

                    // Update Visual Stepper
                    $('.stepper-item').each(function(index) {
                        let step = index + 1;
                        $(this).removeClass('active completed');

                        if (step < currentStep) {
                            $(this).addClass('completed');
                            $(this).find('.step-counter').html('<i class="fas fa-check"></i>');
                        } else if (step === currentStep) {
                            $(this).addClass('active');
                            $(this).find('.step-counter').text(step);
                        } else {
                            $(this).find('.step-counter').text(step);
                        }
                    });

                    // Kontrol Tombol Navigasi
                    $('#btnPrev').toggle(currentStep > 1);

                    if (currentStep === totalSteps) {
                        $('#btnNext').hide();
                        $('#btnSubmit').show();
                    } else {
                        $('#btnNext').show();
                        $('#btnSubmit').hide();
                    }

                    // Scroll ke atas setiap ganti tab
                    window.scrollTo(0, 0);
                }

                // Jalankan UI pertama kali
                updateUI();

                // === 2. NAVIGASI NEXT & SIMPAN ===
                $('#btnNext').on('click', function() {
                    let btn = $(this);
                    let currentTabPane = $(`.tab-pane.active`);
                    let isValid = true;

                    // Validasi input wajib di tab aktif
                    currentTabPane.find('input[required], select[required], textarea[required]').each(
                function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            isValid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    if (!isValid) {
                        alert("Harap lengkapi semua data wajib sebelum melanjutkan.");
                        return;
                    }

                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                    $.ajax({
                        url: "{{ route('pendaftar.data-pendaftar.update', $pendaftar->id) }}",
                        method: "POST",
                        // Mengirim currentStep agar controller mengupdate last_step di database
                        data: $('#formPendaftaran').serialize() + "&current_step=" + currentStep +
                            "&_method=PUT",
                        success: function(res) {
                            if (res.success) {
                                currentStep++; // Pindah ke tahap berikutnya
                                updateUI();
                            } else {
                                alert("Gagal menyimpan data.");
                            }
                        },
                        error: function() {
                            alert("Terjadi kesalahan pada server.");
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(
                                'Selanjutnya <i class="fas fa-arrow-right"></i>');
                        }
                    });
                });

                // Tombol Previous
                $('#btnPrev').on('click', function() {
                    if (currentStep > 1) {
                        currentStep--;
                        updateUI();
                    }
                });

                // === 3. FINALISASI (SUBMIT AKHIR) ===
                $('#formPendaftaran').on('submit', function(e) {
                    e.preventDefault();

                    if (!$('#checkFinal').is(':checked')) {
                        alert("Harap centang konfirmasi pernyataan kebenaran data.");
                        return;
                    }

                    let btn = $('#btnSubmit');
                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm"></span> Memproses...');

                    $.ajax({
                        url: "{{ route('pendaftar.data-pendaftar.finalisasi') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(res) {
                            if (res.success) {
                                alert(res.message);
                                window.location.href = res.redirect;
                            }
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON?.message || "Gagal melakukan finalisasi.");
                            btn.prop('disabled', false).text("SIMPAN SEMUA DATA");
                        }
                    });
                });

                // === 4. API WILAYAH INDONESIA ===
                const api_url = "https://www.emsifa.com/api-wilayah-indonesia/api";
                const oldProv = "{{ $pendaftar->provinsi }}";
                const oldKab = "{{ $pendaftar->kabupaten }}";
                const oldKec = "{{ $pendaftar->kecamatan }}";
                const oldDesa = "{{ $pendaftar->desa }}";

                function loadProvinsi() {
                    fetch(`${api_url}/provinces.json`)
                        .then(res => res.json())
                        .then(data => {
                            let html = '<option value="">-- Pilih Provinsi --</option>';
                            data.forEach(p => {
                                let sel = (p.name == oldProv) ? 'selected' : '';
                                html +=
                                    `<option value="${p.name}" data-id="${p.id}" ${sel}>${p.name}</option>`;
                            });
                            $('#provinsi').html(html);
                            if (oldProv) $('#provinsi').trigger('change');
                        });
                }

                $('#provinsi').on('change', function() {
                    let id = $(this).find(':selected').data('id');
                    if (!id) return;
                    fetch(`${api_url}/regencies/${id}.json`).then(res => res.json()).then(data => {
                        let html = '<option value="">-- Pilih Kabupaten --</option>';
                        data.forEach(r => {
                            let sel = (r.name == oldKab) ? 'selected' : '';
                            html +=
                                `<option value="${r.name}" data-id="${r.id}" ${sel}>${r.name}</option>`;
                        });
                        $('#kabupaten').html(html);
                        if (oldKab) $('#kabupaten').trigger('change');
                    });
                });

                $('#kabupaten').on('change', function() {
                    let id = $(this).find(':selected').data('id');
                    if (!id) return;
                    fetch(`${api_url}/districts/${id}.json`).then(res => res.json()).then(data => {
                        let html = '<option value="">-- Pilih Kecamatan --</option>';
                        data.forEach(d => {
                            let sel = (d.name == oldKec) ? 'selected' : '';
                            html +=
                                `<option value="${d.name}" data-id="${d.id}" ${sel}>${d.name}</option>`;
                        });
                        $('#kecamatan').html(html);
                        if (oldKec) $('#kecamatan').trigger('change');
                    });
                });

                $('#kecamatan').on('change', function() {
                    let id = $(this).find(':selected').data('id');
                    if (!id) return;
                    fetch(`${api_url}/villages/${id}.json`).then(res => res.json()).then(data => {
                        let html = '<option value="">-- Pilih Desa --</option>';
                        data.forEach(v => {
                            let sel = (v.name == oldDesa) ? 'selected' : '';
                            html += `<option value="${v.name}" ${sel}>${v.name}</option>`;
                        });
                        $('#desa').html(html);
                    });
                });

                loadProvinsi();
            });
        </script>
    @endpush
@else
    @section('content')
        <div class="content-body">
            <div class="container-fluid">
                {{-- ROW UTAMA: Desktop (Side by Side), Mobile (Stack) --}}
                <div class="row">

                    {{-- KOLOM KIRI: FOTO & STATUS --}}
                    <div class="col-xl-4 col-lg-5 mb-4">
                        {{-- Card Selamat --}}
                        <div class="card border-0 shadow-sm rounded-4 text-center mb-4">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-light-success rounded-circle"
                                        style="width: 80px; height: 80px;">
                                        <i class="fas fa-check-circle text-success" style="font-size: 40px;"></i>
                                    </div>
                                </div>
                                <h4 class="fw-bold">Selamat!</h4>
                                <p class="text-muted small">Pendaftaran Anda telah berhasil difinalisasi dan data telah
                                    dikunci.</p>
                            </div>
                        </div>

                        {{-- Card Pas Foto --}}
                        <div class="card border-0 shadow-sm rounded-4 text-center">
                            <div class="card-header bg-white border-0 pt-4">
                                <h6 class="fw-bold mb-0">Pas Foto 3x4</h6>
                            </div>
                            <div class="card-body">
                                <div class="mx-auto shadow-sm border p-1 bg-white"
                                    style="width: 150px; height: 200px; overflow: hidden;">
                                    @if ($pas_foto)
                                        {{-- Gunakan Storage::url untuk path yang benar --}}
                                        {{-- str_replace digunakan untuk membersihkan double slash jika ada --}}
                                        <img src="{{ Storage::url(str_replace('//', '/', $pas_foto)) }}" alt="Pas Foto"
                                            class="img-fluid w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-user text-secondary" style="font-size: 50px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-3 mb-0 small text-uppercase fw-bold text-primary">
                                    {{ $pendaftar->kode_pendaftaran }}</p>

                                <hr class="my-4">

                                <div class="d-grid gap-2">
                                    <a href="{{ route('pendaftar.dashboard') }}"
                                        class="btn btn-primary btn-sm rounded-pill">
                                        <i class="fas fa-th-large me-1"></i> Dashboard
                                    </a>
                                    <a href="#" onclick="window.print()"
                                        class="btn btn-outline-dark btn-sm rounded-pill">
                                        <i class="fas fa-print me-1"></i> Cetak Bukti
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: RINGKASAN DATA --}}
                    <div class="col-xl-8 col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <div class="card-header bg-primary py-3 px-4">
                                <h5 class="mb-0 fw-bold text-white"><i class="fas fa-file-alt me-2"></i>Ringkasan Data</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th colspan="2"
                                                    class="ps-4 py-3 text-uppercase small fw-bold text-secondary">A.
                                                    Informasi Sekolah & Pondok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="35%" class="ps-4 text-muted">Pilihan Sekolah</td>
                                                <td class="fw-bold text-uppercase">:
                                                    {{ $pendaftar->sekolah->nama_sekolah ?? 'Belum Memilih Sekolah' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 text-muted">Pilihan Pondok</td>
                                                <td class="fw-bold text-uppercase">:
                                                    {{ $pendaftar->pondok->nama_pondok ?? 'Tidak Bermukim / Belum Memilih' }}
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead class="table-light border-top">
                                            <tr>
                                                <th colspan="2"
                                                    class="ps-4 py-3 text-uppercase small fw-bold text-secondary">B.
                                                    Identitas Pribadi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 text-muted">Nama Lengkap</td>
                                                <td class="fw-bold">: {{ $pendaftar->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 text-muted">NISN / NIK</td>
                                                <td>: {{ $pendaftar->nisn }} / {{ $pendaftar->nik ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 text-muted">TTL</td>
                                                <td>: {{ $pendaftar->tempat_lahir }},
                                                    {{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d F Y') }}
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead class="table-light border-top">
                                            <tr>
                                                <th colspan="2"
                                                    class="ps-4 py-3 text-uppercase small fw-bold text-secondary">C. Status
                                                    Verifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4 text-muted">Status Data</td>
                                                <td>: <span class="badge rounded-pill bg-success">FINAL / LOCKED</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4 text-muted">Status Berkas</td>
                                                <td>:
                                                    @if ($pendaftar->status_berkas == 'verified')
                                                        <span class="badge rounded-pill bg-primary">DIVERIFIKASI</span>
                                                    @else
                                                        <span
                                                            class="badge rounded-pill bg-warning text-dark">MENUNGGU</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white py-3 px-4">
                                <small class="text-muted"><i>* Dicetak pada: {{ now()->format('d/m/Y H:i') }}</i></small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <style>
            .bg-light-success {
                background-color: rgba(25, 135, 84, 0.1);
            }

            /* Layouting Deskripsi vs Data */
            .table td {
                border-color: #f8f9fa;
            }

            @media (max-width: 991.98px) {

                /* Di Tablet/Mobile, jadikan satu kolom (Stack) */
                .col-xl-4,
                .col-xl-8 {
                    width: 100%;
                }
            }

            @media (max-width: 575.98px) {
                .table td {
                    font-size: 0.8rem;
                    padding: 10px 5px;
                }

                .table td:first-child {
                    width: 45% !important;
                    padding-left: 15px !important;
                }

                .card-body {
                    padding: 1rem;
                }
            }

            @media print {
                body {
                    background: white;
                }

                .btn,
                .sidebar,
                .header,
                .footer,
                .nav-tabs {
                    display: none !important;
                }

                .content-body {
                    margin: 0;
                    padding: 0;
                }

                .row {
                    display: flex;
                    flex-wrap: nowrap;
                }

                .col-lg-5 {
                    width: 30%;
                }

                .col-lg-7 {
                    width: 70%;
                }

                .card {
                    border: 1px solid #eee !important;
                    box-shadow: none !important;
                }
            }
        </style>
    @endsection
@endif
