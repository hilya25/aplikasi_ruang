<x-guest-layout>

<div class="card-logo">
    <span class="c-icon">S</span>
    <span class="c-name">SIPARU</span>
</div>

<x-validation-errors class="mb-4" />

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <h1 class="form-title">Konfirmasi Password</h1>
    <p class="form-subtitle">Ini area aman aplikasi. Silakan konfirmasi password Anda untuk melanjutkan.</p>

    <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus placeholder="••••••••">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-shield-halved"></i> Konfirmasi
    </button>

    <div class="form-divider">atau</div>

    <div class="form-footer" style="margin-top:0">
        <a href="{{ url('/dashboard') }}"><i class="fas fa-arrow-left" style="margin-right:5px"></i> Kembali ke dashboard</a>
    </div>
</form>

</x-guest-layout>
