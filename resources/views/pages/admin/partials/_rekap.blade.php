@php
    // Variabel: $rekap (12 bulan), $tahun, $tahunOptions, $tone
    $rp = fn ($n) => number_format($n, 0, ',', '.');
    $cell = fn ($n) => $n ? $rp($n) : '-';
@endphp
<section class="lap-kas" id="data-kas">
    <div class="lap-head lap-head--split">
        <div>
            <h2>Rekap Bulanan {{ $tahun }}</h2>
            <p>Ringkasan saldo & aliran kas seluruh bulan</p>
        </div>
        <form class="lap-year" method="GET" action="{{ route('admin.laporan.index') }}#tab-konten">
            <input type="hidden" name="tab" value="rekap-bulanan">
            <svg class="ic"><use href="#i-calendar"/></svg>
            <select name="tahun" aria-label="Pilih tahun" onchange="this.form.submit()">
                @foreach ($tahunOptions as $y)
                    <option value="{{ $y }}" @selected($y == $tahun)>Tahun {{ $y }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="lap-table-card">
        <div class="admin-table-wrap">
            <table class="lap-rekap">
                <thead>
                    <tr>
                        <th>Bulan</th><th>Kategori</th>
                        <th class="is-right">Saldo Awal (Rp)</th><th class="is-right">Pemasukan (Rp)</th>
                        <th class="is-right">Pengeluaran (Rp)</th><th class="is-right">Saldo Akhir (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $bulan)
                        @foreach ($bulan['rows'] as $row)
                            <tr>
                                @if ($loop->first)
                                    <td class="lap-rekap__month" rowspan="{{ $loop->count + 1 }}">
                                        <span class="lap-rekap__abbr">{{ $bulan['singkat'] }}</span>
                                        <span><strong>{{ $bulan['nama'] }}</strong><small>{{ $bulan['tahun'] }}</small></span>
                                    </td>
                                @endif
                                <td><span class="lap-chip lap-chip--{{ $tone[$row['nama']] ?? 'green' }}">{{ preg_replace('/^Kotak /', '', $row['nama']) }}</span></td>
                                <td class="is-right">{{ $cell($row['awal']) }}</td>
                                <td class="is-right is-income">{{ $cell($row['masuk']) }}</td>
                                <td class="is-right is-expense">{{ $cell($row['keluar']) }}</td>
                                <td class="is-right">{{ $cell($row['akhir']) }}</td>
                            </tr>
                        @endforeach
                        <tr class="is-total">
                            <td>TOTAL</td>
                            <td class="is-right">{{ $rp($bulan['total']['awal']) }}</td>
                            <td class="is-right is-income">{{ $rp($bulan['total']['masuk']) }}</td>
                            <td class="is-right is-expense">{{ $rp($bulan['total']['keluar']) }}</td>
                            <td class="is-right">{{ $rp($bulan['total']['akhir']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
