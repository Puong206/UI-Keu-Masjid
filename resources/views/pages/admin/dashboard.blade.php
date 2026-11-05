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

{{-- Sprite ikon (pindahkan ke layouts/admin.blade.php jika dipakai di halaman admin lain) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></symbol>
    <symbol id="i-swap" viewBox="0 0 24 24"><path d="M8 3 4 7l4 4"/><path d="M4 7h16"/><path d="m16 21 4-4-4-4"/><path d="M20 17H4"/></symbol>
    <symbol id="i-folder" viewBox="0 0 24 24"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></symbol>
    <symbol id="i-file" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></symbol>
    <symbol id="i-receipt" viewBox="0 0 24 24"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/></symbol>
    <symbol id="i-clipboard" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></symbol>
    <symbol id="i-building" viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/></symbol>
    <symbol id="i-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
    <symbol id="i-key" viewBox="0 0 24 24"><path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"/><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/></symbol>
    <symbol id="i-logout" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></symbol>
    <symbol id="i-bell" viewBox="0 0 24 24"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></symbol>
    <symbol id="i-down" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="m8 12 4 4 4-4"/></symbol>
    <symbol id="i-up" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m16 12-4-4-4 4"/><path d="M12 16V8"/></symbol>
    <symbol id="i-wallet" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></symbol>
    <symbol id="i-trend-up" viewBox="0 0 24 24"><path d="M22 7 13.5 15.5 8.5 10.5 2 17"/><path d="M16 7h6v6"/></symbol>
    <symbol id="i-trend-down" viewBox="0 0 24 24"><path d="M22 17 13.5 8.5 8.5 13.5 2 7"/><path d="M16 17h6v-6"/></symbol>
    <symbol id="i-chevron" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></symbol>
</svg>

<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand">
            <img src="/images/Logo Masjid.png" alt="Logo Masjid Al-Hidayah">
            <strong>MASJID<br>AL-HIDAYAH</strong>
        </div>

        <span class="admin-sidebar__label">Keuangan</span>
        <nav class="admin-sidebar__nav">
            <a class="is-active" href="{{ route('admin.dashboard') }}"><svg class="ic"><use href="#i-grid"/></svg><span>Dashboard Keuangan</span></a>
            <a href="#transaksi"><svg class="ic"><use href="#i-swap"/></svg><span>Kelola Dana</span></a>
            <a href="#kategori"><svg class="ic"><use href="#i-folder"/></svg><span>Kategori Dana</span></a>
            <a href="{{ route('admin.laporan') }}"><svg class="ic"><use href="#i-file"/></svg><span>Laporan</span></a>
            <a href="#kwitansi"><svg class="ic"><use href="#i-receipt"/></svg><span>Kwitansi</span></a>
            <a href="#aktivitas"><svg class="ic"><use href="#i-clipboard"/></svg><span>Activity Log</span></a>
        </nav>

        <span class="admin-sidebar__label">Konten Website</span>
        <nav class="admin-sidebar__nav">
            <a href="{{ route('profil') }}"><svg class="ic"><use href="#i-building"/></svg><span>Profil Masjid</span></a>
            <a href="{{ route('agenda') }}"><svg class="ic"><use href="#i-calendar"/></svg><span>Agenda</span></a>
            <a href="{{ route('kontak') }}"><svg class="ic"><use href="#i-phone"/></svg><span>Kontak & Pengaturan</span></a>
        </nav>

        <span class="admin-sidebar__label">Pengaturan</span>
        <nav class="admin-sidebar__nav">
            <a href="#akun"><svg class="ic"><use href="#i-users"/></svg><span>Kelola Akun</span></a>
            <a href="#akses"><svg class="ic"><use href="#i-key"/></svg><span>Kode Akses Laporan</span></a>
        </nav>

        <div class="admin-sidebar__user">
            <span class="admin-avatar">SA</span>
            <span class="admin-sidebar__who">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ auth()->user()->email }}</small>
            </span>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" aria-label="Keluar"><svg class="ic"><use href="#i-logout"/></svg></button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <strong>Dashboard Keuangan</strong>
            <div class="admin-topbar__right">
                <button type="button" class="admin-bell" aria-label="Notifikasi"><svg class="ic"><use href="#i-bell"/></svg><i></i></button>
                <span class="admin-avatar">SA</span>
            </div>
        </header>

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
                <a href="{{ route('admin.laporan') }}"><svg class="ic"><use href="#i-file"/></svg>Lihat Laporan</a>
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
                <a href="{{ route('admin.laporan') }}" class="is-blue"><b><svg class="ic"><use href="#i-file"/></svg></b><span><strong>Lihat Laporan</strong><small>Export & cetak</small></span></a>
                <a href="#aktivitas" class="is-purple"><b><svg class="ic"><use href="#i-clipboard"/></svg></b><span><strong>Activity Log</strong><small>Riwayat perubahan</small></span></a>
                <a href="#akun" class="is-orange"><b><svg class="ic"><use href="#i-users"/></svg></b><span><strong>Kelola Akun</strong><small>Super Admin only</small></span></a>
            </section>
        </div>
    </main>
</div>
@endsection
