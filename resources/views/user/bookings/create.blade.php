<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-calendar-plus mr-1"></i> Buat Booking Ruangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">

                <!-- Header Form -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-4">
                        <i class="fas fa-calendar-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Form Booking Ruangan</h3>
                    <p class="text-gray-500 mt-1">Isi form di bawah untuk mengajukan peminjaman</p>
                </div>

                <!-- Alert Success/Error -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center">
                        <div class="p-2 bg-green-100 rounded-full mr-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center">
                        <div class="p-2 bg-red-100 rounded-full mr-3">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('user.bookings.store') }}">
                    @csrf

                    <!-- Ruangan -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-door-open mr-1 text-indigo-500"></i> Ruangan <span class="text-red-500">*</span>
                        </label>
                        <select name="room_id" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} ({{ $room->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Jenis Acara -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-purple-500"></i> Jenis Acara <span class="text-red-500">*</span>
                        </label>
                        <select name="event_type" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Pinjam" {{ old('event_type') === 'Pinjam' ? 'selected' : '' }}>📌 Pinjam</option>
                            <option value="Acara Sekolah" {{ old('event_type') === 'Acara Sekolah' ? 'selected' : '' }}>🎉 Acara Sekolah</option>
                            <option value="Dikosongkan" {{ old('event_type') === 'Dikosongkan' ? 'selected' : '' }}>🔧 Dikosongkan (Magang)</option>
                        </select>
                        @error('event_type')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Kegiatan -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-1 text-blue-500"></i> Kegiatan
                        </label>
                        <input type="text" name="description" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3"
                               value="{{ old('description') }}" placeholder="Contoh: Maulid Nabi, Praktek Komputer">
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tanggal & Waktu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock mr-1 text-green-500"></i> Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_datetime"
                                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3"
                                   value="{{ old('start_datetime') }}" required>
                            @error('start_datetime')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock mr-1 text-red-500"></i> Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_datetime"
                                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3"
                                   value="{{ old('end_datetime') }}" required>
                            @error('end_datetime')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl">
                        <div class="flex items-start">
                            <div class="p-2 bg-blue-100 rounded-full mr-3 mt-0.5">
                                <i class="fas fa-info-circle text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-blue-800 font-medium">Informasi</p>
                                <p class="text-sm text-blue-600 mt-1">Booking akan dikirim ke admin untuk disetujui. Status booking bisa dilihat di halaman "Booking Saya".</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('user.bookings.my') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> Batal
                        </a>
                        <button type="submit" style="background: linear-gradient(to right, #6366f1, #9333ea);" class="px-6 py-3 text-white rounded-xl hover:opacity-90 transition font-medium shadow-md">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Booking
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>