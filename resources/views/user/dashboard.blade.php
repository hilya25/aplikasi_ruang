<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-home mr-1"></i> Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Booking -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-500 bg-opacity-10 rounded-full">
                            <i class="fas fa-calendar text-blue-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Booking</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-500 bg-opacity-10 rounded-full">
                            <i class="fas fa-clock text-yellow-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Menunggu</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Approved -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-500 bg-opacity-10 rounded-full">
                            <i class="fas fa-check text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Disetujui</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['approved'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-500 bg-opacity-10 rounded-full">
                            <i class="fas fa-times text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Ditolak</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['rejected'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-bolt mr-1"></i> Aksi Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('user.bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        <i class="fas fa-plus mr-2"></i> Booking Ruangan
                    </a>
                    <a href="{{ route('user.bookings.my') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        <i class="fas fa-list mr-2"></i> Lihat Booking Saya
                    </a>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800"><i class="fas fa-history mr-1"></i> Booking Terakhir</h3>
                </div>
                <div class="p-6">
                    @if($myBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-500 border-b">
                                        <th class="pb-3">Ruangan</th>
                                        <th class="pb-3">Jenis</th>
                                        <th class="pb-3">Waktu</th>
                                        <th class="pb-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myBookings as $booking)
                                    <tr class="border-b">
                                        <td class="py-3 font-medium">{{ $booking->room->name }}</td>
                                        <td class="py-3">{{ $booking->event_type }}</td>
                                        <td class="py-3 text-gray-500">
                                            {{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y H:i') }}
                                        </td>
                                        <td class="py-3">
                                            @if($booking->status === 'pending')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                                            @elseif($booking->status === 'approved')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Disetujui</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">
                            <i class="fas fa-info-circle mr-1"></i>
                            Belum ada booking. <a href="{{ route('user.bookings.create') }}" class="text-indigo-600 hover:underline">Buat booking sekarang</a>
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>