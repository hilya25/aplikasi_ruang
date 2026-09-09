<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-calendar-check mr-1"></i> Booking Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Quick Action -->
            <div class="mb-6">
                <a href="{{ route('user.bookings.create') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition font-medium">
                    <i class="fas fa-plus mr-2"></i> Buat Booking Baru
                </a>
            </div>

            <!-- Alert Success/Error -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center">
                    <div class="p-2 bg-green-100 rounded-full mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center">
                    <div class="p-2 bg-red-100 rounded-full mr-3">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                    </div>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Bookings Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-list mr-2 text-indigo-500"></i> Daftar Booking Saya
                    </h3>
                </div>
                <div class="p-6">
                    @if($bookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="p-3 @if($booking->status === 'pending') bg-yellow-100 @elseif($booking->status === 'approved') bg-green-100 @else bg-red-100 @endif rounded-full">
                                        @if($booking->status === 'pending')
                                            <i class="fas fa-clock text-yellow-600"></i>
                                        @elseif($booking->status === 'approved')
                                            <i class="fas fa-check text-green-600"></i>
                                        @else
                                            <i class="fas fa-times text-red-600"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-gray-800">{{ $booking->room->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if($booking->status === 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Menunggu</span>
                                        <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">
                                                <i class="fas fa-times mr-1"></i> Batal
                                            </button>
                                        </form>
                                    @elseif($booking->status === 'approved')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Disetujui</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-calendar-times text-gray-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 mb-4">Belum ada booking</p>
                            <a href="{{ route('user.bookings.create') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition">
                                <i class="fas fa-plus mr-2"></i> Buat Booking Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>