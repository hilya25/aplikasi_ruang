<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-bell mr-1"></i> Notifikasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Tombol Tandai Semua Dibaca -->
            @if($notifications->where('is_read', false)->count() > 0)
                <div class="mb-4">
                    <form method="POST" action="{{ route('user.notifications.readAll') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:shadow-lg transition font-medium">
                            <i class="fas fa-check-double mr-2"></i> Tandai Semua Sudah Dibaca
                        </button>
                    </form>
                </div>
            @endif

            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center">
                    <div class="p-2 bg-green-100 rounded-full mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Daftar Notifikasi -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-list mr-2 text-indigo-500"></i> Daftar Notifikasi
                    </h3>
                </div>
                <div class="p-6">
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                            <div class="flex items-start justify-between p-4 rounded-xl transition {{ $notification->is_read ? 'bg-gray-50' : 'bg-blue-50 border border-blue-100' }}">
                                <div class="flex items-start">
                                    <!-- Icon by type -->
                                    <div class="p-3 rounded-full mr-4
                                        @if($notification->type === 'booking_approved') bg-green-100
                                        @elseif($notification->type === 'booking_rejected') bg-red-100
                                        @else bg-blue-100 @endif">
                                        @if($notification->type === 'booking_approved')
                                            <i class="fas fa-check-circle text-green-600"></i>
                                        @elseif($notification->type === 'booking_rejected')
                                            <i class="fas fa-times-circle text-red-600"></i>
                                        @else
                                            <i class="fas fa-bell text-blue-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            @if(!$notification->is_read)
                                                <span class="inline-block px-2 py-0.5 bg-blue-500 text-white rounded-full text-xs mr-1">Baru</span>
                                            @endif
                                            {{ $notification->title }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-400 mt-2">
                                            <i class="fas fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('user.notifications.read', $notification) }}">
                                        @csrf
                                        <button type="submit" class="p-2 text-gray-400 hover:text-green-600 transition" title="Tandai sudah dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-bell-slash text-gray-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500">Tidak ada notifikasi</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>