<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Keuangan Masjid Al-Hidayah Sorolaten - Pusat ibadah, pembinaan umat, dan pemberdayaan masyarakat Dusun Sorolaten.">
    <title>@yield('title', 'Masjid Al-Hidayah Sorolaten')</title>

    {{-- Google Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Stylesheet with cache busting --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">

    @stack('styles')
</head>
<body class="{{ request()->routeIs('laporan.*') ? 'laporan-page-body' : '' }} {{ request()->routeIs('home') ? 'home-page-body' : '' }}">

    {{-- ==================== FLOATING NAVBAR ==================== --}}
    @if(!request()->routeIs('laporan.*'))
    <header class="navbar-wrapper">
        <nav class="navbar-pill" id="navbar">
            <a href="{{ route('home') }}" class="navbar-pill__logo" aria-label="Beranda Masjid Al-Hidayah">
                <img src="{{ asset('images/Logo Masjid.png') }}" alt="Logo Masjid Al-Hidayah" class="navbar-pill__logo-img">
            </a>

            <div class="navbar-pill__links" id="navLinks">
                <a href="{{ route('home') }}"
                   class="nav-pill-btn {{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('agenda') }}"
                   class="nav-pill-btn {{ request()->routeIs('agenda') ? 'active' : '' }}">
                    Agenda
                </a>
                <a href="{{ route('profil') }}"
                   class="nav-pill-btn {{ request()->routeIs('profil') ? 'active' : '' }}">
                    Profil Masjid
                </a>
                <a href="{{ route('kontak') }}"
                   class="nav-pill-btn {{ request()->routeIs('kontak') ? 'active' : '' }}">
                    Kontak
                </a>
            </div>

            <button class="navbar-pill__toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>

    {{-- Mobile drawer overlay --}}
    <div class="mobile-overlay" id="mobileOverlay"></div>
    @endif

    {{-- ==================== MAIN CONTENT ==================== --}}
    <main class="{{ request()->routeIs('laporan.*') ? 'laporan-main-container' : 'main-content' }} {{ request()->routeIs('home') ? 'main-content--home' : '' }}">
        @yield('content')
    </main>

    {{-- ==================== LIGHT FOOTER ==================== --}}
    @if(!request()->routeIs('laporan.*'))
    <footer class="site-footer">
        <div class="site-footer__container">
            <div class="site-footer__main">
                <div class="site-footer__brand">
                    <h3 class="site-footer__title">Masjid Al-Hidayah</h3>
                    <p class="site-footer__address">
                        <svg class="icon-pin-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Dusun Sorolaten RT 04 RW 15, Sidokarto, Godean, Sleman, Yogyakarta.</span>
                    </p>
                </div>
                <div class="site-footer__links-col">
                    <p class="site-footer__links-heading">TAUTAN KHUSUS</p>
                    <div class="site-footer__links">
                        <a href="{{ route('laporan.index') }}" class="site-footer__link">
                            <svg class="icon-footer-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                            <span>Laporan Keuangan</span>
                        </a>
                        <a href="#" class="site-footer__link">
                            <svg class="icon-footer-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                            <span>Masuk Pengurus</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="site-footer__bottom">
                &copy; {{ date('Y') }} Masjid Al-Hidayah Sorolaten. All rights reserved.
            </div>
        </div>
    </footer>
    @endif

    {{-- ==================== SCRIPTS ==================== --}}
    <script>
        // Floating navbar scroll shadow effect
        const navbar = document.getElementById('navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 30) {
                    navbar.classList.add('is-scrolled');
                } else {
                    navbar.classList.remove('is-scrolled');
                }
            });
        }

        // Mobile drawer menu toggle
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if (navToggle && navLinks && mobileOverlay) {
            function toggleMenu() {
                navToggle.classList.toggle('open');
                navLinks.classList.toggle('open');
                mobileOverlay.classList.toggle('open');
                document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
            }

            navToggle.addEventListener('click', toggleMenu);
            mobileOverlay.addEventListener('click', toggleMenu);

            navLinks.querySelectorAll('.nav-pill-btn').forEach(link => {
                link.addEventListener('click', () => {
                    if (navLinks.classList.contains('open')) toggleMenu();
                });
            });
        }

        // Smooth scroll entrance animations
        const observerOptions = { threshold: 0.02, rootMargin: '0px 0px 350px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

        // Initial check for elements in viewport
        setTimeout(() => {
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    el.classList.add('visible');
                }
            });
        }, 150);
    </script>

    @stack('scripts')
</body>
</html>
