@extends('layouts.app')

@section('title', 'Laporan Keuangan 2026 — Masjid Al-Hidayah Sorolaten')

@section('content')
@php
    $data = require resource_path('views/pages/laporan/data.php');
@endphp

<div class="laporan-page-wrapper">
    <div class="laporan-container">

        {{-- ==================== 1. TOP HEADER ==================== --}}
        <header class="laporan-top-bar">
            <div class="laporan-top-bar__left">
                <a href="{{ route('home') }}" class="btn-laporan-nav btn-laporan-nav--back" id="btnBackToHome">
                    <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Beranda</span>
                </a>
            </div>

            <div class="laporan-top-bar__center">
                <h1 class="laporan-top-bar__title">Laporan Keuangan 2026</h1>
                <p class="laporan-top-bar__subtitle">Masjid Al-Hidayah</p>
            </div>

            <div class="laporan-top-bar__right">
                <a href="{{ route('laporan.export.format') }}" class="btn-laporan-nav btn-laporan-nav--unduh" id="btnGoToExport">
                    <svg class="nav-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Unduh</span>
                </a>
            </div>
        </header>

        {{-- ==================== 2. FILTER & HEADING SECTION ==================== --}}
        <section class="laporan-filter-section">
            <div class="laporan-filter-row-top">
                <div class="laporan-heading-group">
                    <h2 class="laporan-section-title">Detail April 2026</h2>
                    <p class="laporan-section-desc">Rincian pemasukan, pengeluaran, dan resume saldo bulan berjalan</p>
                </div>

                <div class="laporan-preset-pills">
                    <button type="button" class="filter-pill-opt" data-preset="1w">1 minggu terakhir</button>
                    <button type="button" class="filter-pill-opt filter-pill-opt--active" data-preset="1m">1 bulan terakhir</button>
                    <button type="button" class="filter-pill-opt" data-preset="3m">3 bulan terakhir</button>
                    <button type="button" class="filter-pill-opt" id="btnPilihTanggal">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Pilih Tanggal</span>
                    </button>
                </div>
            </div>

            <div class="laporan-filter-row-bottom">
                <div class="laporan-range-group">
                    <span class="laporan-range-label" id="rangeLabel" hidden>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Rentang Kustom:
                    </span>

                    <div class="custom-range-controls" id="customRangeControls" hidden>
                        <div class="date-picker-box">
                            <span class="date-picker-box__label">Tanggal Awal</span>
                            <div class="date-picker-box__value">
                                <input type="date" id="startDate" aria-label="Tanggal awal" value="2026-04-01">
                            </div>
                        </div>
                        <div class="date-picker-box date-picker-box--end">
                            <span class="date-picker-box__label">Tanggal Akhir</span>
                            <div class="date-picker-box__value">
                                <input type="date" id="endDate" aria-label="Tanggal akhir" value="2026-04-30">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-laporan-terapkan" id="btnApplyCustomRange" hidden>Terapkan</button>
                </div>

                <div class="laporan-month-selector">
                    <span class="month-selector-label">PILIH BULAN:</span>
                    <div class="month-select-wrapper">
                        <select class="month-select" aria-label="Pilih Bulan Laporan">
                            <option value="2026-04" selected>April 2026</option>
                            <option value="2026-03">Maret 2026</option>
                            <option value="2026-02">Februari 2026</option>
                            <option value="2026-01">Januari 2026</option>
                            <option value="2025-12">Desember 2025</option>
                        </select>
                        <span class="select-chevron">▾</span>
                    </div>
                </div>
            </div>
        </section>

@php
    $categoriesPemasukan = array_unique(array_column($data['pemasukan'], 'category'));
    $categoriesPengeluaran = array_unique(array_column($data['pengeluaran'], 'category'));
@endphp

        {{-- ==================== 3. TWO-COLUMN TRANSACTION TABLES ==================== --}}
        <section class="laporan-trx-grid">

            {{-- LEFT COLUMN: PEMASUKAN --}}
            <div class="trx-col-box trx-col-box--pemasukan" id="boxPemasukan">
                <div class="trx-col-header trx-col-header--pemasukan">
                    <div class="trx-col-header__main">
                        <div class="trx-col-header__info">
                            <div class="trx-col-header__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h3 class="trx-col-header__title">Pemasukan</h3>
                                <span class="trx-col-header__count">{{ $data['count_pemasukan'] }} transaksi</span>
                            </div>
                        </div>
                        <div class="trx-col-header__total">
                            Rp {{ $data['total_pemasukan'] }}
                        </div>
                    </div>

                    {{-- FILTER & SORT PILLS ROW --}}
                    <div class="trx-filter-bar">
                        <button type="button" class="trx-filter-pill" data-action="sort" data-field="date" data-type="pemasukan" title="Urutkan berdasarkan Tanggal">
                            <span>Tanggal</span>
                            <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </button>
                        <div class="trx-filter-dropdown-wrapper">
                            <button type="button" class="trx-filter-pill" data-action="filter-category" data-type="pemasukan" title="Filter berdasarkan Kategori">
                                <span>Kategori</span>
                                <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                            </button>
                            <div class="trx-dropdown-menu">
                                <div class="trx-dropdown-header">Filter Kategori</div>
                                <button type="button" class="trx-dropdown-item active" data-cat="all">Semua Kategori</button>
                                @foreach($categoriesPemasukan as $cat)
                                    <button type="button" class="trx-dropdown-item" data-cat="{{ $cat }}">{{ $cat }}</button>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="trx-filter-pill" data-action="sort" data-field="title" data-type="pemasukan" title="Urutkan berdasarkan Uraian (A-Z)">
                            <span>Uraian</span>
                            <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </button>
                        <button type="button" class="trx-filter-pill" data-action="sort" data-field="amount" data-type="pemasukan" title="Urutkan berdasarkan Jumlah Nominal">
                            <span>Jumlah</span>
                            <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </button>
                    </div>
                </div>

                <div class="trx-col-body">
                    @foreach($data['pemasukan'] as $trx)
                        @include('pages.laporan.partials.trx-row', [
                            'title' => $trx['title'],
                            'date' => $trx['date'],
                            'category' => $trx['category'],
                            'catColor' => $trx['cat_color'],
                            'amount' => $trx['amount'],
                            'type' => 'pemasukan'
                        ])
                    @endforeach
                </div>
            </div>

            {{-- RIGHT COLUMN: PENGELUARAN --}}
            <div class="trx-col-box trx-col-box--pengeluaran" id="boxPengeluaran">
                <div class="trx-col-header trx-col-header--pengeluaran">
                    <div class="trx-col-header__main">
                        <div class="trx-col-header__info">
                            <div class="trx-col-header__icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="7" x2="17" y2="17"></line>
                                    <polyline points="17 7 17 17 7 17"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h3 class="trx-col-header__title">Pengeluaran</h3>
                                <span class="trx-col-header__count">{{ $data['count_pengeluaran'] }} transaksi</span>
                            </div>
                        </div>
                        <div class="trx-col-header__total">
                            Rp {{ $data['total_pengeluaran'] }}
                        </div>
                    </div>

                    {{-- FILTER & SORT PILLS ROW --}}
                    <div class="trx-filter-bar">
                        <button type="button" class="trx-filter-pill" data-action="sort" data-field="date" data-type="pengeluaran" title="Urutkan berdasarkan Tanggal">
                            <span>Tanggal</span>
                            <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </button>
                        <div class="trx-filter-dropdown-wrapper">
                            <button type="button" class="trx-filter-pill" data-action="filter-category" data-type="pengeluaran" title="Filter berdasarkan Kategori">
                                <span>Kategori</span>
                                <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                            </button>
                            <div class="trx-dropdown-menu">
                                <div class="trx-dropdown-header">Filter Kategori</div>
                                <button type="button" class="trx-dropdown-item active" data-cat="all">Semua Kategori</button>
                                @foreach($categoriesPengeluaran as $cat)
                                    <button type="button" class="trx-dropdown-item" data-cat="{{ $cat }}">{{ $cat }}</button>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="trx-filter-pill" data-action="sort" data-field="title" data-type="pengeluaran" title="Urutkan berdasarkan Uraian (A-Z)">
                            <span>Uraian</span>
                            <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </button>
                        <button type="button" class="trx-filter-pill" data-action="sort" data-field="amount" data-type="pengeluaran" title="Urutkan berdasarkan Jumlah Nominal">
                            <span>Jumlah</span>
                            <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </button>
                    </div>
                </div>

                <div class="trx-col-body">
                    @foreach($data['pengeluaran'] as $trx)
                        @include('pages.laporan.partials.trx-row', [
                            'title' => $trx['title'],
                            'date' => $trx['date'],
                            'category' => $trx['category'],
                            'catColor' => $trx['cat_color'],
                            'amount' => $trx['amount'],
                            'type' => 'pengeluaran'
                        ])
                    @endforeach
                </div>
            </div>

        </section>

        {{-- ==================== 4. RESUME SALDO TABLE ==================== --}}
        <section class="laporan-resume-section">
            <div class="laporan-resume-heading">
                <h2 class="laporan-section-title">Resume Saldo April 2026</h2>
                <p class="laporan-section-desc">Rekapitulasi per kategori dana</p>
            </div>

            @include('pages.laporan.partials.resume-table', [
                'resume' => $data['resume'],
                'total' => $data['resume_total']
            ])
        </section>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format number to Rupiah with dot separator
    function formatRupiah(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    let activeDateRange = { start: '2026-04-01', end: '2026-04-30' };
    const transactionFilterRefreshers = [];

    // Initialize Sort & Category Filter for a Transaction Box
    function initTrxFilterAndSort(boxId) {
        const box = document.getElementById(boxId);
        if (!box) return;

        const body = box.querySelector('.trx-col-body');
        const countEl = box.querySelector('.trx-col-header__count');
        const totalEl = box.querySelector('.trx-col-header__total');
        const sortPills = box.querySelectorAll('.trx-filter-pill[data-action="sort"]');
        const categoryBtn = box.querySelector('.trx-filter-pill[data-action="filter-category"]');
        const categoryMenu = box.querySelector('.trx-dropdown-menu');

        let rows = Array.from(body.querySelectorAll('.trx-row'));
        let currentSort = { field: null, direction: null };
        let currentCategory = 'all';

        // Recalculate count and subtotal
        function updateSummary() {
            let visibleRows = rows.filter(r => r.style.display !== 'none');
            let total = visibleRows.reduce((sum, r) => sum + parseInt(r.getAttribute('data-amount') || '0', 10), 0);
            if (countEl) countEl.textContent = `${visibleRows.length} transaksi`;
            if (totalEl) totalEl.textContent = `Rp ${formatRupiah(total)}`;
        }

        function applyVisibility() {
            rows.forEach(row => {
                const inDateRange = !activeDateRange
                    || (row.getAttribute('data-date') >= activeDateRange.start
                        && row.getAttribute('data-date') <= activeDateRange.end);
                const inCategory = currentCategory === 'all'
                    || row.getAttribute('data-category') === currentCategory;
                row.style.display = inDateRange && inCategory ? 'flex' : 'none';
            });
            updateSummary();
        }

        transactionFilterRefreshers.push(applyVisibility);

        // Apply sort
        function applySort(field, direction) {
            rows.sort((a, b) => {
                let valA = a.getAttribute(`data-${field}`);
                let valB = b.getAttribute(`data-${field}`);

                if (field === 'amount') {
                    valA = parseInt(valA || '0', 10);
                    valB = parseInt(valB || '0', 10);
                    return direction === 'asc' ? valA - valB : valB - valA;
                } else if (field === 'date') {
                    return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                } else {
                    return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                }
            });

            rows.forEach(r => body.appendChild(r));
        }

        // Sorting pills event listener
        sortPills.forEach(pill => {
            pill.addEventListener('click', function(e) {
                e.stopPropagation();
                if (categoryMenu) categoryMenu.classList.remove('show');

                const field = this.getAttribute('data-field');
                let nextDir = 'asc';

                if (currentSort.field === field) {
                    if (currentSort.direction === 'asc') nextDir = 'desc';
                    else if (currentSort.direction === 'desc') nextDir = null;
                }

                // Reset all sort pills in this box
                sortPills.forEach(p => {
                    p.classList.remove('active');
                    const icon = p.querySelector('.sort-icon');
                    if (icon) icon.innerHTML = '<path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/>';
                });

                if (nextDir) {
                    this.classList.add('active');
                    currentSort = { field, direction: nextDir };
                    const iconSvg = nextDir === 'asc'
                        ? '<polyline points="18 15 12 9 6 15"></polyline>'
                        : '<polyline points="6 9 12 15 18 9"></polyline>';
                    const icon = this.querySelector('.sort-icon');
                    if (icon) icon.innerHTML = iconSvg;
                    applySort(field, nextDir);
                } else {
                    currentSort = { field: null, direction: null };
                    // Reset to original natural date order
                    rows.sort((a, b) => a.getAttribute('data-date').localeCompare(b.getAttribute('data-date')));
                    rows.forEach(r => body.appendChild(r));
                }
            });
        });

        // Category dropdown event listener
        if (categoryBtn && categoryMenu) {
            categoryBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                // Close other open dropdowns
                document.querySelectorAll('.trx-dropdown-menu').forEach(m => {
                    if (m !== categoryMenu) m.classList.remove('show');
                });
                categoryMenu.classList.toggle('show');
            });

            categoryMenu.querySelectorAll('.trx-dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    categoryMenu.querySelectorAll('.trx-dropdown-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    const selectedCat = this.getAttribute('data-cat');
                    const labelSpan = categoryBtn.querySelector('span');

                    if (selectedCat === 'all') {
                        currentCategory = 'all';
                        categoryBtn.classList.remove('active');
                        if (labelSpan) labelSpan.textContent = 'Kategori';
                    } else {
                        currentCategory = selectedCat;
                        categoryBtn.classList.add('active');
                        if (labelSpan) {
                            labelSpan.textContent = selectedCat.length > 13 ? selectedCat.substring(0, 12) + '...' : selectedCat;
                        }
                    }

                    categoryMenu.classList.remove('show');
                    applyVisibility();
                });
            });
        }

        applyVisibility();
    }

    // Initialize both columns
    document.addEventListener('DOMContentLoaded', () => {
        initTrxFilterAndSort('boxPemasukan');
        initTrxFilterAndSort('boxPengeluaran');

        // Close dropdowns on outside click
        document.addEventListener('click', () => {
            document.querySelectorAll('.trx-dropdown-menu').forEach(m => m.classList.remove('show'));
        });

        const presetPills = document.querySelectorAll('.filter-pill-opt[data-preset]');
        const customPill = document.getElementById('btnPilihTanggal');
        const customControls = document.getElementById('customRangeControls');
        const applyCustomRange = document.getElementById('btnApplyCustomRange');
        const rangeLabel = document.getElementById('rangeLabel');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        const sectionTitle = document.querySelector('.laporan-heading-group .laporan-section-title');
        const resumeTitle = document.querySelector('.laporan-resume-heading .laporan-section-title');
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        function formatDateLabel(value) {
            const date = new Date(`${value}T00:00:00`);
            return `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
        }

        function updateReport(range, label) {
            if (range.start > range.end) {
                window.alert('Tanggal awal tidak boleh melebihi tanggal akhir.');
                return false;
            }
            activeDateRange = range;
            transactionFilterRefreshers.forEach(refresh => refresh());
            if (sectionTitle) sectionTitle.textContent = `Detail ${label}`;
            if (resumeTitle) resumeTitle.textContent = `Resume Saldo ${label}`;
            return true;
        }

        function activatePill(pill) {
            document.querySelectorAll('.filter-pill-opt').forEach(item => item.classList.remove('filter-pill-opt--active'));
            pill.classList.add('filter-pill-opt--active');
        }

        function setCustomRangeVisibility(isVisible) {
            customControls.hidden = !isVisible;
            applyCustomRange.hidden = !isVisible;
            rangeLabel.hidden = !isVisible;
        }

        presetPills.forEach(pill => {
            pill.addEventListener('click', function() {
                const latest = new Date('2026-04-30T00:00:00');
                const preset = this.dataset.preset;
                const start = new Date(latest);
                let label;
                if (preset === '1w') {
                    start.setDate(start.getDate() - 6);
                    label = `${formatDateLabel(start.toISOString().slice(0, 10))} – ${formatDateLabel('2026-04-30')}`;
                } else if (preset === '1m') {
                    start.setDate(1);
                    label = 'April 2026';
                } else {
                    start.setMonth(start.getMonth() - 2, 1);
                    label = 'Februari – April 2026';
                }
                const startValue = start.toISOString().slice(0, 10);
                if (updateReport({ start: startValue, end: '2026-04-30' }, label)) {
                    activatePill(this);
                    setCustomRangeVisibility(false);
                }
            });
        });

        customPill.addEventListener('click', function() {
            activatePill(this);
            setCustomRangeVisibility(true);
        });

        applyCustomRange.addEventListener('click', function() {
            const label = `${formatDateLabel(startDate.value)} – ${formatDateLabel(endDate.value)}`;
            if (updateReport({ start: startDate.value, end: endDate.value }, label)) {
                activatePill(customPill);
            }
        });
    });
</script>
@endpush
