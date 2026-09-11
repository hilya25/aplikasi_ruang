<x-admin-layout :title="'Tambah Jadwal Mingguan'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-calendar-week mr-2"></i> Tambah Jadwal Mingguan</h1>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Isi jadwal pelajaran untuk beberapa hari sekaligus
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="callout callout-success">
                        <p><i class="fas fa-check-circle mr-1"></i> {{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="callout callout-danger">
                        <p><i class="fas fa-exclamation-circle mr-1"></i> Terjadi kesalahan:</p>
                        <ul class="mb-0 ml-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.schedules.bulk-store') }}">
                    @csrf

                    <div class="card-body">
                        <!-- Pilih Ruangan & Kelas -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ruangan <span class="text-danger">*</span></label>
                                    <select name="room_id" id="bulk_room_id" class="form-control" required onchange="toggleClassFieldBulk(this)">
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" data-type="{{ $room->type }}">{{ $room->name }} ({{ $room->type }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" id="bulk_class_group">
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
                                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Opsional untuk Lab/Aula/Lapangan</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Pilih Hari -->
                        <div class="form-group">
                            <label><i class="fas fa-calendar-day mr-1"></i> Pilih Hari <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap">
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                                    <div class="custom-control custom-checkbox mr-3 mb-2">
                                        <input type="checkbox" class="custom-control-input day-checkbox" id="day_{{ $day }}" name="days[]" value="{{ $day }}">
                                        <label class="custom-control-label font-weight-bold" for="day_{{ $day }}">{{ $day }}</label>
                                    </div>
                                @endforeach
                                <div class="custom-control custom-checkbox ml-3 mb-2">
                                    <input type="checkbox" class="custom-control-input" id="select_all_days" onclick="toggleAllDays(this)">
                                    <label class="custom-control-label font-weight-bold text-primary" for="select_all_days">Pilih Semua</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Jadwal per Hari -->
                        <div id="schedule-container">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                            <div class="day-schedule mb-4" id="schedule_{{ $day }}" style="display: none;">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title font-weight-bold">
                                            <i class="fas fa-calendar-day mr-1"></i> {{ $day }}
                                        </h5>
                                        <button type="button" class="btn btn-success btn-sm float-right" onclick="addRow('{{ $day }}')">
                                            <i class="fas fa-plus mr-1"></i> Tambah Jam
                                        </button>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered mb-0" id="table_{{ $day }}">
                                            <thead style="background: #f8f9fa;">
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th style="width: 150px;">Jam Mulai</th>
                                                    <th style="width: 150px;">Jam Selesai</th>
                                                    <th style="width: 60px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="{{ $day }}_row_0">
                                                    <td>1</td>
                                                    <td>
                                                        <input type="text" name="subjects[{{ $day }}][]" class="form-control" placeholder="Contoh: Matematika">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="start_times[{{ $day }}][]" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="time" name="end_times[{{ $day }}][]" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-default btn-lg">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" id="btn-save" class="btn btn-success btn-lg" onclick="this.disabled=true; this.innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i> Menyimpan...'; this.form.submit();">
                            <i class="fas fa-save mr-2"></i> Simpan Semua Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle semua hari
        function toggleAllDays(el) {
            var checkboxes = document.querySelectorAll('.day-checkbox');
            checkboxes.forEach(function(cb) {
                cb.checked = el.checked;
                toggleSchedule(cb.value, el.checked);
            });
        }

        // Toggle tampilkan jadwal per hari
        document.querySelectorAll('.day-checkbox').forEach(function(cb) {
            cb.addEventListener('change', function() {
                toggleSchedule(this.value, this.checked);
            });
        });

        function toggleSchedule(day, show) {
            var el = document.getElementById('schedule_' + day);
            if (el) {
                el.style.display = show ? 'block' : 'none';
            }
        }

        // Tambah baris jam
        var rowCounter = {};
        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
            rowCounter['{{ $day }}'] = 1;
        @endforeach

        function addRow(day) {
            var table = document.getElementById('table_' + day).getElementsByTagName('tbody')[0];
            var index = rowCounter[day]++;
            var tr = document.createElement('tr');
            tr.id = day + '_row_' + index;
            tr.innerHTML =
                '<td>' + (index + 1) + '</td>' +
                '<td><input type="text" name="subjects[' + day + '][]" class="form-control" placeholder="Contoh: Bahasa Indonesia"></td>' +
                '<td><input type="time" name="start_times[' + day + '][]" class="form-control" required></td>' +
                '<td><input type="time" name="end_times[' + day + '][]" class="form-control" required></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)" title="Hapus"><i class="fas fa-trash"></i></button></td>';
            table.appendChild(tr);
        }

        // Hapus baris jam
        function removeRow(btn) {
            var row = btn.closest('tr');
            var tbody = row.parentElement;
            if (tbody.rows.length > 1) {
                row.remove();
                // Update nomor
                Array.from(tbody.rows).forEach(function(r, i) {
                    r.cells[0].textContent = i + 1;
                });
            } else {
                alert('Minimal harus ada satu jadwal per hari!');
            }
        }

        // Sembunyikan kolom kelas untuk tipe non-kelas
        function toggleClassFieldBulk(select) {
            var selectedOption = select.options[select.selectedIndex];
            var type = selectedOption.getAttribute('data-type');
            var group = document.getElementById('bulk_class_group');
            var classSelect = group.querySelector('select');
            var nonClassTypes = ['Lab', 'Aula', 'Lapangan', 'Masjid', 'Activity Room'];

            if (nonClassTypes.includes(type)) {
                classSelect.removeAttribute('required');
                classSelect.value = '';
            }
        }
    </script>
    @endpush

</x-admin-layout>
