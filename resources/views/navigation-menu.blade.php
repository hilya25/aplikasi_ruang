<nav x-data="{ open: false }" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 15px rgba(102,126,234,0.3);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">

                <!-- Logo -->
                <div class="flex items-center mr-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center" style="text-decoration: none;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-school" style="color: white; font-size: 1.1rem;"></i>
                        </div>
                        <span style="color: white; font-weight: 700; font-size: 1.1rem; margin-left: 10px;">RoomBook</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all" style="color: {{ request()->routeIs('dashboard') ? 'white' : 'rgba(255,255,255,0.8)' }}; background: {{ request()->routeIs('dashboard') ? 'rgba(255,255,255,0.2)' : 'transparent' }};">
                        <i class="fas fa-home mr-1.5"></i> Dashboard
                    </a>
                    <a href="{{ route('user.rooms') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all" style="color: {{ request()->routeIs('user.rooms*') ? 'white' : 'rgba(255,255,255,0.8)' }}; background: {{ request()->routeIs('user.rooms*') ? 'rgba(255,255,255,0.2)' : 'transparent' }};">
                        <i class="fas fa-door-open mr-1.5"></i> Ruangan
                    </a>
                    <a href="{{ route('user.bookings.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all" style="color: {{ request()->routeIs('user.bookings.create') ? 'white' : 'rgba(255,255,255,0.8)' }}; background: {{ request()->routeIs('user.bookings.create') ? 'rgba(255,255,255,0.2)' : 'transparent' }};">
                        <i class="fas fa-calendar-plus mr-1.5"></i> Booking
                    </a>
                    <a href="{{ route('user.bookings.my') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all" style="color: {{ request()->routeIs('user.bookings.my') ? 'white' : 'rgba(255,255,255,0.8)' }}; background: {{ request()->routeIs('user.bookings.my') ? 'rgba(255,255,255,0.2)' : 'transparent' }};">
                        <i class="fas fa-clipboard-list mr-1.5"></i> Booking Saya
                    </a>
                    <a href="{{ route('user.notifications') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all relative" style="color: {{ request()->routeIs('user.notifications*') ? 'white' : 'rgba(255,255,255,0.8)' }}; background: {{ request()->routeIs('user.notifications*') ? 'rgba(255,255,255,0.2)' : 'transparent' }};">
                        <i class="fas fa-bell mr-1.5"></i> Notifikasi
                        @php $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="ml-1.5 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold rounded-full" style="background: #ef4444; color: white; min-width: 20px;">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-white rounded-full focus:outline-none focus:border-white transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 rounded-xl text-sm font-medium transition" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                                        <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; margin-right: 8px;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <div style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; margin-bottom: 4px;">
                                <p style="font-weight: 700; color: #1f2937; margin: 0;">{{ Auth::user()->name }}</p>
                                <small style="color: #9ca3af;">{{ Auth::user()->email }}</small>
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                <i class="fas fa-user-cog mr-2" style="color: #6366f1;"></i> {{ __('Profile') }}
                            </x-dropdown-link>

                            <div style="height: 1px; background: #f3f4f6; margin: 4px 0;"></div>

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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out" style="color: white;">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: rgba(255,255,255,0.1); border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium" style="color: white; {{ request()->routeIs('dashboard') ? 'background: rgba(255,255,255,0.2);' : '' }}">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('user.rooms') }}" class="block px-4 py-3 rounded-xl text-sm font-medium" style="color: white; {{ request()->routeIs('user.rooms*') ? 'background: rgba(255,255,255,0.2);' : '' }}">
                <i class="fas fa-door-open mr-2"></i> Daftar Ruangan
            </a>
            <a href="{{ route('user.bookings.create') }}" class="block px-4 py-3 rounded-xl text-sm font-medium" style="color: white; {{ request()->routeIs('user.bookings.create') ? 'background: rgba(255,255,255,0.2);' : '' }}">
                <i class="fas fa-calendar-plus mr-2"></i> Booking Ruangan
            </a>
            <a href="{{ route('user.bookings.my') }}" class="block px-4 py-3 rounded-xl text-sm font-medium" style="color: white; {{ request()->routeIs('user.bookings.my') ? 'background: rgba(255,255,255,0.2);' : '' }}">
                <i class="fas fa-clipboard-list mr-2"></i> Booking Saya
            </a>
            <a href="{{ route('user.notifications') }}" class="block px-4 py-3 rounded-xl text-sm font-medium" style="color: white; {{ request()->routeIs('user.notifications*') ? 'background: rgba(255,255,255,0.2);' : '' }}">
                <i class="fas fa-bell mr-2"></i> Notifikasi
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t px-4 py-4" style="border-color: rgba(255,255,255,0.15);">
            <div class="flex items-center">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-right: 12px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-base" style="color: white;">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm" style="color: rgba(255,255,255,0.7);">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.show') }}" class="block px-4 py-3 rounded-xl text-sm font-medium" style="color: white;">
                    <i class="fas fa-user-cog mr-2"></i> Profile
                </a>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium" style="color: #fca5a5;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
