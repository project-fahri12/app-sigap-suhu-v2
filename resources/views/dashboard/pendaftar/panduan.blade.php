@extends('dashboard.layouts.app')

@push('css')
<style>
    /* Standar Compact */
    .text-xs { font-size: 10px !important; }
    .text-sm-custom { font-size: 11px !important; }
    
    .guide-card {
        background: white; border-radius: 12px;
        border: 1px solid #edf2f7; margin-bottom: 12px;
        overflow: hidden;
    }

    /* Alur Timeline Full Hijau */
    .timeline-steps { padding: 15px; }
    
    .step-box {
        display: flex; gap: 12px;
        position: relative; padding-bottom: 18px;
    }

    .step-box:last-child { padding-bottom: 0; }

    /* Garis penghubung hijau */
    .step-box:not(:last-child)::after {
        content: ''; position: absolute;
        left: 11px; top: 22px;
        width: 2px; height: calc(100% - 22px);
        background: var(--p-green); /* Full Hijau */
        opacity: 0.3;
    }

    .step-icon {
        width: 24px; height: 24px;
        background: var(--p-green); color: white; /* Full Hijau */
        border-radius: 50%; display: flex;
        align-items: center; justify-content: center;
        font-size: 10px; font-weight: 800;
        z-index: 1; flex-shrink: 0;
        box-shadow: 0 0 0 4px #dcfce7;
    }

    .step-info h6 {
        font-size: 11px; font-weight: 700;
        margin-bottom: 2px; color: #198754;
    }

    .step-info p {
        font-size: 10px; color: #64748b;
        margin-bottom: 0; line-height: 1.4;
    }

    /* Card Grup WhatsApp */
    .group-card {
        border-radius: 10px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        margin-top: 8px;
    }

    .btn-wa {
        background: #25d366; color: white;
        font-size: 9px; font-weight: 800;
        padding: 5px 10px; border-radius: 6px;
        text-decoration: none; transition: 0.2s;
    }
    
    .btn-wa:hover { background: #128c7e; color: white; }

    @media (max-width: 576px) {
        .content-body { padding: 12px !important; }
    }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="mb-3 d-flex justify-content-between align-items-end">
        <div>
            <h6 class="fw-bold mb-0 text-success" style="font-size: 14px;">Panduan Alur Pendaftaran</h6>
            <p class="text-xs text-muted mb-0">Pastikan semua tahapan berwarna hijau</p>
        </div>
        <span class="badge bg-success-subtle text-success text-xs rounded-pill px-2 py-1">T.A 2025/2026</span>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="guide-card shadow-sm">
                <div class="timeline-steps">
                    
                    <div class="step-box">
                        <div class="step-icon"><i class="fas fa-edit"></i></div>
                        <div class="step-info">
                            <h6>1. Isi Berkas Wajib</h6>
                            <p>Upload dokumen utama (KK, Akta, Ijazah/SKL) di menu Berkas.</p>
                        </div>
                    </div>

                    <div class="step-box">
                        <div class="step-icon"><i class="fas fa-check-double"></i></div>
                        <div class="step-info">
                            <h6>2. Verifikasi & Masuk Grup</h6>
                            <p>Setelah data valid, Anda wajib bergabung ke grup koordinasi.</p>
                        </div>
                    </div>

                    <div class="step-box">
                        <div class="step-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="step-info">
                            <h6>3. Daftar Ulang</h6>
                            <p>Pembayaran administrasi dan pengambilan seragam di lokasi.</p>
                        </div>
                    </div>

                    <div class="step-box border-0">
                        <div class="step-icon"><i class="fas fa-user-check"></i></div>
                        <div class="step-info">
                            <h6>4. Selesai</h6>
                            <p>Status pendaftaran berubah menjadi Santri Aktif.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="guide-card shadow-sm p-3">
                <h6 class="text-xs fw-800 text-uppercase text-muted mb-3"><i class="fas fa-users-cog me-1"></i> Grup Koordinasi Resmi</h6>
                
                <div class="group-card shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-xs fw-bold">Grup WA Sekolah</h6>
                            <p class="text-xs text-muted mb-0">Informasi Akademik</p>
                        </div>
                    </div>
                    <a href="#" class="btn-wa shadow-sm"><i class="fab fa-whatsapp me-1"></i> GABUNG</a>
                </div>

                <div class="group-card shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px; background-color: #0d6efd !important;">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-xs fw-bold">Grup WA Pondok</h6>
                            <p class="text-xs text-muted mb-0">Informasi Kesantrian</p>
                        </div>
                    </div>
                    <a href="#" class="btn-wa shadow-sm"><i class="fab fa-whatsapp me-1"></i> GABUNG</a>
                </div>

                <div class="mt-3 p-2 border-top">
                    <p class="text-xs text-center text-muted mb-0 italic">
                        *Tombol gabung aktif otomatis setelah berkas diverifikasi admin.
                    </p>
                </div>
            </div>

            <div class="module-card bg-success text-white border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-xs fw-bold mb-1">Ada Kendala?</h6>
                        <p class="text-xs mb-0 opacity-75">Chat Admin Pusat</p>
                    </div>
                    <i class="fab fa-whatsapp fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="py-3"></div>
</div>
@endsection