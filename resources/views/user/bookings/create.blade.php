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
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start">
                        <div class="p-2 bg-red-100 rounded-full mr-3 mt-0.5">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-red-800">Peringatan Konflik!</p>
                            <div class="mt-1 text-sm text-red-600">{!! session('error') !!}</div>
                        </div>
                    </div>
                @endif

                <!-- Alert Real-time Konflik Jadwal -->
                <div id="scheduleConflictAlert" class="hidden mb-6 p-4 bg-orange-50 border border-orange-200 text-orange-700 rounded-xl flex items-start">
                    <div class="p-2 bg-orange-100 rounded-full mr-3 mt-0.5">
                        <i class="fas fa-exclamation-triangle text-orange-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-orange-800">Jadwal Kelas Terdeteksi!</p>
                        <div id="scheduleConflictMessage" class="mt-1 text-sm text-orange-600"></div>
                    </div>
                </div>

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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.querySelector('select[name="room_id"]');
    const startInput = document.querySelector('input[name="start_datetime"]');
    const endInput = document.querySelector('input[name="end_datetime"]');
    const submitBtn = document.querySelector('button[type="submit"]');
    const conflictAlert = document.getElementById('scheduleConflictAlert');
    const conflictMessage = document.getElementById('scheduleConflictMessage');

    let checkTimeout = null;

    // Fungsi untuk cek konflik jadwal kelas via AJAX
    function checkScheduleConflict() {
        const roomId = roomSelect.value;
        const startDatetime = startInput.value;
        const endDatetime = endInput.value;

        // Validasi input lengkap
        if (!roomId || !startDatetime || !endDatetime) {
            conflictAlert.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        // Debounce - tunggu 500ms setelah user berhenti mengetik
        clearTimeout(checkTimeout);
        checkTimeout = setTimeout(() => {
            fetch('{{ route("user.bookings.check-schedule") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    room_id: roomId,
                    start_datetime: startDatetime,
                    end_datetime: endDatetime,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.has_conflict) {
                    // Tampilkan peringatan konflik
                    conflictMessage.innerHTML = `
                        <p class="mb-2">Waktu yang dipilih bentrok dengan jadwal kelas:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Kelas:</strong> ${data.schedule.class_name}</li>
                            <li><strong>Mata Pelajaran:</strong> ${data.schedule.subject || 'Tidak ada'}</li>
                            <li><strong>Jam:</strong> ${data.schedule.start_time} - ${data.schedule.end_time}</li>
                        </ul>
                        <p class="mt-2 text-orange-800 font-medium">Silakan pilih waktu lain yang tidak berbenturan.</p>
                    `;
                    conflictAlert.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    // Tidak ada konflik
                    conflictAlert.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Error checking schedule:', error);
                conflictAlert.classList.add('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }, 500);
    }

    // Event listeners
    roomSelect.addEventListener('change', checkScheduleConflict);
    startInput.addEventListener('change', checkScheduleConflict);
    endInput.addEventListener('change', checkScheduleConflict);

    // Cek saat halaman dimuat jika ada value lama
    if (roomSelect.value && startInput.value && endInput.value) {
        checkScheduleConflict();
    }
});
</script>
@endpush
</x-app-layout>