<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                    <i class="fas fa-envelope-open-text mr-1.5"></i> Notifikasi
                </p>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                    <span class="relative w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                          style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                        <i class="fas fa-bell"></i>
                        @if($notifications->where('is_read', false)->count() > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full border-2 border-indigo-600" style="background: linear-gradient(135deg, #f43f5e, #fb7185);"></span>
                        @endif
                    </span>
                    Pemberitahuan Terbaru
                </h2>
            </div>
            @if($notifications->where('is_read', false)->count() > 0)
                <form method="POST" action="{{ route('user.notifications.readAll') }}" x-data>
                    @csrf
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg"
                            style="background: rgba(255,255,255,0.95); color: #065f46; backdrop-filter: blur(8px);">
                        <i class="fas fa-check-double mr-2 text-emerald-500"></i> Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl flex items-center animate-fade-up" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0;">
                    <div class="p-2.5 rounded-xl mr-3" style="background: rgba(255,255,255,0.7);">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Daftar Notifikasi -->
            <div class="aesthetic-card animate-fade-up">
                <div class="p-6 flex items-center border-b border-gray-100">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 shadow-md" style="background: linear-gradient(135deg, #06b6d4, #22d3ee);">
                        <i class="fas fa-inbox text-white"></i>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Notifikasi</h3>
                </div>
                <div class="p-4">
                    @if($notifications->count() > 0)
                        <div class="space-y-3">
                            @foreach($notifications as $notification)
                            <div class="flex items-start justify-between p-4 rounded-xl transition-all {{ $notification->is_read ? 'hover:bg-gray-50' : '' }}"
                                 style="{{ !$notification->is_read ? 'background: linear-gradient(135deg, #eef2ff, #f5f3ff); border: 1px solid #c7d2fe;' : 'border: 1px solid #f1f5f9;' }}">
                                <div class="flex items-start">
                                    <!-- Icon by type -->
                                    <div class="p-3 rounded-xl mr-4 flex-shrink-0
                                        @if($notification->type === 'booking_approved') {{ 'bg-gradient-to-br from-green-100 to-emerald-100' }}
                                        @elseif($notification->type === 'booking_rejected') {{ 'bg-gradient-to-br from-red-100 to-rose-100' }}
                                        @else bg-gradient-to-br from-blue-100 to-indigo-100 @endif">
                                        @if($notification->type === 'booking_approved')
                                            <i class="fas fa-check-circle text-emerald-600"></i>
                                        @elseif($notification->type === 'booking_rejected')
                                            <i class="fas fa-times-circle text-red-600"></i>
                                        @else
                                            <i class="fas fa-bell text-indigo-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            @if(!$notification->is_read)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold mr-1.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white;">Baru</span>
                                            @endif
                                            {{ $notification->title }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-400 mt-2 flex items-center">
                                            <i class="fas fa-clock mr-1.5"></i> {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('user.notifications.read', $notification) }}">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-lg transition hover:bg-white hover:shadow-sm" style="color: #a5b4fc;" title="Tandai sudah dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                                <i class="fas fa-bell-slash text-indigo-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada notifikasi</p>
                            <p class="text-gray-400 text-sm mt-1">Notifikasi akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
