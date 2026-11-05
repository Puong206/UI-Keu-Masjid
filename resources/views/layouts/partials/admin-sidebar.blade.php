@php($is = fn ($pattern) => request()->routeIs($pattern) ? 'is-active' : '')
<aside class="admin-sidebar">
    <div class="admin-sidebar__brand">
        <img src="/images/Logo Masjid.png" alt="Logo Masjid Al-Hidayah">
        <strong>MASJID<br>AL-HIDAYAH</strong>
    </div>

    <span class="admin-sidebar__label">Keuangan</span>
    <nav class="admin-sidebar__nav">
        <a class="{{ $is('admin.dashboard') }}" href="{{ route('admin.dashboard') }}"><svg class="ic"><use href="#i-grid"/></svg><span>Dashboard Keuangan</span></a>
        <a class="{{ request()->routeIs('admin.laporan*') ? 'is-active' : '' }}" href="{{ route('admin.laporan') }}"><svg class="ic"><use href="#i-file"/></svg><span>Laporan</span></a>
        <a href="{{ route('admin.dashboard') }}#transaksi"><svg class="ic"><use href="#i-swap"/></svg><span>Kelola Dana</span></a>
        <a href="{{ route('admin.dashboard') }}#kategori"><svg class="ic"><use href="#i-folder"/></svg><span>Kategori Dana</span></a>
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
