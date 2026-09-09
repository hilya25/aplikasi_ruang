<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN (backup untuk utility classes) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- DaisyUI CDN -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased" style="background: linear-gradient(135deg, #f0f4ff 0%, #e8e0f4 50%, #f0f4ff 100%); min-height: 100vh;">
        <x-banner />

        <div class="min-h-screen">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 15px rgba(102,126,234,0.3);">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div style="color: white;">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        @stack('scripts')

        <!-- Custom Styles -->
        <style>
            /* Better header text color */
            .header-text { color: white !important; }
            .header-text h2 { color: white !important; }
        </style>
    </body>
</html>
