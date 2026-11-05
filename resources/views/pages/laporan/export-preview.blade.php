@extends('layouts.app')

@section('title', 'Pratinjau Unduh — Laporan Keuangan Masjid Al-Hidayah')

@section('content')
@php
    $data = require resource_path('views/pages/laporan/data.php');
    $start = request('start', '2026-04-01');
    $end = request('end', '2026-04-30');
    $label = request('label', $data['period']);
    $months = ['januari'=>'01','februari'=>'02','maret'=>'03','april'=>'04','mei'=>'05','juni'=>'06','juli'=>'07','agustus'=>'08','september'=>'09','oktober'=>'10','november'=>'11','desember'=>'12'];
    $parseDate = static function (string $date) use ($months): string {
        $parts = explode(' ', strtolower($date));
        return ($parts[2] ?? '2026') . '-' . ($months[$parts[1] ?? 'april'] ?? '04') . '-' . str_pad($parts[0] ?? '1', 2, '0', STR_PAD_LEFT);
    };
    foreach (['pemasukan', 'pengeluaran'] as $type) {
        $data[$type] = array_values(array_filter($data[$type], static fn (array $transaction): bool => $parseDate($transaction['date']) >= $start && $parseDate($transaction['date']) <= $end));
    }
    $data['count_pemasukan'] = count($data['pemasukan']);
    $data['count_pengeluaran'] = count($data['pengeluaran']);
    $data['total_pemasukan'] = number_format(array_sum(array_map(static fn (array $row): int => (int) str_replace('.', '', $row['amount']), $data['pemasukan'])), 0, ',', '.');
    $data['total_pengeluaran'] = number_format(array_sum(array_map(static fn (array $row): int => (int) str_replace('.', '', $row['amount']), $data['pengeluaran'])), 0, ',', '.');
    $incoming = array_fill_keys(array_column($data['resume'], 'category'), 0);
    $outgoing = $incoming;
    foreach ($data['pemasukan'] as $row) {
        $incoming[$row['category']] = ($incoming[$row['category']] ?? 0) + (int) str_replace('.', '', $row['amount']);
    }
    foreach ($data['pengeluaran'] as $row) {
        $outgoing[$row['category']] = ($outgoing[$row['category']] ?? 0) + (int) str_replace('.', '', $row['amount']);
    }
    foreach ($data['resume'] as &$row) {
        $row['pemasukan'] = number_format($incoming[$row['category']] ?? 0, 0, ',', '.');
        $row['pengeluaran'] = number_format($outgoing[$row['category']] ?? 0, 0, ',', '.');
        $opening = (int) str_replace('.', '', $row['saldo_awal']);
        $row['saldo_akhir'] = number_format($opening + ($incoming[$row['category']] ?? 0) - ($outgoing[$row['category']] ?? 0), 0, ',', '.');
    }
    unset($row);
    $data['resume_total']['pemasukan'] = $data['total_pemasukan'];
    $data['resume_total']['pengeluaran'] = $data['total_pengeluaran'];
    $totalOpening = (int) str_replace('.', '', $data['resume_total']['saldo_awal']);
    $data['resume_total']['saldo_akhir'] = number_format($totalOpening + (int) str_replace('.', '', $data['total_pemasukan']) - (int) str_replace('.', '', $data['total_pengeluaran']), 0, ',', '.');
    $pageCount = 2;
    $periodLabel = $label;
    $pemasukan = $data['pemasukan'];
    $pengeluaranPage1 = array_slice($data['pengeluaran'], 0, 21);
    $pengeluaranPage2 = array_slice($data['pengeluaran'], 21);
@endphp

<div class="laporan-page-wrapper">
    <div class="laporan-container">

        {{-- ==================== 1. TOP HEADER ==================== --}}
        <header class="laporan-top-bar">
            <div class="laporan-top-bar__left">
                <a href="{{ route('laporan.export.format') }}" class="btn-laporan-nav btn-laporan-nav--back" id="btnBackToFormatTop">
                    <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="laporan-top-bar__center">
                <h1 class="laporan-top-bar__title">Laporan Keuangan 2026</h1>
                <p class="laporan-top-bar__subtitle">Masjid Al-Hidayah</p>
            </div>

            <div class="laporan-top-bar__right">
                {{-- Spacer to balance layout --}}
                <div style="width: 100px;"></div>
            </div>
        </header>

        {{-- ==================== 2. TITLE & STEPPER ==================== --}}
        <section class="laporan-stepper-header">
            <div class="laporan-stepper-header__left">
                <h2 class="laporan-step-title">Pratinjau sebelum unduh</h2>
                <p class="laporan-step-desc">Periksa laporan {{ $label }} sebelum mengunduh.</p>
            </div>

            <div class="stepper-indicator">
                <div class="stepper-node stepper-node--completed">
                    <span class="stepper-circle">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span class="stepper-label">Pilih format</span>
                </div>
                <div class="stepper-line stepper-line--active"></div>
                <div class="stepper-node stepper-node--active">
                    <span class="stepper-circle">2</span>
                    <span class="stepper-label">Pratinjau &amp; unduh</span>
                </div>
            </div>
        </section>

        {{-- ==================== 3. TOOLBAR CONTROLS ==================== --}}
        <section class="preview-toolbar-card">
            <div class="preview-toolbar-left">
                <div class="format-switcher-group">
                    <span class="format-switcher-label">Format unduhan</span>
                    <div class="format-pill-toggle">
                        <button type="button" class="format-pill-btn is-active" id="btnTogglePdf" data-format="pdf">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                            <span>PDF</span>
                        </button>
                        <button type="button" class="format-pill-btn" id="btnTogglePng" data-format="png">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>PNG</span>
                        </button>
                    </div>
                </div>

                <div class="format-summary-meta">
                    <div class="meta-title" id="metaTitle">1 dokumen PDF · {{ $pageCount }} halaman</div>
                    <div class="meta-sub" id="metaSubtitle">Seluruh halaman dalam satu berkas PDF.</div>
                    <div class="meta-tags">
                        <span class="badge-tag">A4 lanskap · 297 × 210 mm · {{ $label }}</span>
                    </div>
                </div>
            </div>

            <div class="preview-toolbar-right">
                <a href="{{ route('laporan.export.format') }}" class="btn-laporan-nav-back">Ubah format</a>
                <button type="button" class="btn-laporan-primary" id="btnDownloadTop">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span id="btnDownloadTopText">Unduh PDF - {{ $pageCount }} halaman</span>
                </button>
            </div>
        </section>

        {{-- ==================== 4. NOTICE BOX ==================== --}}
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

        {{-- ==================== 5. PREVIEW WORKSPACE CONTAINER ==================== --}}
        <div class="preview-workspace">

            {{-- Workspace Header Toolbar --}}
            <div class="workspace-header">
                <div class="workspace-header__file-info">
                    <span class="file-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </span>
                    <span class="file-status" id="workspaceStatus">{{ $pageCount }} halaman · Semua halaman ditampilkan</span>
                    <span class="file-name" id="workspaceFilename">Laporan_Al-Hidayah_April_2026.pdf</span>
                </div>

                <div class="workspace-header__tools">
                    <button type="button" class="btn-workspace-tool" id="btnFitWidth">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <polyline points="9 21 3 21 3 15"></polyline>
                            <line x1="21" y1="3" x2="14" y2="10"></line>
                            <line x1="3" y1="21" x2="10" y2="14"></line>
                        </svg>
                        Lebar halaman
                    </button>
                    <span class="badge-a4">A4 lanskap</span>
                </div>
            </div>

            {{-- ==================== SHEET 1 ==================== --}}
            <div class="sheet-wrapper" id="sheet1">
                <div class="sheet-label-bar">
                    <span class="sheet-label-bar__title" id="sheet1TopTitle">Halaman 1 dari 2</span>
                    <span class="sheet-label-bar__desc">Pemasukan 1–17 · Pengeluaran 1–21</span>
                </div>

                <div class="a4-sheet-paper">
                    {{-- Sheet Header --}}
                    <div class="sheet-header">
                        <div class="sheet-header__left">
                            <span class="sheet-brand">Masjid Al-Hidayah</span>
                            <h3 class="sheet-title">Laporan Keuangan {{ $periodLabel }}</h3>
                        </div>
                        <div class="sheet-header__right">
                            <span class="sheet-period">Periode {{ $periodLabel }}</span>
                            <span class="sheet-subinfo">A4 lanskap · Halaman 1 dari 2</span>
                        </div>
                    </div>

                    {{-- Two-Column Transactions (Sheet 1) --}}
                    <div class="sheet-trx-grid">
                        {{-- Left Column: Pemasukan (All 17) --}}
                        <div class="sheet-trx-col">
                            <div class="sheet-col-head sheet-col-head--green">
                                <div class="head-left">
                                    <span class="head-title">Pemasukan</span>
                                    <span class="head-sub">{{ $data['count_pemasukan'] }} transaksi · total periode</span>
                                </div>
                                <div class="head-right">
                                    Rp {{ $data['total_pemasukan'] }}
                                </div>
                            </div>

                            <div class="sheet-table-legend">
                                <span>Uraian · tanggal &amp; kategori</span>
                                <span>Nominal (Rp)</span>
                            </div>

                            <div class="sheet-trx-list">
                                @foreach($pemasukan as $trx)
                                    <div class="sheet-trx-row">
                                        <div class="sheet-trx-meta">
                                            <span class="sheet-trx-name">{{ $trx['title'] }}</span>
                                            <div class="sheet-trx-sub">
                                                <span class="sub-date">{{ $trx['date'] }}</span>
                                                <span class="sub-cat sub-cat--{{ $trx['cat_color'] }}">
                                                    <span class="dot"></span> {{ $trx['category'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="sheet-trx-val sheet-trx-val--green">
                                            Rp {{ $trx['amount'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Right Column: Pengeluaran (1 - 21) --}}
                        <div class="sheet-trx-col">
                            <div class="sheet-col-head sheet-col-head--red">
                                <div class="head-left">
                                    <span class="head-title">Pengeluaran</span>
                                    <span class="head-sub">{{ $data['count_pengeluaran'] }} transaksi · total periode</span>
                                </div>
                                <div class="head-right">
                                    Rp {{ $data['total_pengeluaran'] }}
                                </div>
                            </div>

                            <div class="sheet-table-legend">
                                <span>Uraian · tanggal &amp; kategori</span>
                                <span>Nominal (Rp)</span>
                            </div>

                            <div class="sheet-trx-list">
                                @foreach($pengeluaranPage1 as $trx)
                                    <div class="sheet-trx-row">
                                        <div class="sheet-trx-meta">
                                            <span class="sheet-trx-name">{{ $trx['title'] }}</span>
                                            <div class="sheet-trx-sub">
                                                <span class="sub-date">{{ $trx['date'] }}</span>
                                                <span class="sub-cat sub-cat--{{ $trx['cat_color'] }}">
                                                    <span class="dot"></span> {{ $trx['category'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="sheet-trx-val sheet-trx-val--red">
                                            Rp {{ $trx['amount'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Sheet Footer --}}
                    <div class="sheet-footer">
                        <span class="sheet-footer__summary">
                            Pemasukan 1–17 dari 17 · Pengeluaran 1–21 dari 33 · Pengeluaran berlanjut di halaman 2
                        </span>
                        <span class="sheet-footer__page">Halaman 1 / 2</span>
                    </div>
                </div>
            </div>

            {{-- ==================== SHEET 2 ==================== --}}
            <div class="sheet-wrapper" id="sheet2">
                <div class="sheet-label-bar">
                    <span class="sheet-label-bar__title" id="sheet2TopTitle">Halaman 2 dari 2</span>
                    <span class="sheet-label-bar__desc">Pengeluaran 22–33 · Resume saldo periode</span>
                </div>

                <div class="a4-sheet-paper">
                    {{-- Sheet Header --}}
                    <div class="sheet-header">
                        <div class="sheet-header__left">
                            <span class="sheet-brand">Masjid Al-Hidayah</span>
                            <h3 class="sheet-title">Laporan Keuangan {{ $periodLabel }}</h3>
                        </div>
                        <div class="sheet-header__right">
                            <span class="sheet-period">Periode {{ $periodLabel }}</span>
                            <span class="sheet-subinfo">A4 lanskap · Halaman 2 dari 2</span>
                        </div>
                    </div>

                    {{-- Two-Column Transactions (Sheet 2) --}}
                    <div class="sheet-trx-grid">
                        {{-- Left Column: Placeholder for completed Pemasukan --}}
                        <div class="sheet-trx-col">
                            <div class="sheet-col-head sheet-col-head--green">
                                <div class="head-left">
                                    <span class="head-title">Pemasukan</span>
                                    <span class="head-sub">{{ $data['count_pemasukan'] }} transaksi · total periode</span>
                                </div>
                                <div class="head-right">
                                    Rp {{ $data['total_pemasukan'] }}
                                </div>
                            </div>

                            <div class="sheet-table-legend">
                                <span>Uraian · tanggal &amp; kategori</span>
                                <span>Nominal (Rp)</span>
                            </div>

                            <div class="sheet-empty-placeholder">
                                <p class="empty-title">Tidak ada lanjutan pemasukan</p>
                                <p class="empty-sub">Seluruh {{ $data['count_pemasukan'] }} transaksi pemasukan tercantum pada halaman 1.</p>
                            </div>
                        </div>

                        {{-- Right Column: Pengeluaran (22 - 33) --}}
                        <div class="sheet-trx-col">
                            <div class="sheet-col-head sheet-col-head--red">
                                <div class="head-left">
                                    <span class="head-title">Pengeluaran</span>
                                    <span class="head-sub">{{ $data['count_pengeluaran'] }} transaksi · total periode</span>
                                </div>
                                <div class="head-right">
                                    Rp {{ $data['total_pengeluaran'] }}
                                </div>
                            </div>

                            <div class="sheet-table-legend">
                                <span>Uraian · tanggal &amp; kategori</span>
                                <span>Nominal (Rp)</span>
                            </div>

                            <div class="sheet-trx-list">
                                @foreach($pengeluaranPage2 as $trx)
                                    <div class="sheet-trx-row">
                                        <div class="sheet-trx-meta">
                                            <span class="sheet-trx-name">{{ $trx['title'] }}</span>
                                            <div class="sheet-trx-sub">
                                                <span class="sub-date">{{ $trx['date'] }}</span>
                                                <span class="sub-cat sub-cat--{{ $trx['cat_color'] }}">
                                                    <span class="dot"></span> {{ $trx['category'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="sheet-trx-val sheet-trx-val--red">
                                            Rp {{ $trx['amount'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Resume Saldo Inside Sheet 2 --}}
                    <div class="sheet-resume-box">
                        <div class="sheet-resume-head">
                            <h4 class="sheet-resume-title">Resume Saldo {{ $periodLabel }}</h4>
                            <span class="sheet-resume-subtitle">Rekapitulasi per kategori dana · total periode {{ $periodLabel }}</span>
                        </div>

                        @include('pages.laporan.partials.resume-table', [
                            'resume' => $data['resume'],
                            'total' => $data['resume_total'],
                            'isSheet' => true
                        ])
                    </div>

                    {{-- Sheet Footer --}}
                    <div class="sheet-footer">
                        <span class="sheet-footer__summary">
                            Pemasukan selesai di halaman 1 · Pengeluaran 22–33 dari 33 · Resume saldo seluruh periode
                        </span>
                        <span class="sheet-footer__page">Halaman 2 / 2</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ==================== 6. BOTTOM ACTION BAR ==================== --}}
        <div class="preview-bottom-bar">
            <a href="{{ route('laporan.export.format') }}" class="btn-laporan-nav-back">
                Kembali ke pilihan format
            </a>

            <span class="bottom-file-desc" id="bottomFileDesc">1 berkas PDF berisi {{ $pageCount }} halaman</span>

            <button type="button" class="btn-laporan-primary" id="btnDownloadBottom">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span id="btnDownloadBottomText">Unduh PDF - {{ $pageCount }} halaman</span>
            </button>
        </div>

    </div>
</div>

{{-- Toast Notification for Download simulation --}}
<div class="download-toast" id="downloadToast">
    <div class="toast-icon">✓</div>
    <div class="toast-body">
        <strong id="toastTitle">Mengunduh Dokumen...</strong>
        <p id="toastMessage">Laporan Keuangan {{ $periodLabel }} berhasil disiapkan.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        let currentFormat = urlParams.get('format') || 'pdf';

        const btnTogglePdf = document.getElementById('btnTogglePdf');
        const btnTogglePng = document.getElementById('btnTogglePng');

        const metaTitle = document.getElementById('metaTitle');
        const metaSubtitle = document.getElementById('metaSubtitle');
        const btnDownloadTopText = document.getElementById('btnDownloadTopText');
        const btnDownloadBottomText = document.getElementById('btnDownloadBottomText');
        const bottomFileDesc = document.getElementById('bottomFileDesc');

        const workspaceStatus = document.getElementById('workspaceStatus');
        const workspaceFilename = document.getElementById('workspaceFilename');
        const sheet1TopTitle = document.getElementById('sheet1TopTitle');
        const sheet2TopTitle = document.getElementById('sheet2TopTitle');

        const toast = document.getElementById('downloadToast');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        function updateUI(format) {
            currentFormat = format;
            if (format === 'png') {
                btnTogglePng.classList.add('is-active');
                btnTogglePdf.classList.remove('is-active');

                metaTitle.textContent = '2 gambar PNG terpisah';
                metaSubtitle.textContent = 'Satu gambar untuk setiap halaman laporan.';
                btnDownloadTopText.textContent = 'Unduh 2 gambar PNG';
                btnDownloadBottomText.textContent = 'Unduh 2 gambar PNG';
                bottomFileDesc.textContent = '2 berkas PNG, masing-masing 1 halaman';

                workspaceStatus.textContent = '2 gambar PNG · Semua halaman ditampilkan';
                workspaceFilename.textContent = 'Laporan_Al-Hidayah_April_2026_01.png dan _02.png';
                sheet1TopTitle.textContent = 'Gambar 1 dari 2 · Halaman 1';
                sheet2TopTitle.textContent = 'Gambar 2 dari 2 · Halaman 2';
            } else {
                btnTogglePdf.classList.add('is-active');
                btnTogglePng.classList.remove('is-active');

                metaTitle.textContent = '1 dokumen PDF · {{ $pageCount }} halaman';
                metaSubtitle.textContent = 'Seluruh halaman dalam satu berkas PDF.';
                btnDownloadTopText.textContent = 'Unduh PDF - {{ $pageCount }} halaman';
                btnDownloadBottomText.textContent = 'Unduh PDF - {{ $pageCount }} halaman';
                bottomFileDesc.textContent = '1 berkas PDF berisi {{ $pageCount }} halaman';

                workspaceStatus.textContent = '{{ $pageCount }} halaman · Semua halaman ditampilkan';
                workspaceFilename.textContent = 'Laporan_Al-Hidayah_{{ str_replace(" ", "_", $periodLabel) }}.pdf';
                sheet1TopTitle.textContent = 'Halaman 1 dari 2';
                sheet2TopTitle.textContent = 'Halaman 2 dari 2';
            }
        }

        // Initialize based on URL param
        updateUI(currentFormat);

        btnTogglePdf.addEventListener('click', () => updateUI('pdf'));
        btnTogglePng.addEventListener('click', () => updateUI('png'));

        // Simulated download handler
        function triggerDownload() {
            if (currentFormat === 'pdf') {
                toastTitle.textContent = 'Menyiapkan Unduhan PDF...';
                toastMessage.textContent = 'Laporan_Al-Hidayah_{{ str_replace(" ", "_", $periodLabel) }}.pdf ({{ $pageCount }} halaman A4 Lanskap)';
            } else {
                toastTitle.textContent = 'Menyiapkan Unduhan PNG...';
                toastMessage.textContent = 'Laporan_Al-Hidayah_April_2026_01.png & _02.png';
            }

            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3500);
        }

        document.getElementById('btnDownloadTop').addEventListener('click', triggerDownload);
        document.getElementById('btnDownloadBottom').addEventListener('click', triggerDownload);

        // Fit width button toggles full container
        const btnFitWidth = document.getElementById('btnFitWidth');
        let isFit = false;
        btnFitWidth.addEventListener('click', () => {
            isFit = !isFit;
            const papers = document.querySelectorAll('.a4-sheet-paper');
            papers.forEach(p => {
                if (isFit) {
                    p.style.maxWidth = '100%';
                } else {
                    p.style.maxWidth = '';
                }
            });
        });
    });
</script>
@endpush
