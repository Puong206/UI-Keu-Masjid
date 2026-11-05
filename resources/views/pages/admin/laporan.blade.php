@extends('layouts.admin')

@section('title', 'Laporan Keuangan — Admin')

@section('content')
@php
    $data = $data ?? require resource_path('views/pages/laporan/data.php');
    $transactions = array_merge(
        array_map(fn ($item) => array_merge($item, ['type' => 'Masuk']), $data['pemasukan']),
        array_map(fn ($item) => array_merge($item, ['type' => 'Keluar']), $data['pengeluaran'])
    );
    $tab = in_array($tab ?? 'masuk', ['masuk', 'keluar'], true) ? ($tab ?? 'masuk') : 'masuk';
    $search = $search ?? '';
    $reportItems = $tab === 'masuk' ? $data['pemasukan'] : $data['pengeluaran'];
    $filteredItems = array_filter($reportItems, function ($item) use ($search) {
        return $search === '' || stripos($item['title'], $search) !== false || stripos($item['category'], $search) !== false;
    });
    $perPage = 10;
    $totalItems = count($filteredItems);
    $totalPages = max(1, (int) ceil($totalItems / $perPage));
    $page = min(max(1, (int) ($page ?? 1)), $totalPages);
    $pageItems = array_slice($filteredItems, ($page - 1) * $perPage, $perPage, true);
@endphp
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand"><img src="/images/Logo Masjid.png" alt="Logo Masjid Al-Hidayah"><strong>MASJID<br>AL-HIDAYAH</strong></div>
        <span class="admin-sidebar__label">KEUANGAN</span>
        <nav class="admin-sidebar__nav">
            <a href="{{ route('admin.dashboard') }}">▣ <span>Dashboard Keuangan</span></a>
            <a class="is-active" href="{{ route('admin.laporan') }}">▥ <span>Laporan</span></a>
            <a href="#transaksi">▤ <span>Kelola Dana</span></a>
            <a href="#kategori">▧ <span>Kategori Dana</span></a>
            <a href="#aktivitas">◷ <span>Activity Log</span></a>
        </nav>
        <span class="admin-sidebar__label">KONTEN WEBSITE</span>
        <nav class="admin-sidebar__nav"><a href="{{ route('profil') }}">⌂ <span>Profil Masjid</span></a><a href="{{ route('agenda') }}">◷ <span>Agenda</span></a><a href="{{ route('kontak') }}">⚙ <span>Kontak & Pengaturan</span></a></nav>
        <span class="admin-sidebar__label">PENGATURAN</span>
        <nav class="admin-sidebar__nav"><a href="#akun">♙ <span>Kelola Akun</span></a><a href="#akses">♢ <span>Kode Akses Laporan</span></a></nav>
        <div class="admin-sidebar__user"><span class="admin-avatar">SA</span><span><strong>{{ auth()->user()->name }}</strong><small>Super Admin</small></span><form method="POST" action="{{ route('admin.logout') }}">@csrf<button aria-label="Keluar">↪</button></form></div>
    </aside>
    <main class="admin-main">
        <header class="admin-topbar"><strong>Laporan</strong><span>◔ &nbsp; {{ now()->format('d M Y') }}</span></header>
        <div class="admin-content admin-report">
            <section class="admin-report-hero"><div><span class="admin-report-badge">LAPORAN KEUANGAN</span><h1>LAPORAN<br><b>KEUANGAN</b></h1><p>Ringkasan transparansi dan akuntabilitas pengelolaan dana<br>Masjid Al-Hidayah Sorolaten.</p><div><button>＋ Tambah Pemasukan</button><button>＋ Tambah Pengeluaran</button></div></div></section>
            <section class="admin-report-balance"><small>TOTAL SALDO SELURUH DANA</small><strong>Rp17.228.200</strong><div><span>SALDO AWAL <b>Rp16.864.200</b></span><span>PEMASUKAN <b>Rp1.791.500</b></span><span>PENGELUARAN <b>Rp1.427.500</b></span></div></section>
            <section class="admin-report-category"><article><i>▣</i><small>Kas Masjid</small><strong>Rp12.718.200</strong><span>Saldo Akhir</span></article><article><i>▣</i><small>Kotak Jum'at Berkah</small><strong>Rp3.654.000</strong><span>Saldo Akhir</span></article><article><i>▣</i><small>Kotak Pembangunan & Pemeliharaan</small><strong>Rp856.000</strong><span>Saldo Akhir</span></article></section>
            <div class="admin-report-date"><h2>Detail Oktober 2026</h2><span>Terakhir diperbarui: {{ now()->format('d M Y') }}</span></div>
            <section class="admin-report-columns">
                <article class="admin-report-list admin-report-list--income"><header><strong>↗ Pemasukan</strong><b>Rp1.791.500</b></header>@foreach(array_slice($data['pemasukan'], -6) as $item)<div><span><b>{{ $item['title'] }}</b><small>{{ $item['date'] }} · {{ $item['category'] }}</small></span><strong>+ Rp{{ $item['amount'] }}</strong></div>@endforeach</article>
                <article class="admin-report-list admin-report-list--expense"><header><strong>↘ Pengeluaran</strong><b>Rp1.427.500</b></header>@foreach(array_slice($data['pengeluaran'], -6) as $item)<div><span><b>{{ $item['title'] }}</b><small>{{ $item['date'] }} · {{ $item['category'] }}</small></span><strong>- Rp{{ $item['amount'] }}</strong></div>@endforeach</article>
            </section>
            <section class="admin-card admin-report-resume" id="kategori"><div class="admin-card__heading"><div><h2>Resume Saldo Bulan Oktober</h2><small>Rekapitulasi saldo berdasarkan kategori dana</small></div></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>KATEGORI</th><th>SALDO AWAL (Rp)</th><th>PEMASUKAN (Rp)</th><th>PENGELUARAN (Rp)</th><th>SALDO AKHIR (Rp)</th></tr></thead><tbody><tr><td>● Kas Masjid</td><td>13.463.200</td><td class="is-income">682.500</td><td class="is-expense">1.427.500</td><td>12.718.200</td></tr><tr><td>● Kotak Jum'at Berkah</td><td>3.251.000</td><td class="is-income">403.000</td><td>—</td><td>3.654.000</td></tr><tr><td>● Kotak Pembangunan & Pemeliharaan</td><td>150.000</td><td class="is-income">706.000</td><td>—</td><td>856.000</td></tr><tr class="is-total"><td>TOTAL</td><td>16.864.200</td><td>1.791.500</td><td>1.427.500</td><td>17.228.200</td></tr></tbody></table></div></section>
            <section class="admin-report-download"><div><strong>Unduh Ringkasan Laporan</strong><small>Laporkan transparansi keuangan dengan mudah.</small></div><a href="{{ route('laporan.export.format') }}">⇩ Unduh</a></section>
            <nav class="admin-report-tabs" aria-label="Jenis laporan">
                <a class="{{ $tab === 'masuk' ? 'is-active' : '' }}" href="{{ route('admin.laporan', ['tab' => 'masuk']) }}">↗ &nbsp;Kas Masuk</a>
                <a class="{{ $tab === 'keluar' ? 'is-active' : '' }}" href="{{ route('admin.laporan', ['tab' => 'keluar']) }}">↘ &nbsp;Kas Keluar</a>
                <a href="#rekap-bulanan">▤ &nbsp;Rekap Bulanan</a>
                <a href="#rekap-bulanan">▦ &nbsp;Laporan Bulanan</a>
            </nav>
            <section class="admin-card admin-ledger" id="transaksi">
                <div class="admin-ledger-heading"><div><h2>{{ $tab === 'masuk' ? 'Kas Masuk' : 'Kas Keluar' }}</h2><p>Semua pemasukan dana masjid</p></div><form method="GET" action="{{ route('admin.laporan') }}"><input type="hidden" name="tab" value="{{ $tab }}"><input name="search" value="{{ $search }}" placeholder="Cari transaksi..." aria-label="Cari transaksi"></form></div>
                <div class="admin-ledger-stats"><strong><small>{{ $tab === 'masuk' ? 'TOTAL PEMASUKAN' : 'TOTAL PENGELUARAN' }}</small>Rp{{ $tab === 'masuk' ? $data['total_pemasukan'] : $data['total_pengeluaran'] }}</strong><strong><small>JUMLAH TRANSAKSI</small>{{ $totalItems }}<em>entri tercatat</em></strong></div>
                <div class="admin-table-wrap"><table class="admin-table admin-ledger-table"><thead><tr><th>TANGGAL</th><th>KATEGORI</th><th>URAIAN</th><th>JUMLAH (Rp)</th><th>AKSI</th></tr></thead><tbody>@forelse($pageItems as $index => $item)<tr><td>{{ $item['date'] }}</td><td><span class="admin-tag">{{ $item['category'] }}</span></td><td>{{ $item['title'] }}</td><td class="{{ $tab === 'masuk' ? 'is-income' : 'is-expense' }}">{{ $item['amount'] }}</td><td><a class="admin-detail-link" href="{{ route('admin.laporan.transaction.detail', ['type' => $tab, 'index' => $index]) }}">Lihat detail ›</a></td></tr>@empty<tr><td colspan="5" class="admin-empty">Tidak ada transaksi yang sesuai.</td></tr>@endforelse</tbody></table></div>
                @if($totalPages > 1)
                    <div class="admin-pagination"><span>Menampilkan {{ (($page - 1) * $perPage) + 1 }}–{{ min($page * $perPage, $totalItems) }} dari {{ $totalItems }} data</span><div>@for($number = 1; $number <= $totalPages; $number++)<a class="{{ $number === $page ? 'is-active' : '' }}" href="{{ route('admin.laporan', ['tab' => $tab, 'search' => $search, 'page' => $number]) }}">{{ $number }}</a>@endfor</div></div>
                @endif
            </section>
            <section class="admin-card admin-monthly-placeholder" id="rekap-bulanan"><div><h2>Rekap Bulanan 2026</h2><p>Ringkasan saldo dan transaksi berdasarkan periode bulan.</p></div><span>Segera tersedia</span></section>
        </div>
    </main>
</div>
@endsection
