<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus+jakarta+sans:400,500,600,700,800&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Tailwind CSS CDN (backup untuk utility classes) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- DaisyUI CDN -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            :root {
                --primary: #4f46e5;
                --primary-dark: #4338ca;
                --accent: #818cf8;
            }

            body {
                background: #f6f7fb;
                font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            }

            /* ===== Decorative background blobs ===== */
            .bg-decor {
                position: fixed;
                inset: 0;
                z-index: -1;
                overflow: hidden;
                pointer-events: none;
            }
            .bg-decor::before,
            .bg-decor::after {
                content: '';
                position: absolute;
                border-radius: 9999px;
                filter: blur(100px);
                opacity: 0.3;
                animation: blobDrift 12s ease-in-out infinite alternate;
            }
            .bg-decor::before {
                width: 500px;
                height: 500px;
                top: -160px;
                right: -120px;
                background: radial-gradient(circle, #c7d2fe 0%, transparent 70%);
            }
            .bg-decor::after {
                width: 520px;
                height: 520px;
                bottom: -200px;
                left: -160px;
                background: radial-gradient(circle, #ddd6fe 0%, transparent 70%);
                animation-delay: 4s;
                animation-direction: alternate-reverse;
            }
            @keyframes blobDrift {
                0% { transform: translate(0, 0) scale(1); }
                100% { transform: translate(20px, -15px) scale(1.06); }
            }

            /* ===== Floating particles ===== */
            .bg-particles {
                position: fixed;
                inset: 0;
                pointer-events: none;
                overflow: hidden;
                z-index: -1;
            }
            .bg-particle {
                position: absolute;
                border-radius: 50%;
                opacity: 0;
                animation: particleFloat linear infinite;
            }
            @keyframes particleFloat {
                0% { transform: translateY(0) scale(1); opacity: 0; }
                10% { opacity: 0.4; }
                90% { opacity: 0.4; }
                100% { transform: translateY(-100vh) scale(0.3); opacity: 0; }
            }

            /* ===== Page header ===== */
            .page-header {
                position: relative;
                background: linear-gradient(120deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6366f1 100%);
                border-radius: 0 0 2rem 2rem;
                box-shadow: 0 20px 50px -18px rgba(79, 70, 229, 0.5);
                overflow: hidden;
            }
            .page-header::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 85% 20%, rgba(255,255,255,0.2) 0%, transparent 45%),
                    radial-gradient(circle at 10% 90%, rgba(255,255,255,0.08) 0%, transparent 40%);
                pointer-events: none;
            }
            .page-header::after {
                content: '';
                position: absolute;
                width: 300px;
                height: 300px;
                border-radius: 50%;
                background: rgba(139,92,246,0.15);
                filter: blur(60px);
                top: -100px;
                right: 10%;
                pointer-events: none;
            }

            /* ===== Card aesthetic — Glassmorphism ===== */
            .aesthetic-card {
                background: rgba(255, 255, 255, 0.78);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.85);
                box-shadow: 0 8px 32px -12px rgba(79, 70, 229, 0.12), inset 0 1px 0 rgba(255,255,255,0.8);
                border-radius: 1.25rem;
            }
            .aesthetic-card-hover {
                transition: transform .3s cubic-bezier(.22,.8,.35,1), box-shadow .3s ease;
            }
            .aesthetic-card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 50px -14px rgba(79, 70, 229, 0.25), inset 0 1px 0 rgba(255,255,255,0.9);
            }

            /* ===== Stat card shimmer border ===== */
            .stat-card-shimmer {
                position: relative;
                overflow: hidden;
            }
            .stat-card-shimmer::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                animation: shimmerBorder 3s ease-in-out infinite;
                pointer-events: none;
            }
            @keyframes shimmerBorder {
                0% { left: -100%; }
                100% { left: 200%; }
            }

            /* ===== Smooth scrollbar ===== */
            ::-webkit-scrollbar { width: 10px; height: 10px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb {
                background: #c7d2fe;
                border-radius: 8px;
                border: 2px solid #f6f7fb;
            }
            ::-webkit-scrollbar-thumb:hover { background: #a5b4fc; }

            /* ===== Fade-in animation ===== */
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(14px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-up {
                animation: fadeUp .5s cubic-bezier(.22,.8,.35,1) both;
            }
            .animate-fade-up-1 { animation-delay: .05s; }
            .animate-fade-up-2 { animation-delay: .12s; }
            .animate-fade-up-3 { animation-delay: .19s; }
            .animate-fade-up-4 { animation-delay: .26s; }

            /* ===== Scroll Reveal ===== */
            .reveal{opacity:0;transform:translateY(24px);transition:opacity .7s cubic-bezier(.22,.8,.35,1),transform .7s cubic-bezier(.22,.8,.35,1)}
            .reveal.active{opacity:1;transform:translateY(0)}

            .header-text { color: white !important; }
            .header-text h2 { color: white !important; }

            /* ===== Gradient text ===== */
            .grad-text {
                background: linear-gradient(135deg, #818cf8, #c084fc, #f0abfc);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* ===== Navbar: nav link ===== */
            .nav-link {
                position: relative;
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 0.95rem;
                border-radius: 0.85rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: rgba(255, 255, 255, 0.75);
                background: transparent;
                text-decoration: none;
                transition: color .2s ease, background .2s ease;
            }
            .nav-link:hover {
                color: #fff;
                background: rgba(255, 255, 255, 0.10);
            }
            .nav-link.nav-active {
                color: #fff;
                background: rgba(255, 255, 255, 0.16);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.25), 0 4px 12px -4px rgba(0,0,0,0.25);
                font-weight: 600;
            }
            .nav-link.nav-active::after {
                content: '';
                position: absolute;
                bottom: 4px;
                left: 50%;
                transform: translateX(-50%);
                width: 18px;
                height: 3px;
                border-radius: 9999px;
                background: linear-gradient(90deg, #e0e7ff, #f5d0fe);
            }
            .nav-badge {
                background: linear-gradient(135deg, #f43f5e, #fb7185);
                color: white;
                box-shadow: 0 2px 8px rgba(244, 63, 94, 0.5);
            }

            /* ===== Navbar: user chip ===== */
            .user-chip {
                display: inline-flex;
                align-items: center;
                padding: 0.35rem 0.8rem 0.35rem 0.4rem;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
                color: white;
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.22);
                transition: background .2s ease, border-color .2s ease;
                cursor: pointer;
            }
            .user-chip:hover {
                background: rgba(255, 255, 255, 0.2);
                border-color: rgba(255, 255, 255, 0.4);
            }
            .user-avatar {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: linear-gradient(135deg, rgba(255,255,255,0.35), rgba(255,255,255,0.15));
                border: 1px solid rgba(255,255,255,0.35);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 0.8rem;
                color: white;
                margin-right: 8px;
                flex-shrink: 0;
            }

            /* ===== Navbar: dropdown profile ===== */
            .dropdown-profile {
                display: flex;
                align-items: center;
                padding: 12px 14px;
                margin-bottom: 6px;
                background: linear-gradient(120deg, #eef2ff, #f5f3ff);
                border-bottom: 1px solid #e5e7eb;
            }
            .dropdown-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: linear-gradient(135deg, #6366f1, #a855f7);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                margin-right: 12px;
                flex-shrink: 0;
            }
            .dropdown-name { font-weight: 700; color: #1f2937; margin: 0; }
            .dropdown-email { color: #9ca3af; font-size: 0.8rem; }
            .dropdown-divider { height: 1px; background: #f3f4f6; margin: 4px 0; }

            /* ===== Navbar: mobile links ===== */
            .mobile-link {
                display: block;
                padding: 0.75rem 1rem;
                border-radius: 0.85rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: rgba(255, 255, 255, 0.85);
                text-decoration: none;
                transition: background .2s ease, color .2s ease;
            }
            .mobile-link:hover { background: rgba(255, 255, 255, 0.1); color: white; }
            .mobile-link.mobile-active {
                color: white;
                background: rgba(255, 255, 255, 0.16);
                font-weight: 600;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="min-height: 100vh;">
        <div class="bg-decor"></div>
        <div class="bg-particles" aria-hidden="true">
            <span class="bg-particle" style="left:8%;bottom:-8px;background:#818cf8;width:4px;height:4px;animation-duration:18s;animation-delay:1s"></span>
            <span class="bg-particle" style="left:25%;bottom:-8px;background:#c084fc;width:3px;height:3px;animation-duration:22s;animation-delay:5s"></span>
            <span class="bg-particle" style="left:50%;bottom:-8px;background:#38bdf8;width:5px;height:5px;animation-duration:16s;animation-delay:3s"></span>
            <span class="bg-particle" style="left:72%;bottom:-8px;background:#a5b4fc;width:3px;height:3px;animation-duration:24s;animation-delay:8s"></span>
            <span class="bg-particle" style="left:90%;bottom:-8px;background:#f0abfc;width:4px;height:4px;animation-duration:17s;animation-delay:6s"></span>
        </div>

        <x-banner />

        <div class="min-h-screen flex flex-col">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="page-header">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
                        <div style="color: white;">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-12 py-6 text-center text-sm" style="color: #a5b4fc;">
                <i class="fas fa-door-open mr-1.5"></i> SIPARU &copy; {{ date('Y') }} — Sistem Peminjaman Ruangan Sekolah
            </footer>
        </div>

        @stack('modals')

        @livewireScripts

        @stack('scripts')

        <script>
            // Scroll Reveal
            (function() {
                var els = document.querySelectorAll('.reveal');
                if ('IntersectionObserver' in window) {
                    var obs = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('active');
                                obs.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });
                    els.forEach(function(el) { obs.observe(el); });
                } else {
                    els.forEach(function(el) { el.classList.add('active'); });
                }
            })();

            // Counter Animation
            (function() {
                var counters = document.querySelectorAll('[data-count]');
                if (!counters.length) return;
                var animated = false;
                function animateAll() {
                    if (animated) return;
                    animated = true;
                    counters.forEach(function(el) {
                        var target = parseInt(el.getAttribute('data-count'), 10);
                        var duration = 1200;
                        var start = performance.now();
                        function tick(now) {
                            var progress = Math.min((now - start) / duration, 1);
                            var eased = 1 - Math.pow(1 - progress, 3);
                            el.textContent = Math.round(eased * target);
                            if (progress < 1) requestAnimationFrame(tick);
                        }
                        requestAnimationFrame(tick);
                    });
                }
                if ('IntersectionObserver' in window) {
                    var obs = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) { animateAll(); obs.disconnect(); }
                        });
                    }, { threshold: 0.3 });
                    counters.forEach(function(el) { obs.observe(el.closest('.aesthetic-card') || el); });
                } else {
                    animateAll();
                }
            })();
        </script>
    </body>
</html>
