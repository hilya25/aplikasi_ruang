<x-admin-layout :title="'Profil Admin'">
    <x-slot name="header">
        <h1 class="m-0"><i class="fas fa-user-cog mr-2"></i> Profil Admin</h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46;">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" style="color: #065f46;">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b;">
                    <i class="fas fa-exclamation-circle mr-2"></i> <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" style="color: #991b1b;">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <!-- Profile Photo & Info Card -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 24px;">
                <div style="padding: 1rem 1.5rem; background: linear-gradient(135deg, #eef2ff, #e0e7ff); border-bottom: 1px solid #e5e7eb; display: flex; align-items: center;">
                    <span style="width: 40px; height: 40px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; background: linear-gradient(135deg, #6366f1, #818cf8); color: white; box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                        <i class="fas fa-user-pen"></i>
                    </span>
                    <div>
                        <h3 class="card-title mb-0" style="font-weight: 700; font-size: 1.05rem; color: #1f2937;">Informasi Profil</h3>
                        <small style="color: #9ca3af;">Perbarui foto dan informasi akun Anda</small>
                    </div>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <!-- Photo Upload -->
                        <div class="mb-4">
                            <label class="font-weight-bold text-gray-700 mb-2 d-flex align-items-center" style="font-size: 0.9rem;">
                                <span style="width: 24px; height: 24px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: linear-gradient(135deg, #fdf4ff, #f3e8ff);">
                                    <i class="fas fa-camera" style="color: #a855f7; font-size: 0.7rem;"></i>
                                </span>
                                Foto Profil
                            </label>

                            <div class="d-flex align-items-center" style="gap: 20px;">
                                <!-- Current Photo -->
                                <div class="position-relative">
                                    @if(Auth::user()->profile_photo_path)
                                        <img src="{{ url('storage/' . Auth::user()->profile_photo_path) }}?v={{ Auth::user()->updated_at?->timestamp }}"
                                             alt="{{ Auth::user()->name }}"
                                             class="rounded-3"
                                             style="width: 96px; height: 96px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                    @else
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white font-weight-bold"
                                             style="width: 96px; height: 96px; font-size: 2rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="position-absolute d-flex align-items-center justify-content-center"
                                          style="bottom: -4px; right: -4px; width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: 2px solid white; color: white; font-size: 0.65rem;">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                </div>

                                <div>
                                    <input type="file" id="photoInput" class="d-none" name="photo" accept="image/*"
                                           onchange="previewPhoto(this)">
                                    <button type="button" onclick="document.getElementById('photoInput').click()"
                                            class="btn btn-sm mb-2" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border-radius: 10px; padding: 8px 16px; font-weight: 600; box-shadow: 0 4px 12px rgba(99,102,241,0.4);">
                                        <i class="fas fa-cloud-arrow-up mr-1"></i> Pilih Foto Baru
                                    </button>
                                    <div id="photoPreview" class="d-none mt-2">
                                        <small class="text-success"><i class="fas fa-check-circle mr-1"></i> <span id="photoName"></span></small>
                                    </div>
                                    <div>
                                        <small style="color: #9ca3af;"><i class="fas fa-info-circle mr-1"></i> JPG, JPEG, atau PNG. Maks 1MB.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="border: none; border-top: 1px solid #f3f4f6; margin: 1.5rem 0;">

                        <!-- Name -->
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 mb-2 d-flex align-items-center" style="font-size: 0.9rem;">
                                <span style="width: 24px; height: 24px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: linear-gradient(135deg, #eef2ff, #e0e7ff);">
                                    <i class="fas fa-user" style="color: #6366f1; font-size: 0.7rem;"></i>
                                </span>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                   class="form-control" style="border-radius: 10px; border-color: #e5e7eb; padding: 10px 14px;">
                            @error('name')
                                <small class="text-danger mt-1 d-block"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 mb-2 d-flex align-items-center" style="font-size: 0.9rem;">
                                <span style="width: 24px; height: 24px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                                    <i class="fas fa-envelope" style="color: #3b82f6; font-size: 0.7rem;"></i>
                                </span>
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                   class="form-control" style="border-radius: 10px; border-color: #e5e7eb; padding: 10px 14px;">
                            @error('email')
                                <small class="text-danger mt-1 d-block"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <hr style="border: none; border-top: 1px solid #f3f4f6; margin: 1.5rem 0;">

                        <!-- Submit -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border-radius: 10px; padding: 10px 24px; font-weight: 600; box-shadow: 0 6px 18px rgba(99,102,241,0.4);">
                                <i class="fas fa-floppy-disk mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); overflow: hidden;">
                <div style="padding: 1rem 1.5rem; background: linear-gradient(135deg, #fffbeb, #fef3c7); border-bottom: 1px solid #fde68a; display: flex; align-items: center;">
                    <span style="width: 40px; height: 40px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3);">
                        <i class="fas fa-lock"></i>
                    </span>
                    <div>
                        <h3 class="card-title mb-0" style="font-weight: 700; font-size: 1.05rem; color: #1f2937;">Ubah Password</h3>
                        <small style="color: #9ca3af;">Pastikan password Anda kuat dan aman</small>
                    </div>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <form method="POST" action="{{ route('admin.password.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 mb-2 d-flex align-items-center" style="font-size: 0.9rem;">
                                <span style="width: 24px; height: 24px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                                    <i class="fas fa-key" style="color: #ef4444; font-size: 0.7rem;"></i>
                                </span>
                                Password Saat Ini
                            </label>
                            <input type="password" name="current_password" required
                                   class="form-control" style="border-radius: 10px; border-color: #e5e7eb; padding: 10px 14px;">
                            @error('current_password')
                                <small class="text-danger mt-1 d-block"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- New Password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700 mb-2 d-flex align-items-center" style="font-size: 0.9rem;">
                                        <span style="width: 24px; height: 24px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                                            <i class="fas fa-lock" style="color: #10b981; font-size: 0.7rem;"></i>
                                        </span>
                                        Password Baru
                                    </label>
                                    <input type="password" name="password" required
                                           class="form-control" style="border-radius: 10px; border-color: #e5e7eb; padding: 10px 14px;">
                                    @error('password')
                                        <small class="text-danger mt-1 d-block"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700 mb-2 d-flex align-items-center" style="font-size: 0.9rem;">
                                        <span style="width: 24px; height: 24px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                                            <i class="fas fa-lock" style="color: #6366f1; font-size: 0.7rem;"></i>
                                        </span>
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" name="password_confirmation" required
                                           class="form-control" style="border-radius: 10px; border-color: #e5e7eb; padding: 10px 14px;">
                                </div>
                            </div>
                        </div>

                        <hr style="border: none; border-top: 1px solid #f3f4f6; margin: 1.5rem 0;">

                        <!-- Submit -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; border-radius: 10px; padding: 10px 24px; font-weight: 600; box-shadow: 0 6px 18px rgba(245,158,11,0.4);">
                                <i class="fas fa-shield-halved mr-2"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('photoPreview');
                    var name = document.getElementById('photoName');
                    name.textContent = input.files[0].name;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush

</x-admin-layout>
