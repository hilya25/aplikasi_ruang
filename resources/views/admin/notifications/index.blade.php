<x-admin-layout :title="'Notifikasi'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-bell mr-2"></i> Notifikasi</h1>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Notifikasi</h3>
                    <div class="card-tools">
                        @if($notifications->where('is_read', false)->count() > 0)
                            <form method="POST" action="{{ route('admin.notifications.markAllAsRead') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check-double mr-1"></i> Tandai Semua Sudah Dibaca
                                </button>
                            </form>
                        @endif
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

                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                                <li class="list-group-item {{ $notification->is_read ? '' : 'bg-light' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                @if(!$notification->is_read)
                                                    <span class="badge badge-primary mr-1">Baru</span>
                                                @endif
                                                <strong>{{ $notification->title }}</strong>
                                            </h6>
                                            <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div>
                                            @if(!$notification->is_read)
                                                <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Tandai sudah dibaca">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">
                                <i class="fas fa-bell-slash mr-1"></i>
                                Tidak ada notifikasi.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
