<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Peminjaman Ruangan Sekolah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Figtree',sans-serif;color:#1f2937;line-height:1.6}
        a{text-decoration:none;color:inherit}
        img{max-width:100%}

        /* NAVBAR */
        .navbar{position:fixed;top:0;width:100%;z-index:50;background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);border-bottom:1px solid #e5e7eb;transition:box-shadow .3s}
        .navbar.scrolled{box-shadow:0 4px 20px rgba(0,0,0,0.08)}
        .nav-inner{max-width:1200px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;height:72px}
        .nav-logo{display:flex;align-items:center;gap:12px;font-weight:700;font-size:1.2rem;color:#4f46e5}
        .nav-logo i{font-size:1.5rem}
        .nav-links{display:flex;align-items:center;gap:8px}
        .nav-links a{padding:8px 18px;border-radius:10px;font-weight:500;font-size:0.9rem;transition:all .2s}
        .nav-links a:hover{background:#eef2ff;color:#4f46e5}
        .btn-primary{background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff!important;padding:10px 24px;border-radius:12px;font-weight:600;box-shadow:0 4px 15px rgba(79,70,229,0.3);transition:all .3s}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 25px rgba(79,70,229,0.4)!important;background:linear-gradient(135deg,#4338ca,#6d28d9)!important}

        /* HERO */
        .hero{min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#eef2ff 0%,#f5f3ff 30%,#fdf4ff 60%,#fff1f2 100%);padding:120px 24px 80px;position:relative;overflow:hidden}
        .hero::before{content:'';position:absolute;top:-200px;right:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(124,58,237,0.12),transparent 70%);border-radius:50%}
        .hero::after{content:'';position:absolute;bottom:-150px;left:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(79,70,229,0.1),transparent 70%);border-radius:50%}
        .hero-content{max-width:1200px;width:100%;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:1}
        .hero-text h1{font-size:3.2rem;font-weight:800;line-height:1.15;background:linear-gradient(135deg,#1e1b4b,#4f46e5,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero-text p{font-size:1.15rem;color:#6b7280;margin-top:20px;line-height:1.7}
        .hero-buttons{display:flex;gap:16px;margin-top:36px;flex-wrap:wrap}
        .btn-secondary{background:#fff;color:#4f46e5;padding:14px 32px;border-radius:12px;font-weight:600;border:2px solid #e0e7ff;transition:all .3s}
        .btn-secondary:hover{border-color:#4f46e5;transform:translateY(-2px);box-shadow:0 6px 20px rgba(79,70,229,0.15)}
        .hero-stats{display:flex;gap:32px;margin-top:40px}
        .hero-stat{text-align:center}
        .hero-stat .num{font-size:2rem;font-weight:800;color:#4f46e5}
        .hero-stat .label{font-size:0.8rem;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px}

        /* HERO ILLUSTRATION */
        .hero-illustration{display:flex;justify-content:center;align-items:center}
        .illustration-card{background:white;border-radius:24px;padding:40px;box-shadow:0 25px 60px rgba(79,70,229,0.12);width:100%;max-width:440px;position:relative}
        .illustration-card .header-bar{display:flex;align-items:center;gap:12px;margin-bottom:24px}
        .header-bar .dot{width:12px;height:12px;border-radius:50%}
        .header-bar .dot.r{background:#ef4444}.header-bar .dot.y{background:#f59e0b}.header-bar .dot.g{background:#22c55e}
        .header-bar span{margin-left:auto;font-size:0.75rem;color:#9ca3af}
        .illust-row{display:flex;align-items:center;gap:14px;padding:14px;background:#f9fafb;border-radius:14px;margin-bottom:12px;transition:all .2s}
        .illust-row:hover{background:#eef2ff;transform:translateX(4px)}
        .illust-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;flex-shrink:0}
        .illust-row .info h4{font-size:0.9rem;font-weight:600;color:#1f2937}
        .illust-row .info p{font-size:0.75rem;color:#9ca3af}
        .illust-badge{position:absolute;bottom:-16px;right:-16px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;padding:12px 20px;border-radius:14px;font-weight:700;font-size:0.85rem;box-shadow:0 8px 25px rgba(34,197,94,0.3);display:flex;align-items:center;gap:8px}

        /* FEATURES */
        .features{padding:100px 24px;background:#fff}
        .section-title{text-align:center;margin-bottom:60px}
        .section-title .tag{display:inline-block;background:#eef2ff;color:#4f46e5;padding:6px 16px;border-radius:20px;font-size:0.8rem;font-weight:600;margin-bottom:12px}
        .section-title h2{font-size:2.4rem;font-weight:800;color:#1f2937}
        .section-title p{color:#6b7280;margin-top:12px;font-size:1.05rem}
        .features-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:32px}
        .feature-card{background:white;border:1px solid #f3f4f6;border-radius:20px;padding:36px;transition:all .3s;position:relative;overflow:hidden}
        .feature-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(79,70,229,0.1);border-color:#e0e7ff}
        .feature-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:20px 20px 0 0;opacity:0;transition:opacity .3s}
        .feature-card:nth-child(1)::before{background:linear-gradient(90deg,#4f46e5,#7c3aed)}
        .feature-card:nth-child(2)::before{background:linear-gradient(90deg,#22c55e,#16a34a)}
        .feature-card:nth-child(3)::before{background:linear-gradient(90deg,#f59e0b,#ea580c)}
        .feature-card:hover::before{opacity:1}
        .feature-icon{width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:20px}
        .feature-card:nth-child(1) .feature-icon{background:#eef2ff;color:#4f46e5}
        .feature-card:nth-child(2) .feature-icon{background:#ecfdf5;color:#22c55e}
        .feature-card:nth-child(3) .feature-icon{background:#fff7ed;color:#f59e0b}
        .feature-card h3{font-size:1.2rem;font-weight:700;color:#1f2937;margin-bottom:10px}
        .feature-card p{color:#6b7280;font-size:0.9rem;line-height:1.7}

        /* HOW IT WORKS */
        .how-it-works{padding:100px 24px;background:linear-gradient(180deg,#f9fafb,#fff)}
        .steps{max-width:900px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:40px;position:relative}
        .steps::before{content:'';position:absolute;top:40px;left:15%;right:15%;height:3px;background:linear-gradient(90deg,#4f46e5,#7c3aed,#a855f7);border-radius:2px}
        .step{text-align:center;position:relative;z-index:1}
        .step-num{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:1.8rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 10px 30px rgba(79,70,229,0.25)}
        .step h3{font-size:1.1rem;font-weight:700;color:#1f2937;margin-bottom:8px}
        .step p{color:#6b7280;font-size:0.9rem}

        /* CTA */
        .cta{padding:100px 24px;background:linear-gradient(135deg,#4f46e5,#7c3aed);text-align:center;position:relative;overflow:hidden}
        .cta::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle,rgba(255,255,255,0.05),transparent 50%)}
        .cta h2{font-size:2.4rem;font-weight:800;color:#fff;position:relative}
        .cta p{color:rgba(255,255,255,0.85);font-size:1.1rem;margin-top:16px;position:relative}
        .cta-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:#4f46e5;padding:16px 40px;border-radius:14px;font-weight:700;font-size:1.05rem;margin-top:36px;box-shadow:0 10px 30px rgba(0,0,0,0.15);transition:all .3s;position:relative}
        .cta-btn:hover{transform:translateY(-3px);box-shadow:0 15px 40px rgba(0,0,0,0.2)}

        /* FOOTER */
        footer{padding:40px 24px;background:#1f2937;text-align:center;color:#9ca3af;font-size:0.85rem}
        footer span{color:#a78bfa}

        /* RESPONSIVE */
        @media(max-width:900px){
            .hero-content{grid-template-columns:1fr;text-align:center}
            .hero-buttons{justify-content:center}
            .hero-stats{justify-content:center}
            .hero-illustration{margin-top:40px}
            .features-grid{grid-template-columns:1fr}
            .steps{grid-template-columns:1fr}
            .steps::before{display:none}
            .hero-text h1{font-size:2.2rem}
            .nav-links .desktop-only{display:none}
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">
            <i class="fas fa-door-open" style="font-size: 1.5rem;"></i>
            Ruang Peminjaman
        </a>
        <div class="nav-links">
            @auth
                <a href="{{ url('/dashboard') }}" class="desktop-only">Dashboard</a>
                <a href="{{ url('/dashboard') }}" class="btn-primary">Buka Dashboard <i class="fas fa-arrow-right" style="margin-left:4px"></i></a>
            @else
                <a href="{{ route('login') }}" class="desktop-only">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang <i class="fas fa-arrow-right" style="margin-left:4px"></i></a>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Kelola Peminjaman Ruangan Sekolah Lebih Mudah</h1>
            <p>Sistem digital untuk mengelola peminjaman ruang kelas, laboratorium, aula, dan fasilitas sekolah lainnya — cepat, transparan, dan tanpa ribet.</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary"><i class="fas fa-tachometer-alt"></i> Buka Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary"><i class="fas fa-rocket"></i> Mulai Sekarang</a>
                    <a href="{{ route('login') }}" class="btn-secondary"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                @endauth
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="num">{{ \App\Models\Room::where('is_active', true)->count() }}</div>
                    <div class="label">Ruangan</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ \App\Models\Booking::where('status', 'approved')->count() }}</div>
                    <div class="label">Booking Disetujui</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ \App\Models\ClassRoom::count() }}</div>
                    <div class="label">Kelas Terdaftar</div>
                </div>
            </div>
        </div>

        <div class="hero-illustration">
            <div class="illustration-card">
                <div class="header-bar">
                    <span class="dot r"></span>
                    <span class="dot y"></span>
                    <span class="dot g"></span>
                    <span>Ruang Peminjaman</span>
                </div>
                <div class="illust-row">
                    <div class="illust-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed)"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="info"><h4>Ruang Kelas 101</h4><p>Kelas · Kapasitas 36</p></div>
                </div>
                <div class="illust-row">
                    <div class="illust-icon" style="background:linear-gradient(135deg,#8b5cf6,#a855f7)"><i class="fas fa-flask"></i></div>
                    <div class="info"><h4>Lab Komputer</h4><p>Lab · Kapasitas 30</p></div>
                </div>
                <div class="illust-row">
                    <div class="illust-icon" style="background:linear-gradient(135deg,#f59e0b,#ea580c)"><i class="fas fa-building"></i></div>
                    <div class="info"><h4>Aula Utama</h4><p>Aula · Kapasitas 200</p></div>
                </div>
                <div class="illust-badge"><i class="fas fa-check-circle"></i> Booking Disetujui</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features">
    <div class="section-title">
        <span class="tag"><i class="fas fa-star"></i> Fitur Utama</span>
        <h2>Kemudahan dalam Genggaman</h2>
        <p>Semua yang dibutuhkan untuk mengelola peminjaman ruangan dalam satu platform</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
            <h3>Booking Online</h3>
            <p>Ajukan peminjaman ruangan kapan saja dan dari mana saja. Pilih ruang, isi kegiatan, atur jadwal — selesai.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-bolt"></i></div>
            <h3>Approval Cepat</h3>
            <p>Admin dapat menyetujui atau menolak permohonan booking secara real-time. Anda akan mendapat notifikasi instan.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
            <h3>Dashboard Statistik</h3>
            <p>Pantau penggunaan ruangan, jumlah booking aktif, dan status permohonan dalam satu tampilan ringkas.</p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-it-works">
    <div class="section-title">
        <span class="tag"><i class="fas fa-route"></i> Cara Kerja</span>
        <h2>3 Langkah Saja</h2>
        <p>Proses peminjaman ruangan yang simpel untuk semua orang</p>
    </div>
    <div class="steps">
        <div class="step">
            <div class="step-num">1</div>
            <h3>Daftar Akun</h3>
            <p>Buat akun baru menggunakan email sekolah Anda. Gratis dan cepat.</p>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <h3>Ajukan Booking</h3>
            <p>Pilih ruangan, masukkan detail kegiatan, dan tentukan waktu yang diinginkan.</p>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <h3>Tunggu Persetujuan</h3>
            <p>Admin akan memproses permohonan Anda. Cek status kapan saja melalui dashboard.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <h2>Siap Memulai?</h2>
    <p>Daftar sekarang dan nikmati kemudahan peminjaman ruangan di sekolah Anda</p>
    @auth
        <a href="{{ url('/dashboard') }}" class="cta-btn"><i class="fas fa-tachometer-alt"></i> Buka Dashboard</a>
    @else
        <a href="{{ route('register') }}" class="cta-btn"><i class="fas fa-user-plus"></i> Daftar Gratis</a>
    @endauth
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; {{ date('Y') }} <span>Ruang Peminjaman</span> — Sistem Peminjaman Ruangan Sekolah</p>
</footer>

<script>
    // Navbar shadow on scroll
    window.addEventListener('scroll', function() {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
    });
</script>
</body>
</html>
