<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-door-open mr-1"></i> {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Info Ruangan -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                @if($room->image)
                    <div class="h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="h-32 flex items-center justify-center
                        @if($room->type === 'Kelas') bg-gradient-to-br from-blue-500 to-indigo-600
                        @elseif($room->type === 'Lab') bg-gradient-to-br from-purple-500 to-pink-600
                        @elseif($room->type === 'Aula') bg-gradient-to-br from-orange-500 to-red-500
                        @elseif($room->type === 'Lapangan') bg-gradient-to-br from-green-500 to-emerald-600
                        @else bg-gradient-to-br from-teal-500 to-cyan-600 @endif">
                        <i class="fas @if($room->type === 'Kelas') fa-chalkboard-teacher
                                 @elseif($room->type === 'Lab') fa-flask
                                 @elseif($room->type === 'Aula') fa-building
                                 @elseif($room->type === 'Lapangan') fa-futbol
                                 @else fa-mosque @endif text-white text-5xl opacity-90"></i>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $room->name }}</h1>
                        <span class="px-3 py-1 text-sm font-medium rounded-full
                            @if($room->type === 'Kelas') bg-blue-100 text-blue-700
                            @elseif($room->type === 'Lab') bg-purple-100 text-purple-700
                            @elseif($room->type === 'Aula') bg-orange-100 text-orange-700
                            @elseif($room->type === 'Lapangan') bg-green-100 text-green-700
                            @else bg-teal-100 text-teal-700 @endif">
                            {{ $room->type }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        @if($room->location)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> {{ $room->location }}
                            </div>
                        @endif
                        @if($room->capacity)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-users mr-2 text-blue-400"></i> Kapasitas: {{ $room->capacity }} orang
                            </div>
                        @endif
                    </div>

                    @if($room->description)
                        <p class="mt-4 text-gray-500 text-sm">{{ $room->description }}</p>
                    @endif

                    <!-- Tombol Booking -->
                    <a href="{{ route('user.bookings.create') }}" style="background: linear-gradient(to right, #6366f1, #9333ea);" class="mt-4 inline-flex items-center px-5 py-2.5 text-white rounded-xl hover:opacity-90 transition font-medium shadow-md">
                        <i class="fas fa-calendar-plus mr-2"></i> Booking Ruangan Ini
                    </a>
                </div>
            </div>

            <!-- Jadwal Pelajaran per Hari -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-calendar-week mr-2 text-indigo-500"></i> Jadwal Pelajaran
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Lihat jam yang sudah terisi sebelum booking</p>
                </div>
                <div class="p-6">
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        $grouped = $schedules->groupBy('day_of_week');
                    @endphp

                    @if($schedules->count() > 0)
                        <div class="space-y-5">
                            @foreach($days as $day)
                                @if(isset($grouped[$day]) && $grouped[$day]->count() > 0)
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                        <span class="inline-flex items-center justify-center w-24 px-3 py-1 rounded-lg text-sm font-bold
                                            @if(in_array($day, ['Senin','Selasa','Rabu'])) bg-blue-100 text-blue-700
                                            @else bg-green-100 text-green-700 @endif">
                                            {{ $day }}
                                        </span>
                                    </h4>
                                    <div class="ml-0 md:ml-28 space-y-2">
                                        @foreach($grouped[$day] as $s)
                                        <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                            <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                                                <i class="fas fa-clock text-indigo-600 text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-800">
                                                    {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}
                                                    — {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    @if($s->subject)
                                                        {{ $s->subject }}
                                                    @endif
                                                    @if($s->classRoom)
                                                        @if($s->subject) • @endif {{ $s->classRoom->name }}
                                                    @endif
                                                </p>
                                            </div>
                                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">Terisi</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                                <i class="fas fa-calendar-times text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500">Belum ada jadwal pelajaran untuk ruangan ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking yang Disetujui -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-calendar-check mr-2 text-green-500"></i> Booking Mendatang
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Booking yang sudah disetujui admin</p>
                </div>
                <div class="p-6">
                    @if($bookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($bookings as $b)
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($b->start_datetime)->format('d M Y') }}
                                        &middot;
                                        {{ \Carbon\Carbon::parse($b->start_datetime)->format('H:i') }}
                                        — {{ \Carbon\Carbon::parse($b->end_datetime)->format('H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $b->event_type }}
                                        @if($b->description) — {{ $b->description }} @endif
                                    </p>
                                </div>
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Disetujui</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                                <i class="fas fa-calendar-plus text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 mb-3">Belum ada booking disetujui</p>
                            <a href="{{ route('user.bookings.create') }}" style="background: linear-gradient(to right, #6366f1, #9333ea);" class="inline-flex items-center px-4 py-2 text-white rounded-lg hover:opacity-90 transition text-sm font-medium shadow-md">
                                <i class="fas fa-plus mr-2"></i> Booking Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
