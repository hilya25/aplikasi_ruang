<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                    <i class="fas fa-compass mr-1.5"></i> Daftar Ruangan
                </p>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                          style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                        <i class="fas fa-door-open"></i>
                    </span>
                    Temukan Ruangan Anda
                </h2>
            </div>
            <a href="{{ route('user.bookings.create') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg"
               style="background: rgba(255,255,255,0.95); color: #4338ca; backdrop-filter: blur(8px);">
                <i class="fas fa-calendar-plus mr-2 text-indigo-500"></i> Booking Sekarang
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl flex items-center animate-fade-up" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0;">
                    <div class="p-2.5 rounded-xl mr-3" style="background: rgba(255,255,255,0.7);">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Daftar Ruangan per Jenis -->
            @forelse($typeOrder as $type)
                @if(isset($groupedRooms[$type]) && $groupedRooms[$type]->count() > 0)
                    <!-- Header Jenis Ruangan -->
                    <div class="mb-6 flex items-center">
                        <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 shadow-md
                            @if($type === 'Kelas') bg-gradient-to-br from-blue-500 to-indigo-600
                            @elseif($type === 'Lab') bg-gradient-to-br from-purple-500 to-pink-600
                            @elseif($type === 'Aula') bg-gradient-to-br from-orange-500 to-red-500
                            @elseif($type === 'Lapangan') bg-gradient-to-br from-green-500 to-emerald-600
                            @elseif($type === 'Masjid') bg-gradient-to-br from-teal-500 to-cyan-600
                            @elseif($type === 'Activity Room') bg-gradient-to-br from-pink-500 to-rose-600
                            @elseif($type === 'Perpustakaan') bg-gradient-to-br from-amber-500 to-yellow-600
                            @else bg-gradient-to-br from-gray-400 to-gray-500 @endif">
                            <i class="fas @if($type === 'Kelas') fa-chalkboard-teacher
                                     @elseif($type === 'Lab') fa-flask
                                     @elseif($type === 'Aula') fa-building
                                     @elseif($type === 'Lapangan') fa-futbol
                                     @elseif($type === 'Masjid') fa-mosque
                                     @elseif($type === 'Activity Room') fa-running
                                     @elseif($type === 'Perpustakaan') fa-book-open
                                     @else fa-door-open @endif text-white"></i>
                        </span>
                        <h3 class="text-xl font-extrabold text-gray-800">{{ $type }}</h3>
                        <span class="ml-3 px-3 py-1 text-xs font-semibold rounded-full" style="background: #eef2ff; color: #4f46e5;">
                            {{ $groupedRooms[$type]->count() }} ruangan
                        </span>
                    </div>

                    <!-- Grid Ruangan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        @foreach($groupedRooms[$type] as $room)
                        <div class="aesthetic-card aesthetic-card-hover overflow-hidden">
                            <!-- Header Card with Image or Gradient by Type -->
                            @if($room->image)
                                <div class="h-44 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    <span class="absolute top-3 right-3 px-2.5 py-1 text-xs font-semibold rounded-full backdrop-blur-md"
                                          style="background: rgba(255,255,255,0.85); color: #4338ca;">{{ $room->type }}</span>
                                </div>
                            @else
                                <div class="h-28 flex items-center justify-center relative overflow-hidden
                                    @if($room->type === 'Kelas') bg-gradient-to-br from-blue-500 to-indigo-600
                                    @elseif($room->type === 'Lab') bg-gradient-to-br from-purple-500 to-pink-600
                                    @elseif($room->type === 'Aula') bg-gradient-to-br from-orange-500 to-red-500
                                    @elseif($room->type === 'Lapangan') bg-gradient-to-br from-green-500 to-emerald-600
                                    @elseif($room->type === 'Masjid') bg-gradient-to-br from-teal-500 to-cyan-600
                                    @elseif($room->type === 'Activity Room') bg-gradient-to-br from-pink-500 to-rose-600
                                    @elseif($room->type === 'Perpustakaan') bg-gradient-to-br from-amber-500 to-yellow-600
                                    @else bg-gradient-to-br from-gray-500 to-gray-600 @endif">
                                    <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full" style="background: rgba(255,255,255,0.12);"></div>
                                    <div class="absolute right-8 -bottom-12 w-24 h-24 rounded-full" style="background: rgba(255,255,255,0.08);"></div>
                                    <i class="fas @if($room->type === 'Kelas') fa-chalkboard-teacher
                                             @elseif($room->type === 'Lab') fa-flask
                                             @elseif($room->type === 'Aula') fa-building
                                             @elseif($room->type === 'Lapangan') fa-futbol
                                             @elseif($room->type === 'Masjid') fa-mosque
                                             @elseif($room->type === 'Activity Room') fa-running
                                             @elseif($room->type === 'Perpustakaan') fa-book-open
                                             @else fa-door-open @endif text-white text-4xl opacity-90 relative z-10"></i>
                                </div>
                            @endif

                            <!-- Body -->
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $room->name }}</h3>
                                    @if(!$room->image)
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full
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
                                    @endif
                                </div>

                                @if($room->location)
                                    <p class="text-sm text-gray-500 mb-1.5 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> {{ $room->location }}
                                    </p>
                                @endif

                                @if($room->capacity)
                                    <p class="text-sm text-gray-500 mb-1.5 flex items-center">
                                        <i class="fas fa-users mr-2 text-blue-400"></i> Kapasitas: {{ $room->capacity }} orang
                                    </p>
                                @endif

                                @if($room->description)
                                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">{{ $room->description }}</p>
                                @endif

                                @if($room->schedules_count > 0)
                                    <p class="text-xs mt-2 font-semibold inline-flex items-center px-2.5 py-1 rounded-full" style="background: #eef2ff; color: #4f46e5;">
                                        <i class="fas fa-calendar-alt mr-1.5"></i> {{ $room->schedules_count }} jadwal aktif
                                    </p>
                                @endif

                                <!-- Tombol Detail -->
                                <a href="{{ route('user.rooms.show', $room) }}"
                                   class="mt-4 w-full inline-flex items-center justify-center px-4 py-2.5 text-white rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98] font-semibold"
                                   style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                                    <i class="fas fa-eye mr-2"></i> Lihat Detail &amp; Jadwal
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            @empty
                <!-- Jika tidak ada ruangan sama sekali -->
                <div class="aesthetic-card">
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                            <i class="fas fa-door-closed text-indigo-300 text-3xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada ruangan tersedia</p>
                    </div>
                </div>
            @endforelse

            <!-- Tampilkan ruangan dengan jenis lain yang tidak terdaftar di typeOrder -->
            @php
                $otherTypes = $groupedRooms->diffKeys(array_flip($typeOrder));
            @endphp
            @if($otherTypes->count() > 0)
                @foreach($otherTypes as $type => $typeRooms)
                    <div class="mb-6 flex items-center">
                        <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 shadow-md bg-gradient-to-br from-gray-400 to-gray-500">
                            <i class="fas fa-door-open text-white"></i>
                        </span>
                        <h3 class="text-xl font-extrabold text-gray-800">{{ $type }}</h3>
                        <span class="ml-3 px-3 py-1 text-xs font-semibold rounded-full" style="background: #eef2ff; color: #4f46e5;">
                            {{ $typeRooms->count() }} ruangan
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        @foreach($typeRooms as $room)
                        <div class="aesthetic-card aesthetic-card-hover overflow-hidden">
                            @if($room->image)
                                <div class="h-44 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    <span class="absolute top-3 right-3 px-2.5 py-1 text-xs font-semibold rounded-full backdrop-blur-md"
                                          style="background: rgba(255,255,255,0.85); color: #4338ca;">{{ $room->type }}</span>
                                </div>
                            @else
                                <div class="h-28 flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-gray-500 to-gray-600">
                                    <div class="absolute -right-6 -bottom-8 w-28 h-28 rounded-full" style="background: rgba(255,255,255,0.12);"></div>
                                    <i class="fas fa-door-open text-white text-4xl opacity-90 relative z-10"></i>
                                </div>
                            @endif
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $room->name }}</h3>
                                    @if(!$room->image)
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                            {{ $room->type }}
                                        </span>
                                    @endif
                                </div>
                                @if($room->location)
                                    <p class="text-sm text-gray-500 mb-1.5 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> {{ $room->location }}
                                    </p>
                                @endif
                                @if($room->capacity)
                                    <p class="text-sm text-gray-500 mb-1.5 flex items-center">
                                        <i class="fas fa-users mr-2 text-blue-400"></i> Kapasitas: {{ $room->capacity }} orang
                                    </p>
                                @endif
                                @if($room->description)
                                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">{{ $room->description }}</p>
                                @endif
                                @if($room->schedules_count > 0)
                                    <p class="text-xs mt-2 font-semibold inline-flex items-center px-2.5 py-1 rounded-full" style="background: #eef2ff; color: #4f46e5;">
                                        <i class="fas fa-calendar-alt mr-1.5"></i> {{ $room->schedules_count }} jadwal aktif
                                    </p>
                                @endif
                                <a href="{{ route('user.rooms.show', $room) }}"
                                   class="mt-4 w-full inline-flex items-center justify-center px-4 py-2.5 text-white rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98] font-semibold"
                                   style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                                    <i class="fas fa-eye mr-2"></i> Lihat Detail &amp; Jadwal
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>
