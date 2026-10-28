@extends('layouts.app')

@section('title', 'Kontak & Donasi — Masjid Al-Hidayah Sorolaten')

@section('content')

<div class="kt-page">

    {{-- ==================== 1. HEADER ==================== --}}
    <section class="kt-header">
        <span class="kt-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
            KONTAK KAMI
        </span>
        <h1 class="kt-title">Mari <em>Terhubung</em> Bersama Kami</h1>
        <p class="kt-subtitle">
            Sampaikan pertanyaan, usulan kegiatan, atau permohonan kerja sama kepada pengurus takmir Masjid Al-Hidayah.
        </p>
    </section>

    {{-- ==================== 2. DONASI ==================== --}}
    <section class="kt-donasi">
        <div class="bd-wrap bd-wrap--xl">
            <div class="kt-donasi__card">
                <h2 class="kt-donasi__title">Donasi</h2>

                <div class="kt-donasi__grid">

                    {{-- Scan QRIS --}}
                    <div class="kt-sub">
                        <div class="kt-sub__head">
                            <div>
                                <h3 class="kt-sub__title">Scan QRIS</h3>
                                <p class="kt-sub__desc">Pindai kode QRIS untuk donasi cepat dan aman.</p>
                            </div>
                            <span class="kt-chip">Cepat</span>
                        </div>

                        <div class="kt-qris">
                            <img src="{{ asset('images/qris-donasi.png') }}" alt="QRIS Donasi Masjid Al-Hidayah" class="kt-qris__img">
                            <a href="{{ asset('images/qris-donasi.png') }}" download="QRIS-Masjid-Al-Hidayah.png" class="kt-qris__dl" id="btnDownloadQris">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Unduh QRIS Donasi
                            </a>
                        </div>
                        <p class="kt-qris__hint">Format PNG · Siap simpan atau bagikan</p>
                    </div>

                    {{-- Transfer Bank --}}
                    <div class="kt-sub">
                        <div class="kt-sub__head">
                            <div>
                                <h3 class="kt-sub__title">Transfer Bank</h3>
                                <p class="kt-sub__desc">Transfer ke rekening resmi untuk donasi Anda.</p>
                            </div>
                            <span class="kt-chip">Resmi</span>
                        </div>

                        <dl class="kt-bank">
                            <div class="kt-bank__item">
                                <dt>NAMA BANK</dt>
                                <dd>Bank Syariah Indonesia (BSI)</dd>
                            </div>
                            <div class="kt-bank__item">
                                <dt>NOMOR REKENING</dt>
                                <dd>7123-4567-89</dd>
                            </div>
                            <div class="kt-bank__item">
                                <dt>ATAS NAMA</dt>
                                <dd>Masjid Al-Hidayah Sorolaten</dd>
                            </div>
                        </dl>

                        <div class="kt-note">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <span>Periksa nama penerima sebelum transfer dan simpan bukti donasi.</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 3. HUBUNGI PENGURUS TAKMIR ==================== --}}
    <section class="kt-takmir">
        <div class="bd-wrap bd-wrap--md">
            <h2 class="kt-takmir__title">Hubungi Pengurus Takmir</h2>
            <p class="kt-takmir__sub">Tim takmir aktif melayani jamaah setiap hari pada jam operasional masjid.</p>

            <div class="kt-info">
                <div class="kt-info__row">
                    <span class="kt-info__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <div>
                        <span class="kt-info__label">ALAMAT</span>
                        <div class="kt-info__val">Dusun Sorolaten RT 04 RW 15, Sidokarto, Godean, Sleman, Yogyakarta 55564</div>
                    </div>
                </div>

                <div class="kt-info__row">
                    <span class="kt-info__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </span>
                    <div>
                        <span class="kt-info__label">TELEPON</span>
                        <div class="kt-info__val">(0274) 123–456</div>
                        <div class="kt-info__note">Senin – Sabtu · 08.00–17.00 WIB</div>
                    </div>
                </div>

                <div class="kt-info__row">
                    <span class="kt-info__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    <div>
                        <span class="kt-info__label">JAM OPERASIONAL</span>
                        <div class="kt-info__val">Setiap hari · 04.30 – 21.00 WIB</div>
                    </div>
                </div>
            </div>

            {{-- Peta (Google Maps) --}}
            <div class="kt-map">
                <iframe
                    src="https://maps.google.com/maps?q=-7.7835479,110.3074641&hl=id&z=17&output=embed"
                    class="kt-map__frame"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta Lokasi Masjid Al-Hidayah Sorolaten"></iframe>

                <span class="kt-map__label">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                    Sorolaten, Sidokarto
                </span>

                <a href="https://maps.app.goo.gl/E3NSEB4RGdjkkjL3A" target="_blank" rel="noopener noreferrer" class="kt-map__btn">
                    Buka Google Maps
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                </a>
            </div>
        </div>
    </section>

</div>

@endsection
