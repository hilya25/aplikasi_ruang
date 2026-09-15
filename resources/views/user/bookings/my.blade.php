<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                    <i class="fas fa-folder-open mr-1.5"></i> Booking Saya
                </p>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                          style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                        <i class="fas fa-clipboard-list"></i>
                    </span>
                    Daftar Booking Anda
                </h2>
            </div>
            <a href="{{ route('user.bookings.create') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg"
               style="background: rgba(255,255,255,0.95); color: #4338ca; backdrop-filter: blur(8px);">
                <i class="fas fa-circle-plus mr-2 text-indigo-500"></i> Booking Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Success/Error -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl flex items-center animate-fade-up" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0;">
                    <div class="p-2.5 rounded-xl mr-3" style="background: rgba(255,255,255,0.7);">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-2xl flex items-center animate-fade-up" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fecaca;">
                    <div class="p-2.5 rounded-xl mr-3" style="background: rgba(255,255,255,0.7);">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                    </div>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Bookings Card -->
            <div class="aesthetic-card animate-fade-up">
                <div class="p-6 flex items-center border-b border-gray-100">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <i class="fas fa-list-ul text-white"></i>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Booking Saya</h3>
                </div>
                <div class="p-4">
                    @if($bookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($bookings as $booking)
                            <div class="flex items-center justify-between p-4 rounded-xl border transition-all hover:shadow-md" style="border-color: #f1f5f9; background: #f8fafc;">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl mr-4 flex-shrink-0 inline-flex items-center justify-center shadow-sm text-white
                                        @if($booking->room->type === 'Kelas') {{ 'bg-gradient-to-br from-blue-500 to-indigo-600' }}
                                        @elseif($booking->room->type === 'Lab') {{ 'bg-gradient-to-br from-purple-500 to-pink-600' }}
                                        @elseif($booking->room->type === 'Aula') {{ 'bg-gradient-to-br from-orange-500 to-red-500' }}
                                        @elseif($booking->room->type === 'Lapangan') {{ 'bg-gradient-to-br from-green-500 to-emerald-600' }}
                                        @elseif($booking->room->type === 'Masjid') {{ 'bg-gradient-to-br from-teal-500 to-cyan-600' }}
                                        @elseif($booking->room->type === 'Activity Room') {{ 'bg-gradient-to-br from-pink-500 to-rose-600' }}
                                        @else {{ 'bg-gradient-to-br from-gray-400 to-gray-500' }} @endif">
                                        <i class="fas @if($booking->room->type === 'Kelas') fa-chalkboard-user
                                                 @elseif($booking->room->type === 'Lab') fa-flask
                                                 @elseif($booking->room->type === 'Aula') fa-building
                                                 @elseif($booking->room->type === 'Lapangan') fa-futbol
                                                 @elseif($booking->room->type === 'Masjid') fa-mosque
                                                 @elseif($booking->room->type === 'Activity Room') fa-person-running
                                                 @else fa-door-open @endif"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $booking->room->name }}</p>
                                        <p class="text-sm text-gray-500 flex items-center mt-0.5">
                                            <i class="fas fa-calendar-day mr-1.5 text-gray-400"></i>
                                            {{ \Carbon\Carbon::parse($booking->start_datetime)->translatedFormat('d M Y') }}
                                            <span class="text-gray-300 mx-1.5">•</span>
                                            <i class="fas fa-clock mr-1 text-gray-400"></i>
                                            {{ \Carbon\Carbon::parse($booking->start_datetime)->format('H:i') }}
                                            <span class="text-gray-300 mx-1">—</span>
                                            {{ \Carbon\Carbon::parse($booking->end_datetime)->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    @if($booking->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #fef3c7; color: #92400e;">
                                            <i class="fas fa-hourglass-half mr-1.5 text-amber-500"></i> Menunggu
                                        </span>
                                        <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-all hover:scale-105 active:scale-95" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                                <i class="fas fa-times mr-1"></i> Batal
                                            </button>
                                        </form>
                                    @elseif($booking->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #d1fae5; color: #065f46;">
                                            <i class="fas fa-check-circle mr-1.5 text-emerald-500"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #fee2e2; color: #991b1b;">
                                            <i class="fas fa-times-circle mr-1.5 text-red-500"></i> Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                                <i class="fas fa-calendar-times text-indigo-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada booking</p>
                            <p class="text-gray-400 text-sm mt-1 mb-5">Mulai booking ruangan pertama Anda.</p>
                            <a href="{{ route('user.bookings.create') }}"
                               class="inline-flex items-center px-6 py-3 text-white rounded-xl transition-all hover:scale-105 active:scale-95 font-semibold"
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
