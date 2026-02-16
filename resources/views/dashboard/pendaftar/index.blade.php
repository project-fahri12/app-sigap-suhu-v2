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

    /* Alur Timeline */
    .timeline-steps { padding: 15px; }
    
    .step-box {
        display: flex; gap: 12px;
        position: relative; padding-bottom: 18px;
    }

    .step-box:last-child { padding-bottom: 0; }

    .step-box:not(:last-child)::after {
        content: ''; position: absolute;
        left: 11px; top: 22px;
        width: 2px; height: calc(100% - 22px);
        background: #198754;
        opacity: 0.2;
    }

    .step-icon {
        width: 24px; height: 24px;
        background: #198754; color: white;
        border-radius: 50%; display: flex;
        align-items: center; justify-content: center;
        font-size: 10px; font-weight: 800;
        z-index: 1; flex-shrink: 0;
        box-shadow: 0 0 0 4px #dcfce7;
    }

    /* State: Pending / Belum Lewat */
    .step-box.pending .step-icon { 
        background: #cbd5e1; 
        color: #64748b;
        box-shadow: 0 0 0 4px #f1f5f9; 
    }
    .step-box.pending .step-info h6 { color: #64748b; }
    .step-box.pending::after { background: #cbd5e1; opacity: 0.2; }

    .step-info h6 {
        font-size: 11px; font-weight: 700;
        margin-bottom: 2px; color: #198754;
    }

    .step-info p {
        font-size: 10px; color: #64748b;
        margin-bottom: 0; line-height: 1.4;
    }

    .group-card {
        border-radius: 10px; padding: 10px;
        display: flex; align-items: center;
        justify-content: space-between;
        background: #f8fafc; border: 1px solid #e2e8f0;
        margin-top: 8px;
    }

    .btn-wa {
        background: #25d366; color: white;
        font-size: 9px; font-weight: 800;
        padding: 5px 10px; border-radius: 6px;
        text-decoration: none; transition: 0.2s;
    }
    
    .btn-wa.disabled {
        background: #cbd5e1; color: #64748b; pointer-events: none; border: none;
    }

    .status-badge-berkas {
        font-size: 9px; padding: 3px 8px; border-radius: 50px;
    }
</style>
@endpush

@section('content')
@php
    $pendaftar = Auth::user()->pendaftar;
    $statusBerkas = $pendaftar->status_berkas ?? 'belum_lengkap';
    $statusPendaftaran = $pendaftar->status_pendaftaran ?? 'proses';
@endphp

<div class="content-body">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0 text-dark"  style="font-size: 14px;">Marhaban, {{ Auth::user()->name }}!</h6>
            <p class="text-xs text-muted mb-0">ID Pendaftar: <span class="fw-bold text-success">{{ $pendaftar->kode_pendaftaran ?? '-' }}</span></p>
        </div>
        <div class="text-end">
            <span class="badge bg-success-subtle text-success text-xs rounded-pill px-2 py-1">T.A 2026/2027</span>
        </div>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-6">
            <div class="p-2 border rounded-3 bg-white shadow-sm">
                <p class="text-xs text-muted mb-1">Status Berkas</p>
                @if($statusBerkas == 'lengkap')
                    <span class="status-badge-berkas bg-success-subtle text-success fw-bold">Lengkap</span>
                @else
                    <span class="status-badge-berkas bg-danger-subtle text-danger fw-bold">Belum Lengkap</span>
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="p-2 border rounded-3 bg-white shadow-sm">
                <p class="text-xs text-muted mb-1">Status Seleksi</p>
                <span class="status-badge-berkas bg-primary-subtle text-primary fw-bold text-uppercase">{{ str_replace('_', ' ', $statusPendaftaran) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="guide-card shadow-sm">
                <div class="p-3 border-bottom bg-light">
                    <h6 class="mb-0 fw-bold text-xs text-uppercase"><i class="fas fa-tasks me-1 text-success"></i> Agenda Pendaftaran</h6>
                </div>
                <div class="timeline-steps">
                    <div class="step-box">
                        <div class="step-icon"><i class="fas fa-user-edit"></i></div>
                        <div class="step-info">
                            <h6>1. Lengkapi Profil & Data Ortu</h6>
                            <p>Lengkapi data identitas pada menu <b>Profil</b>.</p>
                        </div>
                    </div>

                    <div class="step-box">
                        <div class="step-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="step-info">
                            <h6>2. Unggah Berkas Digital</h6>
                            <p>Kirim scan KK & Akta di menu <b>Berkas</b>.</p>
                        </div>
                    </div>

                    <div class="step-box {{ $statusBerkas != 'lengkap' ? 'pending' : '' }}">
                        <div class="step-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                        <div class="step-info">
                            <h6>3. Pembayaran Daftar Ulang</h6>
                            <p>Invoice muncul otomatis setelah berkas diverifikasi.</p>
                        </div>
                    </div>

                    <div class="step-box {{ $statusPendaftaran != 'aktif' ? 'pending' : '' }}">
                        <div class="step-icon"><i class="fas fa-id-card"></i></div>
                        <div class="step-info">
                            <h6>4. Pertemuan Wali Santri</h6>
                            <p>Undangan pertemuan dan pengambilan seragam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="guide-card shadow-sm p-3">
                <h6 class="text-xs fw-800 text-uppercase text-muted mb-3"><i class="fas fa-comments-dollar me-1"></i> Bantuan & Koordinasi</h6>
                
                <p class="text-xs text-muted mb-2">Tombol gabung aktif otomatis setelah berkas <b>Lengkap</b>.</p>

                <div class="group-card shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-xs fw-bold">Grup Calon Santri</h6>
                            <p class="text-xs text-muted mb-0">Info Gelombang 1</p>
                        </div>
                    </div>
                    @if($statusBerkas == 'lengkap')
                        <a href="https://chat.whatsapp.com/XXXX" target="_blank" class="btn-wa shadow-sm"><i class="fas fa-link me-1"></i> GABUNG</a>
                    @else
                        <button class="btn-wa disabled shadow-sm border-0"><i class="fas fa-lock me-1"></i> TERKUNCI</button>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between bg-dark text-white p-2 rounded-3">
                        <div>
                            <p class="text-xs mb-0 opacity-75">Butuh Bantuan?</p>
                            <h6 class="text-xs fw-bold mb-0">Admin PPDB</h6>
                        </div>
                        <a href="https://wa.me/628123456789" class="btn btn-sm btn-light py-1 px-2 fw-bold text-xs">HUBUNGI</a>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning border-0 shadow-sm rounded-3">
                <div class="d-flex gap-2">
                    <i class="fas fa-calendar-alt mt-1"></i>
                    <div>
                        <h6 class="text-xs fw-bold mb-1">Agenda Terdekat</h6>
                        <p class="text-xs mb-0">Penutupan Gelombang 1: <b>30 Maret 2026</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection