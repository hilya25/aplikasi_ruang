<x-admin-layout :title="'Kelola Ruangan'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-door-open mr-2"></i> Kelola Ruangan</h1>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Ruangan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addRoomModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Ruangan
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
                    @if($rooms->count() > 0)
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Ruangan</th>
                                    <th>Jenis</th>
                                    <th>Kapasitas</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th style="width: 120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $index => $room)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $room->name }}</strong></td>
                                    <td>
                                        <span class="badge badge-info">{{ $room->type }}</span>
                                    </td>
                                    <td>{{ $room->capacity ?? '-' }}</td>
                                    <td>{{ $room->location ?? '-' }}</td>
                                    <td>
                                        @if($room->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editRoomModal{{ $room->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Ruangan -->
                                <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Ruangan: {{ $room->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Ruangan <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis <span class="text-danger">*</span></label>
                                                        <select name="type" class="form-control" required>
                                                            <option value="Kelas" {{ $room->type === 'Kelas' ? 'selected' : '' }}>Kelas</option>
                                                            <option value="Lab" {{ $room->type === 'Lab' ? 'selected' : '' }}>Lab</option>
                                                            <option value="Aula" {{ $room->type === 'Aula' ? 'selected' : '' }}>Aula</option>
                                                            <option value="Lapangan" {{ $room->type === 'Lapangan' ? 'selected' : '' }}>Lapangan</option>
                                                            <option value="Masjid" {{ $room->type === 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kapasitas</label>
                                                        <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Lokasi</label>
                                                        <input type="text" name="location" class="form-control" value="{{ $room->location }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi</label>
                                                        <textarea name="description" class="form-control" rows="3">{{ $room->description }}</textarea>
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
                                Belum ada ruangan. Klik "Tambah Ruangan" untuk menambahkan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Ruangan -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.rooms.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-door-open mr-1"></i> Tambah Ruangan Baru</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Ruang 10A" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="type" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Kelas">Kelas</option>
                                <option value="Lab">Lab</option>
                                <option value="Aula">Aula</option>
                                <option value="Lapangan">Lapangan</option>
                                <option value="Masjid">Masjid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas</label>
                            <input type="number" name="capacity" class="form-control" placeholder="Contoh: 40" min="0">
                        </div>
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung A, Lantai 2">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat ruangan..."></textarea>
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
