@extends('layouts.admin')

@section('title', ($jenis === 'masuk' ? 'Kas Masuk' : 'Kas Keluar') . ' - Masjid Al-Hidayah')

@section('content')
<div class="admin-shell admin-shell--sub">
    @include('layouts.partials.admin-sidebar')

    <main class="admin-main">
        @include('layouts.partials.admin-topbar', ['title' => 'Transaksi', 'solid' => true])

        <div class="admin-content">
            <nav class="lap-crumb" aria-label="Breadcrumb">
                <a href="{{ route('admin.laporan.index') }}">Laporan</a>
                <svg class="ic"><use href="#i-chevron"/></svg>
                <strong>{{ $jenis === 'masuk' ? 'Kas Masuk' : 'Kas Keluar' }}</strong>
            </nav>

            @if (session('status'))
                <div class="lap-flash" role="status">{{ session('status') }}</div>
            @endif

            @include('laporan.partials._tabs', ['mode' => 'page', 'aktif' => $jenis === 'masuk' ? 'kas-masuk' : 'kas-keluar'])

            @include('laporan.partials._kas', ['formAction' => route('admin.laporan.kas', $jenis)])
        </div>
    </main>
</div>
@endsection
