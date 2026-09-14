<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-door-open mr-1"></i> Daftar Ruangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center">
                    <div class="p-2 bg-green-100 rounded-full mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Daftar Ruangan per Jenis -->
            @forelse($typeOrder as $type)
                @if(isset($groupedRooms[$type]) && $groupedRooms[$type]->count() > 0)
                    <!-- Header Jenis Ruangan -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            @if($type === 'Kelas') <i class="fas fa-chalkboard-teacher mr-2 text-blue-500"></i>
                            @elseif($type === 'Lab') <i class="fas fa-flask mr-2 text-purple-500"></i>
                            @elseif($type === 'Aula') <i class="fas fa-building mr-2 text-orange-500"></i>
                            @elseif($type === 'Lapangan') <i class="fas fa-futbol mr-2 text-green-500"></i>
                            @elseif($type === 'Masjid') <i class="fas fa-mosque mr-2 text-teal-500"></i>
                            @elseif($type === 'Activity Room') <i class="fas fa-running mr-2 text-pink-500"></i>
                            @endif
                            {{ $type }}
                            <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                {{ $groupedRooms[$type]->count() }} ruangan
                            </span>
                        </h3>
                    </div>

                    <!-- Grid Ruangan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        @foreach($groupedRooms[$type] as $room)
                        <div class="bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-xl transition-shadow">
                            <!-- Header Card with Image or Gradient by Type -->
                            @if($room->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="h-28 flex items-center justify-center
                                    @if($room->type === 'Kelas') bg-gradient-to-br from-blue-500 to-indigo-600
                                    @elseif($room->type === 'Lab') bg-gradient-to-br from-purple-500 to-pink-600
                                    @elseif($room->type === 'Aula') bg-gradient-to-br from-orange-500 to-red-500
                                    @elseif($room->type === 'Lapangan') bg-gradient-to-br from-green-500 to-emerald-600
                                    @elseif($room->type === 'Masjid') bg-gradient-to-br from-teal-500 to-cyan-600
                                    @elseif($room->type === 'Activity Room') bg-gradient-to-br from-pink-500 to-rose-600
                                    @else bg-gradient-to-br from-gray-500 to-gray-600 @endif">
                                    <i class="fas @if($room->type === 'Kelas') fa-chalkboard-teacher
                                             @elseif($room->type === 'Lab') fa-flask
                                             @elseif($room->type === 'Aula') fa-building
                                             @elseif($room->type === 'Lapangan') fa-futbol
                                             @elseif($room->type === 'Masjid') fa-mosque
                                             @elseif($room->type === 'Activity Room') fa-running
                                             @else fa-door-open @endif text-white text-4xl opacity-90"></i>
                                </div>
                            @endif

                            <!-- Body -->
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $room->name }}</h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($room->type === 'Kelas') bg-blue-100 text-blue-700
                                        @elseif($room->type === 'Lab') bg-purple-100 text-purple-700
                                        @elseif($room->type === 'Aula') bg-orange-100 text-orange-700
                                        @elseif($room->type === 'Lapangan') bg-green-100 text-green-700
                                        @elseif($room->type === 'Masjid') bg-teal-100 text-teal-700
                                        @elseif($room->type === 'Activity Room') bg-pink-100 text-pink-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ $room->type }}
                                    </span>
                                </div>

                                @if($room->location)
                                    <p class="text-sm text-gray-500 mb-1">
                                        <i class="fas fa-map-marker-alt mr-1 text-red-400"></i> {{ $room->location }}
                                    </p>
                                @endif

                                @if($room->capacity)
                                    <p class="text-sm text-gray-500 mb-1">
                                        <i class="fas fa-users mr-1 text-blue-400"></i> Kapasitas: {{ $room->capacity }} orang
                                    </p>
                                @endif

                                @if($room->description)
                                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">{{ $room->description }}</p>
                                @endif

                                @if($room->schedules_count > 0)
                                    <p class="text-xs text-indigo-600 mt-2 font-medium">
                                        <i class="fas fa-calendar-alt mr-1"></i> {{ $room->schedules_count }} jadwal aktif
                                    </p>
                                @endif

                                <!-- Tombol Detail -->
                                <a href="{{ route('user.rooms.show', $room) }}" style="background: linear-gradient(to right, #6366f1, #9333ea);" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 text-white rounded-xl hover:opacity-90 transition font-medium shadow-md">
                                    <i class="fas fa-eye mr-2"></i> Lihat Detail & Jadwal
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            @empty
                <!-- Jika tidak ada ruangan sama sekali -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <i class="fas fa-door-closed text-gray-300 text-3xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada ruangan tersedia</p>
                    </div>
                </div>
            @endforelse

            <!-- Tampilkan ruangan dengan jenis lain yang tidak terdaftar di typeOrder -->
            @php
                $otherTypes = $groupedRooms->diffKeys(array_flip($typeOrder));
            @endphp
            @if($otherTypes->count() > 0)
                @foreach($otherTypes as $type => $typeRooms)
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-door-open mr-2 text-gray-500"></i>
                            {{ $type }}
                            <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                {{ $typeRooms->count() }} ruangan
                            </span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        @foreach($typeRooms as $room)
                        <div class="bg-white overflow-hidden shadow-lg rounded-2xl hover:shadow-xl transition-shadow">
                            @if($room->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="h-28 flex items-center justify-center bg-gradient-to-br from-gray-500 to-gray-600">
                                    <i class="fas fa-door-open text-white text-4xl opacity-90"></i>
                                </div>
                            @endif
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $room->name }}</h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                        {{ $room->type }}
                                    </span>
                                </div>
                                @if($room->location)
                                    <p class="text-sm text-gray-500 mb-1">
                                        <i class="fas fa-map-marker-alt mr-1 text-red-400"></i> {{ $room->location }}
                                    </p>
                                @endif
                                @if($room->capacity)
                                    <p class="text-sm text-gray-500 mb-1">
                                        <i class="fas fa-users mr-1 text-blue-400"></i> Kapasitas: {{ $room->capacity }} orang
                                    </p>
                                @endif
                                @if($room->description)
                                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">{{ $room->description }}</p>
                                @endif
                                @if($room->schedules_count > 0)
                                    <p class="text-xs text-indigo-600 mt-2 font-medium">
                                        <i class="fas fa-calendar-alt mr-1"></i> {{ $room->schedules_count }} jadwal aktif
                                    </p>
                                @endif
                                <a href="{{ route('user.rooms.show', $room) }}" style="background: linear-gradient(to right, #6366f1, #9333ea);" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2 text-white rounded-xl hover:opacity-90 transition font-medium shadow-md">
                                    <i class="fas fa-eye mr-2"></i> Lihat Detail & Jadwal
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
