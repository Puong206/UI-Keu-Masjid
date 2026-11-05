@extends('layouts.app')

@section('title', 'Beranda — Masjid Al-Hidayah Sorolaten')

@section('content')

{{-- ==================== 1. HERO (full-bleed, sudut bawah membulat) ==================== --}}
<section class="bd-hero">
    <img src="/images/Background Pict.png" alt="Masjid Al-Hidayah Sorolaten" class="bd-hero__img">
    <div class="bd-hero__shade"></div>
    <div class="bd-hero__content">
        <h1 class="bd-hero__title">MASJID<br>AL–HIDAYAH</h1>
        <p class="bd-hero__subtitle">
            Pusat ibadah, pembinaan umat, dan pemberdayaan masyarakat Dusun Sorolaten sejak 1980.
        </p>
        <div class="bd-hero__actions">
            <a href="{{ route('agenda') }}" class="bd-btn bd-btn--white">Lihat Agenda</a>
            <a href="{{ route('profil') }}" class="bd-btn bd-btn--glass">Profil Masjid</a>
        </div>
    </div>
</section>

{{-- ==================== 2. STATS ==================== --}}
<section class="bd-section">
    <div class="bd-wrap bd-wrap--md">
        <div class="bd-stats">
            <div class="bd-stat">
                <svg class="bd-stat__icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span class="bd-stat__label">Berdiri Sejak</span>
                <strong class="bd-stat__value">1980</strong>
            </div>
            <div class="bd-stat">
                <svg class="bd-stat__icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                <span class="bd-stat__label">Luas Bangunan</span>
                <strong class="bd-stat__value">265 m²</strong>
            </div>
            <div class="bd-stat">
                <svg class="bd-stat__icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="bd-stat__label">Kapasitas</span>
                <strong class="bd-stat__value">290 Jamaah</strong>
            </div>
        </div>
    </div>
</section>

{{-- ==================== 3. VISI & MISI (rata kiri) ==================== --}}
<section class="bd-section bd-section--visi">
    <div class="bd-wrap bd-wrap--md">
        <span class="bd-pill">VISI &amp; MISI</span>
        <h2 class="bd-visi__headline">"Menjadi Pusat Ibadah dan Pembinaan Masyarakat Sorolaten."</h2>
        <ol class="bd-misi">
            <li><span class="bd-misi__num">1</span><span class="bd-misi__text">Menyelenggarakan peribadatan berdasarkan Al-Qur'an dan Sunnah.</span></li>
            <li><span class="bd-misi__num">2</span><span class="bd-misi__text">Meningkatkan pemahaman syariat Islam masyarakat Sorolaten.</span></li>
            <li><span class="bd-misi__num">3</span><span class="bd-misi__text">Mempersiapkan generasi muda sebagai generasi Qur'ani yang tangguh.</span></li>
            <li><span class="bd-misi__num">4</span><span class="bd-misi__text">Berperan serta meningkatkan kesejahteraan masyarakat.</span></li>
        </ol>
    </div>
</section>

{{-- ==================== 4. AGENDA & KEGIATAN MASJID ==================== --}}
<section class="bd-section bd-section--gap">
    <div class="bd-wrap bd-wrap--lg">
        <div class="bd-agenda">
            <div class="bd-agenda__left">
                <h2 class="bd-agenda__title">Agenda &amp;<br><span>Kegiatan Masjid</span></h2>
                <p class="bd-agenda__desc">
                    Seluruh kegiatan pengajian rutin Masjid Al-Hidayah Sorolaten, dikelompokkan berdasarkan frekuensi pelaksanaan.
                </p>
                <a href="{{ route('agenda') }}" class="bd-btn bd-btn--white-sm">Lihat Detail Kegiatan</a>
            </div>
            <div class="bd-agenda__right">
                <div class="bd-agenda__pill"><strong>12</strong><span>Total Kegiatan</span></div>
                <div class="bd-agenda__pill"><strong>5</strong><span>Rutin Mingguan</span></div>
                <div class="bd-agenda__pill"><strong>5</strong><span>PHBI / Tahunan</span></div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== 5. KEMAKMURAN MASJID ==================== --}}
<section class="bd-section bd-section--gap">
    <div class="bd-wrap bd-wrap--xl">
        <div class="bd-kemakmuran">
            <h2 class="bd-kemakmuran__title">Kemakmuran Masjid</h2>
            <div class="bd-kemakmuran__grid">

                <article class="bd-kcard">
                    <header class="bd-kcard__head">
                        <h3>Masjid Inklusi</h3>
                        <span class="bd-kcard__badge">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </span>
                    </header>
                    <p class="bd-kcard__desc">Lingkungan ibadah yang ramah anak, difabel, dan lansia, terintegrasi dengan fasilitas PAUD dan TPA.</p>
                </article>

                <article class="bd-kcard bd-kcard--green">
                    <header class="bd-kcard__head">
                        <h3>Usaha Kesehatan</h3>
                        <span class="bd-kcard__badge">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </span>
                    </header>
                    <p class="bd-kcard__desc">Layanan pemeriksaan kesehatan rutin dan gratis bagi jamaah (tensi, gula darah, kolesterol) bersama tenaga medis.</p>
                </article>

                <article class="bd-kcard">
                    <header class="bd-kcard__head">
                        <h3>Usaha Ekonomi</h3>
                        <span class="bd-kcard__badge">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 12h.01M18 12h.01"/></svg>
                        </span>
                    </header>
                    <p class="bd-kcard__desc">Mendorong kemandirian jamaah melalui tabungan majelis taklim, hibah modal UMKM, &amp; penyelenggaraan pasar murah.</p>
                </article>

            </div>
        </div>
    </div>
</section>

{{-- ==================== 6. TRANSPARANSI & AKUNTABILITAS KEUANGAN (full-bleed) ==================== --}}
<section class="bd-transparansi">
    <div class="bd-transparansi__inner">
        <h2 class="bd-transparansi__title">Transparansi &amp; Akuntabilitas Keuangan</h2>
        <p class="bd-transparansi__desc">
            Lihat ringkasan pemasukan dan pengeluaran dana Masjid Al Hidayah secara realtime melalui kode akses yang diberikan pengurus masjid.
        </p>
        <a href="{{ route('laporan.index') }}" class="bd-btn bd-btn--white-sm laporan-access-trigger">Lihat Laporan Keuangan</a>
    </div>
</section>

@endsection
