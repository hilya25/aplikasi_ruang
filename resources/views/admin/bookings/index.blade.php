<x-admin-layout :title="'Kelola Booking'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-calendar-check mr-2"></i> Kelola Booking</h1>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Booking</h3>
                    <div class="card-tools">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-warning">
                                <i class="fas fa-clock mr-1"></i> Pending ({{ $bookings->where('status', 'pending')->count() }})
                            </button>
                            <button type="button" class="btn btn-success">
                                <i class="fas fa-check mr-1"></i> Approved ({{ $bookings->where('status', 'approved')->count() }})
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="fas fa-times mr-1"></i> Rejected ({{ $bookings->where('status', 'rejected')->count() }})
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alert Success/Error -->
                @if (session('success'))
                    <div class="callout callout-success">
                        <p><i class="fas fa-check-circle mr-1"></i> {{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="callout callout-danger">
                        <p><i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}</p>
                    </div>
                @endif

                <div class="card-body table-responsive p-0">
                    @if($bookings->count() > 0)
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Peminjam</th>
                                    <th>Ruangan</th>
                                    <th>Jenis Acara</th>
                                    <th>Kegiatan</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th style="width: 120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $booking->user->name }}</strong>
                                        <br><small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>
                                        @if($booking->event_type === 'Pinjam')
                                            <span class="badge badge-primary">{{ $booking->event_type }}</span>
                                        @elseif($booking->event_type === 'Acara Sekolah')
                                            <span class="badge badge-info">{{ $booking->event_type }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $booking->event_type }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->description ?? '-' }}</td>
                                    <td>
                                        <i class="fas fa-calendar-day mr-1"></i> {{ $booking->start_datetime->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $booking->start_datetime->format('H:i') }} - {{ $booking->end_datetime->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Pending</span>
                                        @elseif($booking->status === 'approved')
                                            <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Approved</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Belum ada booking.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
