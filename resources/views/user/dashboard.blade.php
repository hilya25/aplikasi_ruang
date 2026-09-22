<x-app-layout pageTitle="Dashboard">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                    <i class="fas fa-calendar-day mr-1.5"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                          style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                        <i class="fas fa-house-chimney-window"></i>
                    </span>
                    Hai, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                </h2>
            </div>
            <a href="{{ route('user.bookings.create') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg"
               style="background: rgba(255,255,255,0.95); color: #4338ca; backdrop-filter: blur(8px);">
                <i class="fas fa-circle-plus mr-2 text-rose-500"></i> Booking Sekarang
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 mb-8">
                <!-- Total Booking -->
                <div class="aesthetic-card aesthetic-card-hover stat-card-shimmer animate-fade-up animate-fade-up-1 p-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-10" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);"></div>
                    <i class="fas fa-calendar-days absolute right-5 bottom-4 text-4xl opacity-5" style="color: #6366f1;"></i>
                    <div class="flex items-center relative z-10">
                        <div class="p-3.5 rounded-2xl mr-4 shadow-md" style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                            <i class="fas fa-calendar text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Booking</p>
                            <p class="text-2xl font-extrabold" style="color: #4338ca;" data-count="{{ $stats['total'] }}">0</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-indigo-50 text-xs font-medium" style="color: #818cf8;">
                        <i class="fas fa-chart-simple mr-1"></i> Semua pengajuan Anda
                    </div>
                </div>

                <!-- Pending -->
                <div class="aesthetic-card aesthetic-card-hover stat-card-shimmer animate-fade-up animate-fade-up-2 p-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-10" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);"></div>
                    <i class="fas fa-hourglass-half absolute right-5 bottom-4 text-4xl opacity-5" style="color: #f59e0b;"></i>
                    <div class="flex items-center relative z-10">
                        <div class="p-3.5 rounded-2xl mr-4 shadow-md" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Menunggu</p>
                            <p class="text-2xl font-extrabold" style="color: #b45309;" data-count="{{ $stats['pending'] }}">0</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-amber-50 text-xs font-medium" style="color: #f59e0b;">
                        <i class="fas fa-hourglass-start mr-1"></i> Menunggu persetujuan admin
                    </div>
                </div>

                <!-- Approved -->
                <div class="aesthetic-card aesthetic-card-hover stat-card-shimmer animate-fade-up animate-fade-up-3 p-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-10" style="background: linear-gradient(135deg, #10b981, #34d399);"></div>
                    <i class="fas fa-badge-check absolute right-5 bottom-4 text-4xl opacity-5" style="color: #10b981;"></i>
                    <div class="flex items-center relative z-10">
                        <div class="p-3.5 rounded-2xl mr-4 shadow-md" style="background: linear-gradient(135deg, #10b981, #34d399);">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Disetujui</p>
                            <p class="text-2xl font-extrabold" style="color: #047857;" data-count="{{ $stats['approved'] }}">0</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-emerald-50 text-xs font-medium" style="color: #10b981;">
                        <i class="fas fa-thumbs-up mr-1"></i> Siap digunakan
                    </div>
                </div>

                <!-- Rejected -->
                <div class="aesthetic-card aesthetic-card-hover stat-card-shimmer animate-fade-up animate-fade-up-4 p-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-10" style="background: linear-gradient(135deg, #ef4444, #f87171);"></div>
                    <i class="fas fa-circle-xmark absolute right-5 bottom-4 text-4xl opacity-5" style="color: #ef4444;"></i>
                    <div class="flex items-center relative z-10">
                        <div class="p-3.5 rounded-2xl mr-4 shadow-md" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                            <i class="fas fa-times text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Ditolak</p>
                            <p class="text-2xl font-extrabold" style="color: #b91c1c;" data-count="{{ $stats['rejected'] }}">0</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-red-50 text-xs font-medium" style="color: #ef4444;">
                        <i class="fas fa-rotate-right mr-1"></i> Coba jadwal lain
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="aesthetic-card animate-fade-up animate-fade-up-3 p-6 mb-8 relative overflow-hidden reveal">
                <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full opacity-[0.04]" style="background: linear-gradient(135deg, #6366f1, #ec4899);"></div>
                <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center relative z-10">
                    <span class="w-10 h-10 rounded-xl mr-3 inline-flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-bolt text-white"></i>
                    </span>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 relative z-10">
                    <a href="{{ route('user.bookings.create') }}"
                       class="group flex items-center p-4 rounded-2xl text-white transition-all hover:scale-[1.03] active:scale-95 shadow-lg"
                       style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 10px 24px -10px rgba(99,102,241,0.7);">
                        <span class="w-11 h-11 rounded-xl inline-flex items-center justify-center mr-3 text-lg transition-transform group-hover:rotate-6"
                              style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span>
                            <span class="block font-bold text-sm">Booking Ruangan</span>
                            <span class="block text-xs opacity-80">Ajukan peminjaman baru</span>
                        </span>
                    </a>
                    <a href="{{ route('user.rooms') }}"
                       class="group flex items-center p-4 rounded-2xl font-semibold transition-all hover:scale-[1.03] active:scale-95 border shadow-sm"
                       style="background: linear-gradient(135deg, #eff6ff, #f0f9ff); color: #1d4ed8; border-color: #bfdbfe;">
                        <span class="w-11 h-11 rounded-xl inline-flex items-center justify-center mr-3 text-lg transition-transform group-hover:rotate-6 shadow-sm"
                              style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                            <i class="fas fa-door-open text-white"></i>
                        </span>
                        <span>
                            <span class="block font-bold text-sm">Lihat Ruangan</span>
                            <span class="block text-xs" style="color: #60a5fa;">Jelajahi semua ruangan</span>
                        </span>
                    </a>
                    <a href="{{ route('user.bookings.my') }}"
                       class="group flex items-center p-4 rounded-2xl font-semibold transition-all hover:scale-[1.03] active:scale-95 border shadow-sm"
                       style="background: linear-gradient(135deg, #fdf4ff, #faf5ff); color: #a21caf; border-color: #f5d0fe;">
                        <span class="w-11 h-11 rounded-xl inline-flex items-center justify-center mr-3 text-lg transition-transform group-hover:rotate-6 shadow-sm"
                              style="background: linear-gradient(135deg, #d946ef, #e879f9);">
                            <i class="fas fa-clipboard-list text-white"></i>
                        </span>
                        <span>
                            <span class="block font-bold text-sm">Booking Saya</span>
                            <span class="block text-xs" style="color: #d946ef;">Kelola pengajuan Anda</span>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="aesthetic-card animate-fade-up animate-fade-up-4 overflow-hidden reveal">
                <div class="p-6 flex items-center justify-between border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="w-10 h-10 rounded-xl mr-3 inline-flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #06b6d4, #22d3ee);">
                            <i class="fas fa-clock-rotate-left text-white"></i>
                        </span>
                        Booking Terakhir
                    </h3>
                    <a href="{{ route('user.bookings.my') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-indigo-50">
                        Lihat semua <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="p-6">
                    @if($myBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-400 border-b border-gray-100 uppercase text-xs tracking-wider">
                                        <th class="pb-3 font-semibold"><i class="fas fa-door-open mr-1.5"></i>Ruangan</th>
                                        <th class="pb-3 font-semibold"><i class="fas fa-tag mr-1.5"></i>Jenis</th>
                                        <th class="pb-3 font-semibold"><i class="fas fa-clock mr-1.5"></i>Waktu</th>
                                        <th class="pb-3 font-semibold"><i class="fas fa-circle-info mr-1.5"></i>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myBookings as $booking)
                                    <tr class="border-b border-gray-50 hover:bg-indigo-50/40 transition-colors">
                                        <td class="py-3.5 font-semibold text-gray-800">
                                            <div class="flex items-center">
                                                <span class="w-9 h-9 rounded-xl mr-3 inline-flex items-center justify-center shadow-sm
                                                    @if($booking->room->type === 'Kelas') {{ 'bg-gradient-to-br from-blue-500 to-indigo-500' }}
                                                    @elseif($booking->room->type === 'Lab') {{ 'bg-gradient-to-br from-purple-500 to-pink-500' }}
                                                    @elseif($booking->room->type === 'Aula') {{ 'bg-gradient-to-br from-orange-500 to-red-500' }}
                                                    @elseif($booking->room->type === 'Lapangan') {{ 'bg-gradient-to-br from-green-500 to-emerald-500' }}
                                                    @elseif($booking->room->type === 'Masjid') {{ 'bg-gradient-to-br from-teal-500 to-cyan-500' }}
                                                    @elseif($booking->room->type === 'Activity Room') {{ 'bg-gradient-to-br from-pink-500 to-rose-500' }}
                                                    @elseif($booking->room->type === 'Perpustakaan') {{ 'bg-gradient-to-br from-amber-500 to-yellow-500' }}
                                                    @else {{ 'bg-gradient-to-br from-gray-400 to-gray-500' }} @endif">
                                                    <i class="fas @if($booking->room->type === 'Kelas') fa-chalkboard-user
                                                             @elseif($booking->room->type === 'Lab') fa-flask
                                                             @elseif($booking->room->type === 'Aula') fa-building
                                                             @elseif($booking->room->type === 'Lapangan') fa-futbol
                                                             @elseif($booking->room->type === 'Masjid') fa-mosque
                                                             @elseif($booking->room->type === 'Activity Room') fa-person-running
                                                             @elseif($booking->room->type === 'Perpustakaan') fa-book-open
                                                             @else fa-door-open @endif text-white text-xs"></i>
                                                </span>
                                                {{ $booking->room->name }}
                                            </div>
                                        </td>
                                        <td class="py-3.5">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                                @if($booking->event_type === 'Pinjam') style="background: #eef2ff; color: #4f46e5;"
                                                @elseif($booking->event_type === 'Acara Sekolah') style="background: #fdf4ff; color: #a21caf;"
                                                @else style="background: #f0fdfa; color: #0f766e;" @endif>
                                                <i class="fas @if($booking->event_type === 'Pinjam') fa-hand-holding
                                                         @elseif($booking->event_type === 'Acara Sekolah') fa-graduation-cap
                                                         @else fa-broom @endif mr-1.5"></i>
                                                {{ $booking->event_type }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 text-gray-500">
                                            <i class="far fa-calendar mr-1.5 text-gray-300"></i>{{ \Carbon\Carbon::parse($booking->start_datetime)->translatedFormat('d M Y') }}
                                            <span class="text-gray-300 mx-1">•</span>
                                            <i class="far fa-clock mr-1 text-gray-300"></i>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('H:i') }}
                                        </td>
                                        <td class="py-3.5">
                                            @if($booking->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #fef3c7; color: #92400e;">
                                                    <i class="fas fa-hourglass-half mr-1.5 text-amber-500"></i> Menunggu
                                                </span>
                                            @elseif($booking->status === 'approved' && \Carbon\Carbon::parse($booking->end_datetime)->isFuture())
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #d1fae5; color: #065f46;">
                                                    <i class="fas fa-check-circle mr-1.5 text-emerald-500"></i> Disetujui
                                                </span>
                                            @elseif($booking->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #f3f4f6; color: #374151;">
                                                    <i class="fas fa-check-double mr-1.5 text-gray-500"></i> Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #fee2e2; color: #991b1b;">
                                                    <i class="fas fa-times-circle mr-1.5 text-red-500"></i> Ditolak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="relative inline-block mb-4">
                                <div class="w-20 h-20 rounded-3xl inline-flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                                    <i class="fas fa-calendar-plus text-indigo-300 text-3xl"></i>
                                </div>
                                <span class="absolute -top-1 -right-1 w-7 h-7 rounded-full inline-flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                                    <i class="fas fa-wand-magic-sparkles text-white text-xs"></i>
                                </span>
                            </div>
                            <p class="text-gray-600 mb-1 font-bold">Belum ada booking</p>
                            <p class="text-gray-400 text-sm mb-4">Mulai booking ruangan pertama Anda sekarang.</p>
                            <a href="{{ route('user.bookings.create') }}"
                               class="inline-flex items-center px-5 py-2.5 text-white rounded-xl font-semibold transition-all hover:scale-105 shadow-lg"
                               style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                                <i class="fas fa-plus mr-2"></i> Buat Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
