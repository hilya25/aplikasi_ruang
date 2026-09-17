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

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <h1 class="form-title">Lupa Password?</h1>
    <p class="form-subtitle">Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset password.</p>

    <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrap">
            <i class="fas fa-envelope"></i>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@sekolah.sch.id">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i> Kirim Tautan Reset
    </button>

    <div class="form-divider">atau</div>

    <div class="form-footer" style="margin-top:0">
        <a href="{{ route('login') }}"><i class="fas fa-arrow-left" style="margin-right:5px"></i> Kembali ke halaman masuk</a>
    </div>
</form>
</x-guest-layout>
