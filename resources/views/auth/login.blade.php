<x-guest-layout>

<div class="card-logo">
    <span class="c-icon">S</span>
    <span class="c-name">SIPARU</span>
</div>

<x-validation-errors class="mb-4" />

@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <h1 class="form-title">Masuk ke Akun</h1>
    <p class="form-subtitle">Silakan login untuk melanjutkan</p>

    <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrap">
            <i class="fas fa-envelope"></i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@sekolah.sch.id">
        </div>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
        </div>
    </div>

    <div class="form-check">
        <input type="checkbox" id="remember_me" name="remember">
        <label for="remember_me">Ingat saya</label>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-right-to-bracket"></i> Masuk Sekarang
    </button>

    <div class="form-footer">
        <a href="{{ route('password.request') }}">Lupa password?</a>
    </div>

    <div class="form-divider">atau</div>

    <div class="form-footer" style="margin-top:0">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</form>
</x-guest-layout>
