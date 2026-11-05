@php
    // $mode: 'hub' (halaman laporan utama) atau 'page' (halaman Kas Masuk/Kas Keluar mandiri)
    // $aktif: kas-masuk | kas-keluar | rekap-bulanan | laporan-bulanan
    $tabs = [
        'kas-masuk' => ['Kas Masuk', 'i-arrow-up-right'],
        'kas-keluar' => ['Kas Keluar', 'i-arrow-down-right'],
        'rekap-bulanan' => ['Rekap Bulanan', 'i-file'],
        'laporan-bulanan' => ['Laporan Bulanan', 'i-grid'],
    ];
    $keep = request()->only(['preset', 'bulan', 'dari', 'sampai']);
@endphp
<nav class="lap-tabs" aria-label="Jenis laporan">
    @foreach ($tabs as $key => [$label, $icon])
        @php
            $href = ($mode === 'page' && in_array($key, ['kas-masuk', 'kas-keluar'], true))
                ? route('admin.laporan.kas', ['jenis' => $key === 'kas-masuk' ? 'masuk' : 'keluar'])
                : route('admin.laporan.index', $keep + ['tab' => $key]) . '#tab-konten';
        @endphp
        <a class="lap-tab {{ $key === 'kas-keluar' ? 'lap-tab--danger' : '' }} {{ $aktif === $key ? 'is-active' : '' }}"
           href="{{ $href }}" @if ($aktif === $key) aria-current="page" @endif>
            <svg class="ic"><use href="#{{ $icon }}"/></svg>{{ $label }}
        </a>
    @endforeach
</nav>
