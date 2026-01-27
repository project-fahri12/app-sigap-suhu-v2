@extends('dashboard.layouts.app')

@section('title', 'Audit Log | Super Admin')

@section('content')
    <div class="content-body">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold">Audit Log Sistem</h4>
                <p class="text-muted small">Riwayat aktivitas seluruh pengguna terpantau secara real-time.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-fingerprint me-2 text-primary"></i>Log Aktivitas</h6>
                <div class="badge bg-light text-success border px-3 py-2 rounded-pill">
                    <span class="spinner-grow spinner-grow-sm me-1" role="status"></span> Real-time Monitoring
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: calc(100vh - 280px); overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top" style="z-index: 10;">
                            <tr class="small fw-bold text-muted text-uppercase">
                                <th class="ps-4">Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th class="text-center">IP Address</th>
                            </tr>
                        </thead>
                        <tbody id="audit-log-body">
                            @include('dashboard.superadmin.audit-log._list_rows', ['logs' => $logs])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Inisialisasi ID terakhir
            let lastLogId = {{ $logs->first()->id ?? 0 }};

            function checkNewLogs() {
                $.ajax({
                    url: "{{ route('superadmin.audit.getLatest') }}",
                    type: 'GET',
                    data: {
                        last_id: lastLogId
                    },
                    dataType: 'json', // Pastikan menerima format JSON
                    success: function(res) {
                        // HANYA jika ada data baru (count > 0)
                        if (res.count > 0 && res.new_last_id > lastLogId) {

                            // 1. UPDATE variabel global agar pemanggilan berikutnya membawa ID terbaru
                            lastLogId = res.new_last_id;

                            // 2. Masukkan konten HTML ke tabel
                            const $rows = $(res.html).hide();
                            $('#audit-log-body').prepend($rows);

                            // 3. Efek visual
                            $rows.fadeIn(800).addClass('table-info');

                            setTimeout(() => {
                                $rows.removeClass('table-info');
                            }, 3000);

                            console.log("Log baru ditambahkan. ID Terbaru: " + lastLogId);
                        }
                    },
                    error: function(xhr) {
                        console.error("Gagal mengambil data: " + xhr.statusText);
                    }
                });
            }

            // Jalankan setiap 5 detik
            setInterval(checkNewLogs, 5000);
        </script>

        <style>
            .table-info {
                transition: background-color 2s ease;
            }

            .sticky-top {
                top: -1px;
            }
        </style>
    @endpush
@endsection
