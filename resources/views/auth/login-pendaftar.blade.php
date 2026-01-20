<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Calon Santri | PPDB 2026</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-green: #198754;
            --dark-green: #0a2b1c;
            --bg-soft: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .login-header {
            background: linear-gradient(135deg, #0d5233 0%, #198754 100%);
            padding: 35px 30px;
            text-align: center;
            color: #ffffff;
        }

        .login-header i { font-size: 2.5rem; margin-bottom: 10px; }
        .login-header h4 { font-weight: 800; margin-bottom: 0; }

        .login-body { padding: 35px 30px; }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--dark-green);
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .input-group {
            background: #f8faf9;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            transition: 0.3s;
        }

        .input-group:focus-within {
            border-color: var(--primary-green);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--primary-green);
            padding-left: 15px;
        }

        .form-control {
            background: transparent;
            border: none;
            padding: 12px 12px 12px 0;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control:focus { box-shadow: none; }

        .btn-login {
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: var(--dark-green);
            transform: translateY(-1px);
            color: white;
        }

        .back-link a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-user-check"></i>
            <h4>Portal Santri</h4>
            <p class="small mb-0 opacity-75">Masukkan Kode Pendaftaran Anda</p>
        </div>

        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger border-0 small fw-bold mb-4" style="border-radius: 10px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('pendaftar.login.submit') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Kode Pendaftaran</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" 
                               name="kode_pendaftaran" 
                               class="form-control @error('kode_pendaftaran') is-invalid @enderror" 
                               placeholder="YYPPSH-2026XXXX" 
                               value="{{ old('kode_pendaftaran') }}" 
                               required 
                               autofocus>
                    </div>
                    @error('kode_pendaftaran')
                        <div class="text-danger mt-1" style="font-size: 0.7rem; font-weight: 700;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rem">
                        <label class="form-check-label small text-muted" for="rem">Ingat Saya</label>
                    </div>
                    <a href="https://wa.me/6281234567890" class="small text-success fw-bold text-decoration-none">Lupa Kode?</a>
                </div>

                <button type="submit" class="btn btn-login">
                    MASUK DASHBOARD <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="small text-muted mb-0">Belum mendaftar? 
                    <a href="{{ url('/register') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a>
                </p>
            </div>
        </div>

        <div class="bg-light p-3 text-center border-top">
            <p class="small mb-0 text-muted">
                &copy; 2026 Yayasan Pendidikan PPDB
            </p>
        </div>
    </div>

</body>
</html>