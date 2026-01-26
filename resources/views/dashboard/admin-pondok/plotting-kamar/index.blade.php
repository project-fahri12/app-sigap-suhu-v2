@extends('dashboard.layouts.app')

@section('content')
@php 
    // Deteksi tab aktif dari URL, default ke 'tab-laki'
    $currentTab = request('tab', 'tab-laki'); 
@endphp

<div class="content-body" style="background-color: #f8faf9;">
    <div class="container-fluid">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Plotting Kamar Santri</h4>
                <p class="text-muted small mb-0">Kelola penempatan santri ke asrama secara massal dan efisien.</p>
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
                <button class="nav-link {{ $currentTab == 'tab-laki' ? 'active' : '' }} rounded-pill px-4 fw-bold" 
                    id="tab-laki-tab" data-bs-toggle="pill" data-bs-target="#tab-laki" type="button" role="tab">
                    <i class="fas fa-mars me-2"></i>Antrian L ({{ $santriBelumPlot->where('pendaftar.jenis_kelamin', 'L')->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $currentTab == 'tab-perempuan' ? 'active' : '' }} rounded-pill px-4 fw-bold" 
                    id="tab-perempuan-tab" data-bs-toggle="pill" data-bs-target="#tab-perempuan" type="button" role="tab">
                    <i class="fas fa-venus me-2"></i>Antrian P ({{ $santriBelumPlot->where('pendaftar.jenis_kelamin', 'P')->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $currentTab == 'tab-sudah' ? 'active' : '' }} rounded-pill px-4 fw-bold text-danger" 
                    id="tab-sudah-tab" data-bs-toggle="pill" data-bs-target="#tab-sudah" type="button" role="tab">
                    <i class="fas fa-bed me-2"></i>Terplotting ({{ $plottings->total() }})
                </button>
            </li>
        </ul>

        <div class="row g-4">
            <div id="tableContainer" class="{{ $currentTab == 'tab-sudah' ? 'col-xl-12' : 'col-xl-8' }}">
                <div class="tab-content" id="pills-tabContent">
                    
                    <div class="tab-pane fade {{ $currentTab == 'tab-laki' ? 'show active' : '' }}" id="tab-laki" role="tabpanel">
                        <form action="{{ route('adminpondok.plotting-kamar.store') }}" method="POST" class="formPlotting">
                            @csrf
                            @include('dashboard.admin-pondok.plotting-kamar.partials.table-santri', [
                                'gender' => 'L', 
                                'data' => $santriBelumPlot->where('pendaftar.jenis_kelamin', 'L')
                            ])
                        </form>
                    </div>

                    <div class="tab-pane fade {{ $currentTab == 'tab-perempuan' ? 'show active' : '' }}" id="tab-perempuan" role="tabpanel">
                        <form action="{{ route('adminpondok.plotting-kamar.store') }}" method="POST" class="formPlotting">
                            @csrf
                            @include('dashboard.admin-pondok.plotting-kamar.partials.table-santri', [
                                'gender' => 'P', 
                                'data' => $santriBelumPlot->where('pendaftar.jenis_kelamin', 'P')
                            ])
                        </form>
                    </div>

                    <div class="tab-pane fade {{ $currentTab == 'tab-sudah' ? 'show active' : '' }}" id="tab-sudah" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 py-3">NAMA SANTRI</th>
                                            <th>GENDER</th>
                                            <th>KAMAR SAAT INI</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($plottings as $p)
                                        <tr class="santri-row">
                                            <td class="ps-4">
                                                <span class="fw-bold text-dark">{{ $p->pendaftar->nama_lengkap }}</span><br>
                                                <small class="text-muted">{{ $p->nis }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $p->pendaftar->jenis_kelamin == 'L' ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }} rounded-pill px-3">
                                                    {{ $p->pendaftar->jenis_kelamin }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success-subtle text-success rounded p-2 me-2">
                                                        <i class="fas fa-door-closed"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block" style="font-size: 10px;">{{ $p->romkam->asrama->nama_asrama ?? 'N/A' }}</small>
                                                        <span class="fw-bold small">{{ $p->romkam->nama_romkam ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('adminpondok.plotting-kamar.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Keluarkan santri ini dari kamar?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                        <i class="fas fa-sign-out-alt me-1"></i> Lepas
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <p class="text-muted">Data tidak ditemukan.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-white border-0 py-3">
                                {{ $plottings->appends(['tab' => 'tab-sudah'])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sidebarContainer" class="col-xl-4 {{ $currentTab == 'tab-sudah' ? 'd-none' : '' }}">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="bg-success-subtle text-success p-3 rounded-circle d-inline-block mb-3">
                                <i class="fas fa-door-open fa-2x"></i>
                            </div>
                            <h6 class="fw-bold">Tujuan Penempatan</h6>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2 text-uppercase">Pilih Kamar Tujuan</label>
                            <select id="selectKamar" class="form-select rounded-3 border-0 bg-light py-2 shadow-none">
                                <option value="" selected disabled>-- Pilih Kamar --</option>
                                @foreach($romkams as $rk)
                                    <option value="{{ $rk->id }}" data-gender="{{ $rk->jk }}" class="kamar-option">
                                        [{{ $rk->jk }}] {{ $rk->asrama->nama_asrama }} - {{ $rk->nama_romkam }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="p-3 rounded-3 mb-4 bg-light border border-dashed text-center">
                            <div class="small text-muted mb-1">Santri terpilih:</div>
                            <div class="h3 fw-bold text-success mb-0" id="countSelected">0</div>
                        </div>

                        <button type="button" id="btnSubmitMassal" class="btn btn-success w-100 rounded-pill fw-bold py-3 shadow-sm" disabled>
                            PROSES PLOTTING <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link { color: #6c757d; border: 1px solid transparent; transition: 0.3s; }
    .nav-pills .nav-link.active { background-color: #198754 !important; color: white !important; }
    .nav-pills .nav-link.active.text-danger { background-color: #dc3545 !important; }
    .bg-success-subtle { background-color: #eaf6ed !important; }
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .border-dashed { border-style: dashed !important; }
    .table thead th { background-color: #f1f7f5 !important; border: none; font-size: 11px; letter-spacing: 0.5px; }
    .santri-row:hover { background-color: #f8faf9; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectKamar = document.getElementById('selectKamar');
    const btnSubmitMassal = document.getElementById('btnSubmitMassal');
    const countSpan = document.getElementById('countSelected');
    const globalSearch = document.getElementById('globalSearch');
    const sidebar = document.getElementById('sidebarContainer');
    const tableContainer = document.getElementById('tableContainer');

    // Filter Kamar berdasarkan Gender pada Tab aktif
    function filterKamarByGender() {
        const activeTab = document.querySelector('.tab-pane.active');
        const activeTabGender = activeTab.id === 'tab-laki' ? 'L' : 'P';
        const options = document.querySelectorAll('.kamar-option');
        
        selectKamar.value = ""; 
        options.forEach(opt => {
            opt.style.display = (opt.getAttribute('data-gender') === activeTabGender) ? 'block' : 'none';
        });
    }

    // Hitung Item Terpilih
    function validateAndCount() {
        const activeTab = document.querySelector('.tab-pane.active');
        const checkedItems = activeTab.querySelectorAll('.check-item:checked');
        const count = checkedItems.length;
        
        countSpan.innerText = count;
        btnSubmitMassal.disabled = (count === 0 || !selectKamar.value);
    }

    // Update URL agar tab tidak hilang saat refresh/pagination
    function updateURLParams(tabId) {
        const url = new URL(window.location);
        url.searchParams.set('tab', tabId);
        window.history.pushState({}, '', url);
    }

    // Handle Tab Switch
    document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            const targetId = e.target.getAttribute('data-bs-target').replace('#', '');
            updateURLParams(targetId);

            if (targetId === 'tab-sudah') {
                sidebar.classList.add('d-none');
                tableContainer.className = 'col-xl-12';
            } else {
                sidebar.classList.remove('d-none');
                tableContainer.className = 'col-xl-8';
                filterKamarByGender();
                validateAndCount();
            }
        });
    });

    // Pencarian Real-time
    globalSearch.addEventListener('input', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.santri-row').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });

    // Proses Submit Massal
    btnSubmitMassal.addEventListener('click', function() {
        const activeTab = document.querySelector('.tab-pane.active');
        const activeForm = activeTab.querySelector('form');
        
        if(!selectKamar.value) return alert('Pilih kamar terlebih dahulu!');

        const hiddenKamar = document.createElement('input');
        hiddenKamar.type = 'hidden';
        hiddenKamar.name = 'romkam_id';
        hiddenKamar.value = selectKamar.value;
        
        activeForm.appendChild(hiddenKamar);
        activeForm.submit();
    });

    // Delegasi Event untuk Checkbox & Select
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('check-item') || e.target.classList.contains('check-all') || e.target.id === 'selectKamar') {
            validateAndCount();
        }
    });

    // Check All Logic Per Tab
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

    // Inisialisasi awal saat load
    if ("{{ $currentTab }}" !== 'tab-sudah') {
        filterKamarByGender();
    }
});
</script>
@endsection