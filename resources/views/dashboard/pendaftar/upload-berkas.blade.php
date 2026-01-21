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

        /* Label Wajib */
        .badge-required {
            position: absolute; top: -5px; right: -5px;
            background: #ef4444; color: white; font-size: 7px;
            padding: 2px 5px; border-radius: 4px; font-weight: 700;
        }

        .upload-box:hover { border-color: #16a34a; transform: translateY(-2px); }
        .doc-icon { font-size: 20px; color: #cbd5e0; margin-bottom: 8px; }
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

        .st-belum { background: #f8fafc; color: var(--s-belum); }
        .st-pending { background: #ecfeff; color: var(--s-pending); }
        .st-invalid { background: #fef2f2; color: var(--s-invalid); }
        .st-valid { background: #f0fdf4; color: var(--s-valid); }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="mb-3">
            <h6 class="fw-bold mb-0" style="font-size: 14px;">Verifikasi Berkas</h6>
            <p class="text-xs text-muted mb-0">Pastikan semua berkas wajib terisi dengan benar.</p>
        </div>

        <div class="module-card bg-light border-0 shadow-sm py-2 mb-3">
            <h6 class="text-xs fw-bold text-success mb-2"><i class="fas fa-lightbulb me-1"></i> PANDUAN UPLOAD:</h6>
            <ul class="mb-0 ps-3 text-xs text-muted">
                <li><b>Rapor & Ijazah:</b> Wajib scan dalam format <b>PDF</b> (Gabungkan semua halaman jadi 1 file).</li>
                <li><b>KK, Akta, Foto:</b> Gunakan format <b>JPG/PNG</b> dengan pencahayaan terang.</li>
                <li><b>Ukuran Maksimal:</b> 2MB per file. Jika terlalu besar, kecilkan (compress) terlebih dahulu.</li>
            </ul>
        </div>

        <div class="section-title mb-2 mt-3">
            <i class="fas fa-star text-warning"></i> Berkas Utama (Wajib)
            <hr class="flex-grow-1 my-0 opacity-10">
        </div>
        <div class="grid-container mb-4">
            @foreach($finalDocs->whereIn('id', ['form', 'kk', 'akta', 'foto', 'ktp', 'rapor', 'ijazah', 'nisn']) as $doc)
                <div class="upload-box shadow-sm">
                    <span class="badge-required">WAJIB</span>
                    <div>
                        <span class="badge-status st-{{ $doc['status'] }}">
                            {{ $doc['status'] == 'belum' ? 'Kosong' : $doc['status'] }}
                        </span>
                        <div class="doc-icon text-{{ $doc['status'] == 'valid' ? 'success' : ($doc['status'] == 'invalid' ? 'danger' : 'secondary') }}">
                            <i class="fas {{ $doc['i'] }}"></i>
                        </div>
                        <div class="doc-name">{{ $doc['n'] }}</div>
                    </div>

                    @php
                        $btnStyle = ['valid' => ['c'=>'btn-success', 'i'=>'fa-eye', 't'=>'LIHAT'], 'pending' => ['c'=>'btn-info text-white', 'i'=>'fa-clock', 't'=>'PROSES'], 'invalid' => ['c'=>'btn-danger', 'i'=>'fa-sync', 't'=>'ULANG']];
                        $curr = $btnStyle[$doc['status']] ?? ['c'=>'btn-outline-success', 'i'=>'fa-upload', 't'=>'UPLOAD'];
                    @endphp

                    @if($doc['status'] === 'valid')
                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn btn-xs {{ $curr['c'] }} w-100 fw-bold mt-2 shadow-sm" style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $curr['i'] }}"></i> {{ $curr['t'] }}
                        </a>
                    @else
                        <button class="btn btn-xs {{ $curr['c'] }} w-100 fw-bold mt-2 shadow-sm" onclick="openUpload('{{ $doc['n'] }}', '{{ $doc['id'] }}')" {{ $doc['status'] === 'pending' ? 'disabled' : '' }} style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                            <i class="fas {{ $curr['i'] }}"></i> {{ $curr['t'] }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="section-title mb-2">
            <i class="fas fa-plus-circle text-primary"></i> Berkas Pendukung (Opsional)
            <hr class="flex-grow-1 my-0 opacity-10">
        </div>
        <div class="grid-container">
            @foreach($finalDocs->whereIn('id', ['pres', 'kps']) as $doc)
                <div class="upload-box shadow-sm">
                    <div>
                        <span class="badge-status st-{{ $doc['status'] }}">{{ $doc['status'] }}</span>
                        <div class="doc-icon text-secondary"><i class="fas {{ $doc['i'] }}"></i></div>
                        <div class="doc-name">{{ $doc['n'] }}</div>
                    </div>
                    <button class="btn btn-xs btn-outline-secondary w-100 fw-bold mt-2" onclick="openUpload('{{ $doc['n'] }}', '{{ $doc['id'] }}')" style="font-size: 9px; border-radius: 6px; padding: 4px 0;">
                        <i class="fas fa-upload"></i> UPLOAD
                    </button>
                </div>
            @endforeach
        </div>

        @php $invalidDocs = collect($finalDocs)->where('status', 'invalid'); @endphp
        @if($invalidDocs->count() > 0)
            <div class="module-card border-start border-3 border-danger bg-light mt-3 py-2">
                <h6 class="text-danger fw-bold text-xs mb-1">Perlu Diperbaiki:</h6>
                @foreach($invalidDocs as $inv)
                    <p class="text-muted text-xs mb-1 italic"><b>{{ $inv['n'] }}:</b> "{{ $inv['keterangan'] ?? 'File tidak sesuai' }}"</p>
                @endforeach
            </div>
        @endif
        <div class="py-3"></div>
    </div>

    <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h6 class="fw-bold text-sm-custom mb-0">Upload Berkas</h6>
                    <button type="button" class="btn-close" style="font-size: 10px;" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pendaftar.upload-berkas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-3">
                        <p class="text-xs text-muted mb-2 text-center fw-bold" id="docTargetName"></p>
                        <input type="hidden" name="jenis_berkas" id="docIdInput">
                        <input type="file" name="file_berkas" class="form-control form-control-sm text-xs shadow-sm" required>
                        <p class="text-center mt-2 text-muted" style="font-size: 8px;">*Pastikan file tidak blur dan terbaca jelas</p>
                    </div>
                    <div class="modal-footer border-0 pt-0 justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm w-100 rounded-pill fw-bold text-xs shadow">Simpan & Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openUpload(name, id) {
            document.getElementById('docTargetName').innerText = name;
            document.getElementById('docIdInput').value = id;
            new bootstrap.Modal(document.getElementById('modalUpload')).show();
        }
    </script>
@endpush