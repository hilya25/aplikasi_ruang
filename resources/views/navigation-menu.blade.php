<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     class="sticky top-0 z-40 transition-all duration-300"
     :class="scrolled ? 'shadow-lg' : ''"
     style="background: linear-gradient(120deg, rgba(67,56,202,0.92) 0%, rgba(99,102,241,0.92) 50%, rgba(139,92,246,0.92) 100%); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">

                <!-- Logo -->
                <div class="flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center group" style="text-decoration: none;">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-extrabold text-white text-lg transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6"
                             style="background: linear-gradient(135deg, #6366f1, #a855f7); box-shadow: 0 6px 18px rgba(99,102,241,0.45); font-family: 'Plus Jakarta Sans', sans-serif;">
                            S
                        </div>
                        <div class="ml-2.5 leading-none">
                            <span style="color: white; font-weight: 800; font-size: 1.15rem; letter-spacing: -0.02em;">SIPARU</span>
                            <div style="color: rgba(255,255,255,0.6); font-size: 0.6rem; letter-spacing: 0.18em; text-transform: uppercase; margin-top: 2px;">Sistem Peminjaman Ruangan</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:flex items-center">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        <i class="fas fa-home mr-1.5"></i> Dashboard
                    </a>
                    <a href="{{ route('user.rooms') }}"
                       class="nav-link {{ request()->routeIs('user.rooms*') ? 'nav-active' : '' }}">
                        <i class="fas fa-door-open mr-1.5"></i> Ruangan
                    </a>
                    <a href="{{ route('user.bookings.create') }}"
                       class="nav-link {{ request()->routeIs('user.bookings.create') ? 'nav-active' : '' }}">
                        <i class="fas fa-calendar-plus mr-1.5"></i> Booking
                    </a>
                    <a href="{{ route('user.bookings.my') }}"
                       class="nav-link {{ request()->routeIs('user.bookings.my') ? 'nav-active' : '' }}">
                        <i class="fas fa-clipboard-list mr-1.5"></i> Booking Saya
                    </a>
                    <a href="{{ route('user.notifications') }}"
                       class="nav-link relative {{ request()->routeIs('user.notifications*') ? 'nav-active' : '' }}">
                        <i class="fas fa-bell mr-1.5"></i> Notifikasi
                        @php $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-0.5 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold rounded-full nav-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                    <button type="button" class="user-chip">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_path)
                                            <img class="h-8 w-8 rounded-full object-cover ring-2 ring-white/50" src="{{ url('storage/' . Auth::user()->profile_photo_path) }}?v={{ Auth::user()->updated_at?->timestamp }}" alt="{{ Auth::user()->name }}" />
                                        @else
                                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                        @endif
                                        <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                        <svg class="ms-1.5 -me-0.5 h-3.5 w-3.5 opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="dropdown-profile">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_path)
                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-100" src="{{ url('storage/' . Auth::user()->profile_photo_path) }}?v={{ Auth::user()->updated_at?->timestamp }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <div class="dropdown-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <p class="dropdown-name">{{ Auth::user()->name }}</p>
                                    <small class="dropdown-email">{{ Auth::user()->email }}</small>
                                </div>
                            </div>

                            <x-dropdown-link href="{{ route('user.profile') }}">
                                <i class="fas fa-user-cog mr-2" style="color: #6366f1;"></i> {{ __('Profile') }}
                            </x-dropdown-link>

                            <div class="dropdown-divider"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" style="color: #dc2626;">
                                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl transition duration-150 ease-in-out hover:bg-white/10" style="color: white;">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
         class="hidden sm:hidden" style="background: rgba(255,255,255,0.08); border-top: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(10px);">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <a href="{{ route('dashboard') }}" class="mobile-link {{ request()->routeIs('dashboard') ? 'mobile-active' : '' }}">
                <i class="fas fa-home w-5 mr-2.5 text-center"></i> Dashboard
            </a>
            <a href="{{ route('user.rooms') }}" class="mobile-link {{ request()->routeIs('user.rooms*') ? 'mobile-active' : '' }}">
                <i class="fas fa-door-open w-5 mr-2.5 text-center"></i> Daftar Ruangan
            </a>
            <a href="{{ route('user.bookings.create') }}" class="mobile-link {{ request()->routeIs('user.bookings.create') ? 'mobile-active' : '' }}">
                <i class="fas fa-calendar-plus w-5 mr-2.5 text-center"></i> Booking Ruangan
            </a>
            <a href="{{ route('user.bookings.my') }}" class="mobile-link {{ request()->routeIs('user.bookings.my') ? 'mobile-active' : '' }}">
                <i class="fas fa-clipboard-list w-5 mr-2.5 text-center"></i> Booking Saya
            </a>
            <a href="{{ route('user.notifications') }}" class="mobile-link {{ request()->routeIs('user.notifications*') ? 'mobile-active' : '' }}">
                <i class="fas fa-bell w-5 mr-2.5 text-center"></i> Notifikasi
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t px-4 py-4" style="border-color: rgba(255,255,255,0.15);">
            <div class="flex items-center">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_path)
                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white/50" src="{{ url('storage/' . Auth::user()->profile_photo_path) }}?v={{ Auth::user()->updated_at?->timestamp }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="user-avatar" style="width: 42px; height: 42px; font-size: 1rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="ml-3">
                    <div class="font-semibold text-base" style="color: white;">{{ Auth::user()->name }}</div>
                    <div class="text-sm" style="color: rgba(255,255,255,0.65);">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('user.profile') }}" class="mobile-link">
                    <i class="fas fa-user-cog w-5 mr-2.5 text-center"></i> Profile
                </a>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium transition hover:bg-white/10" style="color: #fda4af;">
                        <i class="fas fa-sign-out-alt w-5 mr-2.5 text-center"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
