<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

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
                font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
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
                filter: blur(90px);
                opacity: 0.35;
            }
            .bg-decor::before {
                width: 480px;
                height: 480px;
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
            }

            /* ===== Page header ===== */
            .page-header {
                position: relative;
                background: linear-gradient(120deg, #4338ca 0%, #6366f1 45%, #8b5cf6 100%);
                border-radius: 0 0 2rem 2rem;
                box-shadow: 0 20px 40px -18px rgba(79, 70, 229, 0.45);
                overflow: hidden;
            }
            .page-header::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 85% 20%, rgba(255,255,255,0.18) 0%, transparent 45%),
                    radial-gradient(circle at 10% 90%, rgba(255,255,255,0.10) 0%, transparent 40%);
                pointer-events: none;
            }

            /* ===== Card aesthetic ===== */
            .aesthetic-card {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.9);
                box-shadow: 0 8px 30px -12px rgba(79, 70, 229, 0.14);
                border-radius: 1.25rem;
            }
            .aesthetic-card-hover {
                transition: transform .25s ease, box-shadow .25s ease;
            }
            .aesthetic-card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 40px -14px rgba(79, 70, 229, 0.28);
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
                animation: fadeUp .5s ease both;
            }
            .animate-fade-up-1 { animation-delay: .05s; }
            .animate-fade-up-2 { animation-delay: .12s; }
            .animate-fade-up-3 { animation-delay: .19s; }
            .animate-fade-up-4 { animation-delay: .26s; }

            .header-text { color: white !important; }
            .header-text h2 { color: white !important; }

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
                <i class="fas fa-school mr-1.5"></i> {{ config('app.name', 'RoomBook') }} &copy; {{ date('Y') }} — Ruang yang tepat, waktu yang tepat.
            </footer>
        </div>

        @stack('modals')

        @livewireScripts

        @stack('scripts')
    </body>
</html>
