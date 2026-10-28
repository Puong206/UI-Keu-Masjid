@extends('layouts.app')

@section('title', 'Profil Masjid — Masjid Al-Hidayah Sorolaten')

@section('content')

@php
    $takmirRow1 = [
        ['JM', 'KETUA', 'Jiyamta, S.Pd', null],
        ['TW', 'PELINDUNG', 'Tri Warjunadi', '( Kepala Dukuh )'],
        ['SH', 'PENASEHAT', 'Sugiharto, S.KM, MPH', '( Ketua LPMD )'],
        ['PS', 'WAKIL KETUA', 'Drs.Puji Suharjoko', null],
    ];
    $takmirRow2 = [
        ['WD', 'SEKRETARIS', 'Wawan Dwi Nugroho', null],
        ['AP', 'WAKIL SEKRETARIS', 'Aditya Pratama Istawar', null],
        ['AH', 'BENDAHARA', 'Ardi Hartono', null],
    ];
@endphp

<div class="pf-page">

    {{-- ==================== 1. HEADER ==================== --}}
    <section class="pf-header">
        <span class="pf-badge">EST. 1980 · SOROLATEN</span>
        <h1 class="pf-title">
            Profil Masjid <em>Al–Hidayah</em>
            <span class="pf-title__sub">Sorolaten</span>
        </h1>
        <p class="pf-subtitle">
            Empat dekade berkhidmat — dari sebuah mushola kecil di tengah dusun, kini menjadi pusat ibadah dan pembinaan masyarakat Sorolaten.
        </p>
    </section>

    {{-- ==================== 2. DUA KARTU STATISTIK ==================== --}}
    <section class="pf-stats">
        <div class="bd-wrap bd-wrap--md">
            <div class="pf-stats__grid">
                <div class="pf-stat pf-stat--green">
                    <div class="pf-stat__top">
                        <span class="pf-stat__icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                        </span>
                        <span class="pf-stat__label">LUAS BANGUNAN</span>
                    </div>
                    <div class="pf-stat__value">265 <small>m²</small></div>
                    <p class="pf-stat__desc">Berdiri di atas tanah wakaf warga Sorolaten, dilengkapi serambi, tempat wudhu, dan aula multifungsi.</p>
                </div>

                <div class="pf-stat pf-stat--orange">
                    <div class="pf-stat__top">
                        <span class="pf-stat__icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <span class="pf-stat__label">KAPASITAS RUANG</span>
                    </div>
                    <div class="pf-stat__value">290 <small>Jamaah</small></div>
                    <p class="pf-stat__desc">Ruang sholat utama menampung 290 jamaah dengan fasilitas ramah lansia dan difabel.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 3. VISI & MISI ==================== --}}
    <section class="pf-visi">
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

    {{-- ==================== 4. SEJARAH & LINIMASA ==================== --}}
    <section class="pf-sejarah">
        <div class="bd-wrap bd-wrap--lg">
            <p class="pf-eyebrow">PERJALANAN</p>
            <h2 class="pf-heading">Sejarah &amp; Linimasa</h2>

            <div class="pf-tl">
                <div class="pf-tl__row">
                    <div class="pf-tl__era pf-tl__era--right">
                        <span class="pf-tl__tag">Era Perintisan</span>
                        <div class="pf-tl__year">Tahun 1980</div>
                        <div class="pf-tl__name">Mushola Al Qodar</div>
                    </div>
                    <div class="pf-tl__mid"><span class="pf-tl__dot"></span></div>
                    <div class="pf-tl__card">
                        <h3>Awal Mula — Inisiatif Pemuda Dusun</h3>
                        <p>Berdiri sebagai mushola kecil di atas tanah wakaf warga, dibangun secara swadaya oleh pemuda dan masyarakat Sorolaten sebagai tempat ibadah harian.</p>
                    </div>
                </div>

                <div class="pf-tl__row">
                    <div class="pf-tl__card">
                        <h3>Diperluas &amp; Berganti Nama</h3>
                        <p>Seiring pertumbuhan jamaah, mushola dipugar menjadi masjid jami' dan diresmikan dengan nama baru untuk melayani ibadah Jumat serta kegiatan pembinaan umat.</p>
                    </div>
                    <div class="pf-tl__mid"><span class="pf-tl__dot"></span></div>
                    <div class="pf-tl__era">
                        <span class="pf-tl__tag">Era Pengembangan</span>
                        <div class="pf-tl__year">Tahun 2000</div>
                        <div class="pf-tl__name">Masjid Al-Hidayah</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 5. STRUKTUR ORGANISASI TAKMIR ==================== --}}
    <section class="pf-struktur">
        <p class="pf-struktur__eyebrow">STRUKTUR ORGANISASI</p>
        <h2 class="pf-struktur__title">Pengurus Takmir 2023–2025</h2>

        <div class="pf-takmir">
            <div class="pf-takmir__row">
                @foreach($takmirRow1 as [$ini, $role, $name, $sub])
                <article class="pf-tcard">
                    <span class="pf-tcard__avatar">{{ $ini }}</span>
                    <span class="pf-tcard__role">{{ $role }}</span>
                    <h3 class="pf-tcard__name">{{ $name }}</h3>
                    @if($sub)<p class="pf-tcard__sub">{{ $sub }}</p>@endif
                </article>
                @endforeach
            </div>
            <div class="pf-takmir__row">
                @foreach($takmirRow2 as [$ini, $role, $name, $sub])
                <article class="pf-tcard">
                    <span class="pf-tcard__avatar">{{ $ini }}</span>
                    <span class="pf-tcard__role">{{ $role }}</span>
                    <h3 class="pf-tcard__name">{{ $name }}</h3>
                    @if($sub)<p class="pf-tcard__sub">{{ $sub }}</p>@endif
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== 6. CTA ==================== --}}
    <section class="pf-cta">
        <div class="bd-wrap bd-wrap--lg">
            <div class="pf-cta__card">
                <h2 class="pf-cta__title">Ingin berkontribusi sebagai jamaah aktif?</h2>
                <p class="pf-cta__desc">Hubungi pengurus takmir untuk informasi keanggotaan, donasi, atau usulan kegiatan.</p>
                <a href="{{ route('kontak') }}" class="pf-cta__btn">Hubungi Takmir</a>
            </div>
        </div>
    </section>

</div>

@endsection
