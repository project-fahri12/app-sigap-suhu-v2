
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Panel Login | Yayasan Pendidikan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --admin-primary: #0a2b1c; 
            --admin-success: #198754;
            --admin-bg: #f4f7f6;
            --gradient-admin: linear-gradient(135deg, #0a2b1c 0%, #198754 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Container & Card */
        .admin-auth-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .admin-login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: none;
        }

        /* Admin Specific Header */
        .admin-header {
            background: var(--gradient-admin);
            padding: 50px 30px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }

        .admin-header::after {
            content: 'ADMINISTRATOR';
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 2px;
            opacity: 0.5;
            border: 1px solid #fff;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .admin-header i {
            font-size: 3.5rem;
            margin-bottom: 15px;
            color: #ffc107; /* Aksen Gold untuk simbol otoritas */
        }

        .admin-header h4 {
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Form Styling */
        .admin-body {
            padding: 40px;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--admin-primary);
            text-transform: uppercase;
        }

        .input-group {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            transition: 0.3s;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--admin-success);
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
        }

        .input-group-text {
            background: #f8fafc;
            border: none;
            color: #64748b;
        }

        .form-control {
            border: none;
            padding: 12px 15px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .form-control:focus {
            box-shadow: none;
        }

        /* Admin Button */
        .btn-admin-login {
            background: var(--admin-primary);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            transition: 0.3s;
            letter-spacing: 0.5px;
        }

        .btn-admin-login:hover {
            background: #000;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Protection Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .security-badge i {
            color: var(--admin-success);
        }

        /* Responsive Fixes */
        @media (max-width: 480px) {
            .admin-body { padding: 30px 20px; }
            .admin-header { padding: 40px 20px; }
        }
    </style>
</head>
<body>

    <div class="admin-auth-wrapper animate__animated animate__fadeIn">
        
        <div class="text-center mb-4">
            <h5 class="fw-bold text-dark">
                <i class="fas fa-shield-alt text-success me-2"></i>
                PPDB SISTEM <span class="text-success">V4.0</span>
            </h5>
        </div>

        <div class="admin-login-card">
            <div class="admin-header">
                <i class="fas fa-user-shield"></i>
                <h4>Staff Login</h4>
                <p class="small mb-0 opacity-75">Sistem Manajemen PPDB Terpadu</p>
            </div>

            <div class="admin-body">
                <form action="admin-dashboard.html" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label">Email / Username Staf</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="text" class="form-control" placeholder="admin@yayasan.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password Keamanan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" id="adminPass" class="form-control" placeholder="••••••••" required>
                            <button class="btn btn-light border-0" type="button" onclick="toggleAdminPass()">
                                <i class="fas fa-eye" id="adminEye"></i>
                            </button>
                        </div>
                    </div>

                    <a href="/dashbaord superadmin/dashboard.html" class="btn btn-admin-login shadow-sm">
                        MASUK PANEL ADMIN <i class="fas fa-sign-in-alt ms-2"></i>
                    </a>

                    <div class="text-center mt-4">
                        <a href="index.html" class="text-decoration-none small text-muted hover-success">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </form>

                <div class="security-badge">
                    <i class="fas fa-lock"></i>
                    <span>Encrypted Connection & Secure Session</span>
                </div>
            </div>
        </div>

        <p class="text-center mt-4 small text-muted">
            Internal Staff Only. Unauthorized access is prohibited.
        </p>
    </div>

    <script>
        function toggleAdminPass() {
            const input = document.getElementById('adminPass');
            const icon = document.getElementById('adminEye');
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