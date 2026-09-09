<x-admin-layout :title="'Kelola Kode Invite Admin'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-user-shield mr-2"></i> Kelola Kode Invite Admin</h1>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kode Invite</h3>
                    <div class="card-tools">
                        <form method="POST" action="{{ route('admin.invite-codes.store') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-plus mr-1"></i> Buat Kode Baru
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->

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
                    @if($inviteCodes->count() > 0)
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Kode</th>
                                    <th>Status</th>
                                    <th>Digunakan Oleh</th>
                                    <th>Dibuat</th>
                                    <th style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inviteCodes as $index => $code)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <code class="bg-light p-1 rounded">{{ $code->code }}</code>
                                    </td>
                                    <td>
                                        @if($code->is_used)
                                            <span class="badge badge-danger">Sudah Dipakai</span>
                                        @else
                                            <span class="badge badge-success">Belum Dipakai</span>
                                        @endif
                                    </td>
                                    <td>{{ $code->usedByUser ? $code->usedByUser->name : '-' }}</td>
                                    <td>{{ $code->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if(!$code->is_used)
                                            <form method="POST" action="{{ route('admin.invite-codes.destroy', $code) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kode ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
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
                                Belum ada kode invite. Klik tombol "Buat Kode Baru" untuk membuat.
                            </p>
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</x-admin-layout>
