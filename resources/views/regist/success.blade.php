<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary-green: #198754;
            --light-green: #f0fdf4;
            --dark-green: #0a2b1c;
        }

        body { 
            background: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0; 
        }

        .card-success { 
            background: white; 
            border-radius: 24px; 
            padding: 2rem; 
            width: 100%;
            max-width: 380px; 
            text-align: center; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: var(--light-green);
            color: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 1.5rem;
        }

        .reg-number-box { 
            background: var(--light-green); 
            border: 2px dashed var(--primary-green); 
            border-radius: 16px; 
            padding: 1rem; 
            margin: 1.5rem 0;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .reg-number-box:hover {
            background: #dcfce7;
            transform: translateY(-2px);
        }

        .reg-number-box:active { transform: scale(0.97); }

        .reg-label { 
            font-size: 11px; 
            font-weight: 800; 
            color: var(--primary-green); 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .reg-id { 
            font-size: 1.75rem; 
            font-weight: 800; 
            color: var(--dark-green);
            margin: 5px 0;
        }

        .btn-finish { 
            background: var(--primary-green); 
            color: white; 
            width: 100%; 
            border: none; 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 15px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(25, 135, 84, 0.2);
        }

        .btn-finish:hover { 
            background: #146c43;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(25, 135, 84, 0.3);
        }

        /* Notifikasi Copy */
        .copy-badge {
            position: absolute;
            top: -10px;
            right: 50%;
            transform: translateX(50%);
            background: var(--dark-green);
            color: white;
            font-size: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .copy-badge.show { opacity: 1; }

        .info-text {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="card-success animate__animated animate__zoomIn">
    <div class="icon-circle animate__animated animate__bounceIn animate__delay-1s">
        <i class="fas fa-check"></i>
    </div>

    <h5 class="fw-bold mb-1" style="color: var(--dark-green);">Alhamdulillah!</h5>
    <p class="text-muted small mb-0">Data pendaftaran berhasil kami terima.</p>

    <div class="reg-number-box" onclick="copyText()">
        <div id="copyBadge" class="copy-badge">Tersalin!</div>
        <span class="reg-label">ID Pendaftaran Anda</span>
        <div class="reg-id" id="kodeID">{{ $pendaftaran->kode_pendaftaran ?? 'maaf, hubungi admin untuk no pendaftaran' }}</div>
        <small class="text-muted" style="font-size: 10px;">
            <i class="far fa-copy me-1"></i> Klik kode untuk menyalin
        </small>
    </div>

    <div class="bg-light p-3 rounded-4 mb-4 text-start border-0">
        <div class="d-flex align-items-start info-text">
            <i class="fas fa-info-circle me-2 mt-1" style="color: var(--primary-green);"></i>
            <span>Simpan ID ini untuk mengecek status pendaftaran atau konfirmasi via WhatsApp admin.</span>
        </div>
    </div>

    <div class="d-grid gap-2">
        <a href="{{ url('/auth/pendaftar') }}" class="btn-finish">
            <i class="fas fa-home me-2"></i> Login
        </a>
        <a href="https://wa.me/628123456789?text=Konfirmasi%20Pendaftaran%20ID%3A%20{{ $kode ?? 'PPDB-26001' }}" 
           target="_blank" class="btn btn-link text-success text-decoration-none fw-bold small">
           <i class="fab fa-whatsapp me-1"></i> Konfirmasi WhatsApp
        </a>
    </div>
</div>

<script>
    function copyText() {
        const textToCopy = document.getElementById("kodeID").innerText;
        const badge = document.getElementById("copyBadge");
        
        navigator.clipboard.writeText(textToCopy).then(() => {
            // Tampilkan badge "Tersalin"
            badge.classList.add('show');
            
            // Sembunyikan setelah 2 detik
            setTimeout(() => {
                badge.classList.remove('show');
            }, 2000);
        });
    }
</script>

</body>
</html>