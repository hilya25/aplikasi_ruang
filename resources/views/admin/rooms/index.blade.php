<x-admin-layout :title="'Kelola Ruangan'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-door-open mr-2"></i> Kelola Ruangan</h1>
    </x-slot>

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

    <!-- Tombol Tambah Ruangan -->
    <div class="mb-3">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRoomModal">
            <i class="fas fa-plus mr-1"></i> Tambah Ruangan
        </button>
    </div>

    <!-- Daftar Ruangan per Jenis -->
    @forelse($typeOrder as $type)
        @if(isset($groupedRooms[$type]))
            <div class="card card-outline card-{{ $type === 'Kelas' ? 'primary' : ($type === 'Lab' ? 'success' : ($type === 'Aula' ? 'warning' : ($type === 'Lapangan' ? 'info' : 'secondary'))) }}">
                <div class="card-header">
                    <h3 class="card-title">
                        @if($type === 'Kelas') <i class="fas fa-chalkboard mr-1 text-primary"></i>
                        @elseif($type === 'Lab') <i class="fas fa-flask mr-1 text-success"></i>
                        @elseif($type === 'Aula') <i class="fas fa-building mr-1 text-warning"></i>
                        @elseif($type === 'Lapangan') <i class="fas fa-futbol mr-1 text-info"></i>
                        @elseif($type === 'Masjid') <i class="fas fa-mosque mr-1 text-secondary"></i>
                        @elseif($type === 'Activity Room') <i class="fas fa-running mr-1 text-purple"></i>
                        @endif
                        <strong>{{ $type }}</strong>
                        <span class="badge badge-pill badge-{{ $type === 'Kelas' ? 'primary' : ($type === 'Lab' ? 'success' : ($type === 'Aula' ? 'warning' : ($type === 'Lapangan' ? 'info' : 'secondary'))) }} ml-2">
                            {{ $groupedRooms[$type]->count() }} Ruangan
                        </span>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 50px">#</th>
                                <th style="width: 50px">Gambar</th>
                                <th>Nama Ruangan</th>
                                <th>Kapasitas</th>
                                <th>Lokasi</th>
                                <th>Deskripsi</th>
                                <th style="width: 80px">Status</th>
                                <th style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedRooms[$type] as $index => $room)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($room->image)
                                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div style="width: 40px; height: 40px; border-radius: 8px; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $room->name }}</strong></td>
                                <td>
                                    @if($room->capacity)
                                        <span class="badge badge-light">{{ $room->capacity }} orang</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $room->location ?? '-' }}</td>
                                <td>
                                    @if($room->description)
                                        <span class="text-muted" title="{{ $room->description }}">
                                            {{ Str::limit($room->description, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($room->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editRoomModal{{ $room->id }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ruangan {{ $room->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Ruangan -->
                            <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit: {{ $room->name }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($room->image)
                                                    <div class="form-group text-center">
                                                        <label>Gambar Saat Ini</label><br>
                                                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="max-height: 150px; border-radius: 8px;">
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label>Gambar Ruangan</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input" id="editRoomImage{{ $room->id }}" accept="image/*" onchange="previewEditImage(this, 'editImagePreview{{ $room->id }}')">
                                                        <label class="custom-file-label" for="editRoomImage{{ $room->id }}">Ganti gambar...</label>
                                                    </div>
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti. Format: JPG, PNG, WebP. Maks 2MB.</small>
                                                    <div class="mt-2 text-center">
                                                        <img id="editImagePreview{{ $room->id }}" src="#" alt="Preview" style="max-height: 150px; border-radius: 8px; display: none;">
                                                    </div>
                                                </div>
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
                                                        <option value="Activity Room" {{ $room->type === 'Activity Room' ? 'selected' : '' }}>Activity Room</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kapasitas</label>
                                                    <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" min="0">
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
                </div>
            </div>
        @endif
    @empty
        <!-- Jika tidak ada ruangan sama sekali -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-door-open fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-500">Belum ada ruangan</h5>
                <p class="text-muted">Klik tombol "Tambah Ruangan" untuk menambahkan ruangan baru.</p>
            </div>
        </div>
    @endforelse

    <!-- Tampilkan ruangan dengan jenis lain yang tidak terdaftar di typeOrder -->
    @if(isset($groupedRooms['Lainnya']) || count($groupedRooms->diffKeys(array_flip($typeOrder))) > 0)
        @php
            $otherTypes = $groupedRooms->diffKeys(array_flip($typeOrder));
        @endphp
        @if($otherTypes->count() > 0)
            @foreach($otherTypes as $type => $typeRooms)
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-ellipsis-h mr-1 text-secondary"></i>
                            <strong>{{ $type }}</strong>
                            <span class="badge badge-pill badge-secondary ml-2">{{ $typeRooms->count() }} Ruangan</span>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th style="width: 50px">Gambar</th>
                                    <th>Nama Ruangan</th>
                                    <th>Kapasitas</th>
                                    <th>Lokasi</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 80px">Status</th>
                                    <th style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($typeRooms as $index => $room)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($room->image)
                                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div style="width: 40px; height: 40px; border-radius: 8px; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $room->name }}</strong></td>
                                    <td>
                                        @if($room->capacity)
                                            <span class="badge badge-light">{{ $room->capacity }} orang</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $room->location ?? '-' }}</td>
                                    <td>
                                        @if($room->description)
                                            <span class="text-muted" title="{{ $room->description }}">
                                                {{ Str::limit($room->description, 30) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editRoomModal{{ $room->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ruangan {{ $room->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Ruangan -->
                                <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header bg-secondary text-white">
                                                    <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit: {{ $room->name }}</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($room->image)
                                                        <div class="form-group text-center">
                                                            <label>Gambar Saat Ini</label><br>
                                                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="max-height: 150px; border-radius: 8px;">
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <label>Gambar Ruangan</label>
                                                        <div class="custom-file">
                                                            <input type="file" name="image" class="custom-file-input" id="editRoomImageLainnya{{ $room->id }}" accept="image/*" onchange="previewEditImage(this, 'editImagePreviewLainnya{{ $room->id }}')">
                                                            <label class="custom-file-label" for="editRoomImageLainnya{{ $room->id }}">Ganti gambar...</label>
                                                        </div>
                                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
                                                        <div class="mt-2 text-center">
                                                            <img id="editImagePreviewLainnya{{ $room->id }}" src="#" alt="Preview" style="max-height: 150px; border-radius: 8px; display: none;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Ruangan <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis <span class="text-danger">*</span></label>
                                                        <input type="text" name="type" class="form-control" value="{{ $room->type }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kapasitas</label>
                                                        <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" min="0">
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
                    </div>
                </div>
            @endforeach
        @endif
    @endif

    <!-- Modal Tambah Ruangan -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fas fa-plus-circle mr-1"></i> Tambah Ruangan Baru</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Ruang 10A" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar Ruangan</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="addRoomImage" accept="image/*" onchange="previewAddImage(this)">
                                <label class="custom-file-label" for="addRoomImage">Pilih gambar...</label>
                            </div>
                            <small class="text-muted">Format: JPG, PNG, WebP. Maks 2MB.</small>
                            <div class="mt-2 text-center">
                                <img id="addImagePreview" src="#" alt="Preview" style="max-height: 150px; border-radius: 8px; display: none;">
                            </div>
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
                                <option value="Activity Room">Activity Room</option>
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

    @push('scripts')
    <script>
        function previewAddImage(input) {
            var preview = document.getElementById('addImagePreview');
            var label = input.nextElementSibling;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
                label.innerText = input.files[0].name;
            } else {
                preview.style.display = 'none';
                label.innerText = 'Pilih gambar...';
            }
        }

        function previewEditImage(input, previewId) {
            var preview = document.getElementById(previewId);
            var label = input.nextElementSibling;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
                label.innerText = input.files[0].name;
            } else {
                preview.style.display = 'none';
                label.innerText = 'Ganti gambar...';
            }
        }
    </script>
    @endpush

</x-admin-layout>
