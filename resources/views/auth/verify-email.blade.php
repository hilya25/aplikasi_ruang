<x-guest-layout>

<div class="card-logo">
    <span class="c-icon">S</span>
    <span class="c-name">SIPARU</span>
</div>

<x-validation-errors class="mb-4" />

<h1 class="form-title">Verifikasi Email</h1>
<p class="form-subtitle" style="margin-bottom:24px">Sebelum melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan.</p>

@if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600" style="background:#ecfdf5;padding:14px 18px;border-radius:12px;border:1px solid #a7f3d0;">
        <i class="fas fa-check-circle" style="margin-right:6px"></i> Tautan verifikasi baru telah dikirim ke email Anda.
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf

    <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i> Kirim Ulang Email Verifikasi
    </button>
</form>

<div class="form-divider">atau</div>

<div style="display:flex;flex-direction:column;gap:10px;text-align:center">
    <div class="form-footer" style="margin-top:0">
        <a href="{{ route('user.profile') }}">Edit Profil</a>
    </div>
    <div class="form-footer" style="margin-top:0">
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" style="background:none;border:none;color:#6366f1;font-weight:700;font-size:0.85rem;cursor:pointer;font-family:inherit">
                Keluar dari akun
            </button>
        </form>
    </div>
</div>

</x-guest-layout>
