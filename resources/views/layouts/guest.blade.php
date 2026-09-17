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
        .auth-page::before{content:'';position:absolute;width:600px;height:600px;border-radius:50%;background:rgba(99,102,241,0.15);filter:blur(120px);top:-200px;right:-150px}
        .auth-page::after{content:'';position:absolute;width:500px;height:500px;border-radius:50%;background:rgba(168,85,247,0.1);filter:blur(120px);bottom:-200px;left:-150px}

        /* CARD */
        .auth-card{background:#1e293b;border:1px solid rgba(148,163,184,0.12);border-radius:24px;padding:36px 36px;width:100%;max-width:420px;box-shadow:0 40px 100px rgba(2,6,23,0.6);position:relative;z-index:1}

        /* HEADER */
        .auth-card .card-logo{display:flex;align-items:center;gap:11px;margin-bottom:24px}
        .card-logo .c-icon{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#a855f7);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.25rem;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 8px 22px rgba(99,102,241,0.4)}
        .card-logo .c-name{font-size:1.15rem;font-weight:800;color:#f1f5f9;letter-spacing:-0.3px}

        .auth-card .form-title{font-size:1.4rem;font-weight:800;color:#f1f5f9;margin-bottom:5px;letter-spacing:-0.5px}
        .auth-card .form-subtitle{color:#94a3b8;font-size:0.85rem;margin-bottom:22px;line-height:1.5}

        /* FORM */
        .form-group{margin-bottom:14px}
        .form-group:last-of-type{margin-bottom:0}
        .form-group label{display:block;font-size:0.8rem;font-weight:700;color:#cbd5e1;margin-bottom:5px}
        .input-wrap{position:relative}
        .input-wrap i{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.9rem;pointer-events:none}
        .input-wrap input[type="text"],
        .input-wrap input[type="email"],
        .input-wrap input[type="password"]{
            width:100%;padding:11px 14px 11px 42px;border:1.5px solid rgba(148,163,184,0.2);border-radius:11px;font-size:0.88rem;font-weight:500;font-family:'Plus Jakarta Sans',sans-serif;color:#f1f5f9;background:rgba(255,255,255,0.05);transition:all .25s;outline:none
        }
        .input-wrap input:focus{border-color:#818cf8;background:rgba(255,255,255,0.08);box-shadow:0 0 0 3px rgba(129,140,248,0.15)}
        .input-wrap input::placeholder{color:#475569}

        .form-check{display:flex;align-items:center;gap:9px;margin-bottom:20px}
        .form-check input[type="checkbox"]{width:18px;height:18px;accent-color:#6366f1;cursor:pointer;border-radius:5px}
        .form-check label{margin:0;font-weight:600;color:#94a3b8;font-size:0.85rem;cursor:pointer}

        .hint-text{font-size:0.78rem;color:#64748b;margin-top:5px}

        /* BUTTON */
        .btn-submit{width:100%;padding:14px;border:none;border-radius:14px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:0.95rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;box-shadow:0 8px 24px rgba(99,102,241,0.35);transition:all .3s}
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 14px 34px rgba(99,102,241,0.55)}

        /* DIVIDER & FOOTER */
        .form-divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:#475569;font-size:0.8rem}
        .form-divider::before,.form-divider::after{content:'';flex:1;height:1px;background:rgba(148,163,184,0.15)}
        .form-footer{text-align:center;margin-top:20px;font-size:0.85rem;color:#94a3b8}
        .form-footer a{color:#818cf8;font-weight:700;text-decoration:none;transition:color .2s}
        .form-footer a:hover{color:#a5b4fc}

        /* SUCCESS MSG */
        .alert-success{background:rgba(34,197,94,0.1);color:#4ade80;padding:14px 18px;border-radius:12px;border:1px solid rgba(34,197,94,0.2);font-size:0.85rem;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:8px}

        /* RESPONSIVE */
        @media(max-width:480px){
            .auth-card{padding:36px 28px;border-radius:22px}
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
