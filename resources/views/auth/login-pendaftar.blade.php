
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Calon Santri | PPDB Yayasan Pendidikan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-green: #198754;
            --dark-green: #0a2b1c;
            --light-green: #2ecc71;
            --accent-yellow: #ffc107;
            --bg-soft: #f0f4f2;
            --gradient-main: linear-gradient(135deg, #0d5233 0%, #198754 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Container Limit & Center */
        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        /* Card Styling */
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            border: none;
        }

        .login-header {
            background: var(--gradient-main);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }

        /* Background Pattern Overlay */
        .login-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/islamic-art.png');
            opacity: 0.1;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .login-header h4 {
            font-weight: 800;
            position: relative;
            z-index: 1;
            margin-bottom: 5px;
        }

        /* Form Styling */
        .login-body {
            padding: 40px 30px;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--dark-green);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            background: #f8faf9;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            transition: 0.3s;
        }

        .input-group:focus-within {
            border-color: var(--primary-green);
            background: #fff;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--primary-green);
            padding-left: 20px;
        }

        .form-control {
            background: transparent;
            border: none;
            padding: 15px 15px 15px 0;
            font-weight: 600;
            color: var(--dark-green);
        }

        .form-control:focus {
            box-shadow: none;
            background: transparent;
        }

        /* Button Styling */
        .btn-login {
            background: var(--gradient-main);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.4);
            color: white;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .back-link a:hover {
            color: var(--dark-green);
        }

        /* Responsive Fix */
        @media (max-width: 480px) {
            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper animate__animated animate__fadeIn">
        

        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-user-circle"></i>
                <h4>Portal Santri</h4>
                <p class="small mb-0 opacity-75">Gunakan Kode Pendaftaran & PIN Anda</p>
            </div>

            <div class="login-body">
                <form action="dashboard.html" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label">Kode Pendaftaran</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" placeholder="PPDB2026xxxx" required>
                        </div>
                        <div class="form-text text-muted" style="font-size: 0.7rem;">
                            *Dapatkan kode saat pendaftaran awal.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rem">
                            <label class="form-check-label small text-muted" for="rem">Ingat Saya</label>
                        </div>
                        <a href="#" class="small text-success fw-bold text-decoration-none">Bantuan Login?</a>
                    </div>

                    <a href="dashboard pendaftar/dashboard.html" class="btn btn-login">
                        MASUK DASHBOARD <i class="fas fa-arrow-right ms-2"></i>
                    </a>

                </form>

                <div class="back-link">
                    <p class="small text-muted">Belum punya akun? <br>
                    <a href="index.html#lembaga">Daftar Akun Sekarang</a></p>
                </div>
            </div>

            <div class="bg-light p-3 text-center border-top">
                <p class="small mb-0 text-muted">
                    <i class="fab fa-whatsapp text-success me-1"></i> Bantuan: <strong>0812-3456-7890</strong>
                </p>
            </div>
        </div>

        <p class="text-center mt-4 small text-muted opacity-50">
            &copy; 2026 Yayasan Pendidikan Unggul Terpadu
        </p>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('passInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>