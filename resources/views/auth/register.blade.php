<x-guest-layout>

<div class="card-logo">
    <span class="c-icon">S</span>
    <span class="c-name">SIPARU</span>
</div>

<x-validation-errors class="mb-4" />

<form method="POST" action="{{ route('register') }}" style="--register-form: compact;">
    @csrf

    <h1 class="form-title">Daftar Akun Baru</h1>
    <p class="form-subtitle">Isi data di bawah untuk mulai menggunakan SIPARU</p>

    <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <div class="input-wrap">
            <i class="fas fa-user"></i>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda">
        </div>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrap">
            <i class="fas fa-envelope"></i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="contoh@sekolah.sch.id">
        </div>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
        </div>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
        </div>
    </div>

    <div class="form-group">
        <label for="invite_code">Invite Code <span style="color:#64748b;font-weight:500">(khusus Admin)</span></label>
        <div class="input-wrap">
            <i class="fas fa-key"></i>
            <input id="invite_code" type="text" name="invite_code" value="{{ old('invite_code') }}" autocomplete="off" placeholder="Kosongkan jika daftar sebagai guru/staff">
        </div>
    </div>

    <button type="submit" class="btn-submit" style="margin-top:20px">
        <i class="fas fa-user-plus"></i> Daftar Sekarang
    </button>

    <div class="form-divider">atau</div>

    <div class="form-footer" style="margin-top:0">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</form>
</x-guest-layout>
