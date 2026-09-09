<x-admin-layout :title="'Kelola Jadwal'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-calendar-alt mr-2"></i> Kelola Jadwal</h1>
    </x-slot>

    <!-- Header Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.schedules.bulk') }}" class="btn btn-primary">
                <i class="fas fa-calendar-week mr-1"></i> Tambah Jadwal Mingguan
            </a>
        </div>
        <div class="text-muted" style="font-size: 0.9rem;">
            <i class="fas fa-info-circle mr-1"></i> {{ $rooms->sum(fn($r) => $r->schedules->count()) }} jadwal aktif
        </div>
    </div>

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

    <!-- Filter Ruangan -->
    <div class="card mb-4" style="border-radius: 12px; border: 1px solid #e5e7eb;">
        <div class="card-body py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-filter mr-2" style="color: #6366f1;"></i>
                <label class="mr-2 mb-0 font-weight-bold" style="font-size: 0.9rem;">Filter Ruangan:</label>
                <select id="roomFilter" class="form-control form-control-sm" style="max-width: 250px; border-radius: 8px;" onchange="filterRooms()">
                    <option value="all">Semua Ruangan</option>
                    @foreach($rooms as $room)
                        <option value="room-{{ $room->id }}">{{ $room->name }} ({{ $room->schedules->count() }} jadwal)</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Card per Ruangan -->
    @forelse($rooms as $room)
    <div class="card mb-4 room-card" id="room-{{ $room->id }}" style="border-radius: 12px; border: 1px solid #e5e7eb;">
        <!-- Card Header: Nama Ruangan -->
        <div class="card-header d-flex align-items-center justify-content-between" style="border-radius: 12px 12px 0 0; background: linear-gradient(to right, #6366f1, #9333ea); color: white; padding: 14px 20px;">
            <div class="d-flex align-items-center">
                <i class="fas @if($room->type === 'Kelas') fa-chalkboard-teacher @elseif($room->type === 'Lab') fa-flask @elseif($room->type === 'Aula') fa-building @else fa-door-open @endif mr-2" style="font-size: 1.1rem;"></i>
                <strong style="font-size: 1.05rem;">{{ $room->name }}</strong>
                <span class="badge badge-light ml-2" style="font-size: 0.75rem;">{{ $room->type }}</span>
            </div>
            <span class="badge badge-light" style="font-size: 0.8rem;">{{ $room->schedules->count() }} jadwal</span>
        </div>

        <!-- Card Body: Jadwal per Hari (Accordion) -->
        <div class="card-body p-0">
            @if($room->schedules->count() > 0)
                @php
                    $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                    $grouped = $room->schedules->groupBy('day_of_week');
                @endphp

                <div class="accordion" id="accordion-{{ $room->id }}">
                    @foreach($days as $day)
                        @if(isset($grouped[$day]) && $grouped[$day]->count() > 0)
                        <div style="border-bottom: 1px solid #f3f4f6;">
                            <!-- Hari Header (Collapse Toggle) -->
                            <div style="padding: 12px 20px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; background: #fafafa;" data-toggle="collapse" data-target="#collapse-{{ $room->id }}-{{ $loop->index }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chevron-right mr-2" style="color: #6366f1; font-size: 0.75rem; transition: transform 0.2s;" id="icon-{{ $room->id }}-{{ $loop->index }}"></i>
                                    <span style="font-weight: 600; color: #374151; font-size: 0.9rem;">{{ $day }}</span>
                                </div>
                                <span class="badge" style="background: #ede9fe; color: #6d28d9; font-size: 0.75rem;">{{ $grouped[$day]->count() }} jam</span>
                            </div>

                            <!-- Isi Jadwal Hari Itu -->
                            <div id="collapse-{{ $room->id }}-{{ $loop->index }}" class="collapse" style="padding: 0;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background: #f8f9fa;">
                                            <th style="padding: 8px 20px 8px 44px; font-size: 0.75rem; color: #6b7280; text-align: left; border-bottom: 1px solid #e5e7eb;">Jam</th>
                                            <th style="padding: 8px 16px; font-size: 0.75rem; color: #6b7280; text-align: left; border-bottom: 1px solid #e5e7eb;">Kelas</th>
                                            <th style="padding: 8px 16px; font-size: 0.75rem; color: #6b7280; text-align: left; border-bottom: 1px solid #e5e7eb;">Mapel</th>
                                            <th style="padding: 8px 16px; font-size: 0.75rem; color: #6b7280; text-align: left; border-bottom: 1px solid #e5e7eb;">Status</th>
                                            <th style="padding: 8px 16px; font-size: 0.75rem; color: #6b7280; text-align: center; border-bottom: 1px solid #e5e7eb;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($grouped[$day] as $schedule)
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td style="padding: 8px 20px 8px 44px; font-size: 0.85rem; color: #1f2937;">
                                                <i class="fas fa-clock mr-1" style="color: #22c55e; font-size: 0.75rem;"></i>
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                            </td>
                                            <td style="padding: 8px 16px; font-size: 0.85rem; color: #374151;">
                                                {{ $schedule->classRoom?->name ?? '-' }}
                                            </td>
                                            <td style="padding: 8px 16px; font-size: 0.85rem; color: #6b7280;">
                                                {{ $schedule->subject ?? '-' }}
                                            </td>
                                            <td style="padding: 8px 16px;">
                                                @if($schedule->status === 'active')
                                                    <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">Aktif</span>
                                                @else
                                                    <span style="background: #f3f4f6; color: #6b7280; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td style="padding: 8px 16px; text-align: center;">
                                                <!-- Toggle -->
                                                <form method="POST" action="{{ route('admin.schedules.toggle-status', $schedule) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $schedule->status === 'active' ? 'btn-warning' : 'btn-success' }}" title="{{ $schedule->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}" style="border-radius: 8px; padding: 3px 8px;">
                                                        <i class="fas {{ $schedule->status === 'active' ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                </form>
                                                <!-- Edit -->
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{ $schedule->id }}" title="Edit" style="border-radius: 8px; padding: 3px 8px;">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Delete -->
                                                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" style="display: inline;" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" style="border-radius: 8px; padding: 3px 8px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editModal{{ $schedule->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" style="border-radius: 12px;">
                                                    <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header" style="border-radius: 12px 12px 0 0; background: linear-gradient(to right, #6366f1, #9333ea); color: white;">
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
                                                                    @foreach($classes as $class)
                                                                        <option value="{{ $class->id }}" {{ $schedule->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Mata Pelajaran</label>
                                                                <input type="text" name="subject" class="form-control" value="{{ $schedule->subject }}" placeholder="Contoh: Matematika">
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
                <div style="text-align: center; padding: 30px 0; color: #9ca3af;">
                    <i class="fas fa-calendar-times" style="font-size: 1.5rem; margin-bottom: 8px; display: block;"></i>
                    Belum ada jadwal untuk ruangan ini
                </div>
            @endif
        </div>
    </div>
    @empty
        <div class="card" style="border-radius: 12px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-door-open" style="font-size: 2rem; color: #d1d5db; margin-bottom: 10px;"></i>
                <p class="text-muted mb-0">Belum ada ruangan aktif</p>
            </div>
        </div>
    @endforelse

    <!-- Script: Filter & Accordion -->
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

        // Rotate chevron icon on collapse
        document.querySelectorAll('[data-toggle="collapse"]').forEach(function(el) {
            el.addEventListener('click', function() {
                var target = document.querySelector(el.getAttribute('data-target'));
                var icon = el.querySelector('.fa-chevron-right');
                if (target.classList.contains('show')) {
                    icon.style.transform = 'rotate(90deg)';
                } else {
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>

</x-admin-layout>
