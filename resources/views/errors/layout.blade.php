<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Global System Control</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-color: #198754;
            --primary-dark: #146c43;
            --bg-light: #f0f4f2;
        }

        body { 
            background: radial-gradient(circle at top right, #e8f5e9, var(--bg-light));
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow: hidden;
        }

        .error-container {
            position: relative;
            z-index: 1;
        }

        .error-card { 
            text-align: center; 
            padding: 50px 40px; 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 30px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.06); 
            max-width: 550px; 
            width: 100%; 
        }

        .error-code { 
            font-size: 120px; 
            font-weight: 800; 
            background: linear-gradient(135deg, var(--primary-color), #2ecc71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1; 
            margin-bottom: 10px;
            letter-spacing: -5px;
        }

        .error-msg { 
            font-size: 18px; 
            color: #6c757d; 
            margin-bottom: 35px; 
            line-height: 1.6;
        }

        .btn-home { 
            background: var(--primary-color); 
            color: white; 
            border-radius: 15px; 
            padding: 15px 35px; 
            text-decoration: none; 
            font-weight: 600;
            display: inline-block;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2);
        }

        .btn-home:hover { 
            background: var(--primary-dark); 
            color: white; 
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(25, 135, 84, 0.3);
        }

        /* Dekorasi Lingkaran Animasi */
        .shape {
            position: absolute;
            background: var(--primary-color);
            border-radius: 50%;
            opacity: 0.05;
            z-index: -1;
            animation: floating 6s infinite ease-in-out;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
    </style>
</head>
<body>
    <div class="shape animate__animated animate__fadeIn" style="width: 200px; height: 200px; top: -50px; left: -50px;"></div>
    <div class="shape animate__animated animate__fadeIn" style="width: 150px; height: 150px; bottom: -30px; right: -30px; animation-delay: 1s;"></div>

    <div class="error-container animate__animated animate__zoomIn">
        <div class="error-card">
            <div class="error-code">@yield('code')</div>
            <h3 class="fw-800 text-dark mb-3">@yield('message')</h3>
            <p class="error-msg">@yield('description')</p>
            
            <div class="animate__animated animate__fadeInUp animate__delay-1s">
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
        
        <div class="text-center mt-4 animate__animated animate__fadeIn animate__delay-2s">
            <small class="text-muted fw-bold">Global System Control &copy; 2026</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>