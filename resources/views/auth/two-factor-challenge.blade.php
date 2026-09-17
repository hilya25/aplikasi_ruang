<x-guest-layout>

<div class="card-logo">
    <span class="c-icon">S</span>
    <span class="c-name">SIPARU</span>
</div>

<x-validation-errors class="mb-4" />

<div x-data="{ recovery: false }">
    <h1 class="form-title">Verifikasi Dua Langkah</h1>
    <p class="form-subtitle" x-show="! recovery" style="margin-bottom:28px">
        Masukkan kode autentikasi dari aplikasi authenticator Anda untuk melanjutkan.
    </p>
    <p class="form-subtitle" x-cloak x-show="recovery" style="margin-bottom:28px">
        Masukkan salah satu kode pemulihan darurat Anda untuk melanjutkan.
    </p>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="form-group" x-show="! recovery">
            <label for="code">Kode Autentikasi</label>
            <div class="input-wrap">
                <i class="fas fa-shield-halved"></i>
                <input id="code" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" placeholder="6 digit kode">
            </div>
        </div>

        <div class="form-group" x-cloak x-show="recovery">
            <label for="recovery_code">Kode Pemulihan</label>
            <div class="input-wrap">
                <i class="fas fa-life-ring"></i>
                <input id="recovery_code" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" placeholder="Kode pemulihan darurat">
            </div>
        </div>

        <button type="submit" class="btn-submit" style="margin-top:8px">
            <i class="fas fa-right-to-bracket"></i> Masuk
        </button>
    </form>

    <div class="form-divider">atau</div>

    <div style="text-align:center">
        <button type="button" style="background:none;border:none;color:#6366f1;font-weight:700;font-size:0.85rem;cursor:pointer;font-family:inherit"
                        x-show="! recovery"
                        x-on:click="
                            recovery = true;
                            $nextTick(() => { $refs.recovery_code.focus() })
                        ">
            Gunakan kode pemulihan
        </button>

        <button type="button" style="background:none;border:none;color:#6366f1;font-weight:700;font-size:0.85rem;cursor:pointer;font-family:inherit"
                        x-cloak
                        x-show="recovery"
                        x-on:click="
                            recovery = false;
                            $nextTick(() => { $refs.code.focus() })
                        ">
            Gunakan kode autentikasi
        </button>
    </div>
</div>

</x-guest-layout>
