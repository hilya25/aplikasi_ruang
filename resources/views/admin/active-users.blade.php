<x-admin-layout :title="'User Aktif'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-user-clock mr-2"></i> User Aktif</h1>
    </x-slot>

    <!-- Ringkasan -->
    <div class="row mb-4">
        <div class="col-lg-4 col-6">
            <div class="card" style="border-radius: 12px; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e8f5e9;">
                            <i class="fas fa-circle" style="color: #28a745; font-size: 1rem;"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Sedang Online</p>
                            <h4 class="mb-0 font-weight-bold">{{ $onlineUsers->count() }} user</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="card" style="border-radius: 12px; border-left: 4px solid #17a2b8;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e0f7fa;">
                            <i class="fas fa-sign-in-alt" style="color: #17a2b8; font-size: 1.2rem;"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Total Users</p>
                            <h4 class="mb-0 font-weight-bold">{{ \App\Models\User::count() }} user</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="card" style="border-radius: 12px; border-left: 4px solid #6c757d;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #f1f3f5;">
                            <i class="fas fa-user-slash" style="color: #6c757d; font-size: 1.2rem;"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Belum Pernah Login</p>
                            <h4 class="mb-0 font-weight-bold">{{ $neverLoggedIn }} user</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sedang Online -->
    <div class="card" style="border-radius: 12px;">
        <div class="card-header border-0" style="background: transparent;">
            <h3 class="card-title mb-0">
                <i class="fas fa-circle mr-1" style="color: #28a745; font-size: 0.7rem;"></i>
                Sedang Login
            </h3>
        </div>
        <div class="card-body p-0">
            @if($onlineUsers->count() > 0)
            <table class="table table-hover mb-0">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="width: 10px; border-top: none;">#</th>
                        <th style="border-top: none;">Nama</th>
                        <th style="border-top: none;">Email</th>
                        <th style="border-top: none;">Tipe</th>
                        <th style="border-top: none;">Login Terakhir</th>
                        <th style="border-top: none;">Aktivitas Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($onlineUsers as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->usertype === 'admin')
                                <span class="badge badge-danger">Admin</span>
                            @else
                                <span class="badge badge-success">User</span>
                            @endif
                        </td>
                        <td>{{ $user->last_login_at?->format('d M Y, H:i') ?? '-' }}</td>
                        <td>
                            <span class="text-success"><i class="fas fa-circle mr-1" style="font-size: 0.6rem;"></i>{{ \Carbon\Carbon::parse($user->last_active_at)->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-wifi fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted mb-0">Tidak ada user yang online saat ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Login -->
    <div class="card" style="border-radius: 12px;">
        <div class="card-header border-0" style="background: transparent;">
            <h3 class="card-title mb-0"><i class="fas fa-history mr-1" style="color: #6366f1;"></i> Login Terakhir (10 user)</h3>
        </div>
        <div class="card-body p-0">
            @if($recentlyLoggedIn->count() > 0)
            <table class="table table-hover mb-0">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="width: 10px; border-top: none;">#</th>
                        <th style="border-top: none;">Nama</th>
                        <th style="border-top: none;">Email</th>
                        <th style="border-top: none;">Tipe</th>
                        <th style="border-top: none;">Waktu Login</th>
                        <th style="border-top: none;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentlyLoggedIn as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->usertype === 'admin')
                                <span class="badge badge-danger">Admin</span>
                            @else
                                <span class="badge badge-success">User</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($user->last_login_at)->format('d M Y, H:i') }}
                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if($user->is_logged_in)
                                <span class="badge badge-success p-2"><i class="fas fa-circle mr-1" style="font-size: 0.6rem;"></i> Online</span>
                            @else
                                <span class="badge badge-secondary p-2">Offline</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-clock fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted mb-0">Belum ada riwayat login</p>
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>
