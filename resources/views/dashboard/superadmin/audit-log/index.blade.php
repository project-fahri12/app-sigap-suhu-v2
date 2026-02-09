@extends('dashboard.layouts.app')

@push('css')
   <style>
    .table-danger-custom {
        background-color: #fff5f5 !important; /* Latar merah sangat muda */
        border-left: 4px solid #dc3545 !important; /* Garis merah tegas di kiri */
    }
    
    .table-danger-custom:hover {
        background-color: #ffebeb !important;
    }

    /* Animasi getar sedikit untuk baris error baru (opsional) */
    .table-highlight.table-danger-custom {
        animation: shake 0.5s;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(5px); }
        50% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }
</style>
@endpush

@section('content')
<div class="content-body">
    {{-- Header & Live Search --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-4">
            <h4 class="fw-bold text-dark mb-0"><i class="fas fa-terminal me-2 text-primary"></i>Audit Log</h4>
        </div>
        <div class="col-md-5">
            <div class="input-group shadow-sm rounded-pill border overflow-hidden">
                <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="live-search" class="form-control border-0 ps-0" placeholder="Cari aktor, log, atau IP...">
            </div>
        </div>
        <div class="col-md-3 text-md-end">
            <button class="btn btn-danger rounded-pill px-3 shadow-sm" onclick="confirmClearLogs()">
                <i class="fas fa-trash-alt me-1"></i> Bersihkan
            </button>
        </div>
    </div>

    {{-- Tabel Card --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 70vh;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light sticky-top">
                        <tr class="small fw-bold text-muted text-uppercase">
                            <th class="ps-4">Waktu</th>
                            <th>Aktor</th>
                            <th>Level</th>
                            <th>Deskripsi</th>
                            <th class="text-center">IP</th>
                        </tr>
                    </thead>
                    <tbody id="audit-log-body">
                        @if ($logs->count() > 0)
                            @include('dashboard.superadmin.audit-log._list_rows', ['logs' => $logs])
                        @else
                            <tr id="empty-row"><td colspan="5" class="text-center py-5 text-muted">Belum ada aktivitas.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalLogDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <span id="m-badge" class="badge rounded-pill px-3 py-2 mb-2"></span>
                    <h5 class="fw-bold mb-0">Detail Log Aktivitas</h5>
                    <small class="text-muted d-block mt-1" id="m-time"></small>
                </div>
                <div class="row g-3 mb-4 text-center">
                    <div class="col-4 border-end">
                        <small class="text-muted d-block">USER</small>
                        <span id="m-user" class="fw-bold text-primary"></span>
                    </div>
                    <div class="col-4 border-end">
                        <small class="text-muted d-block">IP ADDRESS</small>
                        <code id="m-ip" class="fw-bold"></code>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">MODEL</small>
                        <span id="m-model" class="fw-bold"></span>
                    </div>
                </div>
                <div class="p-3 bg-dark rounded-3 shadow-inner">
                    <label class="small fw-bold text-secondary mb-2 text-uppercase">Log Description / Trace:</label>
                    <pre id="m-desc" class="mb-0 small text-wrap font-monospace" style="color: #00ff41; max-height: 300px; overflow-y: auto;"></pre>
                </div>
                <button type="button" class="btn btn-light w-100 rounded-pill mt-4 shadow-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let lastLogId = {{ $logs->first()->id ?? 0 }};
    let searchQuery = '';

    $(document).ready(function() {
        // 1. LIVE SEARCH (Client-side)
        $('#live-search').on('keyup', function() {
            searchQuery = $(this).val().toLowerCase();
            $('#audit-log-body tr').each(function() {
                let rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.indexOf(searchQuery) > -1);
            });
            checkEmpty();
        });

        // 2. MODAL DETAIL
        $(document).on('click', '.audit-row', function() {
            const row = $(this);
            $('#m-time').text(row.data('fulltime'));
            $('#m-user').text(row.data('user'));
            $('#m-ip').text(row.data('ip'));
            $('#m-model').text(row.data('model') + ' (#' + row.data('modelid') + ')');
            $('#m-desc').text(row.data('desc'));
            $('#m-badge').text(row.data('action')).attr('class', 'badge rounded-pill px-3 py-2 mb-2 ' + row.data('badge-color'));
            new bootstrap.Modal(document.getElementById('modalLogDetail')).show();
        });

        // 3. POLLING DATA BARU (Server-side Search Sync)
        setInterval(function() {
            $.ajax({
                url: "{{ route('superadmin.audit.getLatest') }}",
                data: { last_id: lastLogId, search: searchQuery },
                success: function(res) {
                    if (res.count > 0) {
                        lastLogId = res.new_last_id;
                        let $newRows = $(res.html).hide();
                        
                        $('#empty-row, #no-results-msg').remove();
                        $('#audit-log-body').prepend($newRows);

                        // Sinkronkan visibility jika sedang searching
                        $newRows.each(function() {
                            if (searchQuery !== '' && $(this).text().toLowerCase().indexOf(searchQuery) === -1) {
                                $(this).hide();
                            } else {
                                $(this).fadeIn(800).addClass('table-highlight');
                            }
                        });

                        setTimeout(() => $newRows.removeClass('table-highlight'), 3000);
                        if (res.html.includes('bg-danger')) {
                            new Audio('https://www.soundjay.com/buttons/beep-01a.mp3').play().catch(()=>{});
                        }
                    }
                }
            });
        }, 5000);

        function checkEmpty() {
            $('#no-results-msg').remove();
            if ($('#audit-log-body tr:visible').length === 0) {
                $('#audit-log-body').append('<tr id="no-results-msg"><td colspan="5" class="text-center py-5 text-muted">Tidak ada hasil ditemukan.</td></tr>');
            }
        }
    });

    function confirmClearLogs() {
        Swal.fire({ title: 'Hapus Semua Log?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Bersihkan!' })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('superadmin.audit.clear') }}",
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function() { location.reload(); }
                });
            }
        });
    }
</script>

<style>
    .audit-row { cursor: pointer; transition: 0.2s; border-left: 3px solid transparent; }
    .audit-row:hover { background-color: rgba(0,0,0,0.02); border-left: 3px solid #4e73df; }
    .table-highlight { background-color: #e8f0fe !important; transition: 2s; }
    .table-danger-custom { background-color: #fff5f5 !important; border-left: 3px solid #dc3545 !important; }
    .sticky-top { top: -1px; background: #f8f9fa; z-index: 10; border-bottom: 2px solid #dee2e6; }
    .font-monospace { font-family: 'Fira Code', 'Courier New', monospace; white-space: pre-wrap; }
    .shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.2); }
    #live-search:focus { box-shadow: none; }
</style>
@endpush
@endsection