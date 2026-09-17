<x-admin-layout :title="'Kelola Jadwal'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-calendar-alt mr-2"></i> Kelola Jadwal</h1>
    </x-slot>

    <!-- Alert -->
    @if(session('success'))
        <div class="callout callout-success">
            <p><i class="fas fa-check-circle mr-1"></i> {{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="callout callout-danger">
            <p><i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}</p>
        </div>
    @endif

    <!-- Header Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.schedules.bulk') }}" class="btn btn-success">
                <i class="fas fa-calendar-week mr-1"></i> Tambah Jadwal Mingguan
            </a>
        </div>
        <div class="text-muted">
            <i class="fas fa-info-circle mr-1"></i> Total {{ $rooms->sum(fn($r) => $r->schedules->count()) }} jadwal
        </div>
    </div>

    <!-- Filter Ruangan -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-filter mr-2 text-primary"></i>
                <label class="mr-2 mb-0 font-weight-bold">Filter Ruangan:</label>
                <select id="roomFilter" class="form-control form-control-sm" style="max-width: 250px;" onchange="filterRooms()">
                    <option value="all">Semua Ruangan</option>
                    @foreach($typeOrder as $type)
                        @if(isset($groupedRooms[$type]))
                            <optgroup label="{{ $type }}">
                                @foreach($groupedRooms[$type] as $room)
                                    <option value="room-{{ $room->id }}">{{ $room->name }} ({{ $room->schedules->count() }} jadwal)</option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                    @if(isset($groupedRooms['Lainnya']))
                        <optgroup label="Lainnya">
                            @foreach($groupedRooms['Lainnya'] as $room)
                                <option value="room-{{ $room->id }}">{{ $room->name }} ({{ $room->schedules->count() }} jadwal)</option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>
        </div>
    </div>

    <!-- Daftar Jadwal per Jenis Ruangan -->
    @forelse($typeOrder as $type)
        @if(isset($groupedRooms[$type]))
            <!-- Header Jenis Ruangan -->
            <div class="mb-3">
                <h5 class="mb-0">
                    @if($type === 'Kelas') <i class="fas fa-chalkboard mr-1 text-primary"></i>
                    @elseif($type === 'Lab') <i class="fas fa-flask mr-1 text-success"></i>
                    @elseif($type === 'Aula') <i class="fas fa-building mr-1 text-warning"></i>
                    @elseif($type === 'Lapangan') <i class="fas fa-futbol mr-1 text-info"></i>
                    @elseif($type === 'Masjid') <i class="fas fa-mosque mr-1 text-secondary"></i>
                    @elseif($type === 'Activity Room') <i class="fas fa-running mr-1 text-purple"></i>
                    @elseif($type === 'Perpustakaan') <i class="fas fa-book-open mr-1 text-warning"></i>
                    @endif
                    <strong>{{ $type }}</strong>
                    <small class="text-muted ml-2">({{ $groupedRooms[$type]->count() }} ruangan)</small>
                </h5>
            </div>

            <!-- Card per Ruangan -->
            @foreach($groupedRooms[$type] as $room)
            <div class="card mb-3 room-card" id="room-{{ $room->id }}">
                <!-- Card Header: Nama Ruangan -->
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-door-open mr-2 text-muted"></i>
                        <strong>{{ $room->name }}</strong>
                        @if($room->location)
                            <small class="text-muted ml-2"><i class="fas fa-map-marker-alt mr-1"></i>{{ $room->location }}</small>
                        @endif
                    </div>
                    <div>
                        <span class="badge badge-{{ $type === 'Kelas' ? 'primary' : ($type === 'Lab' ? 'success' : ($type === 'Aula' ? 'warning' : ($type === 'Lapangan' ? 'info' : 'secondary'))) }}">
                            {{ $room->schedules->count() }} jadwal
                        </span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <!-- Card Body: Jadwal per Hari -->
                <div class="card-body p-0">
                    @if($room->schedules->count() > 0)
                        @php
                            $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                            $grouped = $room->schedules->groupBy('day_of_week');
                        @endphp

                        <div class="accordion" id="accordion-{{ $room->id }}">
                            @foreach($days as $day)
                                @if(isset($grouped[$day]) && $grouped[$day]->count() > 0)
                                <div style="border-bottom: 1px solid #e5e7eb;">
                                    <!-- Hari Header -->
                                    <div style="padding: 10px 20px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; background: #f9fafb;" data-toggle="collapse" data-target="#collapse-{{ $room->id }}-{{ $loop->index }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-chevron-right mr-2" style="color: #6366f1; font-size: 0.75rem; transition: transform 0.2s;"></i>
                                            <span style="font-weight: 600; color: #374151;">{{ $day }}</span>
                                        </div>
                                        <span class="badge badge-light">{{ $grouped[$day]->count() }} jam</span>
                                    </div>

                                    <!-- Isi Jadwal Hari Itu -->
                                    <div id="collapse-{{ $room->id }}-{{ $loop->index }}" class="collapse">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 180px;">Jam</th>
                                                    <th>Kelas</th>
                                                    <th>Mapel</th>
                                                    <th>Guru</th>
                                                    <th style="width: 80px;">Status</th>
                                                    <th style="width: 120px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($grouped[$day] as $schedule)
                                                <tr>
                                                    <td>
                                                        <i class="fas fa-clock mr-1 text-success" style="font-size: 0.75rem;"></i>
                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                    </td>
                                                    <td>{{ $schedule->classRoom?->name ?? '-' }}</td>
                                                    <td class="text-muted">{{ $schedule->subject ?? '-' }}</td>
                                                    <td class="text-muted">{{ $schedule->teacher ?? '-' }}</td>
                                                    <td>
                                                        @if($schedule->status === 'active')
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Nonaktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Toggle -->
                                                        <form method="POST" action="{{ route('admin.schedules.toggle-status', $schedule) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm {{ $schedule->status === 'active' ? 'btn-warning' : 'btn-success' }}" title="{{ $schedule->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                                <i class="fas {{ $schedule->status === 'active' ? 'fa-pause' : 'fa-play' }}"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Edit -->
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{ $schedule->id }}" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <!-- Delete -->
                                                        <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="d-inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editModal{{ $schedule->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header bg-primary text-white">
                                                                    <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit Jadwal</h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Ruangan</label>
                                                                        <select name="room_id" class="form-control" required>
                                                                            @foreach($rooms as $rm)
                                                                                <option value="{{ $rm->id }}" {{ $schedule->room_id == $rm->id ? 'selected' : '' }}>{{ $rm->name }} ({{ $rm->type }})</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kelas</label>
                                                                        <select name="class_id" class="form-control">
                                                                            <option value="">-- Pilih Kelas --</option>
                                                                            @php
                                                                                $classesByGrade = $classes->groupBy(function ($class) {
                                                                                    $name = strtolower(trim($class->name));
                                                                                    if (preg_match('/^(xii|12)/', $name)) {
                                                                                        return 'XII';
                                                                                    } elseif (preg_match('/^(xi|11)/', $name)) {
                                                                                        return 'XI';
                                                                                    } elseif (preg_match('/^(x|10)/', $name)) {
                                                                                        return 'X';
                                                                                    }
                                                                                    return 'Lainnya';
                                                                                });
                                                                                $gradeOrder = ['X', 'XI', 'XII', 'Lainnya'];
                                                                            @endphp
                                                                            @foreach($gradeOrder as $grade)
                                                                                @if(isset($classesByGrade[$grade]) && $classesByGrade[$grade]->count() > 0)
                                                                                    <optgroup label="Kelas {{ $grade }}">
                                                                                        @foreach($classesByGrade[$grade] as $class)
                                                                                            <option value="{{ $class->id }}" {{ $schedule->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                                                        @endforeach
                                                                                    </optgroup>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Mata Pelajaran</label>
                                                                        <input type="text" name="subject" class="form-control" value="{{ $schedule->subject }}" placeholder="Contoh: Matematika">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Guru Pengajar</label>
                                                                        <input type="text" name="teacher" class="form-control" value="{{ $schedule->teacher }}" placeholder="Contoh: Budi Santoso, S.Pd">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Hari</label>
                                                                        <select name="day_of_week" class="form-control" required>
                                                                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                                                                                <option value="{{ $day }}" {{ $schedule->day_of_week === $day ? 'selected' : '' }}>{{ $day }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Jam Mulai</label>
                                                                                <input type="time" name="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Jam Selesai</label>
                                                                                <input type="time" name="end_time" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
                                                                            </div>
                                                                        </div>
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
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times mr-1"></i> Belum ada jadwal
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    @empty
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-door-open fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-500">Belum ada ruangan aktif</h5>
                <p class="text-muted">Tambahkan ruangan terlebih dahulu di menu "Kelola Ruangan".</p>
            </div>
        </div>
    @endforelse

    <!-- Ruangan dengan jenis lain yang tidak terdaftar di typeOrder -->
    @php
        $otherTypes = $groupedRooms->diffKeys(array_flip($typeOrder));
    @endphp
    @if($otherTypes->count() > 0)
        @foreach($otherTypes as $type => $typeRooms)
            <div class="mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-ellipsis-h mr-1 text-secondary"></i>
                    <strong>{{ $type }}</strong>
                    <small class="text-muted ml-2">({{ $typeRooms->count() }} ruangan)</small>
                </h5>
            </div>

            @foreach($typeRooms as $room)
            <div class="card mb-3 room-card" id="room-{{ $room->id }}">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-door-open mr-2 text-muted"></i>
                        <strong>{{ $room->name }}</strong>
                    </div>
                    <div>
                        <span class="badge badge-secondary">{{ $room->schedules->count() }} jadwal</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($room->schedules->count() > 0)
                        @php
                            $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                            $grouped = $room->schedules->groupBy('day_of_week');
                        @endphp

                        <div class="accordion" id="accordion-{{ $room->id }}">
                            @foreach($days as $day)
                                @if(isset($grouped[$day]) && $grouped[$day]->count() > 0)
                                <div style="border-bottom: 1px solid #e5e7eb;">
                                    <div style="padding: 10px 20px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; background: #f9fafb;" data-toggle="collapse" data-target="#collapse-{{ $room->id }}-{{ $loop->index }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-chevron-right mr-2" style="color: #6366f1; font-size: 0.75rem;"></i>
                                            <span style="font-weight: 600; color: #374151;">{{ $day }}</span>
                                        </div>
                                        <span class="badge badge-light">{{ $grouped[$day]->count() }} jam</span>
                                    </div>
                                    <div id="collapse-{{ $room->id }}-{{ $loop->index }}" class="collapse">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 180px;">Jam</th>
                                                    <th>Kelas</th>
                                                    <th>Mapel</th>
                                                    <th>Guru</th>
                                                    <th style="width: 80px;">Status</th>
                                                    <th style="width: 120px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($grouped[$day] as $schedule)
                                                <tr>
                                                    <td>
                                                        <i class="fas fa-clock mr-1 text-success" style="font-size: 0.75rem;"></i>
                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                    </td>
                                                    <td>{{ $schedule->classRoom?->name ?? '-' }}</td>
                                                    <td class="text-muted">{{ $schedule->subject ?? '-' }}</td>
                                                    <td class="text-muted">{{ $schedule->teacher ?? '-' }}</td>
                                                    <td>
                                                        @if($schedule->status === 'active')
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Nonaktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{ route('admin.schedules.toggle-status', $schedule) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm {{ $schedule->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                                                <i class="fas {{ $schedule->status === 'active' ? 'fa-pause' : 'fa-play' }}"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{ $schedule->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="d-inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="editModal{{ $schedule->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header bg-primary text-white">
                                                                    <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit Jadwal</h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Ruangan</label>
                                                                        <select name="room_id" class="form-control" required>
                                                                            @foreach($rooms as $rm)
                                                                                <option value="{{ $rm->id }}" {{ $schedule->room_id == $rm->id ? 'selected' : '' }}>{{ $rm->name }} ({{ $rm->type }})</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kelas</label>
                                                                        <select name="class_id" class="form-control">
                                                                            <option value="">-- Pilih Kelas --</option>
                                                                            @php
                                                                                $classesByGrade = $classes->groupBy(function ($class) {
                                                                                    $name = strtolower(trim($class->name));
                                                                                    if (preg_match('/^(xii|12)/', $name)) {
                                                                                        return 'XII';
                                                                                    } elseif (preg_match('/^(xi|11)/', $name)) {
                                                                                        return 'XI';
                                                                                    } elseif (preg_match('/^(x|10)/', $name)) {
                                                                                        return 'X';
                                                                                    }
                                                                                    return 'Lainnya';
                                                                                });
                                                                                $gradeOrder = ['X', 'XI', 'XII', 'Lainnya'];
                                                                            @endphp
                                                                            @foreach($gradeOrder as $grade)
                                                                                @if(isset($classesByGrade[$grade]) && $classesByGrade[$grade]->count() > 0)
                                                                                    <optgroup label="Kelas {{ $grade }}">
                                                                                        @foreach($classesByGrade[$grade] as $class)
                                                                                            <option value="{{ $class->id }}" {{ $schedule->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                                                        @endforeach
                                                                                    </optgroup>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Mata Pelajaran</label>
                                                                        <input type="text" name="subject" class="form-control" value="{{ $schedule->subject }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Hari</label>
                                                                        <select name="day_of_week" class="form-control" required>
                                                                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                                                                                <option value="{{ $day }}" {{ $schedule->day_of_week === $day ? 'selected' : '' }}>{{ $day }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Jam Mulai</label>
                                                                                <input type="time" name="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Jam Selesai</label>
                                                                                <input type="time" name="end_time" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
                                                                            </div>
                                                                        </div>
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
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times mr-1"></i> Belum ada jadwal
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        @endforeach
    @endif

    <!-- Script: Filter & Collapse -->
    <script>
        function filterRooms() {
            var val = document.getElementById('roomFilter').value;
            document.querySelectorAll('.room-card').forEach(function(card) {
                if (val === 'all' || card.id === val) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

</x-admin-layout>
