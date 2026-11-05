@php
    // Variabel: $jenis (masuk|keluar), $items (LengthAwarePaginator), $total, $count, $q, $formAction, $tone
    $rp = fn ($n) => number_format($n, 0, ',', '.');
    $masuk = $jenis === 'masuk';
    $perPage = request('per_page', '20');
    $items->fragment('data-kas');
@endphp
<section class="lap-kas" id="data-kas">
    <div class="lap-head">
        <h2>{{ $masuk ? 'Kas Masuk' : 'Kas Keluar' }}</h2>
        <p>{{ $masuk ? 'Semua pemasukan dana masjid' : 'Semua pengeluaran dana masjid' }}</p>
    </div>

    <div class="lap-stats">
        <div class="lap-total {{ $masuk ? '' : 'lap-total--danger' }}">
            <small>{{ $masuk ? 'Total Pemasukan' : 'Total Pengeluaran' }}</small>
            <strong>Rp{{ $rp($total) }}</strong>
        </div>
        <div class="lap-count">
            <small>Jumlah Transaksi</small>
            <strong>{{ $rp($count) }}</strong>
            <span>entri tercatat</span>
        </div>
        <form class="lap-search" method="GET" action="{{ $formAction }}#data-kas" role="search">
            @foreach (request()->except(['q', 'page']) as $name => $value)
                @if (is_scalar($value))
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endif
            @endforeach
            <i><svg class="ic"><use href="#i-search"/></svg></i>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari transaksi..." aria-label="Cari transaksi">
        </form>
    </div>

    <p class="lap-info"><svg class="ic"><use href="#i-info"/></svg>Klik baris atau Lihat detail untuk melihat transaksi. Edit dan hapus tersedia di halaman detail.</p>

    <div class="lap-table-card">
        <div class="admin-table-wrap">
            <table class="lap-table">
                <colgroup><col style="width:17%"><col style="width:25%"><col><col style="width:13%"><col style="width:12%"></colgroup>
                <thead>
                    <tr><th>Tanggal</th><th>Kategori</th><th>Uraian</th><th class="is-right">Jumlah (Rp)</th><th class="is-right">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($items as $t)
                        <tr data-href="{{ route('admin.laporan.show', [$jenis, $t]) }}">
                            <td>{{ $t->tanggal->translatedFormat('j F Y') }}</td>
                            <td><span class="lap-chip lap-chip--{{ $tone[$t->kategori->nama] ?? 'green' }}">{{ $t->kategori->nama }}</span></td>
                            <td>{{ $t->uraian }}</td>
                            <td class="lap-num {{ $masuk ? '' : 'lap-num--out' }}">{{ $rp($t->jumlah) }}</td>
                            <td class="is-right"><a class="lap-link" href="{{ route('admin.laporan.show', [$jenis, $t]) }}">Lihat detail <svg class="ic"><use href="#i-chevron"/></svg></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="lap-empty">{{ $q !== '' ? 'Tidak ada transaksi yang cocok dengan pencarian.' : 'Belum ada transaksi.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="lap-foot">
            <div class="lap-foot__left">
                <span>Menampilkan {{ $items->firstItem() ?? 0 }}-{{ $items->lastItem() ?? 0 }} dari {{ $rp($items->total()) }} data</span>
                <span class="lap-per">
                    Tampilkan:
                    @foreach (['20', '30', '50', 'all'] as $n)
                        <a class="{{ (string) $perPage === $n ? 'is-active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['per_page' => $n, 'page' => 1]) }}#data-kas">{{ $n === 'all' ? 'Semua' : $n }}</a>
                    @endforeach
                </span>
            </div>
            {{ $items->links('vendor.pagination.masjid') }}
        </div>
    </div>
</section>

<script>
    // Baris tabel bisa diklik untuk membuka halaman detail
    document.querySelectorAll('.lap-table tr[data-href]').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('a')) return;
            window.location.href = row.dataset.href;
        });
    });
</script>
