<x-app-layout pageTitle="Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Banner -->
            <div class="mb-6 overflow-hidden shadow-lg rounded-2xl" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="p-8 text-white relative">
                    <!-- Decorative circles -->
                    <div class="absolute top-0 right-0 w-40 h-40 rounded-full opacity-10" style="background: white; transform: translate(30%, -30%);"></div>
                    <div class="absolute bottom-0 right-20 w-24 h-24 rounded-full opacity-10" style="background: white; transform: translate(0, 40%);"></div>

                    <h1 class="text-2xl font-bold relative z-10">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="mt-2 opacity-90 relative z-10">Kelola peminjaman ruangan dengan mudah. Gunakan menu di bawah untuk melakukan booking atau melihat status booking Anda.</p>

                    <!-- Stats mini di banner -->
                    <div class="flex gap-6 mt-6 relative z-10">
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-calendar"></i>
                            <span class="text-sm font-semibold">{{ $stats['total'] }} Booking</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-clock"></i>
                            <span class="text-sm font-semibold">{{ $stats['pending'] }} Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards — Warna-warni -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Booking — Biru -->
                <div class="overflow-hidden shadow-lg rounded-2xl hover:shadow-xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <div class="p-5 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 rounded-xl" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-calendar text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold">{{ $stats['total'] }}</span>
                        </div>
                        <p class="text-sm opacity-90 font-medium">Total Booking</p>
                        <!-- Mini progress bar -->
                        <div class="mt-3 h-1.5 rounded-full" style="background: rgba(255,255,255,0.3);">
                            <div class="h-full rounded-full" style="background: white; width: {{ $stats['total'] > 0 ? 100 : 0 }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Pending — Kuning/Amber -->
                <div class="overflow-hidden shadow-lg rounded-2xl hover:shadow-xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <div class="p-5 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 rounded-xl" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold">{{ $stats['pending'] }}</span>
                        </div>
                        <p class="text-sm opacity-90 font-medium">Menunggu</p>
                        <div class="mt-3 h-1.5 rounded-full" style="background: rgba(255,255,255,0.3);">
                            <div class="h-full rounded-full" style="background: white; width: {{ $stats['total'] > 0 ? ($stats['pending'] / $stats['total'] * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Approved — Hijau -->
                <div class="overflow-hidden shadow-lg rounded-2xl hover:shadow-xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                    <div class="p-5 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 rounded-xl" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold">{{ $stats['approved'] }}</span>
                        </div>
                        <p class="text-sm opacity-90 font-medium">Disetujui</p>
                        <div class="mt-3 h-1.5 rounded-full" style="background: rgba(255,255,255,0.3);">
                            <div class="h-full rounded-full" style="background: white; width: {{ $stats['total'] > 0 ? ($stats['approved'] / $stats['total'] * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Rejected — Merah -->
                <div class="overflow-hidden shadow-lg rounded-2xl hover:shadow-xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <div class="p-5 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-3 rounded-xl" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-times-circle text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold">{{ $stats['rejected'] }}</span>
                        </div>
                        <p class="text-sm opacity-90 font-medium">Ditolak</p>
                        <div class="mt-3 h-1.5 rounded-full" style="background: rgba(255,255,255,0.3);">
                            <div class="h-full rounded-full" style="background: white; width: {{ $stats['total'] > 0 ? ($stats['rejected'] / $stats['total'] * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions — Gradient Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Booking Ruangan — Ungu -->
                <a href="{{ route('user.bookings.create') }}" class="group overflow-hidden rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80 font-medium">Ajukan</p>
                                <h3 class="text-lg font-bold mt-1">Booking Ruangan</h3>
                            </div>
                            <div class="p-3 rounded-full transition-all" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 flex items-center text-sm font-medium" style="border-top: 1px solid rgba(255,255,255,0.2);">
                            <span>Mulai Booking</span>
                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </div>
                    </div>
                </a>

                <!-- Booking Saya — Teal -->
                <a href="{{ route('user.bookings.my') }}" class="group overflow-hidden rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80 font-medium">Status</p>
                                <h3 class="text-lg font-bold mt-1">Booking Saya</h3>
                            </div>
                            <div class="p-3 rounded-full transition-all" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-list text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 flex items-center text-sm font-medium" style="border-top: 1px solid rgba(255,255,255,0.2);">
                            <span>Lihat Semua</span>
                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </div>
                    </div>
                </a>

                <!-- Daftar Ruangan — Orange -->
                <a href="{{ route('user.rooms') }}" class="group overflow-hidden rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80 font-medium">Jelajahi</p>
                                <h3 class="text-lg font-bold mt-1">Daftar Ruangan</h3>
                            </div>
                            <div class="p-3 rounded-full transition-all" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-door-open text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 flex items-center text-sm font-medium" style="border-top: 1px solid rgba(255,255,255,0.2);">
                            <span>Lihat Ruangan</span>
                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </div>
                    </div>
                </a>

                <!-- Notifikasi — Biru Muda -->
                <a href="{{ route('user.notifications') }}" class="group overflow-hidden rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80 font-medium">Info</p>
                                <h3 class="text-lg font-bold mt-1">Notifikasi</h3>
                            </div>
                            <div class="p-3 rounded-full transition-all relative" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-bell text-xl"></i>
                                @php $dashNotif = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count(); @endphp
                                @if($dashNotif > 0)
                                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white rounded-full" style="background: #ef4444;">{{ $dashNotif }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 pt-3 flex items-center text-sm font-medium" style="border-top: 1px solid rgba(255,255,255,0.2);">
                            <span>Buka Notifikasi</span>
                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6" style="background: linear-gradient(135deg, #f0f9ff 0%, #ede9fe 100%); border-bottom: 1px solid #e5e7eb;">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-history mr-2" style="color: #6366f1;"></i> Booking Terakhir
                        </h3>
                        <a href="{{ route('user.bookings.my') }}" class="text-sm font-medium px-4 py-2 rounded-xl transition-all hover:opacity-80" style="color: #6366f1; background: #ede9fe;">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($myBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($myBookings as $booking)
                            <div class="flex items-center justify-between p-4 rounded-xl transition-all hover:shadow-md" style="background: #f9fafb;">
                                <div class="flex items-center">
                                    @if($booking->status === 'pending')
                                        <div class="p-3 rounded-full" style="background: #fef3c7;">
                                            <i class="fas fa-clock" style="color: #d97706;"></i>
                                        </div>
                                    @elseif($booking->status === 'approved')
                                        <div class="p-3 rounded-full" style="background: #dcfce7;">
                                            <i class="fas fa-check" style="color: #16a34a;"></i>
                                        </div>
                                    @else
                                        <div class="p-3 rounded-full" style="background: #fee2e2;">
                                            <i class="fas fa-times" style="color: #dc2626;"></i>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <p class="font-semibold text-gray-800">{{ $booking->room->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1 text-xs"></i>
                                            {{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if($booking->status === 'pending')
                                        <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: #fef3c7; color: #92400e;">Menunggu</span>
                                    @elseif($booking->status === 'approved')
                                        <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: #dcfce7; color: #166534;">Disetujui</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: #fee2e2; color: #991b1b;">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4" style="background: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 100%);">
                                <i class="fas fa-calendar-plus text-3xl" style="color: #8b5cf6;"></i>
                            </div>
                            <p class="text-gray-500 mb-4 font-medium">Belum ada booking</p>
                            <a href="{{ route('user.bookings.create') }}" class="inline-flex items-center px-6 py-3 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
                                <i class="fas fa-plus mr-2"></i> Buat Booking Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
