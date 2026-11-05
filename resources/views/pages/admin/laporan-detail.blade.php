@extends('layouts.admin')

@section('title', 'Detail Transaksi — Admin')

@section('content')
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand"><img src="/images/Logo Masjid.png" alt="Logo Masjid Al-Hidayah"><strong>MASJID<br>AL-HIDAYAH</strong></div>
        <span class="admin-sidebar__label">KEUANGAN</span>
        <nav class="admin-sidebar__nav">
            <a href="{{ route('admin.dashboard') }}">▣ <span>Dashboard Keuangan</span></a>
            <a class="is-active" href="{{ route('admin.laporan') }}">▥ <span>Laporan</span></a>
            <a href="{{ route('admin.laporan', ['tab' => $type]) }}">▤ <span>Kelola Dana</span></a>
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
        <header class="admin-topbar"><strong>Transaksi</strong><span>◔ &nbsp; {{ now()->format('d M Y') }}</span></header>
        <div class="admin-content admin-detail">
            <div class="admin-breadcrumb"><a href="{{ route('admin.laporan') }}">Laporan</a><span>›</span><a href="{{ route('admin.laporan', ['tab' => $type]) }}">Kas {{ ucfirst($type) }}</a><span>›</span><b>Detail Transaksi</b></div>
            <a class="admin-back-link" href="{{ route('admin.laporan', ['tab' => $type]) }}">← &nbsp;Kembali ke Kas {{ ucfirst($type) }}</a>
            <div class="admin-detail-heading"><div><h1>Detail Transaksi</h1><p>Lihat informasi kas {{ $type }} sebelum mengubah atau menghapus data.</p></div><div><button class="admin-danger-button">♲ Hapus</button><button class="admin-edit-button">✎ Edit Transaksi</button></div></div>
            <div class="admin-detail-grid">
                <section class="admin-detail-card"><header><strong>Informasi Kas {{ ucfirst($type) }}</strong><span class="admin-type admin-type--{{ $type }}">{{ ucfirst($type) }}</span></header><div class="admin-detail-body"><small>Uraian transaksi</small><h2>{{ $item['title'] }}</h2><div class="admin-detail-meta"><div><small>Tanggal transaksi</small><strong>▣ &nbsp;{{ $item['date'] }}</strong></div><div><small>Kategori dana</small><span class="admin-tag">{{ $item['category'] }}</span></div></div><small>Jumlah {{ $type === 'masuk' ? 'pemasukan' : 'pengeluaran' }}</small><strong class="admin-detail-amount {{ $type === 'masuk' ? 'is-income' : 'is-expense' }}">Rp{{ $item['amount'] }}</strong></div></section>
                <aside><div class="admin-detail-callout {{ $type === 'masuk' ? 'is-income-box' : 'is-expense-box' }}"><strong>{{ $type === 'masuk' ? '↗ Pemasukan dana masjid' : '↘ Pengeluaran dana masjid' }}</strong><p>Transaksi ini tercatat sebagai kas {{ $type }} pada kategori {{ $item['category'] }}.</p></div><div class="admin-detail-note"><strong>♧ &nbsp;Kelola dengan hati-hati</strong><p>Gunakan Edit Transaksi untuk memperbaiki tanggal, kategori, uraian, atau jumlah.</p><p>Penghapusan memerlukan konfirmasi dan tidak dapat dibatalkan.</p></div></aside>
            </div>
        </div>
    </main>
</div>
@endsection