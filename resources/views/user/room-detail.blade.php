<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                <i class="fas fa-map-location-dot mr-1.5"></i> Detail Ruangan
            </p>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                      style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                    <i class="fas @if($room->type === 'Kelas') fa-chalkboard-user
                             @elseif($room->type === 'Lab') fa-flask
                             @elseif($room->type === 'Aula') fa-building
                             @elseif($room->type === 'Lapangan') fa-futbol
                             @elseif($room->type === 'Masjid') fa-mosque
                             @elseif($room->type === 'Activity Room') fa-person-running
                             @elseif($room->type === 'Perpustakaan') fa-book-open
                             @else fa-door-open @endif"></i>
                </span>
                {{ $room->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="w-full px-6 sm:px-10 lg:px-16">

            <!-- Info Ruangan -->
            <div class="aesthetic-card overflow-hidden mb-8 animate-fade-up">
                @if($room->image)
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(49,46,129,0.55), transparent 55%);"></div>
                        <div class="absolute bottom-4 left-6">
                            <span class="px-3 py-1.5 text-sm font-semibold rounded-full backdrop-blur-md"
                                  style="background: rgba(255,255,255,0.9); color: #4338ca;">{{ $room->type }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                @else
                    <div class="p-6">
                @endif
                    @if(!$room->image)
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-extrabold text-gray-800">{{ $room->name }}</h1>
                            <span class="px-3 py-1.5 text-sm font-semibold rounded-full
                                @if($room->type === 'Kelas') bg-blue-100 text-blue-700
                                @elseif($room->type === 'Lab') bg-purple-100 text-purple-700
                                @elseif($room->type === 'Aula') bg-orange-100 text-orange-700
                                @elseif($room->type === 'Lapangan') bg-green-100 text-green-700
                                @elseif($room->type === 'Masjid') bg-teal-100 text-teal-700
                                @elseif($room->type === 'Activity Room') bg-pink-100 text-pink-700
                                @elseif($room->type === 'Perpustakaan') bg-amber-100 text-amber-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ $room->type }}
                            </span>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-2">
                        @if($room->location)
                            <div class="flex items-center p-3 rounded-xl border" style="background: linear-gradient(135deg, #fef2f2, #fff1f2); border-color: #fecaca;">
                                <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                                    <i class="fas fa-location-dot text-white text-sm"></i>
                                </span>
                                <span>
                                    <span class="block text-xs text-gray-400 font-medium">Lokasi</span>
                                    <span class="block text-sm text-gray-700 font-semibold">{{ $room->location }}</span>
                                </span>
                            </div>
                        @endif
                        @if($room->capacity)
                            <div class="flex items-center p-3 rounded-xl border" style="background: linear-gradient(135deg, #eff6ff, #f0f9ff); border-color: #bfdbfe;">
                                <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                                    <i class="fas fa-users text-white text-sm"></i>
                                </span>
                                <span>
                                    <span class="block text-xs text-gray-400 font-medium">Kapasitas</span>
                                    <span class="block text-sm text-gray-700 font-semibold">{{ $room->capacity }} orang</span>
                                </span>
                            </div>
                        @endif
                        @if($room->type)
                            <div class="flex items-center p-3 rounded-xl border" style="background: linear-gradient(135deg, #fdf4ff, #faf5ff); border-color: #f5d0fe;">
                                <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(135deg, #d946ef, #e879f9);">
                                    <i class="fas fa-shapes text-white text-sm"></i>
                                </span>
                                <span>
                                    <span class="block text-xs text-gray-400 font-medium">Jenis</span>
                                    <span class="block text-sm text-gray-700 font-semibold">{{ $room->type }}</span>
                                </span>
                            </div>
                        @endif
                    </div>

                    @if($room->description)
                        <p class="mt-3 text-gray-500 text-sm leading-relaxed">{{ $room->description }}</p>
                    @endif

                    <!-- Tombol Booking -->
                    <a href="{{ route('user.bookings.create') }}"
                       class="mt-5 inline-flex items-center px-6 py-3 text-white rounded-xl transition-all hover:scale-105 active:scale-95 font-semibold"
                       style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                        <i class="fas fa-calendar-plus mr-2"></i> Booking Ruangan Ini
                    </a>
                </div>
            </div>

            <!-- Jadwal Pelajaran per Hari -->
            <div class="aesthetic-card mb-8 animate-fade-up-2 animate-fade-up">
                <div class="p-6 flex items-center border-b border-gray-100">
                    <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                        <i class="fas fa-calendar-week text-indigo-500"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Jadwal Pelajaran</h3>
                        <p class="text-sm text-gray-400">Lihat jam yang sudah terisi sebelum booking</p>
                    </div>
                </div>
                <div class="p-6">
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        $grouped = $schedules->groupBy('day_of_week');
                    @endphp

                    @if($schedules->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            @foreach($days as $day)
                                @if(isset($grouped[$day]) && $grouped[$day]->count() > 0)
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2.5">
                                        <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-sm font-bold shadow-sm
                                            @if(in_array($day, ['Senin','Selasa','Rabu'])) bg-gradient-to-r from-blue-500 to-indigo-500 text-white
                                            @else bg-gradient-to-r from-emerald-500 to-teal-500 text-white @endif">
                                            {{ $day }}
                                        </span>
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($grouped[$day] as $s)
                                        <div class="p-3.5 rounded-xl border transition-all hover:shadow-md" style="background: #f8fafc; border-color: #eef2f7;">
                                            <div class="flex items-center justify-between mb-1.5">
                                                <p class="font-semibold text-gray-800 text-sm">
                                                    {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}
                                                    <span class="text-gray-300 mx-1">—</span>
                                                    {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                                                </p>
                                                <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0" title="Terisi"></span>
                                            </div>
                                            @if($s->subject)
                                                <p class="text-sm font-medium text-gray-700 mb-0.5">{{ $s->subject }}</p>
                                            @endif
                                            @if($s->teacher)
                                                <p class="text-xs text-gray-500 mb-0.5">{{ $s->teacher }}</p>
                                            @endif
                                            @if($s->classRoom)
                                                <p class="text-xs text-gray-400">{{ $s->classRoom->name }}</p>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-3" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                                <i class="fas fa-calendar-times text-indigo-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada jadwal pelajaran untuk ruangan ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking yang Disetujui -->
            <div class="aesthetic-card animate-fade-up-3 animate-fade-up">
                <div class="p-6 flex items-center border-b border-gray-100">
                    <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                        <i class="fas fa-calendar-check text-emerald-500"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Jadwal Booking Disetujui Admin</h3>
                        <p class="text-sm text-gray-400">Tanggal, jam, dan jenis acara yang telah dijadwalkan</p>
                    </div>
                </div>
                <div class="p-6">
                    @if($bookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($bookings as $b)
                            <div class="flex items-center p-4 rounded-xl border transition-all hover:shadow-md" style="background: #f8fafc; border-color: #eef2f7;">
                                <div class="p-2.5 rounded-lg mr-3" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                                    <i class="fas fa-calendar-check text-emerald-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">
                                        <i class="far fa-calendar mr-1.5 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($b->start_datetime)->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="far fa-clock mr-1.5 text-gray-400"></i>
                                        {{ \Carbon\Carbon::parse($b->start_datetime)->format('H:i') }}
                                        <span class="text-gray-300 mx-1">—</span>
                                        {{ \Carbon\Carbon::parse($b->end_datetime)->format('H:i') }}
                                        <span class="text-gray-300 mx-2">•</span>
                                        <i class="fas fa-tag mr-1 text-gray-400"></i>{{ $b->event_type }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-3" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                                <i class="fas fa-calendar-plus text-emerald-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium mb-4">Belum ada booking disetujui</p>
                            <a href="{{ route('user.bookings.create') }}"
                               class="inline-flex items-center px-5 py-2.5 text-white rounded-xl transition-all hover:scale-105 font-semibold"
                               style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                                <i class="fas fa-plus mr-2"></i> Booking Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
