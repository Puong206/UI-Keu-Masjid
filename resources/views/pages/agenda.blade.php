@extends('layouts.app')

@section('title', 'Agenda & Kegiatan — Masjid Al-Hidayah Sorolaten')
@section('content')

@php
    $groups = [
        [
            'title' => 'Mingguan',
            'sub'   => 'Rutin setiap pekan',
            'lime'  => false,
            'items' => [
                ['Majlis Dzikrullah Bapak–bapak', 'Rabu Malam'],
                ['Pengajian Ibu–ibu', 'Kamis Malam'],
                ['Tadarus Al–Qur\'an Ibu–ibu', 'Selasa Malam'],
                ['Pengajian FORMADA (Remaja Masjid)', 'Jum\'at Malam'],
                ['Taman Pengajian Al–Qur\'an Anak-anak / TPA', 'Rabu Sore & Sabtu Sore'],
            ],
        ],
        [
            'title' => 'Bulanan',
            'sub'   => 'Rutin setiap bulan',
            'lime'  => true,
            'items' => [
                ['Pengajian Akbar Warga Sorolaten', 'Rabu Pon'],
                ['Pengajian Jama\'ah Ibu–Ibu Warga Sorolaten dan sekitarnya', 'Jum\'at Pahing'],
            ],
        ],
        [
            'title' => 'Tahunan / PHBI',
            'sub'   => 'Hari Besar Islam',
            'lime'  => false,
            'items' => [
                ['Peringatan Nuzulul Qur\'an', 'Bulan Ramadhan'],
                ['Pengajian Syawalan', 'Bulan Syawal'],
                ['Peringatan Tahun Baru Islam', 'Bulan Muharram / Shafar'],
                ['Peringatan Maulid Nabi Muhammad SAW', 'Bulan Rabi\'ul Awwal'],
                ['Peringatan Isra\' Mi\'raj Nabi Muhammad SAW', 'Bulan Rajab'],
            ],
        ],
    ];
@endphp

<div class="ag-page">
    <div class="ag-wrap">

        {{-- ==================== 1. BANNER ATAS ==================== --}}
        <section class="ag-hero">
            <div class="ag-hero__text">
                <h1 class="ag-hero__title">Agenda &amp;<br><span>Kegiatan Masjid</span></h1>
                <p class="ag-hero__desc">
                    Seluruh kegiatan pengajian rutin Masjid Al-Hidayah Sorolaten, dikelompokkan berdasarkan frekuensi pelaksanaan.
                </p>
            </div>
            <div class="ag-hero__stats">
                <div class="ag-hero__pill"><strong>12</strong><span>Total Kegiatan</span></div>
                <div class="ag-hero__pill"><strong>5</strong><span>Rutin Mingguan</span></div>
                <div class="ag-hero__pill"><strong>5</strong><span>PHBI / Tahunan</span></div>
            </div>
        </section>

        {{-- ==================== 2-4. KELOMPOK KEGIATAN ==================== --}}
        @foreach($groups as $group)
        <section class="ag-group {{ $group['lime'] ? 'ag-group--lime' : '' }}">
            <header class="ag-group__head">
                <div class="ag-group__id">
                    <span class="ag-group__icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    <div>
                        <h2 class="ag-group__title">{{ $group['title'] }}</h2>
                        <p class="ag-group__sub">{{ $group['sub'] }}</p>
                    </div>
                </div>
                <span class="ag-group__count">{{ count($group['items']) }} Kegiatan</span>
            </header>

            <div class="ag-cols" aria-hidden="true">
                <span>NO</span><span>NAMA KEGIATAN</span><span>WAKTU</span>
            </div>

            <ol class="ag-rows">
                @foreach($group['items'] as $i => [$name, $time])
                <li class="ag-row">
                    <span class="ag-row__no">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="ag-row__body">
                        <span class="ag-row__name">{{ $name }}</span>
                        <span class="ag-row__time">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $time }}
                        </span>
                    </div>
                </li>
                @endforeach
            </ol>
        </section>
        @endforeach

    </div>
</div>

@endsection
