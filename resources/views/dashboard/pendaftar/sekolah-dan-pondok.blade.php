@extends('dashboard.layouts.app')

@push('css')
<style>
    /* Standar Compact sesuai acuan */
    .text-xs { font-size: 10px !important; }
    .text-sm-custom { font-size: 11px !important; }
    .fw-800 { font-weight: 800; }
    
    .content-body { padding-bottom: 110px !important; }

    /* Nav Tab Compact */
    .nav-pills-compact .nav-link {
        font-size: 10px; font-weight: 800; color: #64748b;
        text-transform: uppercase; border-radius: 8px; padding: 8px;
    }
    .nav-pills-compact .nav-link.active {
        background: #198754; color: white;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
    }

    /* Floating Island Bar */
    .floating-island {
        position: fixed;
        bottom: -100px; left: 50%;
        transform: translateX(-50%);
        width: 92%; max-width: 480px;
        z-index: 1050;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .floating-island.active { bottom: 20px; }

    .island-content {
        background: #1e293b; color: white;
        padding: 10px 16px; border-radius: 16px;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    /* Card Item Styling */
    .guide-card {
        background: white; border-radius: 12px;
        border: 1px solid #edf2f7; overflow: hidden;
        transition: 0.2s;
    }
    .btn-xs { padding: 4px 8px; font-size: 9px; font-weight: 700; }
    
    /* Radio Button Logic */
    .selected-text { display: none; }
    .btn-check:checked + label { 
        background-color: #198754 !important; 
        color: white !important; 
        border-color: #198754 !important;
    }
    .btn-check:checked + label .select-text { display: none; }
    .btn-check:checked + label .selected-text { display: inline; }

    .border-dashed { border: 2px dashed #e2e8f0 !important; }
</style>
@endpush

@section('content')
@php
    $pendaftar = Auth::user()->pendaftar;
@endphp

<div class="content-body">
    {{-- Header --}}
    <div class="mb-3 d-flex justify-content-between align-items-end">
        <div>
            <h6 class="fw-800 mb-0 text-dark" style="font-size: 14px;">PILIHAN INSTITUSI</h6>
            <p class="text-xs text-muted mb-0">Tentukan sekolah & tempat tinggal santri.</p>
        </div>
        <div class="text-end">
             <span class="badge bg-success-subtle text-success text-xs rounded-pill px-2">TA 2026/2027</span>
        </div>
    </div>

    {{-- Control Panel: Tabs & Search --}}
    <div class="guide-card p-2 shadow-sm mb-3">
        <div class="row g-2">
            <div class="col-7">
                <ul class="nav nav-pills nav-pills-compact bg-light p-1 rounded-3" id="pills-tab" role="tablist">
                    <li class="nav-item w-50">
                        <button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#tab-sekolah">Sekolah</button>
                    </li>
                    <li class="nav-item w-50">
                        <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#tab-pondok">Pondok</button>
                    </li>
                </ul>
            </div>
            <div class="col-5">
                <div class="input-group input-group-sm border rounded-3 overflow-hidden bg-white">
                    <span class="input-group-text border-0 bg-transparent pe-1"><i class="fas fa-search text-muted text-xs"></i></span>
                    <input type="text" id="globalSearch" class="form-control border-0 text-xs shadow-none ps-1" placeholder="Cari...">
                </div>
            </div>
        </div>
    </div>

    {{-- Form Utama --}}
    <form action="{{ route('pendaftar.sekolah-pondok.store') }}" method="POST" id="formPilihan">
        @csrf
        <div class="tab-content" id="pills-tabContent">
            {{-- Bagian Sekolah --}}
            <div class="tab-pane fade show active" id="tab-sekolah">
                @include('dashboard.pendaftar.partials._tab_sekolah')
            </div>

            {{-- Bagian Pondok --}}
            <div class="tab-pane fade" id="tab-pondok">
                @include('dashboard.pendaftar.partials._tab_pondok')
            </div>
        </div>
    </form>

    {{-- Floating Island Bar --}}
    @if($pendaftar->pilih_lembaga != 'selesai')
    <div id="floatingBar" class="floating-island {{ ($pendaftar->sekolah_id || $pendaftar->pondok_id) ? 'active' : '' }}">
        <div class="island-content shadow-lg">
            <div class="d-flex align-items-center">
                <div class="bg-success rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                    <i class="fas fa-check text-white" style="font-size: 9px;"></i>
                </div>
                <div>
                    <h6 class="text-white fw-800 mb-0 text-xs">PILIHAN TERSIMPAN</h6>
                    <p class="text-white-50 text-xs mb-0">Klik tombol kunci untuk finalisasi.</p>
                </div>
            </div>
            <button type="button" class="btn btn-warning btn-xs rounded-pill px-3 py-2 fw-800" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi">
                KUNCI DATA <i class="fas fa-lock ms-1"></i>
            </button>
        </div>
    </div>
    @endif
</div>

{{-- Modal Konfirmasi Minimalis --}}
<div class="modal fade" id="modalKonfirmasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-4">
                <div class="bg-warning-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-shield-alt text-warning fs-5"></i>
                </div>
                <h6 class="fw-800 text-dark text-sm-custom">KONFIRMASI AKHIR</h6>
                <p class="text-xs text-muted">Setelah dikunci, pilihan institusi <b>tidak dapat diubah</b> kembali. Anda yakin?</p>
                <div class="d-grid gap-2 mt-4">
                    <button type="button" onclick="document.getElementById('formPilihan').submit();" class="btn btn-dark fw-800 text-xs py-2 rounded-3 text-uppercase">Ya, Kunci Sekarang</button>
                    <button type="button" class="btn btn-link text-muted text-xs text-decoration-none fw-bold" data-bs-dismiss="modal">Periksa Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('globalSearch');
        const floatingBar = document.getElementById('floatingBar');

        // Search Engine Minimalis
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.col-card').forEach(col => {
                const name = col.getAttribute('data-name').toLowerCase();
                col.style.display = name.includes(query) ? '' : 'none';
            });
        });

        // Toggle Floating Bar
        document.querySelectorAll('.btn-check').forEach(radio => {
            radio.addEventListener('change', () => {
                floatingBar.classList.add('active');
            });
        });
    });
</script>
@endsection