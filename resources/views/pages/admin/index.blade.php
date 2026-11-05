@extends('layouts.admin')

@section('title', 'Laporan Keuangan - Masjid Al-Hidayah')

@section('content')
@php
    $rp = fn ($n) => number_format($n, 0, ',', '.');
    $catIcons = ['green' => 'i-landmark', 'orange' => 'i-hardhat', 'blue' => 'i-sparkles'];
    $total = $resume['total'];
    $labelResume = $preset === 'bulan' ? 'Bulan ' . \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F') : $judul;
@endphp

<div class="admin-shell">
    @include('layouts.partials.admin-sidebar')

    <main class="admin-main">
        @include('layouts.partials.admin-topbar', ['title' => 'Transaksi'])

        <div class="admin-content">
            <section class="admin-hero admin-hero--laporan">
                <div>
                    <span class="lap-eyebrow"><svg class="ic"><use href="#i-file"/></svg>Masjid Al-Hidayah</span>
                    <h1>LAPORAN<br>KEUANGAN</h1>
                    <p>Ringkasan transparan pemasukan, pengeluaran, dan bantuan<br>internal dana masjid secara realtime.</p>
                    <div class="admin-hero__actions admin-hero__actions--row">
                        <button type="button" class="admin-btn admin-btn--light"><svg class="ic"><use href="#i-down"/></svg>Tambah Pemasukan</button>
                        <button type="button" class="admin-btn admin-btn--ghost"><svg class="ic"><use href="#i-up"/></svg>Tambah Pengeluaran</button>
                    </div>
                </div>
            </section>

            <section class="lap-balance">
                <small class="lap-balance__label">Total Saldo Seluruh Dana</small>
                <span class="lap-balance__chip">Update {{ now()->translatedFormat('F Y') }}</span>
                <strong>Rp{{ $rp($total['akhir']) }}</strong>
                <div class="lap-balance__mini">
                    <div class="is-light"><small>Saldo Awal</small><b>Rp{{ $rp($total['awal']) }}</b></div>
                    <div><small>Total Pemasukan</small><b>Rp{{ $rp($total['masuk']) }}</b></div>
                    <div><small>Total Pengeluaran</small><b>Rp{{ $rp($total['keluar']) }}</b></div>
                </div>
            </section>

            <section class="lap-cats">
                @foreach ($resume['rows'] as $row)
                    @php($t = $tone[$row['nama']] ?? 'green')
                    <article class="lap-cat lap-cat--{{ $t }}">
                        <div class="lap-cat__top">
                            <i><svg class="ic"><use href="#{{ $catIcons[$t] }}"/></svg></i>
                            <span class="lap-badge"><svg class="ic"><use href="#i-arrow-up-right"/></svg>Aktif</span>
                        </div>
                        <small>{{ $row['nama'] }}</small>
                        <strong>Rp{{ $rp($row['akhir']) }}</strong>
                        <span>Update {{ now()->translatedFormat('F') }}</span>
                        <svg class="ic lap-cat__go"><use href="#i-chevron"/></svg>
                    </article>
                @endforeach
            </section>

            <section class="lap-period">
                <div class="lap-period__head">
                    <div>
                        <h2>Detail {{ $judul }}</h2>
                        <p>Rincian pemasukan, pengeluaran, dan resume saldo bulan berjalan</p>
                    </div>
                    <div class="lap-presets">
                        @foreach (['1-minggu' => '1 minggu terakhir', '1-bulan' => '1 bulan terakhir', '3-bulan' => '3 bulan terakhir'] as $key => $label)
                            <a class="lap-preset {{ $preset === $key ? 'is-active' : '' }}" href="{{ route('admin.laporan.index', ['preset' => $key, 'tab' => $tab]) }}">{{ $label }}</a>
                        @endforeach
                        <a class="lap-preset {{ in_array($preset, ['bulan', 'kustom'], true) ? 'is-active' : '' }}" href="{{ route('admin.laporan.index', ['tab' => $tab]) }}"><svg class="ic"><use href="#i-calendar"/></svg>{{ $judul }}</a>
                    </div>
                </div>

                <form class="lap-range" method="GET" action="{{ route('admin.laporan.index') }}">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <span class="lap-range__label"><svg class="ic"><use href="#i-calendar"/></svg>Rentang Kustom:</span>
                    <label class="lap-field"><small>Tanggal Awal</small><input type="date" name="dari" value="{{ $dari }}"></label>
                    <label class="lap-field"><small>Tanggal Akhir</small><input type="date" name="sampai" value="{{ $sampai }}"></label>
                    <button type="submit" class="admin-btn lap-range__apply">Terapkan</button>
                    <label class="lap-range__month">Pilih Bulan:
                        <select name="bulan" onchange="this.form.dari.disabled = this.form.sampai.disabled = true; this.form.submit()">
                            @foreach ($bulanOptions as $value => $label)
                                <option value="{{ $value }}" @selected($value === $bulan)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                </form>
            </section>

            <section class="lap-flow">
                @foreach (['masuk' => $masuk, 'keluar' => $keluar] as $jenis => $list)
                    <article class="lap-box lap-box--{{ $jenis }}">
                        <header>
                            <div class="lap-box__title">
                                <i><svg class="ic"><use href="#{{ $jenis === 'masuk' ? 'i-arrow-up-right' : 'i-arrow-down-right' }}"/></svg></i>
                                <div>
                                    <h3>{{ $jenis === 'masuk' ? 'Pemasukan' : 'Pengeluaran' }}</h3>
                                    <small>{{ $list->count() }} transaksi</small>
                                </div>
                            </div>
                            <strong>Rp {{ $rp($list->sum('jumlah')) }}</strong>
                        </header>
                        <div class="lap-sort" data-sort-target="list-{{ $jenis }}">
                            @foreach (['tanggal' => 'Tanggal', 'kategori' => 'Kategori', 'uraian' => 'Uraian', 'jumlah' => 'Jumlah'] as $key => $label)
                                <button type="button" data-key="{{ $key }}">{{ $label }}<svg class="ic"><use href="#i-sort"/></svg></button>
                            @endforeach
                        </div>
                        <ul class="lap-items" id="list-{{ $jenis }}">
                            @forelse ($list as $t)
                                <li data-tanggal="{{ $t->tanggal->format('Y-m-d') }}" data-kategori="{{ $t->kategori->nama }}" data-uraian="{{ $t->uraian }}" data-jumlah="{{ $t->jumlah }}">
                                    <div>
                                        <strong>{{ $t->uraian }}</strong>
                                        <span class="lap-items__meta">{{ $t->tanggal->translatedFormat('j F Y') }}<span class="lap-chip lap-chip--{{ $tone[$t->kategori->nama] ?? 'green' }}">{{ $t->kategori->nama }}</span></span>
                                    </div>
                                    <span class="lap-items__amount">Rp {{ $rp($t->jumlah) }}</span>
                                    <a class="lap-icon-btn" href="{{ route('admin.laporan.edit', [$jenis, $t]) }}" aria-label="Edit transaksi"><svg class="ic"><use href="#i-edit"/></svg></a>
                                    <a class="lap-icon-btn lap-icon-btn--danger" href="{{ route('admin.laporan.show', [$jenis, $t, 'hapus' => 1]) }}" aria-label="Hapus transaksi"><svg class="ic"><use href="#i-trash"/></svg></a>
                                </li>
                            @empty
                                <li class="lap-items__empty">Belum ada transaksi pada periode ini.</li>
                            @endforelse
                        </ul>
                    </article>
                @endforeach
            </section>

            <section class="lap-resume">
                <h2>Resume Saldo {{ $labelResume }}</h2>
                <p>Rekapitulasi per kategori dana</p>
                <div class="admin-card">
                    <div class="admin-table-wrap">
                        <table class="admin-table admin-table--resume">
                            <thead>
                                <tr><th>Kategori</th><th>Saldo Awal (Rp)</th><th>Pemasukan (Rp)</th><th>Pengeluaran (Rp)</th><th>Saldo Akhir (Rp)</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($resume['rows'] as $row)
                                    <tr>
                                        <td><span class="admin-cat"><i class="admin-dot admin-dot--{{ $tone[$row['nama']] ?? 'green' }}"></i>{{ $row['nama'] }}</span></td>
                                        <td>{{ $rp($row['awal']) }}</td>
                                        <td class="is-income">{{ $rp($row['masuk']) }}</td>
                                        <td class="is-expense">{{ $row['keluar'] ? $rp($row['keluar']) : '-' }}</td>
                                        <td>{{ $rp($row['akhir']) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="is-total">
                                    <td>TOTAL</td>
                                    <td>{{ $rp($total['awal']) }}</td>
                                    <td class="is-income">{{ $rp($total['masuk']) }}</td>
                                    <td class="is-expense">{{ $rp($total['keluar']) }}</td>
                                    <td class="is-final">{{ $rp($total['akhir']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="admin-banner">
                <div>
                    <strong>Unduh Ringkasan Laporan</strong>
                    <small>Ekspor laporan keuangan dalam format PDF atau PNG.</small>
                </div>
                <a href="#unduh"><svg class="ic"><use href="#i-download"/></svg>Unduh</a>
            </section>

            @include('laporan.partials._tabs', ['mode' => 'hub', 'aktif' => $tab])

            <div id="tab-konten">
                @switch($tab)
                    @case('kas-masuk')
                        @include('laporan.partials._kas', ['jenis' => 'masuk', 'formAction' => route('admin.laporan.index')])
                        @break
                    @case('kas-keluar')
                        @include('laporan.partials._kas', ['jenis' => 'keluar', 'formAction' => route('admin.laporan.index')])
                        @break
                    @case('rekap-bulanan')
                        @include('laporan.partials._rekap')
                        @break
                    @default
                        @include('laporan.partials._laporan-bulanan')
                @endswitch
            </div>
        </div>
    </main>
</div>

<script>
    // Urutkan daftar Pemasukan/Pengeluaran dari tombol Tanggal, Kategori, Uraian, Jumlah
    document.querySelectorAll('.lap-sort').forEach(function (bar) {
        var list = document.getElementById(bar.dataset.sortTarget);
        var state = {};
        bar.querySelectorAll('button').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var key = btn.dataset.key;
                state[key] = !state[key];
                var dir = state[key] ? 1 : -1;
                var rows = Array.from(list.querySelectorAll('li[data-' + key + ']'));
                rows.sort(function (a, b) {
                    var x = a.dataset[key], y = b.dataset[key];
                    if (key === 'jumlah') return (Number(x) - Number(y)) * dir;
                    return x.localeCompare(y, 'id') * dir;
                });
                rows.forEach(function (r) { list.appendChild(r); });
            });
        });
    });
</script>
@endsection
