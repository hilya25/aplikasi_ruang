<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIPARU — {{ request()->routeIs('login') ? 'Masuk' : 'Daftar' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus+jakarta+sans:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%;overflow:auto}
        body{font-family:'Plus Jakarta Sans',sans-serif;color:#0f172a}

        /* FULL PAGE */
        .auth-page{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#0f172a;padding:32px 20px;position:relative;overflow:hidden}
        .auth-page::before{content:'';position:absolute;width:600px;height:600px;border-radius:50%;background:rgba(99,102,241,0.15);filter:blur(120px);top:-200px;right:-150px;animation:glowDrift1 8s ease-in-out infinite alternate}
        .auth-page::after{content:'';position:absolute;width:500px;height:500px;border-radius:50%;background:rgba(168,85,247,0.1);filter:blur(120px);bottom:-200px;left:-150px;animation:glowDrift2 10s ease-in-out infinite alternate}
        @keyframes glowDrift1{0%{transform:translate(0,0) scale(1)}100%{transform:translate(-30px,20px) scale(1.08)}}
        @keyframes glowDrift2{0%{transform:translate(0,0) scale(1)}100%{transform:translate(25px,-15px) scale(1.06)}}

        /* FLOATING PARTICLES */
        .auth-particles{position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:0}
        .auth-particle{position:absolute;width:4px;height:4px;border-radius:50%;animation:authFloat linear infinite;opacity:0}
        @keyframes authFloat{
            0%{transform:translateY(0) scale(1);opacity:0}
            10%{opacity:.5}
            90%{opacity:.5}
            100%{transform:translateY(-100vh) scale(0.3);opacity:0}
        }

        /* CARD */
        .auth-card{background:#1e293b;border:1px solid rgba(148,163,184,0.12);border-radius:24px;padding:36px 36px;width:100%;max-width:420px;box-shadow:0 40px 100px rgba(2,6,23,0.6);position:relative;z-index:1;animation:cardEnter .7s cubic-bezier(.22,.8,.35,1) both}
        @keyframes cardEnter{from{opacity:0;transform:translateY(32px) scale(0.96)}to{opacity:1;transform:translateY(0) scale(1)}}

        /* HEADER */
        .auth-card .card-logo{display:flex;align-items:center;gap:11px;margin-bottom:24px;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .15s both}
        .card-logo .c-icon{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#a855f7);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.25rem;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 8px 22px rgba(99,102,241,0.4);animation:iconPulse 3s ease-in-out infinite}
        @keyframes iconPulse{0%,100%{box-shadow:0 8px 22px rgba(99,102,241,0.4)}50%{box-shadow:0 8px 30px rgba(99,102,241,0.65),0 0 0 6px rgba(99,102,241,0.1)}}
        .card-logo .c-name{font-size:1.15rem;font-weight:800;color:#f1f5f9;letter-spacing:-0.3px}

        .auth-card .form-title{font-size:1.4rem;font-weight:800;color:#f1f5f9;margin-bottom:5px;letter-spacing:-0.5px;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .25s both}
        .auth-card .form-subtitle{color:#94a3b8;font-size:0.85rem;margin-bottom:22px;line-height:1.5;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .3s both}

        /* STAGGER ANIMATION */
        @keyframes staggerFade{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}

        /* FORM */
        .form-group{margin-bottom:14px;opacity:0;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) forwards}
        .form-group:nth-child(1){animation-delay:.35s}
        .form-group:nth-child(2){animation-delay:.42s}
        .form-group:nth-child(3){animation-delay:.49s}
        .form-group:nth-child(4){animation-delay:.56s}
        .form-group:nth-child(5){animation-delay:.63s}
        .form-group:last-of-type{margin-bottom:0}
        .form-group label{display:block;font-size:0.8rem;font-weight:700;color:#cbd5e1;margin-bottom:5px}
        .input-wrap{position:relative}
        .input-wrap i{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.9rem;pointer-events:none;transition:color .25s}
        .input-wrap input[type="text"],
        .input-wrap input[type="email"],
        .input-wrap input[type="password"]{
            width:100%;padding:11px 14px 11px 42px;border:1.5px solid rgba(148,163,184,0.2);border-radius:11px;font-size:0.88rem;font-weight:500;font-family:'Plus Jakarta Sans',sans-serif;color:#f1f5f9;background:rgba(255,255,255,0.05);transition:all .3s;outline:none
        }
        .input-wrap input:focus{border-color:#818cf8;background:rgba(255,255,255,0.08);box-shadow:0 0 0 3px rgba(129,140,248,0.15)}
        .input-wrap input:focus + i,
        .input-wrap:has(input:focus) i{color:#818cf8}
        .input-wrap input::placeholder{color:#475569}

        .form-check{display:flex;align-items:center;gap:9px;margin-bottom:20px;opacity:0;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .7s forwards}
        .form-check input[type="checkbox"]{width:18px;height:18px;accent-color:#6366f1;cursor:pointer;border-radius:5px;transition:transform .2s}
        .form-check input[type="checkbox"]:checked{transform:scale(1.15)}
        .form-check label{margin:0;font-weight:600;color:#94a3b8;font-size:0.85rem;cursor:pointer}

        .hint-text{font-size:0.78rem;color:#64748b;margin-top:5px}

        /* BUTTON */
        .btn-submit{width:100%;padding:14px;border:none;border-radius:14px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:0.95rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;box-shadow:0 8px 24px rgba(99,102,241,0.35);transition:all .3s;opacity:0;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .75s forwards}
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 14px 34px rgba(99,102,241,0.55)}
        .btn-submit:active{transform:translateY(0) scale(0.98)}

        /* DIVIDER & FOOTER */
        .form-divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:#475569;font-size:0.8rem;opacity:0;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .8s forwards}
        .form-divider::before,.form-divider::after{content:'';flex:1;height:1px;background:rgba(148,163,184,0.15)}
        .form-footer{text-align:center;margin-top:20px;font-size:0.85rem;color:#94a3b8;opacity:0;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .85s forwards}
        .form-footer a{color:#818cf8;font-weight:700;text-decoration:none;transition:all .25s;position:relative}
        .form-footer a::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:2px;background:linear-gradient(90deg,#818cf8,#a5b4fc);border-radius:2px;transition:width .3s}
        .form-footer a:hover{color:#a5b4fc}
        .form-footer a:hover::after{width:100%}

        /* SUCCESS MSG */
        .alert-success{background:rgba(34,197,94,0.1);color:#4ade80;padding:14px 18px;border-radius:12px;border:1px solid rgba(34,197,94,0.2);font-size:0.85rem;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:8px;animation:staggerFade .5s cubic-bezier(.22,.8,.35,1) .2s both}

        /* RESPONSIVE */
        @media(max-width:480px){
            .auth-card{padding:36px 28px;border-radius:22px}
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-particles" aria-hidden="true">
            <span class="auth-particle" style="left:10%;bottom:-8px;background:#818cf8;width:4px;height:4px;animation-duration:16s;animation-delay:1s"></span>
            <span class="auth-particle" style="left:30%;bottom:-8px;background:#c084fc;width:3px;height:3px;animation-duration:20s;animation-delay:5s"></span>
            <span class="auth-particle" style="left:55%;bottom:-8px;background:#38bdf8;width:5px;height:5px;animation-duration:18s;animation-delay:3s"></span>
            <span class="auth-particle" style="left:75%;bottom:-8px;background:#a5b4fc;width:3px;height:3px;animation-duration:22s;animation-delay:8s"></span>
            <span class="auth-particle" style="left:92%;bottom:-8px;background:#f0abfc;width:4px;height:4px;animation-duration:15s;animation-delay:6s"></span>
        </div>
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
