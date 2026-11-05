@extends('layouts.admin')

@section('title', 'Detail Transaksi - Masjid Al-Hidayah')

@section('content')
@php
    $masuk = $jenis === 'masuk';
    $namaKas = $masuk ? 'Kas Masuk' : 'Kas Keluar';
    $kategori = $transaksi->kategori->nama;
@endphp

<div class="admin-shell admin-shell--sub">
    @include('layouts.partials.admin-sidebar')

    <main class="admin-main">
        @include('layouts.partials.admin-topbar', ['title' => 'Transaksi', 'solid' => true])

        <div class="admin-content">
            <nav class="lap-crumb" aria-label="Breadcrumb">
                <a href="{{ route('admin.laporan.index') }}">Laporan</a>
                <svg class="ic"><use href="#i-chevron"/></svg>
                <a href="{{ route('admin.laporan.kas', $jenis) }}">{{ $namaKas }}</a>
                <svg class="ic"><use href="#i-chevron"/></svg>
                <strong>Detail Transaksi</strong>
            </nav>

            <a class="lap-back" href="{{ route('admin.laporan.kas', $jenis) }}"><svg class="ic"><use href="#i-arrow-left"/></svg>Kembali ke {{ $namaKas }}</a>

            <div class="lap-detail-head">
                <div class="lap-head">
                    <h1>Detail Transaksi</h1>
                    <p>Lihat informasi {{ strtolower($namaKas) }} sebelum mengubah atau menghapus data.</p>
                </div>
                <div class="lap-detail-actions">
                    <button type="button" class="lap-btn lap-btn--danger" data-open-hapus><svg class="ic"><use href="#i-trash"/></svg>Hapus</button>
                    <a class="lap-btn lap-btn--primary" href="{{ route('admin.laporan.edit', [$jenis, $transaksi]) }}"><svg class="ic"><use href="#i-pencil"/></svg>Edit Transaksi</a>
                </div>
            </div>

            <div class="lap-detail">
                <article class="lap-panel">
                    <header class="lap-panel__head">
                        <h2>Informasi {{ $namaKas }}</h2>
                        <span class="lap-pill {{ $masuk ? '' : 'lap-pill--danger' }}">{{ $masuk ? 'Masuk' : 'Keluar' }}</span>
                    </header>

                    <div class="lap-panel__block">
                        <small>Uraian transaksi</small>
                        <h3>{{ $transaksi->uraian }}</h3>
                    </div>

                    <div class="lap-panel__block lap-panel__grid">
                        <div>
                            <small>Tanggal transaksi</small>
                            <p class="lap-panel__date"><svg class="ic"><use href="#i-calendar"/></svg>{{ $transaksi->tanggal->translatedFormat('j F Y') }}</p>
                        </div>
                        <div>
                            <small>Kategori dana</small>
                            <span class="lap-chip lap-chip--{{ $tone[$kategori] ?? 'green' }}">{{ $kategori }}</span>
                        </div>
                    </div>

                    <div class="lap-panel__block">
                        <small>Jumlah {{ $masuk ? 'pemasukan' : 'pengeluaran' }}</small>
                        <p class="lap-panel__amount {{ $masuk ? '' : 'is-out' }}">Rp{{ number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                    </div>
                </article>

                <aside class="lap-side">
                    <div class="lap-side__hero {{ $masuk ? '' : 'lap-side__hero--danger' }}">
                        <svg class="ic"><use href="#{{ $masuk ? 'i-arrow-down-left' : 'i-arrow-up-right' }}"/></svg>
                        <h3>{{ $masuk ? 'Pemasukan dana masjid' : 'Pengeluaran dana masjid' }}</h3>
                        <p>Transaksi ini tercatat sebagai {{ strtolower($namaKas) }} pada kategori {{ $kategori }}.</p>
                    </div>
                    <div class="lap-side__note">
                        <h3><svg class="ic"><use href="#i-shield"/></svg>Kelola dengan hati-hati</h3>
                        <p>Gunakan Edit Transaksi untuk memperbaiki tanggal, kategori, uraian, atau jumlah.</p>
                        <p>Penghapusan memerlukan konfirmasi dengan mengetik HAPUS dan tidak dapat dibatalkan.</p>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</div>

<dialog id="hapus-dialog" class="lap-dialog" aria-labelledby="hapus-judul">
    <form method="POST" action="{{ route('admin.laporan.destroy', [$jenis, $transaksi]) }}">
        @csrf
        @method('DELETE')
        <h3 id="hapus-judul">Hapus transaksi ini?</h3>
        <p>{{ $transaksi->uraian }} sebesar Rp{{ number_format($transaksi->jumlah, 0, ',', '.') }} akan dihapus permanen. Ketik <strong>HAPUS</strong> untuk melanjutkan.</p>
        <input class="lap-dialog__input" name="konfirmasi" autocomplete="off" placeholder="HAPUS" aria-label="Ketik HAPUS untuk konfirmasi">
        @error('konfirmasi')<p class="lap-dialog__error">{{ $message }}</p>@enderror
        <div class="lap-dialog__actions">
            <button type="button" class="lap-btn lap-btn--ghost" data-close-hapus>Batal</button>
            <button type="submit" class="lap-btn lap-btn--danger" disabled>Hapus Transaksi</button>
        </div>
    </form>
</dialog>

<script>
    (function () {
        var dialog = document.getElementById('hapus-dialog');
        var input = dialog.querySelector('input[name="konfirmasi"]');
        var submit = dialog.querySelector('button[type="submit"]');
        document.querySelectorAll('[data-open-hapus]').forEach(function (b) { b.addEventListener('click', function () { dialog.showModal(); input.focus(); }); });
        dialog.querySelector('[data-close-hapus]').addEventListener('click', function () { dialog.close(); });
        input.addEventListener('input', function () { submit.disabled = input.value !== 'HAPUS'; });
        @if (request('hapus') || $errors->has('konfirmasi'))
            dialog.showModal();
        @endif
    })();
</script>
@endsection
