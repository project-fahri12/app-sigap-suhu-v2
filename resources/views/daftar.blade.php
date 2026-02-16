@extends('partials.app-home')

@section('title', 'Daftar | Subulul Huda')

@section('content')
<section class="py-4 py-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3 p-md-4">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold mb-1">REGISTRASI AWAL</h4>
                            <p class="small text-muted">Isi data calon santri dengan benar</p>
                        </div>

                        <form id="registerForm">
                            @csrf
                            <div class="row g-2">
                                
                                <div class="col-12 mb-1">
                                    <label class="form-label small fw-bold mb-1">NISN</label>
                                    <input type="text" name="nisn" id="nisn" class="form-control form-control-sm" placeholder="10 Digit NISN" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="10">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-nisn"></div>
                                </div>

                                <div class="col-12 mb-1">
                                    <label class="form-label small fw-bold mb-1">NAMA LENGKAP</label>
                                    <input type="text" name="nama" id="nama" class="form-control form-control-sm text-uppercase" placeholder="Nama Sesuai Ijazah">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-nama"></div>
                                </div>

                                <div class="col-12 mb-1">
                                    <label class="form-label small fw-bold mb-1">EMAIL</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="email@contoh.com">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-email"></div>
                                </div>

                                <div class="col-12 mb-1">
                                    <label class="form-label small fw-bold mb-1">NO. WHATSAPP</label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control form-control-sm" placeholder="08xxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-whatsapp"></div>
                                </div>

                                <div class="col-6 mb-1">
                                    <label class="form-label small fw-bold mb-1">TEMPAT LAHIR</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control-sm" placeholder="Kota">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-tempat_lahir"></div>
                                </div>

                                <div class="col-6 mb-1">
                                    <label class="form-label small fw-bold mb-1">TGL LAHIR</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-control-sm">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-tanggal_lahir"></div>
                                </div>

                                <div class="col-12 mb-1">
                                    <label class="form-label small fw-bold mb-1">ASAL SEKOLAH</label>
                                    <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control form-control-sm text-uppercase" placeholder="Sekolah Asal">
                                    <div class="error-text text-danger" style="font-size: 11px; min-height: 15px;" id="error-asal_sekolah"></div>
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" id="btnSubmit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                        <span id="btnText">DAFTAR SEKARANG</span> <i class="fa fa-arrow-right ms-1"></i>
                                    </button>
                                    <div class="text-center mt-3">
                                        <p class="small mb-0">Sudah punya akun? <a href="/" class="text-decoration-none fw-bold">Login Disini</a></p>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-3 p-2 text-center">
                    <p class="text-muted" style="font-size: 0.75rem;">
                        <i class="fa fa-shield-alt me-1"></i> Data Anda tersimpan aman dalam sistem PSB kami.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<style>
    .form-control-sm {
        padding: 0.6rem 0.75rem;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    .form-label { color: #444; }
    .btn-success { background-color: #00c853; border: none; border-radius: 10px; }
    .card { border-radius: 15px; }
    .is-invalid { border-color: #dc3545 !important; }
    
    @media (max-width: 576px) {
        .card-body { padding: 1.25rem !important; }
        .form-label { font-size: 0.75rem; }
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const btn = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const formData = new FormData(form);

        // Reset Error UI
        document.querySelectorAll('.error-text').forEach(el => el.innerText = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

        // Loading State
        btn.disabled = true;
        btnText.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> MEMPROSES...';

        fetch("{{ route('daftar.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                if (data.errors) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Mohon lengkapi data dengan benar'
                    });
                    for (const [key, messages] of Object.entries(data.errors)) {
                        const input = document.getElementById(key);
                        const errorDiv = document.getElementById(`error-${key}`);
                        if (input) input.classList.add('is-invalid');
                        if (errorDiv) errorDiv.innerText = messages[0];
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.message || 'Gagal mendaftar'
                    });
                }
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Toast.fire({
                icon: 'error',
                title: 'Koneksi bermasalah'
            });
        })
        .finally(() => {
            btn.disabled = false;
            btnText.innerHTML = 'DAFTAR SEKARANG <i class="fa fa-arrow-right ms-1"></i>';
        });
    });
</script>
@endpush