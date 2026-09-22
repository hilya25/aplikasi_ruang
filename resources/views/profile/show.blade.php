<x-app-layout pageTitle="Profil">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1 flex items-center">
                    <i class="fas fa-user-circle mr-1.5"></i> Akun Saya
                </p>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 text-lg"
                          style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);">
                        <i class="fas fa-user-gear"></i>
                    </span>
                    Pengaturan Profil
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 rounded-2xl flex items-center animate-fade-up" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0;">
                    <div class="p-2.5 rounded-xl mr-3" style="background: rgba(255,255,255,0.7);">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-2xl flex items-start animate-fade-up" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); border: 1px solid #fecaca;">
                    <div class="p-2.5 rounded-xl mr-3 mt-0.5" style="background: rgba(255,255,255,0.7);">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-red-800">Terjadi kesalahan:</p>
                        <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Profile Photo & Info -->
            <div class="aesthetic-card stat-card-shimmer overflow-hidden reveal">
                <div class="p-6 flex items-center border-b border-gray-100">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <i class="fas fa-user-pen text-white"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Informasi Profil</h3>
                        <p class="text-sm text-gray-400">Perbarui foto dan informasi akun Anda</p>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Photo Upload -->
                        <div x-data="{photoName: null, photoPreview: null}" class="mb-6">
                            <input type="file" id="photo" class="hidden" name="photo"
                                   x-ref="photo"
                                   x-on:change="
                                       photoName = $refs.photo.files[0].name;
                                       const reader = new FileReader();
                                       reader.onload = (e) => { photoPreview = e.target.result; };
                                       reader.readAsDataURL($refs.photo.files[0]);
                                   " />

                            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #fdf4ff, #f3e8ff);">
                                    <i class="fas fa-camera text-purple-500 text-xs"></i>
                                </span>
                                Foto Profil
                            </label>

                            <div class="flex items-center gap-5">
                                <!-- Current Photo -->
                                <div x-show="! photoPreview" class="relative">
                                    @if($user->profile_photo_path)
                                        <img src="{{ url('storage/' . $user->profile_photo_path) }}?v={{ $user->updated_at?->timestamp }}" alt="{{ $user->name }}"
                                             class="rounded-2xl h-24 w-24 object-cover ring-4 ring-white shadow-lg"
                                             style="background: linear-gradient(135deg, #e0e7ff, #ede9fe);">
                                    @else
                                        <div class="rounded-2xl h-24 w-24 flex items-center justify-center text-3xl font-extrabold text-white ring-4 ring-white shadow-lg"
                                             style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full inline-flex items-center justify-center shadow-md"
                                          style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: 2px solid white;">
                                        <i class="fas fa-camera text-white text-xs"></i>
                                    </span>
                                </div>

                                <!-- Preview -->
                                <div x-show="photoPreview" style="display: none;" class="relative">
                                    <span class="block rounded-2xl w-24 h-24 bg-cover bg-no-repeat bg-center ring-4 ring-white shadow-lg"
                                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                                    <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full inline-flex items-center justify-center shadow-md"
                                          style="background: linear-gradient(135deg, #10b981, #34d399); border: 2px solid white;">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </span>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <button type="button" x-on:click.prevent="$refs.photo.click()"
                                            class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95"
                                            style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; box-shadow: 0 4px 12px -4px rgba(99,102,241,0.5);">
                                        <i class="fas fa-cloud-arrow-up mr-2"></i> Pilih Foto Baru
                                    </button>

                                    @if($user->profile_photo_path)
                                        <button type="submit" name="remove_photo" value="1"
                                                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 border"
                                                style="background: white; color: #dc2626; border-color: #fecaca;">
                                            <i class="fas fa-trash-can mr-2"></i> Hapus Foto
                                        </button>
                                    @endif

                                    <div class="flex items-center gap-2 mt-1" x-show="photoName" style="display: none;">
                                        <i class="fas fa-paperclip text-gray-400 text-xs"></i>
                                        <span class="text-xs text-gray-500 truncate max-w-[140px]" x-text="photoName"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 p-3 rounded-xl flex items-start gap-2" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <i class="fas fa-info-circle text-indigo-400 text-xs mt-0.5"></i>
                                <p class="text-xs text-gray-500">Format: JPG, JPEG, atau PNG. Maksimal 1MB.</p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eef2ff, #e0e7ff);">
                                    <i class="fas fa-user text-indigo-500 text-xs"></i>
                                </span>
                                Nama Lengkap
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                                    <i class="fas fa-envelope text-blue-500 text-xs"></i>
                                </span>
                                Email
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 text-white rounded-xl transition-all hover:scale-105 active:scale-95 font-semibold"
                                    style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
                                <i class="fas fa-floppy-disk mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="aesthetic-card stat-card-shimmer overflow-hidden reveal">
                <div class="p-6 flex items-center border-b border-gray-100">
                    <span class="w-10 h-10 rounded-xl inline-flex items-center justify-center mr-3 shadow-md" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-lock text-white"></i>
                    </span>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Ubah Password</h3>
                        <p class="text-sm text-gray-400">Pastikan password Anda kuat dan aman</p>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                                    <i class="fas fa-key text-red-500 text-xs"></i>
                                </span>
                                Password Saat Ini
                            </label>
                            <input type="password" name="current_password" required
                                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                                        <i class="fas fa-lock text-emerald-500 text-xs"></i>
                                    </span>
                                    Password Baru
                                </label>
                                <input type="password" name="password" required
                                       class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1.5"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eef2ff, #f5f3ff);">
                                        <i class="fas fa-lock text-indigo-500 text-xs"></i>
                                    </span>
                                    Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 text-white rounded-xl transition-all hover:scale-105 active:scale-95 font-semibold"
                                    style="background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 8px 20px -8px rgba(245,158,11,0.5);">
                                <i class="fas fa-shield-halved mr-2"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
