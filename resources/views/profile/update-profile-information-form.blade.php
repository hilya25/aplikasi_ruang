<x-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <label for="photo" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #fdf4ff, #f3e8ff);">
                        <i class="fas fa-camera text-purple-500 text-xs"></i>
                    </span>
                    Foto Profil
                </label>

                <div class="flex items-center gap-5">
                    <!-- Current Profile Photo -->
                    <div x-show="! photoPreview" class="relative">
                        <img src="{{ url('storage/' . $this->user->profile_photo_path) }}?v={{ $this->user->updated_at?->timestamp }}" alt="{{ $this->user->name }}"
                             class="rounded-2xl h-24 w-24 object-cover ring-4 ring-white shadow-lg"
                             style="background: linear-gradient(135deg, #e0e7ff, #ede9fe);">
                        <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full inline-flex items-center justify-center shadow-md"
                              style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: 2px solid white;">
                            <i class="fas fa-camera text-white text-xs"></i>
                        </span>
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div x-show="photoPreview" style="display: none;" class="relative">
                        <span class="block rounded-2xl w-24 h-24 bg-cover bg-no-repeat bg-center ring-4 ring-white shadow-lg"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                        <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full inline-flex items-center justify-center shadow-md"
                              style="background: linear-gradient(135deg, #10b981, #34d399); border: 2px solid white;">
                            <i class="fas fa-check text-white text-xs"></i>
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-2">
                        <button type="button"
                                x-on:click.prevent="$refs.photo.click()"
                                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95"
                                style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; box-shadow: 0 4px 12px -4px rgba(99,102,241,0.5);">
                            <i class="fas fa-cloud-arrow-up mr-2"></i> Pilih Foto Baru
                        </button>

                        @if ($this->user->profile_photo_path)
                            <button type="button"
                                    wire:click="deleteProfilePhoto"
                                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95 border"
                                    style="background: white; color: #dc2626; border-color: #fecaca;">
                                <i class="fas fa-trash-can mr-2"></i> Hapus Foto
                            </button>
                        @endif

                        <!-- File name -->
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

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eef2ff, #e0e7ff);">
                    <i class="fas fa-user text-indigo-500 text-xs"></i>
                </span>
                Nama Lengkap
            </label>
            <input id="name" type="text" wire:model="state.name" required autocomplete="name"
                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                <span class="w-6 h-6 rounded-lg inline-flex items-center justify-center mr-2" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                    <i class="fas fa-envelope text-blue-500 text-xs"></i>
                </span>
                Email
            </label>
            <input id="email" type="email" wire:model="state.email" required autocomplete="username"
                   class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 transition-all" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl flex items-start gap-2" style="background: #fffbeb; border: 1px solid #fde68a;">
                    <i class="fas fa-exclamation-triangle text-amber-500 text-xs mt-0.5"></i>
                    <div>
                        <p class="text-sm text-amber-700">Email Anda belum terverifikasi.</p>
                        <button type="button" class="underline text-sm font-semibold text-amber-600 hover:text-amber-800 rounded-md focus:outline-none" wire:click.prevent="sendEmailVerification">
                            Klik di sini untuk kirim ulang email verifikasi.
                        </button>
                    </div>
                </div>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-emerald-600 flex items-center gap-1.5">
                        <i class="fas fa-check-circle"></i> Link verifikasi baru telah dikirim ke email Anda.
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-check-circle text-emerald-500"></i> Tersimpan!
            </span>
        </x-action-message>

        <button wire:loading.attr="disabled" wire:target="photo"
                class="inline-flex items-center px-6 py-3 text-white rounded-xl transition-all hover:scale-105 active:scale-95 font-semibold"
                style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px -8px rgba(99,102,241,0.6);">
            <span wire:loading.remove wire:target="photo"><i class="fas fa-floppy-disk mr-2"></i> Simpan Perubahan</span>
            <span wire:loading wire:target="photo"><i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...</span>
        </button>
    </x-slot>
</x-form-section>
