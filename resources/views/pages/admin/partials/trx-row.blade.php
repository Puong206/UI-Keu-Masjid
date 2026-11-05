@props([
    'title' => '',
    'date' => '',
    'category' => 'Kas Masjid',
    'catColor' => 'green',
    'amount' => '0',
    'type' => 'pemasukan'
])

@php
    $cleanAmount = (int) str_replace(['.', ',', ' '], '', $amount);

    $bulanMap = [
        'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
        'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
        'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12'
    ];
    $dateParts = explode(' ', strtolower(trim($date)));
    $day = isset($dateParts[0]) ? str_pad($dateParts[0], 2, '0', STR_PAD_LEFT) : '01';
    $month = isset($dateParts[1], $bulanMap[$dateParts[1]]) ? $bulanMap[$dateParts[1]] : '04';
    $year = isset($dateParts[2]) ? $dateParts[2] : '2026';
    $dateIso = "{$year}-{$month}-{$day}";
@endphp

<div class="trx-row {{ $type === 'pengeluaran' ? 'trx-row--pengeluaran' : 'trx-row--pemasukan' }}"
     data-title="{{ strtolower($title) }}"
     data-category="{{ $category }}"
     data-date="{{ $dateIso }}"
     data-amount="{{ $cleanAmount }}">
    <div class="trx-row__left">
        <div class="trx-row__title" title="{{ $title }}">{{ $title }}</div>
        <div class="trx-row__meta">
            <span class="trx-row__date">{{ $date }}</span>
            <span class="trx-row__category trx-row__category--{{ $catColor }}">
                <span class="trx-cat-dot"></span>
                {{ $category }}
            </span>
        </div>
    </div>
    <div class="trx-row__amount {{ $type === 'pengeluaran' ? 'trx-row__amount--red' : 'trx-row__amount--green' }}">
        Rp {{ $amount }}
    </div>
</div>
