@props(['header' => null, 'title' => 'Admin Dashboard'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap 4 CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- AdminLTE CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); min-height: 100vh;">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background: white; border-bottom: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(79,70,229,0.08); padding: 0 1rem;">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #6366f1; font-size: 1.1rem;">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: #4b5563; font-weight: 600;">
                    <i class="fas fa-home mr-1" style="color: #6366f1;"></i> Dashboard
                </a>
            </li>
            <li class="nav-item d-none d-md-inline-block">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link" style="color: #6b7280;">
                    <i class="fas fa-calendar-check mr-1"></i> Booking
                    @php $navPending = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                    @if($navPending > 0)
                        <span style="background: #ef4444; color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 9999px; font-weight: 700; margin-left: 4px;">{{ $navPending }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Quick Links -->
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.rooms.index') }}" class="nav-link" style="color: #6b7280;" title="Kelola Ruangan">
                    <i class="fas fa-door-open"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.schedules.index') }}" class="nav-link" style="color: #6b7280;" title="Kelola Jadwal">
                    <i class="fas fa-calendar-alt"></i>
                </a>
            </li>

            <!-- Notification Bell -->
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.notifications.index') }}" class="nav-link" style="color: #6b7280; position: relative;" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    @php $navNotif = \App\Models\Notification::where('is_read', false)->count(); @endphp
                    @if($navNotif > 0)
                        <span style="position: absolute; top: 2px; right: 0; background: #f59e0b; color: white; font-size: 0.6rem; min-width: 16px; height: 16px; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-weight: 700; border: 2px solid white;">{{ $navNotif }}</span>
                    @endif
                </a>
            </li>

            <!-- Divider -->
            <li class="nav-item d-none d-sm-inline-block" style="display: flex; align-items: center;">
                <div style="width: 1px; height: 24px; background: #e5e7eb; margin: 0 4px;"></div>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#" style="color: #374151; font-weight: 600;">
                    <div style="width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #818cf8); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; margin-right: 8px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid #f3f4f6; padding: 8px;">
                    <div style="padding: 8px 16px 12px; border-bottom: 1px solid #f3f4f6; margin-bottom: 4px;">
                        <p style="font-weight: 700; color: #1f2937; margin: 0;">{{ Auth::user()->name }}</p>
                        <small style="color: #9ca3af;">{{ Auth::user()->email }}</small>
                    </div>
                    <a href="{{ route('profile.show') }}" class="dropdown-item" style="border-radius: 8px; padding: 8px 16px; color: #374151;">
                        <i class="fas fa-user mr-2" style="color: #6366f1;"></i> Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="dropdown-item" style="border-radius: 8px; padding: 8px 16px; color: #374151;">
                        <i class="fas fa-globe mr-2" style="color: #3b82f6;"></i> Lihat Website
                    </a>
                    <div style="height: 1px; background: #f3f4f6; margin: 4px 0;"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="border-radius: 8px; padding: 8px 16px; color: #dc2626;">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar elevation-4" style="background: linear-gradient(180deg, #312e81 0%, #4f46e5 50%, #818cf8 100%);">
        <!-- Sidebar -->
        <div class="sidebar" style="background: transparent;">
            <!-- User Panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid rgba(255,255,255,0.15);">
                <div class="info">
                    <a href="#" class="d-block" style="color: white; font-weight: 600;">
                        <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }}
                    </a>
                    <small style="color: rgba(255,255,255,0.6);">Administrator</small>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Kelola Ruangan -->
                    <li class="nav-item">
                        <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>Kelola Ruangan</p>
                        </a>
                    </li>

                    <!-- Kelola Kelas -->
                    <li class="nav-item">
                        <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelola Kelas</p>
                        </a>
                    </li>

                    <!-- Kelola Booking -->
                    <li class="nav-item">
                        <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Kelola Booking
                                @php $pendingCount = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="right badge badge-danger">{{ $pendingCount }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <!-- Kelola Jadwal -->
                    <li class="nav-item">
                        <a href="{{ route('admin.schedules.index') }}" class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Kelola Jadwal</p>
                        </a>
                    </li>

                    <!-- Notifikasi -->
                    <li class="nav-item">
                        <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>Notifikasi
                                @php $unreadNotif = \App\Models\Notification::where('is_read', false)->count(); @endphp
                                @if($unreadNotif > 0)
                                    <span class="right badge badge-warning">{{ $unreadNotif }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <!-- Divider -->
                    <li class="nav-header">LAINNYA</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.active-users') }}" class="nav-link {{ request()->routeIs('admin.active-users') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-clock"></i>
                            <p>User Aktif
                                @php $onlineCount = \App\Models\User::where('is_logged_in', true)->count(); @endphp
                                @if($onlineCount > 0)
                                    <span class="right badge badge-success">{{ $onlineCount }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.invite-codes.index') }}" class="nav-link {{ request()->routeIs('admin.invite-codes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Kelola Admin</p>
                        </a>
                    </li>

                    <!-- Divider -->
                    <li class="nav-header">LAINNYA</li>

                    <!-- Lihat Website -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>Lihat Website</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <!-- Content Header (Page header) -->
        @if($header)
        <div class="content-header" style="background: transparent;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{ $header }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</strong>
        <div class="float-right d-none d-sm-inline-block">
            Room Booking System
        </div>
    </footer>
</div>

<!-- jQuery (CDN) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 JS (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE JS (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')

@livewireScripts

<!-- Custom Sidebar Styles -->
<style>
    /* Sidebar link colors */
    .sidebar .nav-link {
        color: rgba(255,255,255,0.75) !important;
        border-radius: 8px;
        margin: 2px 8px;
        padding: 10px 15px;
        transition: all 0.2s;
    }
    .sidebar .nav-link:hover {
        color: white !important;
        background: rgba(255,255,255,0.15) !important;
    }
    .sidebar .nav-link.active {
        color: white !important;
        background: rgba(255,255,255,0.2) !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .sidebar .nav-link .nav-icon {
        color: rgba(255,255,255,0.7) !important;
        margin-right: 8px;
    }
    .sidebar .nav-link.active .nav-icon,
    .sidebar .nav-link:hover .nav-icon {
        color: white !important;
    }
    .sidebar .nav-header {
        color: rgba(255,255,255,0.4) !important;
        font-size: 0.7rem;
        letter-spacing: 1px;
        padding: 15px 20px 5px;
    }
    .sidebar .badge {
        font-size: 0.65rem;
    }
    /* Brand logo area */
    .brand-link {
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
    }
    .brand-text {
        color: white !important;
        font-weight: 700;
    }
</style>
</body>
</html>
