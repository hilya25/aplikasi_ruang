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
        .hero-glow{position:absolute;border-radius:50%;filter:blur(90px);pointer-events:none;transition:transform .15s ease-out}
        .hero-glow.g1{width:560px;height:560px;top:-160px;right:-100px;background:rgba(99,102,241,0.28)}
        .hero-glow.g2{width:460px;height:460px;bottom:-140px;left:-120px;background:rgba(168,85,247,0.2)}
        .hero-glow.g3{width:300px;height:300px;top:38%;left:44%;background:rgba(56,189,248,0.1)}
        .hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(148,163,184,0.045) 1px,transparent 1px),linear-gradient(90deg,rgba(148,163,184,0.045) 1px,transparent 1px);background-size:52px 52px;mask-image:radial-gradient(ellipse 90% 70% at 50% 40%,#000 40%,transparent 100%)}
        .hero-content{max-width:1200px;margin:0 auto;width:100%;text-align:center;position:relative;z-index:2}
        .hero-tagline{display:inline-flex;align-items:center;gap:8px;background:rgba(99,102,241,0.14);border:1px solid rgba(129,140,248,0.3);color:#a5b4fc;padding:8px 18px;border-radius:100px;font-size:0.82rem;font-weight:600;margin-bottom:28px}
        .hero-tagline .pulse-dot{width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 0 0 rgba(74,222,128,0.6);animation:pulse 2s infinite}
        @keyframes pulse{0%{box-shadow:0 0 0 0 rgba(74,222,128,0.5)}70%{box-shadow:0 0 0 9px rgba(74,222,128,0)}100%{box-shadow:0 0 0 0 rgba(74,222,128,0)}}
        .hero h1{font-size:3.6rem;font-weight:800;line-height:1.12;color:#fff;letter-spacing:-1.2px;max-width:760px;margin:0 auto}
        .hero h1 .grad{
            background:linear-gradient(90deg,#818cf8,#c084fc,#f0abfc,#c084fc,#818cf8);
            background-size:300% 100%;
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
            animation:shimmer 4s ease-in-out infinite;
        }
        @keyframes shimmer{0%{background-position:100% 50%}50%{background-position:0% 50%}100%{background-position:100% 50%}}
        .typing-cursor{display:inline-block;width:3px;height:0.85em;background:#818cf8;margin-left:4px;vertical-align:text-bottom;animation:blink 1s step-end infinite;border-radius:2px}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:0}}
        .hero p.lead{font-size:1.1rem;color:#94a3b8;margin:22px auto 0;line-height:1.75;max-width:560px}
        .hero-buttons{display:flex;gap:14px;margin-top:38px;justify-content:center;flex-wrap:wrap}
        .btn-hero{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;padding:15px 32px;border-radius:14px;font-weight:700;font-size:0.95rem;display:inline-flex;align-items:center;gap:9px;box-shadow:0 10px 30px rgba(99,102,241,0.4);transition:all .3s}
        .btn-hero:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(99,102,241,0.55)}
        .btn-ghost{background:rgba(255,255,255,0.06);color:#e2e8f0;padding:15px 32px;border-radius:14px;font-weight:600;font-size:0.95rem;border:1px solid rgba(255,255,255,0.14);display:inline-flex;align-items:center;gap:9px;transition:all .3s;backdrop-filter:blur(8px)}
        .btn-ghost:hover{background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.3);transform:translateY(-3px)}
        .hero-trust{display:flex;align-items:center;gap:10px;margin-top:34px;color:#64748b;font-size:0.83rem;justify-content:center}
        .hero-trust i{color:#4ade80}

        /* ================= FLOATING PARTICLES ================= */
        .particles{position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:1}
        .particle{position:absolute;border-radius:50%;animation:floatParticle linear infinite;opacity:0}
        @keyframes floatParticle{
            0%{transform:translateY(0) scale(1);opacity:0}
            10%{opacity:.6}
            90%{opacity:.6}
            100%{transform:translateY(-100vh) scale(0.3);opacity:0}
        }

        /* ================= MARQUEE ================= */
        .marquee-wrap{background:#0f172a;border-top:1px solid rgba(148,163,184,0.09);border-bottom:1px solid rgba(148,163,184,0.09);padding:20px 0;overflow:hidden;white-space:nowrap}
        .marquee{display:inline-flex;gap:56px;animation:scrollMarquee 30s linear infinite}
        .marquee span{color:#475569;font-weight:700;font-size:0.85rem;letter-spacing:2.5px;text-transform:uppercase;display:inline-flex;align-items:center;gap:12px}
        .marquee i{color:#6366f1;font-size:0.8rem}
        @keyframes scrollMarquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}

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

        /* ================= SCROLL REVEAL ================= */
        .reveal{opacity:0;transform:translateY(40px);transition:opacity .8s cubic-bezier(.22,.8,.35,1), transform .8s cubic-bezier(.22,.8,.35,1)}
        .reveal.active{opacity:1;transform:translateY(0)}
        .reveal-left{opacity:0;transform:translateX(-50px);transition:opacity .8s cubic-bezier(.22,.8,.35,1), transform .8s cubic-bezier(.22,.8,.35,1)}
        .reveal-left.active{opacity:1;transform:translateX(0)}
        .reveal-right{opacity:0;transform:translateX(50px);transition:opacity .8s cubic-bezier(.22,.8,.35,1), transform .8s cubic-bezier(.22,.8,.35,1)}
        .reveal-right.active{opacity:1;transform:translateX(0)}
        .reveal-scale{opacity:0;transform:scale(0.88);transition:opacity .7s cubic-bezier(.22,.8,.35,1), transform .7s cubic-bezier(.22,.8,.35,1)}
        .reveal-scale.active{opacity:1;transform:scale(1)}

        /* ================= RESPONSIVE ================= */
        @media(max-width:980px){
            .hero h1{font-size:2.4rem}
            .hero p.lead{max-width:100%}
            .features-grid{grid-template-columns:1fr;max-width:520px}
            .steps{grid-template-columns:1fr;max-width:520px}
            .step-arrow{display:none!important}
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
    <div class="particles" aria-hidden="true">
        <span class="particle" style="width:5px;height:5px;left:12%;bottom:-10px;background:#818cf8;animation-duration:14s;animation-delay:0s"></span>
        <span class="particle" style="width:3px;height:3px;left:28%;bottom:-10px;background:#c084fc;animation-duration:18s;animation-delay:4s"></span>
        <span class="particle" style="width:6px;height:6px;left:55%;bottom:-10px;background:#38bdf8;animation-duration:16s;animation-delay:2s"></span>
        <span class="particle" style="width:4px;height:4px;left:76%;bottom:-10px;background:#a5b4fc;animation-duration:20s;animation-delay:7s"></span>
        <span class="particle" style="width:3px;height:3px;left:90%;bottom:-10px;background:#f0abfc;animation-duration:13s;animation-delay:5s"></span>
    </div>
    <div class="hero-content">
        <div class="hero-text">
            <div class="hero-tagline fade-up d1"><span class="pulse-dot"></span> Sistem Peminjaman Ruangan Sekolah</div>
            <h1 class="fade-up d2">Pinjam Ruangan,<br><span class="grad">Sekali Klik Selesai.</span><span class="typing-cursor"></span></h1>
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
    </div>
</section>

<!-- MARQUEE -->
<div class="marquee-wrap reveal-scale">
    <div class="marquee">
        @php
            $marqueeItems = ['Ruang Kelas','Laboratorium','Aula','Lapangan','Masjid','Activity Room','Perpustakaan','Ruang Rapat'];
        @endphp
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
            <span><i class="fas fa-diamond" style="font-size:0.5rem"></i> {{ $item }}</span>
        @endforeach
    </div>
</div>

<!-- FEATURES -->
<section class="features" id="fitur">
    <div class="section-title reveal">
        <span class="tag"><i class="fas fa-star"></i> Fitur Utama</span>
        <h2>Semua Kebutuhan, Satu Platform</h2>
        <p>Dibangun untuk memudahkan pengelolaan fasilitas sekolah sehari-hari</p>
    </div>
    <div class="features-grid">
        <div class="feature-card reveal" style="transition-delay:.05s">
            <div class="feature-icon fi-1"><i class="fas fa-calendar-check"></i></div>
            <h3>Booking Online 24/7</h3>
            <p>Ajukan peminjaman ruangan kapan saja, di mana saja. Pilih ruang, isi kegiatan, atur jadwal — selesai dalam hitungan menit.</p>
        </div>
        <div class="feature-card reveal" style="transition-delay:.15s">
            <div class="feature-icon fi-2"><i class="fas fa-bolt"></i></div>
            <h3>Approval Cepat</h3>
            <p>Admin menyetujui atau menolak permohonan secara real-time. Setiap keputusan langsung muncul sebagai notifikasi.</p>
        </div>
        <div class="feature-card reveal" style="transition-delay:.25s">
            <div class="feature-icon fi-3"><i class="fas fa-clock-rotate-left"></i></div>
            <h3>Status Otomatis</h3>
            <p>Booking yang sudah lewat waktunya otomatis berstatus "Selesai". Riwayat peminjaman selalu rapi dan akurat.</p>
        </div>
        <div class="feature-card reveal" style="transition-delay:.05s">
            <div class="feature-icon fi-4"><i class="fas fa-triangle-exclamation"></i></div>
            <h3>Cek Konflik Jadwal</h3>
            <p>Sistem otomatis mendeteksi bentrok dengan jadwal pelajaran maupun booking lain, lengkap dengan detailnya.</p>
        </div>
        <div class="feature-card reveal" style="transition-delay:.15s">
            <div class="feature-icon fi-5"><i class="fas fa-chart-pie"></i></div>
            <h3>Dashboard Statistik</h3>
            <p>Pantau penggunaan ruangan, jumlah booking aktif, dan status permohonan dalam tampilan yang ringkas dan jelas.</p>
        </div>
        <div class="feature-card reveal" style="transition-delay:.25s">
            <div class="feature-icon fi-6"><i class="fas fa-chalkboard"></i></div>
            <h3>Jadwal Pelajaran Lengkap</h3>
            <p>Lihat jadwal pelajaran per ruangan lengkap dengan mata pelajaran, guru pengajar, dan kelas pengguna.</p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="cara">
    <div class="section-title reveal">
        <span class="tag"><i class="fas fa-route"></i> Cara Kerja</span>
        <h2>3 Langkah Saja</h2>
        <p>Proses peminjaman yang simpel untuk semua orang</p>
    </div>
    <div class="steps">
        <div class="step-card reveal-left" style="transition-delay:.05s">
            <div class="step-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="step-num">1</div>
            <h3>Daftar Akun</h3>
            <p>Buat akun baru dengan email sekolah Anda. Prosesnya gratis dan hanya butuh satu menit.</p>
        </div>
        <div class="step-card reveal" style="transition-delay:.15s">
            <div class="step-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="step-num">2</div>
            <h3>Ajukan Booking</h3>
            <p>Pilih ruangan, masukkan detail kegiatan, dan tentukan tanggal serta jam yang diinginkan.</p>
        </div>
        <div class="step-card reveal-right" style="transition-delay:.25s">
            <div class="step-num">3</div>
            <h3>Approval & Selesai</h3>
            <p>Admin memproses permohonan Anda. Pantau statusnya kapan saja lewat dashboard — dari Menunggu hingga Selesai.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="cta-box reveal-scale">
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
    // ========== NAVBAR SCROLL ==========
    window.addEventListener('scroll', function() {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
    });

    // ========== SCROLL REVEAL ==========
    (function() {
        var els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            els.forEach(function(el) { obs.observe(el); });
        } else {
            els.forEach(function(el) { el.classList.add('active'); });
        }
    })();

    // ========== HERO GLOW PARALLAX ==========
    (function() {
        var hero = document.querySelector('.hero');
        if (!hero) return;
        var g1 = hero.querySelector('.hero-glow.g1');
        var g2 = hero.querySelector('.hero-glow.g2');
        var g3 = hero.querySelector('.hero-glow.g3');
        hero.addEventListener('mousemove', function(e) {
            var rect = hero.getBoundingClientRect();
            var x = (e.clientX - rect.left) / rect.width - 0.5;
            var y = (e.clientY - rect.top) / rect.height - 0.5;
            if (g1) g1.style.transform = 'translate(' + (x * 30) + 'px,' + (y * 25) + 'px)';
            if (g2) g2.style.transform = 'translate(' + (x * -22) + 'px,' + (y * -18) + 'px)';
            if (g3) g3.style.transform = 'translate(' + (x * 15) + 'px,' + (y * 12) + 'px)';
        });
        hero.addEventListener('mouseleave', function() {
            [g1, g2, g3].forEach(function(g) { if (g) g.style.transform = ''; });
        });
    })();
</script>
</body>
</html>
