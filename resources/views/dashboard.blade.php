@extends('layouts.admin')

@section('title', 'Dashboard Keuangan - Masjid Al-Hidayah')

@section('content')
@php
    // Warna per kategori dana (dipakai untuk titik di tabel resume dan tag di tabel transaksi)
    $tone = [
        'Kas Masjid' => 'green',
        "Kotak Jum'at Berkah" => 'blue',
        'Kotak Pembangunan & Pemeliharaan' => 'orange',
    ];
    $tanggal = now()->translatedFormat('d F Y');
@endphp

<div class="admin-shell">
    @include('layouts.partials.admin-sidebar')

    <main class="admin-main">
        @include('layouts.partials.admin-topbar', ['title' => 'Dashboard Keuangan'])

        <div class="admin-content">
            <section class="admin-hero">
                <div>
                    <h1>MASJID<br>AL-HIDAYAH</h1>
                    <p>Kelola seluruh transaksi keuangan, konten website,<br>dalam satu dashboard terintegrasi.</p>
                    <div class="admin-hero__actions">
                        <button type="button" class="admin-btn admin-btn--light"><svg class="ic"><use href="#i-down"/></svg>Tambah Pemasukan</button>
                        <button type="button" class="admin-btn admin-btn--ghost"><svg class="ic"><use href="#i-up"/></svg>Tambah Pengeluaran</button>
                    </div>
                </div>
            </section>

            <div class="admin-updated">Terakhir Update: {{ $tanggal }}</div>

            <section class="admin-stat-grid">
                <article class="admin-stat admin-stat--green">
                    <div class="admin-stat__head"><i><svg class="ic"><use href="#i-wallet"/></svg></i><small>Saldo Awal</small></div>
                    <strong>Rp16.864.200</strong>
                    <span>Diambil dari Saldo Akhir bulan lalu</span>
                </article>
                <article class="admin-stat admin-stat--income">
                    <div class="admin-stat__head"><i><svg class="ic"><use href="#i-trend-up"/></svg></i><small>Pemasukan</small></div>
                    <strong>Rp1.791.500</strong>
                </article>
                <article class="admin-stat admin-stat--red">
                    <div class="admin-stat__head"><i><svg class="ic"><use href="#i-trend-down"/></svg></i><small>Pengeluaran</small></div>
                    <strong>Rp1.427.500</strong>
                </article>
                <article class="admin-stat admin-stat--green">
                    <div class="admin-stat__head"><i><svg class="ic"><use href="#i-wallet"/></svg></i><small>Saldo Akhir</small></div>
                    <strong>Rp17.228.200</strong>
                    <span>Update: {{ $tanggal }}</span>
                </article>
            </section>

            <section class="admin-card" id="kategori">
                <div class="admin-card__heading">
                    <h2>Resume Saldo per Kategori</h2>
                    <div class="admin-updated admin-updated--sm">Terakhir Update: {{ $tanggal }}</div>
                    <p>Rekap pemasukan, pengeluaran, dan saldo akhir semua kotak dana</p>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr><th>Kategori</th><th>Saldo Awal (Rp)</th><th>Pemasukan (Rp)</th><th>Pengeluaran (Rp)</th><th>Saldo Akhir (Rp)</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="admin-cat"><i class="admin-dot admin-dot--green"></i>Kas Masjid</span></td>
                                <td>13.463.200</td>
                                <td class="is-income">682.500</td>
                                <td class="is-expense">1.427.500</td>
                                <td>12.718.200</td>
                            </tr>
                            <tr>
                                <td><span class="admin-cat"><i class="admin-dot admin-dot--blue"></i>Kotak Jum'at Berkah</span></td>
                                <td>3.251.000</td>
                                <td class="is-income">403.000</td>
                                <td class="is-expense">-</td>
                                <td>3.654.000</td>
                            </tr>
                            <tr>
                                <td><span class="admin-cat"><i class="admin-dot admin-dot--orange"></i>Kotak Pembangunan & Pemeliharaan</span></td>
                                <td>150.000</td>
                                <td class="is-income">706.000</td>
                                <td class="is-expense">-</td>
                                <td>856.000</td>
                            </tr>
                            <tr class="is-total">
                                <td>TOTAL</td>
                                <td>16.864.200</td>
                                <td class="is-income">1.791.500</td>
                                <td class="is-expense">1.427.500</td>
                                <td class="is-final">17.228.200</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="admin-banner">
                <div>
                    <strong>Transparansi & Akuntabilitas Keuangan</strong>
                    <small>Pantau dan ekspor laporan keuangan masjid secara realtime.</small>
                </div>
                <a href="{{ route('admin.laporan.index') }}"><svg class="ic"><use href="#i-file"/></svg>Lihat Laporan</a>
            </section>

            <section class="admin-card" id="transaksi">
                <div class="admin-card__bar">
                    <h2>Transaksi Terbaru</h2>
                    <a class="admin-link-btn" href="#transaksi">Lihat Semua <svg class="ic"><use href="#i-chevron"/></svg></a>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table admin-table--transactions">
                        <thead>
                            <tr><th>Tanggal</th><th>Kategori</th><th>Jenis</th><th>Uraian</th><th>Nominal (Rp)</th></tr>
                        </thead>
                        <tbody>
                            @foreach([
                                ['15 Oktober 2026', 'Kas Masjid', 'Masuk', 'Infaq Pengajian Malam Kamis', '+ 117.000'],
                                ['15 Oktober 2026', 'Kas Masjid', 'Keluar', 'Snack Pengajian Malam Kamis', '- 110.000'],
                                ['15 Oktober 2026', 'Kas Masjid', 'Keluar', 'Donasi Paud', '- 100.000'],
                                ['14 Oktober 2026', 'Kas Masjid', 'Keluar', 'Pembelian Pewangi Karpet & Pembersih Lantai', '- 118.500'],
                                ['9 Oktober 2026', 'Kotak Pembangunan & Pemeliharaan', 'Masuk', 'Kotak Pembangunan & Pemeliharaan', '+ 403.000'],
                            ] as $transaction)
                                <tr>
                                    <td class="admin-date">{{ $transaction[0] }}</td>
                                    <td><span class="admin-tag admin-tag--{{ $tone[$transaction[1]] ?? 'green' }}">{{ $transaction[1] }}</span></td>
                                    <td><span class="admin-type admin-type--{{ strtolower($transaction[2]) }}">{{ $transaction[2] }}</span></td>
                                    <td class="admin-desc">{{ $transaction[3] }}</td>
                                    <td class="admin-nominal {{ str_starts_with($transaction[4], '+') ? 'is-income' : 'is-expense' }}">{{ $transaction[4] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="admin-quick-links">
                <a href="{{ route('admin.laporan.index') }}" class="is-blue"><b><svg class="ic"><use href="#i-file"/></svg></b><span><strong>Lihat Laporan</strong><small>Export & cetak</small></span></a>
                <a href="#aktivitas" class="is-purple"><b><svg class="ic"><use href="#i-clipboard"/></svg></b><span><strong>Activity Log</strong><small>Riwayat perubahan</small></span></a>
                <a href="#akun" class="is-orange"><b><svg class="ic"><use href="#i-users"/></svg></b><span><strong>Kelola Akun</strong><small>Super Admin only</small></span></a>
            </section>
        </div>
    </main>
</div>
@endsection
