<x-guest-layout>

<div class="card-logo">
    <span class="c-icon">S</span>
    <span class="c-name">SIPARU</span>
</div>

<x-validation-errors class="mb-4" />

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <h1 class="form-title">Reset Password</h1>
    <p class="form-subtitle">Masukkan password baru Anda di bawah ini</p>

    <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrap">
            <i class="fas fa-envelope"></i>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="nama@sekolah.sch.id">
        </div>
    </div>

    <div class="form-group">
        <label for="password">Password Baru</label>
        <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
        </div>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-key"></i> Reset Password
    </button>

    <div class="form-divider">atau</div>

    <div class="form-footer" style="margin-top:0">
        <a href="{{ route('login') }}"><i class="fas fa-arrow-left" style="margin-right:5px"></i> Kembali ke halaman masuk</a>
    </div>
</form>

</x-guest-layout>
