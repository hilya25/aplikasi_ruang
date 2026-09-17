<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPARU — Sistem Peminjaman Ruangan Sekolah</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus+jakarta+sans:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{font-family:'Plus Jakarta Sans',sans-serif;color:#0f172a;line-height:1.6;background:#f8fafc;overflow-x:hidden}
        a{text-decoration:none;color:inherit}
        img{max-width:100%}

        /* ================= NAVBAR ================= */
        .navbar{position:fixed;top:0;width:100%;z-index:50;transition:all .35s ease;padding:18px 0}
        .navbar.scrolled{background:rgba(15,23,42,0.85);backdrop-filter:blur(16px);padding:12px 0;box-shadow:0 8px 32px rgba(2,6,23,0.35)}
        .nav-inner{max-width:1200px;margin:0 auto;padding:0 28px;display:flex;align-items:center;justify-content:space-between}
        .nav-logo{display:flex;align-items:center;gap:11px;font-weight:800;font-size:1.15rem;color:#fff;letter-spacing:-0.3px}
        .nav-logo .logo-badge{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#a855f7);display:flex;align-items:center;justify-content:center;font-size:1.25rem;font-weight:800;color:#fff;box-shadow:0 6px 18px rgba(99,102,241,0.45);font-family:'Plus Jakarta Sans',sans-serif}
        .nav-links{display:flex;align-items:center;gap:6px}
        .nav-links a:not(.btn-cta){padding:9px 16px;border-radius:10px;font-weight:600;font-size:0.88rem;color:rgba(255,255,255,0.75);transition:all .25s}
        .nav-links a:not(.btn-cta):hover{color:#fff;background:rgba(255,255,255,0.1)}
        .btn-cta{background:#fff;color:#312e81!important;padding:10px 22px;border-radius:12px;font-weight:700;font-size:0.88rem;box-shadow:0 6px 20px rgba(255,255,255,0.18);transition:all .3s;display:inline-flex;align-items:center;gap:7px}
        .btn-cta:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(255,255,255,0.28)}

        /* ================= HERO ================= */
        .hero{min-height:100vh;display:flex;align-items:center;background:#0f172a;padding:130px 24px 90px;position:relative;overflow:hidden}
        .hero-glow{position:absolute;border-radius:50%;filter:blur(90px);pointer-events:none}
        .hero-glow.g1{width:560px;height:560px;top:-160px;right:-100px;background:rgba(99,102,241,0.28)}
        .hero-glow.g2{width:460px;height:460px;bottom:-140px;left:-120px;background:rgba(168,85,247,0.2)}
        .hero-glow.g3{width:300px;height:300px;top:38%;left:44%;background:rgba(56,189,248,0.1)}
        .hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(148,163,184,0.045) 1px,transparent 1px),linear-gradient(90deg,rgba(148,163,184,0.045) 1px,transparent 1px);background-size:52px 52px;mask-image:radial-gradient(ellipse 90% 70% at 50% 40%,#000 40%,transparent 100%)}
        .hero-content{max-width:1200px;margin:0 auto;width:100%;text-align:center;position:relative;z-index:2}
        .hero-tagline{display:inline-flex;align-items:center;gap:8px;background:rgba(99,102,241,0.14);border:1px solid rgba(129,140,248,0.3);color:#a5b4fc;padding:8px 18px;border-radius:100px;font-size:0.82rem;font-weight:600;margin-bottom:28px}
        .hero-tagline .pulse-dot{width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 0 0 rgba(74,222,128,0.6);animation:pulse 2s infinite}
        @keyframes pulse{0%{box-shadow:0 0 0 0 rgba(74,222,128,0.5)}70%{box-shadow:0 0 0 9px rgba(74,222,128,0)}100%{box-shadow:0 0 0 0 rgba(74,222,128,0)}}
        .hero h1{font-size:3.6rem;font-weight:800;line-height:1.12;color:#fff;letter-spacing:-1.2px;max-width:760px;margin:0 auto}
        .hero h1 .grad{background:linear-gradient(120deg,#818cf8 0%,#c084fc 50%,#f0abfc 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero p.lead{font-size:1.1rem;color:#94a3b8;margin:22px auto 0;line-height:1.75;max-width:560px}
        .hero-buttons{display:flex;gap:14px;margin-top:38px;justify-content:center;flex-wrap:wrap}
        .btn-hero{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;padding:15px 32px;border-radius:14px;font-weight:700;font-size:0.95rem;display:inline-flex;align-items:center;gap:9px;box-shadow:0 10px 30px rgba(99,102,241,0.4);transition:all .3s}
        .btn-hero:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(99,102,241,0.55)}
        .btn-ghost{background:rgba(255,255,255,0.06);color:#e2e8f0;padding:15px 32px;border-radius:14px;font-weight:600;font-size:0.95rem;border:1px solid rgba(255,255,255,0.14);display:inline-flex;align-items:center;gap:9px;transition:all .3s;backdrop-filter:blur(8px)}
        .btn-ghost:hover{background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.3);transform:translateY(-3px)}
        .hero-trust{display:flex;align-items:center;gap:10px;margin-top:34px;color:#64748b;font-size:0.83rem;justify-content:center}
        .hero-trust i{color:#4ade80}

        /* HERO PREVIEW CARD */
        .hero-visual{position:relative;margin-top:52px}
        .preview-card{background:rgba(30,41,59,0.72);border:1px solid rgba(148,163,184,0.16);border-radius:24px;padding:28px 32px;backdrop-filter:blur(20px);box-shadow:0 40px 80px rgba(2,6,23,0.6),inset 0 1px 0 rgba(255,255,255,0.06);max-width:780px;margin:0 auto}
        .preview-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        .preview-head .ph-title{display:flex;align-items:center;gap:10px;color:#e2e8f0;font-weight:700;font-size:0.95rem}
        .preview-head .ph-title .ph-icon{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#a855f7);display:flex;align-items:center;justify-content:center;font-size:0.9rem}
        .preview-head .live-badge{font-size:0.7rem;font-weight:700;color:#4ade80;background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.25);padding:5px 12px;border-radius:100px;display:flex;align-items:center;gap:6px}
        .preview-rows{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .room-row{display:flex;align-items:center;gap:14px;padding:13px 15px;background:rgba(255,255,255,0.035);border:1px solid rgba(148,163,184,0.08);border-radius:14px;transition:all .25s}
        .room-row:hover{background:rgba(99,102,241,0.12);border-color:rgba(129,140,248,0.3);transform:translateY(-2px)}
        .room-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;flex-shrink:0}
        .room-row .r-info{flex:1;min-width:0}
        .room-row .r-info h4{font-size:0.86rem;font-weight:700;color:#f1f5f9}
        .room-row .r-info p{font-size:0.72rem;color:#64748b}
        .room-row .r-status{font-size:0.68rem;font-weight:700;padding:5px 11px;border-radius:100px;white-space:nowrap}
        .r-status.ok{background:rgba(74,222,128,0.12);color:#4ade80}
        .r-status.busy{background:rgba(251,146,60,0.12);color:#fb923c}
        .floating-chip{position:absolute;background:rgba(30,41,59,0.92);border:1px solid rgba(148,163,184,0.2);backdrop-filter:blur(14px);border-radius:16px;padding:13px 18px;display:flex;align-items:center;gap:11px;box-shadow:0 20px 50px rgba(2,6,23,0.55);animation:float 5s ease-in-out infinite;z-index:3}
        .floating-chip .fc-icon{width:38px;height:38px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:0.95rem}
        .floating-chip .fc-text h5{font-size:0.78rem;font-weight:800;color:#f1f5f9}
        .floating-chip .fc-text p{font-size:0.68rem;color:#94a3b8}
        .chip-1{top:-20px;right:40px;animation-delay:0s}
        .chip-2{bottom:-20px;left:40px;animation-delay:2.5s}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-11px)}}

        /* ================= MARQUEE ================= */
        .marquee-wrap{background:#0f172a;border-top:1px solid rgba(148,163,184,0.09);border-bottom:1px solid rgba(148,163,184,0.09);padding:20px 0;overflow:hidden;white-space:nowrap}
        .marquee{display:inline-flex;gap:56px;animation:scroll 30s linear infinite}
        .marquee span{color:#475569;font-weight:700;font-size:0.85rem;letter-spacing:2.5px;text-transform:uppercase;display:inline-flex;align-items:center;gap:12px}
        .marquee i{color:#6366f1;font-size:0.8rem}
        @keyframes scroll{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

        /* ================= STATS ================= */
        .stats-band{background:#fff;padding:72px 24px}
        .stats-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:26px}
        .stat-card{text-align:center;padding:34px 20px;border-radius:22px;background:linear-gradient(180deg,#fafbff,#f4f4fd);border:1px solid #e9e9f9;transition:all .3s}
        .stat-card:hover{transform:translateY(-5px);box-shadow:0 18px 40px rgba(99,102,241,0.12);border-color:#d5d7f6}
        .stat-card .s-icon{width:52px;height:52px;margin:0 auto 16px;border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:1.2rem}
        .stat-card .num{font-size:2.3rem;font-weight:800;letter-spacing:-1px;background:linear-gradient(135deg,#4f46e5,#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .stat-card .label{font-size:0.82rem;color:#64748b;font-weight:600;margin-top:4px}

        /* ================= FEATURES ================= */
        .features{padding:110px 24px;background:#f8fafc;position:relative}
        .section-title{text-align:center;margin-bottom:64px}
        .section-title .tag{display:inline-flex;align-items:center;gap:8px;background:#eef2ff;color:#4f46e5;padding:8px 18px;border-radius:100px;font-size:0.8rem;font-weight:700;margin-bottom:16px}
        .section-title h2{font-size:2.5rem;font-weight:800;color:#0f172a;letter-spacing:-0.8px}
        .section-title p{color:#64748b;margin-top:14px;font-size:1.05rem}
        .features-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:26px}
        .feature-card{background:#fff;border:1px solid #eef0f6;border-radius:24px;padding:38px 32px;transition:all .35s;position:relative;overflow:hidden}
        .feature-card:hover{transform:translateY(-8px);box-shadow:0 26px 60px rgba(15,23,42,0.09);border-color:#dcdffb}
        .feature-icon{width:58px;height:58px;border-radius:17px;display:flex;align-items:center;justify-content:center;font-size:1.35rem;margin-bottom:22px;color:#fff}
        .fi-1{background:linear-gradient(135deg,#6366f1,#818cf8);box-shadow:0 10px 26px rgba(99,102,241,0.35)}
        .fi-2{background:linear-gradient(135deg,#f59e0b,#fbbf24);box-shadow:0 10px 26px rgba(245,158,11,0.35)}
        .fi-3{background:linear-gradient(135deg,#10b981,#34d399);box-shadow:0 10px 26px rgba(16,185,129,0.35)}
        .fi-4{background:linear-gradient(135deg,#ec4899,#f472b6);box-shadow:0 10px 26px rgba(236,72,153,0.35)}
        .fi-5{background:linear-gradient(135deg,#0ea5e9,#38bdf8);box-shadow:0 10px 26px rgba(14,165,233,0.35)}
        .fi-6{background:linear-gradient(135deg,#8b5cf6,#a78bfa);box-shadow:0 10px 26px rgba(139,92,246,0.35)}
        .feature-card h3{font-size:1.15rem;font-weight:800;color:#0f172a;margin-bottom:10px;letter-spacing:-0.3px}
        .feature-card p{color:#64748b;font-size:0.9rem;line-height:1.75}

        /* ================= HOW ================= */
        .how{padding:110px 24px 120px;background:#0f172a;position:relative;overflow:hidden}
        .how::before{content:'';position:absolute;width:500px;height:500px;border-radius:50%;background:rgba(99,102,241,0.14);filter:blur(100px);top:-100px;left:50%;transform:translateX(-50%)}
        .how .section-title h2{color:#fff}
        .how .section-title p{color:#94a3b8}
        .how .section-title .tag{background:rgba(99,102,241,0.16);color:#a5b4fc;border:1px solid rgba(129,140,248,0.3)}
        .steps{max-width:1080px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:26px;position:relative;z-index:1}
        .step-card{background:rgba(255,255,255,0.045);border:1px solid rgba(148,163,184,0.13);border-radius:22px;padding:36px 30px;transition:all .35s;position:relative}
        .step-card:hover{background:rgba(99,102,241,0.1);border-color:rgba(129,140,248,0.35);transform:translateY(-6px)}
        .step-num{width:54px;height:54px;border-radius:15px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:1.35rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin-bottom:20px;box-shadow:0 10px 28px rgba(99,102,241,0.4)}
        .step-card h3{font-size:1.1rem;font-weight:800;color:#f1f5f9;margin-bottom:9px}
        .step-card p{color:#94a3b8;font-size:0.88rem;line-height:1.75}
        .step-arrow{position:absolute;top:44px;right:-40px;color:#475569;font-size:1.3rem;z-index:2}
        .step-card:last-child .step-arrow{display:none}

        /* ================= CTA ================= */
        .cta{padding:110px 24px;background:#fff;text-align:center}
        .cta-box{max-width:960px;margin:0 auto;background:linear-gradient(135deg,#4f46e5,#7c3aed 55%,#a855f7);border-radius:32px;padding:80px 48px;position:relative;overflow:hidden;box-shadow:0 40px 90px rgba(99,102,241,0.35)}
        .cta-box::before{content:'';position:absolute;top:-60%;left:-30%;width:80%;height:220%;background:radial-gradient(circle,rgba(255,255,255,0.13),transparent 55%);transform:rotate(18deg)}
        .cta-box h2{font-size:2.5rem;font-weight:800;color:#fff;letter-spacing:-0.8px;position:relative}
        .cta-box p{color:rgba(255,255,255,0.86);font-size:1.08rem;margin-top:16px;position:relative}
        .cta-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:#4338ca;padding:17px 42px;border-radius:15px;font-weight:800;font-size:1rem;margin-top:38px;box-shadow:0 12px 34px rgba(2,6,23,0.25);transition:all .3s;position:relative}
        .cta-btn:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 18px 44px rgba(2,6,23,0.32)}

        /* ================= FOOTER ================= */
        footer{padding:44px 24px;background:#0b1120;text-align:center;color:#64748b;font-size:0.85rem}
        footer .f-logo{display:inline-flex;align-items:center;gap:9px;font-weight:800;color:#e2e8f0;margin-bottom:12px;font-size:1rem}
        footer .f-logo i{color:#818cf8}
        footer span{color:#a78bfa}

        /* ================= ANIM ON LOAD ================= */
        .fade-up{opacity:0;transform:translateY(28px);animation:fadeUp .8s cubic-bezier(.22,.8,.35,1) forwards}
        .d1{animation-delay:.1s}.d2{animation-delay:.25s}.d3{animation-delay:.4s}.d4{animation-delay:.55s}
        @keyframes fadeUp{to{opacity:1;transform:translateY(0)}}

        /* ================= RESPONSIVE ================= */
        @media(max-width:980px){
            .hero h1{font-size:2.4rem}
            .hero p.lead{max-width:100%}
            .preview-card{padding:22px}
            .preview-rows{grid-template-columns:1fr}
            .hero-visual{margin-top:40px}
            .chip-1{right:6px;top:-16px}.chip-2{left:6px;bottom:-16px}
            .features-grid{grid-template-columns:1fr;max-width:520px}
            .steps{grid-template-columns:1fr;max-width:520px}
            .step-arrow{display:none!important}
            .stats-grid{grid-template-columns:repeat(2,1fr)}
            .nav-links a:not(.btn-cta){display:none}
            .cta-box{padding:60px 28px}
            .cta-box h2{font-size:1.9rem}
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">
            <span class="logo-badge">S</span>
            SIPARU
        </a>
        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#cara">Cara Kerja</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-cta">Buka Dashboard <i class="fas fa-arrow-right"></i></a>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}" class="btn-cta">Daftar Sekarang <i class="fas fa-arrow-right"></i></a>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-glow g1"></div>
    <div class="hero-glow g2"></div>
    <div class="hero-glow g3"></div>
    <div class="hero-grid"></div>
    <div class="hero-content">
        <div class="hero-text">
            <div class="hero-tagline fade-up d1"><span class="pulse-dot"></span> Sistem Peminjaman Ruangan Sekolah</div>
            <h1 class="fade-up d2">Pinjam Ruangan,<br><span class="grad">Sekali Klik Selesai.</span></h1>
            <p class="lead fade-up d3">Kelola peminjaman kelas, laboratorium, aula, hingga lapangan dalam satu platform digital — tanpa antre, tanpa buku tulis, tanpa ribet.</p>
            <div class="hero-buttons fade-up d4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-hero"><i class="fas fa-gauge-high"></i> Buka Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-hero"><i class="fas fa-rocket"></i> Mulai Sekarang</a>
                    <a href="{{ route('login') }}" class="btn-ghost"><i class="fas fa-right-to-bracket"></i> Masuk</a>
                @endauth
            </div>
            <div class="hero-trust fade-up d4">
                <i class="fas fa-shield-halved"></i> Dipercaya guru & staff · Data terpusat & aman
            </div>
        </div>

        <div class="hero-visual fade-up d3">
            <div class="preview-card">
                <div class="preview-head">
                    <div class="ph-title">
                        <span class="ph-icon"><i class="fas fa-building-columns"></i></span>
                        Status Ruangan Hari Ini
                    </div>
                    <span class="live-badge"><i class="fas fa-circle" style="font-size:0.45rem"></i> LIVE</span>
                </div>
                <div class="preview-rows">
                    <div class="room-row">
                        <div class="room-icon" style="background:linear-gradient(135deg,#3b82f6,#6366f1)"><i class="fas fa-chalkboard-user"></i></div>
                        <div class="r-info"><h4>Ruang Kelas X-A</h4><p>Kelas · Kapasitas 36 orang</p></div>
                        <span class="r-status ok"><i class="fas fa-check"></i> Tersedia</span>
                    </div>
                    <div class="room-row">
                        <div class="room-icon" style="background:linear-gradient(135deg,#8b5cf6,#d946ef)"><i class="fas fa-flask"></i></div>
                        <div class="r-info"><h4>Lab Komputer 1</h4><p>Lab · Kapasitas 30 orang</p></div>
                        <span class="r-status busy"><i class="fas fa-clock"></i> Digunakan</span>
                    </div>
                    <div class="room-row">
                        <div class="room-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316)"><i class="fas fa-building"></i></div>
                        <div class="r-info"><h4>Aula Utama</h4><p>Aula · Kapasitas 200 orang</p></div>
                        <span class="r-status ok"><i class="fas fa-check"></i> Tersedia</span>
                    </div>
                    <div class="room-row" style="margin-bottom:0">
                        <div class="room-icon" style="background:linear-gradient(135deg,#10b981,#34d399)"><i class="fas fa-table-tennis-paddle-ball"></i></div>
                        <div class="r-info"><h4>Ruang OSIS</h4><p>Activity Room · Kapasitas 20 orang</p></div>
                        <span class="r-status ok"><i class="fas fa-check"></i> Tersedia</span>
                    </div>
                </div>
            </div>
            <div class="floating-chip chip-1">
                <div class="fc-icon" style="background:linear-gradient(135deg,#22c55e,#4ade80)"><i class="fas fa-check"></i></div>
                <div class="fc-text"><h5>Booking Disetujui</h5><p>Notifikasi instan</p></div>
            </div>
            <div class="floating-chip chip-2">
                <div class="fc-icon" style="background:linear-gradient(135deg,#6366f1,#a78bfa)"><i class="fas fa-calendar-check"></i></div>
                <div class="fc-text"><h5>Jadwal Real-time</h5><p>Selalu up to date</p></div>
            </div>
        </div>
    </div>
</section>

<!-- MARQUEE -->
<div class="marquee-wrap">
    <div class="marquee">
        @php
            $marqueeItems = ['Ruang Kelas','Laboratorium','Aula','Lapangan','Masjid','Activity Room','Perpustakaan','Ruang Rapat'];
        @endphp
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
            <span><i class="fas fa-diamond" style="font-size:0.5rem"></i> {{ $item }}</span>
        @endforeach
    </div>
</div>

<!-- STATS -->
<section class="stats-band">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="s-icon" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4f46e5"><i class="fas fa-door-open"></i></div>
            <div class="num">{{ \App\Models\Room::where('is_active', true)->count() }}</div>
            <div class="label">Ruangan Tersedia</div>
        </div>
        <div class="stat-card">
            <div class="s-icon" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);color:#10b981"><i class="fas fa-circle-check"></i></div>
            <div class="num">{{ \App\Models\Booking::where('status', 'approved')->count() }}</div>
            <div class="label">Booking Disetujui</div>
        </div>
        <div class="stat-card">
            <div class="s-icon" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);color:#f59e0b"><i class="fas fa-hourglass-half"></i></div>
            <div class="num">{{ \App\Models\Booking::where('status', 'pending')->count() }}</div>
            <div class="label">Menunggu Approval</div>
        </div>
        <div class="stat-card">
            <div class="s-icon" style="background:linear-gradient(135deg,#fdf4ff,#fae8ff);color:#a855f7"><i class="fas fa-users"></i></div>
            <div class="num">{{ \App\Models\User::count() }}</div>
            <div class="label">Pengguna Terdaftar</div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features" id="fitur">
    <div class="section-title">
        <span class="tag"><i class="fas fa-star"></i> Fitur Utama</span>
        <h2>Semua Kebutuhan, Satu Platform</h2>
        <p>Dibangun untuk memudahkan pengelolaan fasilitas sekolah sehari-hari</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon fi-1"><i class="fas fa-calendar-check"></i></div>
            <h3>Booking Online 24/7</h3>
            <p>Ajukan peminjaman ruangan kapan saja, di mana saja. Pilih ruang, isi kegiatan, atur jadwal — selesai dalam hitungan menit.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon fi-2"><i class="fas fa-bolt"></i></div>
            <h3>Approval Cepat</h3>
            <p>Admin menyetujui atau menolak permohonan secara real-time. Setiap keputusan langsung muncul sebagai notifikasi.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon fi-3"><i class="fas fa-clock-rotate-left"></i></div>
            <h3>Status Otomatis</h3>
            <p>Booking yang sudah lewat waktunya otomatis berstatus "Selesai". Riwayat peminjaman selalu rapi dan akurat.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon fi-4"><i class="fas fa-triangle-exclamation"></i></div>
            <h3>Cek Konflik Jadwal</h3>
            <p>Sistem otomatis mendeteksi bentrok dengan jadwal pelajaran maupun booking lain, lengkap dengan detailnya.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon fi-5"><i class="fas fa-chart-pie"></i></div>
            <h3>Dashboard Statistik</h3>
            <p>Pantau penggunaan ruangan, jumlah booking aktif, dan status permohonan dalam tampilan yang ringkas dan jelas.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon fi-6"><i class="fas fa-chalkboard"></i></div>
            <h3>Jadwal Pelajaran Lengkap</h3>
            <p>Lihat jadwal pelajaran per ruangan lengkap dengan mata pelajaran, guru pengajar, dan kelas pengguna.</p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="cara">
    <div class="section-title">
        <span class="tag"><i class="fas fa-route"></i> Cara Kerja</span>
        <h2>3 Langkah Saja</h2>
        <p>Proses peminjaman yang simpel untuk semua orang</p>
    </div>
    <div class="steps">
        <div class="step-card">
            <div class="step-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="step-num">1</div>
            <h3>Daftar Akun</h3>
            <p>Buat akun baru dengan email sekolah Anda. Prosesnya gratis dan hanya butuh satu menit.</p>
        </div>
        <div class="step-card">
            <div class="step-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="step-num">2</div>
            <h3>Ajukan Booking</h3>
            <p>Pilih ruangan, masukkan detail kegiatan, dan tentukan tanggal serta jam yang diinginkan.</p>
        </div>
        <div class="step-card">
            <div class="step-num">3</div>
            <h3>Approval & Selesai</h3>
            <p>Admin memproses permohonan Anda. Pantau statusnya kapan saja lewat dashboard — dari Menunggu hingga Selesai.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="cta-box">
        <h2>Siap Ganti Buku Tulis dengan Klik?</h2>
        <p>Bergabung sekarang dan rasakan kemudahan peminjaman ruangan di sekolah Anda</p>
        @auth
            <a href="{{ url('/dashboard') }}" class="cta-btn"><i class="fas fa-gauge-high"></i> Buka Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="cta-btn"><i class="fas fa-user-plus"></i> Daftar Gratis Sekarang</a>
        @endauth
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="f-logo"><i class="fas fa-door-open"></i> SIPARU</div>
    <p>&copy; {{ date('Y') }} <span>SIPARU</span> — Sistem Peminjaman Ruangan Sekolah</p>
</footer>

<script>
    // Navbar shadow on scroll
    window.addEventListener('scroll', function() {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
    });
</script>
</body>
</html>
