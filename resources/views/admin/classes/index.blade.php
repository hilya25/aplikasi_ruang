<x-admin-layout :title="'Kelola Kelas'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-users mr-2"></i> Kelola Kelas</h1>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kelas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addClassModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Kelas
                        </button>
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
                    @if($classes->count() > 0)
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Kelas</th>
                                    <th style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classes as $index => $class)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $class->name }}</strong></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editClassModal{{ $class->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Kelas -->
                                <div class="modal fade" id="editClassModal{{ $class->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.classes.update', $class) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kelas</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Kelas <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $class->name }}" placeholder="Contoh: X PPLG A" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Belum ada kelas. Klik "Tambah Kelas" untuk menambahkan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelas -->
    <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.classes.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-user-plus mr-1"></i> Tambah Kelas Baru</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: X PPLG A" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-plus mr-1"></i> Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-admin-layout>
