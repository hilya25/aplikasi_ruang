<x-admin-layout :title="'Admin Dashboard'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</h1>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; border-radius: 16px; overflow: hidden; position: relative;">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center" style="position: relative; z-index: 1;">
                    <div class="text-white">
                        <h4 class="mb-1 font-weight-bold">Selamat datang, {{ Auth::user()->name }}! 👋</h4>
                        <p class="mb-0" style="opacity: 0.85;">Kelola ruangan, booking, dan jadwal sekolah dari satu tempat.</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-light btn-sm mr-1" style="border-radius: 10px;">
                            <i class="fas fa-calendar-check mr-1"></i> Kelola Booking
                        </a>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-light btn-sm" style="border-radius: 10px;">
                            <i class="fas fa-door-open mr-1"></i> Kelola Ruangan
                        </a>
                    </div>
                </div>
                <!-- Decorative circles -->
                <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -20px; right: 60px; width: 80px; height: 80px; background: rgba(255,255,255,0.08); border-radius: 50%;"></div>
            </div>
        </div>
    </div>

    <!-- Stat Cards — Gradient Warna-warni -->
    <div class="row mb-4">
        <!-- Total Users — Indigo -->
        <div class="col-lg-3 col-6 mb-3">
            <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 16px; color: white; box-shadow: 0 8px 20px rgba(99,102,241,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 12px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users" style="font-size: 1.2rem;"></i>
                            </div>
                            <div class="ml-3">
                                <p style="font-size: 0.8rem; opacity: 0.9; margin: 0;">Total Users</p>
                                <h4 class="mb-0 font-weight-bold">{{ $totalUsers }}</h4>
                            </div>
                        </div>
                        <i class="fas fa-users" style="font-size: 2.5rem; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Ruangan — Violet -->
        <div class="col-lg-3 col-6 mb-3">
            <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 16px; color: white; box-shadow: 0 8px 20px rgba(139,92,246,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 12px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-door-open" style="font-size: 1.2rem;"></i>
                            </div>
                            <div class="ml-3">
                                <p style="font-size: 0.8rem; opacity: 0.9; margin: 0;">Total Ruangan</p>
                                <h4 class="mb-0 font-weight-bold">{{ $totalRooms }}</h4>
                            </div>
                        </div>
                        <i class="fas fa-door-open" style="font-size: 2.5rem; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Pending — Blue -->
        <div class="col-lg-3 col-6 mb-3">
            <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 16px; color: white; box-shadow: 0 8px 20px rgba(59,130,246,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 12px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock" style="font-size: 1.2rem;"></i>
                            </div>
                            <div class="ml-3">
                                <p style="font-size: 0.8rem; opacity: 0.9; margin: 0;">Booking Pending</p>
                                <h4 class="mb-0 font-weight-bold">{{ $pendingBookings }}</h4>
                            </div>
                        </div>
                        <i class="fas fa-clock" style="font-size: 2.5rem; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Hari Ini — Dark Indigo -->
        <div class="col-lg-3 col-6 mb-3">
            <div style="background: linear-gradient(135deg, #312e81, #1e1b4b); border-radius: 16px; color: white; box-shadow: 0 8px 20px rgba(49,46,129,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 12px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-day" style="font-size: 1.2rem;"></i>
                            </div>
                            <div class="ml-3">
                                <p style="font-size: 0.8rem; opacity: 0.9; margin: 0;">Booking Hari Ini</p>
                                <h4 class="mb-0 font-weight-bold">{{ $todayBookings }}</h4>
                            </div>
                        </div>
                        <i class="fas fa-calendar-day" style="font-size: 2.5rem; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Terbaru -->
    <div class="row">
        <div class="col-12">
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); overflow: hidden;">
                <div style="padding: 1rem 1.5rem; background: linear-gradient(135deg, #eef2ff, #e0e7ff); border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between;">
                    <h3 class="card-title mb-0" style="font-weight: 700; font-size: 1.05rem; color: #1f2937;">
                        <i class="fas fa-history mr-1" style="color: #6366f1;"></i> Booking Terbaru
                    </h3>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm font-weight-600" style="color: #6366f1; text-decoration: none;">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentBookings->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead style="background: #f9fafb;">
                            <tr>
                                <th style="padding: 12px 16px; font-size: 0.8rem; color: #6b7280; border-top: none;">#</th>
                                <th style="padding: 12px 16px; font-size: 0.8rem; color: #6b7280; border-top: none;">Peminjam</th>
                                <th style="padding: 12px 16px; font-size: 0.8rem; color: #6b7280; border-top: none;">Ruangan</th>
                                <th style="padding: 12px 16px; font-size: 0.8rem; color: #6b7280; border-top: none;">Waktu</th>
                                <th style="padding: 12px 16px; font-size: 0.8rem; color: #6b7280; border-top: none;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                            <tr style="transition: background 0.15s;">
                                <td style="padding: 12px 16px;">{{ $loop->iteration }}</td>
                                <td style="padding: 12px 16px;">
                                    <strong>{{ $booking->user->name }}</strong>
                                    <br><small style="color: #9ca3af;">{{ $booking->user->email }}</small>
                                </td>
                                <td style="padding: 12px 16px;">
                                    <span style="background: #e0e7ff; color: #4338ca; padding: 3px 10px; border-radius: 8px; font-size: 0.8rem; font-weight: 600;">{{ $booking->room->name }}</span>
                                </td>
                                <td style="padding: 12px 16px; color: #6b7280; font-size: 0.9rem;">
                                    {{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y, H:i') }}
                                </td>
                                <td style="padding: 12px 16px;">
                                    @if($booking->status === 'pending')
                                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600;"><i class="fas fa-clock mr-1"></i> Menunggu</span>
                                    @elseif($booking->status === 'approved')
                                        <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600;"><i class="fas fa-check mr-1"></i> Disetujui</span>
                                    @else
                                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600;"><i class="fas fa-times mr-1"></i> Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="text-center py-5">
                            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                                <i class="fas fa-inbox" style="font-size: 1.5rem; color: #6366f1;"></i>
                            </div>
                            <p style="color: #9ca3af; margin: 0;">Belum ada booking</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
