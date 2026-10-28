@extends('layouts.app')

@section('title', 'Pilih Format Unduh — Laporan Keuangan Masjid Al-Hidayah')

@section('content')
@php
    $data = require resource_path('views/pages/laporan/data.php');
@endphp

<div class="laporan-page-wrapper">
    <div class="laporan-container laporan-container--narrow">

        {{-- ==================== 1. TOP HEADER ==================== --}}
        <header class="laporan-top-bar laporan-top-bar--center-only">
            <div class="laporan-top-bar__center">
                <h1 class="laporan-top-bar__title">Laporan Keuangan 2026</h1>
                <p class="laporan-top-bar__subtitle">Masjid Al-Hidayah</p>
            </div>
        </header>

        {{-- ==================== 2. TITLE & STEPPER ==================== --}}
        <section class="laporan-stepper-header">
            <div class="laporan-stepper-header__left">
                <h2 class="laporan-step-title">Unduh laporan keuangan</h2>
                <p class="laporan-step-desc">Pilih format untuk menyimpan laporan {{ $data['period'] }}.</p>
            </div>

            <div class="stepper-indicator">
                <div class="stepper-node stepper-node--active">
                    <span class="stepper-circle">1</span>
                    <span class="stepper-label">Pilih format</span>
                </div>
                <div class="stepper-line"></div>
                <div class="stepper-node stepper-node--inactive">
                    <span class="stepper-circle">2</span>
                    <span class="stepper-label">Pratinjau &amp; unduh</span>
                </div>
            </div>
        </section>

        {{-- ==================== 3. PERIOD INFO CARD ==================== --}}
        <section class="export-period-card">
            <div class="export-period-card__left">
                <div class="period-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="period-text-group">
                    <span class="period-label">Periode laporan</span>
                    <span class="period-value">{{ $data['period_range'] }}</span>
                </div>
            </div>
            <div class="export-period-card__right">
                <span class="summary-pill">{{ $data['count_pemasukan'] }} transaksi masuk · {{ $data['count_pengeluaran'] }} transaksi keluar · 2 lembar</span>
            </div>
        </section>

        {{-- ==================== 4. FORMAT SELECTION ==================== --}}
        <section class="export-format-section">
            <h3 class="export-section-subtitle">Format unduhan</h3>

            <div class="format-card-grid">
                {{-- PDF CARD --}}
                <div class="format-card format-card--active" data-format="pdf" id="cardPdf" tabindex="0" role="button" aria-pressed="true">
                    <div class="format-card__header">
                        <div class="format-card__icon format-card__icon--pdf">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <div class="format-card__radio">
                            <span class="radio-outer">
                                <span class="radio-inner"></span>
                            </span>
                        </div>
                    </div>

                    <h4 class="format-card__title">PDF</h4>
                    <p class="format-card__desc">
                        Satu dokumen untuk dibaca, diarsipkan, atau dicetak. Semua halaman tersimpan dalam satu berkas.
                    </p>

                    <div class="format-card__footer">
                        <span class="format-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                            1 dokumen PDF · 2 halaman
                        </span>
                    </div>
                </div>

                {{-- PNG CARD --}}
                <div class="format-card" data-format="png" id="cardPng" tabindex="0" role="button" aria-pressed="false">
                    <div class="format-card__header">
                        <div class="format-card__icon format-card__icon--png">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                        <div class="format-card__radio">
                            <span class="radio-outer">
                                <span class="radio-inner"></span>
                            </span>
                        </div>
                    </div>

                    <h4 class="format-card__title">PNG</h4>
                    <p class="format-card__desc">
                        Gambar terpisah untuk setiap halaman laporan. Praktis untuk dibagikan sebagai foto.
                    </p>

                    <div class="format-card__footer">
                        <span class="format-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            2 gambar PNG · 1 gambar per halaman
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 5. NOTICE BOX ==================== --}}
        <div class="export-notice-box">
            <div class="notice-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <div class="notice-content">
                <h5 class="notice-title">Dibagi otomatis sesuai panjang data</h5>
                <p class="notice-text">
                    Setiap lembar berukuran A4 lanskap (297 × 210 mm). Transaksi tetap utuh di setiap halaman, dengan pemasukan di kiri, pengeluaran di kanan, dan resume saldo periode pada halaman terakhir.
                </p>
            </div>
        </div>

        {{-- ==================== 6. BOTTOM ACTION BUTTONS ==================== --}}
        <div class="export-bottom-actions">
            <a href="{{ route('laporan.index') }}" class="btn-laporan-nav-back" id="btnBackToReport">
                Kembali ke laporan
            </a>

            <div class="export-bottom-actions__right">
                <span class="export-hint-text">Periksa isi laporan sebelum mengunduh.</span>
                <a href="{{ route('laporan.export.preview') }}?format=pdf" class="btn-laporan-primary" id="btnNextPreview">
                    <span>Lanjut ke pratinjau</span>
                    <span class="arrow">→</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cardPdf = document.getElementById('cardPdf');
        const cardPng = document.getElementById('cardPng');
        const btnNext = document.getElementById('btnNextPreview');
        const previewBaseUrl = "{{ route('laporan.export.preview') }}";

        let selectedFormat = 'pdf';

        function setFormat(format) {
            selectedFormat = format;
            if (format === 'pdf') {
                cardPdf.classList.add('format-card--active');
                cardPdf.setAttribute('aria-pressed', 'true');
                cardPng.classList.remove('format-card--active');
                cardPng.setAttribute('aria-pressed', 'false');
                btnNext.href = previewBaseUrl + '?format=pdf';
            } else {
                cardPng.classList.add('format-card--active');
                cardPng.setAttribute('aria-pressed', 'true');
                cardPdf.classList.remove('format-card--active');
                cardPdf.setAttribute('aria-pressed', 'false');
                btnNext.href = previewBaseUrl + '?format=png';
            }
        }

        cardPdf.addEventListener('click', () => setFormat('pdf'));
        cardPng.addEventListener('click', () => setFormat('png'));

        cardPdf.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setFormat('pdf'); }
        });
        cardPng.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setFormat('png'); }
        });
    });
</script>
@endpush
