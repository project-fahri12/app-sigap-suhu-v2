@extends('dashboard.layouts.app')

@push('css')
    <style>
        :root {
            --s-belum: #64748b;
            --s-pending: #0891b2;
            --s-invalid: #dc2626;
            --s-valid: #16a34a;
        }

        .content-body { overflow-y: auto; padding: 12px !important; }
        .text-xs { font-size: 10px !important; }
        .text-sm-custom { font-size: 11px !important; }

        .module-card {
            background: white; border-radius: 12px; padding: 15px;
            border: 1px solid #edf2f7; margin-bottom: 12px;
        }

        .section-title {
            font-size: 11px; font-weight: 800; color: #475569;
            text-transform: uppercase; letter-spacing: 0.5px;
            display: flex; align-items: center; gap: 8px;
        }

        .badge-status {
            font-size: 8px; font-weight: 800; padding: 2px 6px;
            border-radius: 4px; display: inline-block; margin-bottom: 8px;
            text-transform: uppercase;
        }

        .upload-box {
            text-align: center; padding: 12px 8px; border: 1px solid #f1f5f9;
            border-radius: 10px; background: white; height: 100%;
            display: flex; flex-direction: column; justify-content: space-between;
            transition: 0.2s; position: relative;
        }

        .badge-required {
            position: absolute; top: -5px; right: -5px;
            background: #ef4444; color: white; font-size: 7px;
            padding: 2px 5px; border-radius: 4px; font-weight: 700;
            z-index: 10;
        }

        .upload-box:hover { border-color: #16a34a; transform: translateY(-2px); }
        .doc-icon { font-size: 20px; margin-bottom: 8px; }
        .doc-name {
            font-size: 10px; font-weight: 700; color: #4a5568;
            line-height: 1.2; min-height: 24px; display: -webkit-box;
            -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }

        .grid-container {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;
        }

        @media (min-width: 576px) { .grid-container { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 992px) { .grid-container { grid-template-columns: repeat(5, 1fr); } }

        .st-belum { background: #f8fafc; color: var(--s-belum); border: 1px solid #e2e8f0; }
        .st-pending { background: #ecfeff; color: var(--s-pending); border: 1px solid #cffafe; }
        .st-invalid { background: #fef2f2; color: var(--s-invalid); border: 1px solid #fee2e2; }
        .st-valid { background: #f0fdf4; color: var(--s-valid); border: 1px solid #dcfce7; }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="mb-3">
            <h6 class="fw-bold mb-0" style="font-size: 14px;">Verifikasi Berkas</h6>
            <p class="text-xs text-muted mb-0">Kelola dokumen persyaratan pendaftaran Anda di sini.</p>
        </div>

        {{-- Panduan --}}
        <div class="module-card bg-light border-0 shadow-sm py-2 mb-3">
            <h6 class="text-xs fw-bold text-success mb-2"><i class="fas fa-lightbulb me-1"></i> INFO STATUS:</h6>
            <div class="row g-2">
                <div class="col-6 col-md-3"><span class="badge-status st-belum w-100 text-center">KOSONG / UPLOAD</span></div>
                <div class="col-6 col-md-3"><span class="badge-status st-pending w-100 text-center">PENDING (DIPROSES)</span></div>
                <div class="col-6 col-md-3"><span class="badge-status st-valid w-100 text-center">VERIFIED (SAH)</span></div>
                <div class="col-6 col-md-3"><span class="badge-status st-invalid w-100 text-center">REJECTED (ULANG)</span></div>
            </div>
        </div>

        @php
            $statusConfig = [
                'verified' => [
                    'badge' => 'st-valid', 'label' => 'VERIFIED', 'color' => 'text-success',
                    'btn' => 'btn-success', 'icon' => 'fa-eye', 'text' => 'LIHAT', 'action' => 'view'
                ],
                'pending' => [
                    'badge' => 'st-pending', 'label' => 'PENDING', 'color' => 'text-info',
                    'btn' => 'btn-secondary disabled', 'icon' => 'fa-clock', 'text' => 'PROSES', 'action' => 'none'
                ],
                'rejected' => [
                    'badge' => 'st-invalid', 'label' => 'REJECTED', 'color' => 'text-danger',
                    'btn' => 'btn-danger', 'icon' => 'fa-sync', 'text' => 'ULANG', 'action' => 'upload'
                ],
                'belum' => [
                    'badge' => 'st-belum', 'label' => 'KOSONG', 'color' => 'text-secondary',
                    'btn' => 'btn-outline-success', 'icon' => 'fa-upload', 'text' => 'UPLOAD', 'action' => 'upload'
                ]
            ];
        @endphp

        {{-- Berkas Utama --}}
        <div class="section-title mb-2 mt-3">
            <i class="fas fa-star text-warning"></i> Berkas Utama (Wajib)
            <hr class="flex-grow-1 my-0 opacity-10">
        </div>
        
        <div class="grid-container mb-4">
            @foreach($finalDocs->whereIn('id', ['form', 'kk', 'akta', 'foto', 'ktp', 'rapor', 'ijazah', 'nisn']) as $doc)
                @php $cfg = $statusConfig[$doc['status']] ?? $statusConfig['belum']; @endphp
                <div class="upload-box shadow-sm">
                    <span class="badge-required">WAJIB</span>
                    <div>
                        <span class="badge-status {{ $cfg['badge'] }}">{{ $cfg['label'] }}</span>
                        <div class="doc-icon {{ $cfg['color'] }}">
                            <i class="fas {{ $doc['i'] }}"></i>
                        </div>
                        <div class="doc-name">{{ $doc['n'] }}</div>
                    </div>

                    @if($cfg['action'] === 'view')
                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn btn-xs {{ $cfg['btn'] }} w-100 fw-bold mt-2 shadow-sm" style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                        </a>
                    @elseif($cfg['action'] === 'upload')
                        <button class="btn btn-xs {{ $cfg['btn'] }} w-100 fw-bold mt-2 shadow-sm" onclick="openUpload('{{ $doc['n'] }}', '{{ $doc['id'] }}')" style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                        </button>
                    @else
                        <button class="btn btn-xs {{ $cfg['btn'] }} w-100 fw-bold mt-2" disabled style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Berkas Pendukung --}}
        <div class="section-title mb-2">
            <i class="fas fa-plus-circle text-primary"></i> Berkas Pendukung (Opsional)
            <hr class="flex-grow-1 my-0 opacity-10">
        </div>
        <div class="grid-container">
            @foreach($finalDocs->whereIn('id', ['pres', 'kps']) as $doc)
                @php $cfg = $statusConfig[$doc['status']] ?? $statusConfig['belum']; @endphp
                <div class="upload-box shadow-sm">
                    <div>
                        <span class="badge-status {{ $cfg['badge'] }}">{{ $cfg['label'] }}</span>
                        <div class="doc-icon {{ $cfg['color'] }}">
                            <i class="fas {{ $doc['i'] }}"></i>
                        </div>
                        <div class="doc-name">{{ $doc['n'] }}</div>
                    </div>

                    @if($cfg['action'] === 'view')
                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn btn-xs {{ $cfg['btn'] }} w-100 fw-bold mt-2 shadow-sm" style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                        </a>
                    @elseif($cfg['action'] === 'upload')
                        <button class="btn btn-xs {{ $cfg['btn'] }} w-100 fw-bold mt-2 shadow-sm" onclick="openUpload('{{ $doc['n'] }}', '{{ $doc['id'] }}')" style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                        </button>
                    @else
                        <button class="btn btn-xs {{ $cfg['btn'] }} w-100 fw-bold mt-2" disabled style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Notifikasi Penolakan --}}
        @php $invalidDocs = collect($finalDocs)->where('status', 'invalid'); @endphp
        @if($invalidDocs->count() > 0)
            <div class="module-card border-start border-3 border-danger bg-light mt-3 py-2">
                <h6 class="text-danger fw-bold text-xs mb-1"><i class="fas fa-exclamation-triangle"></i> PERLU REVISI:</h6>
                @foreach($invalidDocs as $inv)
                    <p class="text-muted text-xs mb-1 italic"><b>{{ $inv['n'] }}:</b> "{{ $inv['keterangan'] ?? 'Berkas tidak jelas atau salah format.' }}"</p>
                @endforeach
            </div>
        @endif
        <div class="py-3"></div>
    </div>

    {{-- Modal Upload --}}
    <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0 text-center d-block">
                    <h6 class="fw-bold text-sm-custom mb-0 mt-2">UPLOAD DOKUMEN</h6>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" style="font-size: 10px;" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pendaftar.upload-berkas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="text-center mb-3">
                            <div class="doc-icon text-primary mb-1"><i class="fas fa-cloud-upload-alt fa-2x"></i></div>
                            <p class="text-xs text-dark mb-0 fw-bold" id="docTargetName"></p>
                        </div>
                        <input type="hidden" name="jenis_berkas" id="docIdInput">
                        <div class="bg-light p-2 rounded-3 border">
                            <input type="file" name="file_berkas" class="form-control form-control-sm text-xs border-0 bg-transparent" required>
                        </div>
                        <p class="mt-2 text-muted text-center" style="font-size: 8px;">Maks. 2MB (PDF/JPG/PNG)</p>
                    </div>
                    <div class="modal-footer border-0 pt-0 justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm w-100 rounded-pill fw-bold text-xs shadow-sm py-2">KONFIRMASI UPLOAD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openUpload(name, id) {
            document.getElementById('docTargetName').innerText = name.toUpperCase();
            document.getElementById('docIdInput').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('modalUpload'));
            myModal.show();
        }
    </script>
@endpush