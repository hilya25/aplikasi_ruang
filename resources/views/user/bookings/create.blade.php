<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                <i class="fas fa-file-signature mr-1.5"></i> Booking Ruangan
            </p>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                      style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                    <i class="fas fa-calendar-plus"></i>
                </span>
                Ajukan Peminjaman
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="aesthetic-card stat-card-shimmer overflow-hidden animate-fade-up reveal">

                <!-- Header Form -->
                <div class="p-8 text-center relative overflow-hidden" style="background: linear-gradient(120deg, #eef2ff, #f5f3ff);">
                    <div class="absolute -right-12 -top-12 w-40 h-40 rounded-full opacity-[0.07]" style="background: linear-gradient(135deg, #6366f1, #a855f7);"></div>
                    <div class="absolute -left-8 -bottom-8 w-32 h-32 rounded-full opacity-[0.05]" style="background: linear-gradient(135deg, #ec4899, #8b5cf6);"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-3 shadow-lg"
                             style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 10px 30px -8px rgba(99,102,241,0.5);">
                            <i class="fas fa-calendar-plus text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Form Booking Ruangan</h3>
                        <p class="text-gray-500 mt-1">Isi form di bawah untuk mengajukan peminjaman</p>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Alert Success/Error -->
                    @if (session('success'))
                        <div class="mb-6 p-4 rounded-2xl flex items-center" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0;">
                            <div class="p-2.5 rounded-xl mr-3" style="background: rgba(255,255,255,0.7);">
                                <i class="fas fa-check-circle text-emerald-600"></i>
                            </div>
                            <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 rounded-2xl flex items-start" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fecaca;">
                            <div class="p-2.5 rounded-xl mr-3 mt-0.5" style="background: rgba(255,255,255,0.7);">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-red-800">Peringatan Konflik!</p>
                                <div class="mt-1 text-sm text-red-600">{!! session('error') !!}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Alert Real-time Konflik Jadwal -->
                    <div id="scheduleConflictAlert" class="hidden mb-6 p-4 rounded-2xl flex items-start" style="background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1px solid #fde68a;">
                        <div class="p-2.5 rounded-xl mr-3 mt-0.5" style="background: rgba(255,255,255,0.7);">
                            <i class="fas fa-exclamation-triangle text-amber-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-amber-800">Jadwal Kelas Terdeteksi!</p>
                            <div id="scheduleConflictMessage" class="mt-1 text-sm text-amber-700"></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('user.bookings.store') }}">
                        @csrf

                        <!-- Ruangan -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eef2ff, #e0e7ff);">
                                    <i class="fas fa-door-open text-indigo-500 text-xs"></i>
                                </span>
                                Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select name="room_id" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} ({{ $room->type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Jenis Acara -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #faf5ff, #f3e8ff);">
                                    <i class="fas fa-tag text-purple-500 text-xs"></i>
                                </span>
                                Jenis Acara <span class="text-red-500">*</span>
                            </label>
                            <select name="event_type" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Pinjam" {{ old('event_type') === 'Pinjam' ? 'selected' : '' }}>📌 Pinjam</option>
                                <option value="Acara Sekolah" {{ old('event_type') === 'Acara Sekolah' ? 'selected' : '' }}>🎉 Acara Sekolah</option>
                                <option value="Dikosongkan" {{ old('event_type') === 'Dikosongkan' ? 'selected' : '' }}>🔧 Dikosongkan (Magang)</option>
                            </select>
                            @error('event_type')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Kegiatan -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                                    <i class="fas fa-align-left text-blue-500 text-xs"></i>
                                </span>
                                Kegiatan
                            </label>
                            <input type="text" name="description" class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all"
                                   value="{{ old('description') }}" placeholder="Contoh: Maulid Nabi, Praktek Komputer">
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tanggal & Waktu -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                                        <i class="fas fa-clock text-emerald-500 text-xs"></i>
                                    </span>
                                    Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="start_datetime"
                                       class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all"
                                       value="{{ old('start_datetime') }}" required>
                                @error('start_datetime')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                                        <i class="fas fa-clock text-red-500 text-xs"></i>
                                    </span>
                                    Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="end_datetime"
                                       class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all"
                                       value="{{ old('end_datetime') }}" required>
                                @error('end_datetime')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="mb-6 p-4 rounded-2xl flex items-start" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff); border: 1px solid #c7d2fe;">
                            <div class="p-2.5 rounded-xl mr-3 mt-0.5" style="background: rgba(255,255,255,0.7);">
                                <i class="fas fa-info-circle text-indigo-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-indigo-800 font-semibold">Informasi</p>
                                <p class="text-sm text-indigo-600 mt-1">Booking akan dikirim ke admin untuk disetujui. Status booking bisa dilihat di halaman "Booking Saya".</p>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('user.bookings.my') }}"
                               class="px-6 py-3 rounded-xl font-semibold text-sm transition-all hover:scale-105 active:scale-95 border"
                               style="background: white; color: #475569; border-color: #e2e8f0;">
                                <i class="fas fa-arrow-left mr-2"></i> Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 text-white rounded-xl transition-all hover:scale-105 active:scale-95 font-semibold"
                                    style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Booking
                            </button>
                        </div>
                    </form>
                </div>
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

    function checkScheduleConflict() {
        const roomId = roomSelect.value;
        const startDatetime = startInput.value;
        const endDatetime = endInput.value;

        if (!roomId || !startDatetime || !endDatetime) {
            conflictAlert.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

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
                    conflictMessage.innerHTML = `
                        <p class="mb-2">Waktu yang dipilih bentrok dengan jadwal kelas:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Kelas:</strong> ${data.schedule.class_name}</li>
                            <li><strong>Mata Pelajaran:</strong> ${data.schedule.subject || 'Tidak ada'}</li>
                            <li><strong>Jam:</strong> ${data.schedule.start_time} - ${data.schedule.end_time}</li>
                        </ul>
                        <p class="mt-2 text-amber-800 font-medium">Silakan pilih waktu lain yang tidak berbenturan.</p>
                    `;
                    conflictAlert.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
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

    roomSelect.addEventListener('change', checkScheduleConflict);
    startInput.addEventListener('change', checkScheduleConflict);
    endInput.addEventListener('change', checkScheduleConflict);

    if (roomSelect.value && startInput.value && endInput.value) {
        checkScheduleConflict();
    }
});
</script>
@endpush
</x-app-layout>
