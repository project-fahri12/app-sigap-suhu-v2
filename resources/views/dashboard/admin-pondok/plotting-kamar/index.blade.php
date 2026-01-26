@extends('dashboard.layouts.app')

@section('content')
<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Plotting Kamar Santri</h4>
                <p class="text-muted small mb-0">Kelola penempatan santri baru atau pindah kamar santri lama secara massal.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex bg-white p-2 rounded-pill shadow-sm border">
                    <input type="text" id="globalSearch" class="form-control form-control-sm border-0 bg-transparent px-3" placeholder="Cari Nama Santri..." style="width: 250px;">
                    <span class="btn btn-success btn-sm rounded-pill px-3"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-primary border-0 rounded-4 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <ul class="nav nav-pills mb-4 bg-white p-2 rounded-pill shadow-sm d-inline-flex border" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4 fw-bold" id="tab-laki-tab" data-bs-toggle="pill" data-bs-target="#tab-laki" type="button" role="tab">
                    <i class="fas fa-mars me-2"></i>Antrian Laki-laki
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-bold" id="tab-perempuan-tab" data-bs-toggle="pill" data-bs-target="#tab-perempuan" type="button" role="tab">
                    <i class="fas fa-venus me-2"></i>Antrian Perempuan
                </button>
            </li>
        </ul>

        <form action="{{ route('adminpondok.plotting-kamar.store') }}" method="POST" id="formPlotting">
            @csrf
            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tab-laki" role="tabpanel">
                            @include('dashboard.admin-pondok.plotting-kamar.partials.table-santri', [
                                'gender' => 'L', 
                                'data' => $santriBelumPlot->where('pendaftar.jenis_kelamin', 'L')
                            ])
                        </div>

                        <div class="tab-pane fade" id="tab-perempuan" role="tabpanel">
                            @include('dashboard.admin-pondok.plotting-kamar.partials.table-santri', [
                                'gender' => 'P', 
                                'data' => $santriBelumPlot->where('pendaftar.jenis_kelamin', 'P')
                            ])
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="bg-success-subtle text-success p-3 rounded-circle d-inline-block mb-3">
                                    <i class="fas fa-door-open fa-2x"></i>
                                </div>
                                <h6 class="fw-bold">Tujuan Penempatan</h6>
                            </div>

                            <div class="mb-3">
                                <label class="small fw-bold text-muted mb-2">PILIH KAMAR TUJUAN</label>
                                <select name="romkam_id" id="selectKamar" class="form-select rounded-3 border-0 bg-light py-2" required>
                                    <option value="" selected disabled>-- Pilih Kamar --</option>
                                    @foreach($romkams as $rk)
                                        <option value="{{ $rk->id }}" data-gender="{{ $rk->jk }}" class="kamar-option">
                                            [{{ $rk->jk }}] {{ $rk->asrama->nama_asrama }} - {{ $rk->nama_romkam }}
                                        </option>
                                    @endforeach
                                </select>
                                <small id="genderAlert" class="text-danger d-none mt-1" style="font-size: 11px;">
                                    <i class="fas fa-exclamation-triangle"></i> Kamar tidak sesuai gender!
                                </small>
                            </div>

                            <div class="p-3 rounded-3 mb-4 bg-light border border-dashed text-center">
                                <div class="small text-muted mb-1">Santri terpilih:</div>
                                <div class="h3 fw-bold text-success mb-0" id="countSelected">0</div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-3 shadow-sm btn-proses" disabled>
                                PROSES PLOTTING <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .nav-pills .nav-link { color: #6c757d; border: 1px solid transparent; }
    .nav-pills .nav-link.active { background-color: #198754 !important; color: white !important; box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2); }
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .text-success { color: #198754 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .border-dashed { border-style: dashed !important; }
    .table thead th { background-color: #f1f7f5 !important; border: none; font-size: 11px; letter-spacing: 0.5px; }
    .santri-row:hover { background-color: #f8faf9; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectKamar = document.getElementById('selectKamar');
    const btnProses = document.querySelector('.btn-proses');
    const countSpan = document.getElementById('countSelected');
    const kamarOptions = document.querySelectorAll('.kamar-option');
    const globalSearch = document.getElementById('globalSearch');

    // 1. Fungsi Filter Kamar berdasarkan Gender Tab
    function filterKamarByGender() {
        const activeTab = document.querySelector('.tab-pane.active');
        const activeTabGender = activeTab.id === 'tab-laki' ? 'L' : 'P';
        
        selectKamar.value = ""; // Reset pilihan dropdown

        kamarOptions.forEach(option => {
            const kamarGender = option.getAttribute('data-gender');
            option.style.display = (kamarGender === activeTabGender) ? 'block' : 'none';
        });
    }

    // 2. Fungsi Hitung dan Validasi
    function validateAndCount() {
        const activeTab = document.querySelector('.tab-pane.active');
        const checkedCount = activeTab.querySelectorAll('.check-item:checked').length;
        
        countSpan.innerText = checkedCount;
        btnProses.disabled = (checkedCount === 0 || !selectKamar.value);
    }

    // 3. Search Real-time
    globalSearch.addEventListener('input', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.santri-row').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });

    // 4. Event Listeners
    filterKamarByGender(); // Run on load

    document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            document.querySelectorAll('.check-item, .check-all').forEach(i => i.checked = false);
            filterKamarByGender();
            validateAndCount();
        });
    });

    document.querySelectorAll('.check-item, .check-all, #selectKamar').forEach(el => {
        el.addEventListener('change', validateAndCount);
    });

    // Check All Per Tab Logic
    ['L', 'P'].forEach(g => {
        const ca = document.getElementById('checkAll' + g);
        if(ca) {
            ca.addEventListener('change', function() {
                const tab = document.getElementById(g === 'L' ? 'tab-laki' : 'tab-perempuan');
                tab.querySelectorAll('.check-item').forEach(item => {
                    if (item.closest('tr').style.display !== 'none') {
                        item.checked = this.checked;
                    }
                });
                validateAndCount();
            });
        }
    });
});
</script>
@endsection