<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Masuk Pengurus — Masjid Al-Hidayah Sorolaten</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/admin.css?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="lg-body">

<main class="lg-layout">

    {{-- ==================== PANEL KIRI (foto + teks) ==================== --}}
    <aside class="lg-hero" style="--lg-photo: url('/images/Background Pict.png');">
        <div class="lg-hero__content">
            <a href="{{ route('home') }}" class="lg-hero__logo" aria-label="Kembali ke Beranda">
                <img src="/images/Logo Masjid.png" alt="Logo Masjid Al-Hidayah">
            </a>
            <h1 class="lg-hero__title">Sistem Informasi<br>Keuangan Masjid</h1>
            <p class="lg-hero__desc">
                Platform pengelolaan keuangan dan konten website Masjid Al Hidayah Sorolaten yang transparan dan terpercaya.
            </p>
        </div>
    </aside>

    {{-- ==================== PANEL KANAN (form login) ==================== --}}
    <section class="lg-panel">
        <div class="lg-card">
            <h2 class="lg-card__title">Masuk Pengurus</h2>
            <p class="lg-card__desc">Masuk ke dashboard pengelolaan keuangan dan konten website Masjid Al Hidayah Sorolaten.</p>

            @if (session('status'))
                <div class="lg-alert lg-alert--ok" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}" class="lg-form" id="loginForm" novalidate>
                @csrf

                <div class="lg-field">
                    <label for="email" class="lg-label">Email<span aria-hidden="true">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="lg-input @error('email') is-invalid @enderror"
                           placeholder="nama@masjid.id" autocomplete="username" required autofocus>
                    @error('email')
                        <p class="lg-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg-field">
                    <label for="password" class="lg-label">Password<span aria-hidden="true">*</span></label>
                    <div class="lg-input-wrap">
                        <input type="password" id="password" name="password"
                               class="lg-input lg-input--icon @error('password') is-invalid @enderror"
                               placeholder="••••••••" autocomplete="current-password" required>
                        <button type="button" class="lg-eye" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false">
                            {{-- mata tertutup (default) --}}
                            <svg class="lg-eye__off" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9c2.2 3.6 5.6 5.5 10 5.5S19.8 12.6 22 9"/><path d="m4.5 13.2-1.7 2.1"/><path d="m9 15.2-.8 2.6"/><path d="m15 15.2.8 2.6"/><path d="m19.5 13.2 1.7 2.1"/></svg>
                            {{-- mata terbuka --}}
                            <svg class="lg-eye__on" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="lg-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="lg-submit" id="loginSubmit">Masuk Dashboard</button>
            </form>
        </div>
    </section>

</main>

<script>
    // Tampilkan / sembunyikan password
    (function () {
        var input = document.getElementById('password');
        var btn = document.getElementById('togglePassword');
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.classList.toggle('is-on', show);
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
            input.focus();
        });

        // Cegah klik ganda saat mengirim
        var form = document.getElementById('loginForm');
        var submit = document.getElementById('loginSubmit');
        form.addEventListener('submit', function () {
            submit.disabled = true;
            submit.textContent = 'Memproses…';
        });
    })();
</script>
</body>
</html>
