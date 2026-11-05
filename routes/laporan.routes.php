<?php

// Tempel di routes/web.php (di dalam grup middleware admin/auth yang sudah ada).

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/laporan')->name('admin.laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');

    Route::get('{jenis}', [LaporanController::class, 'kas'])
        ->whereIn('jenis', ['masuk', 'keluar'])->name('kas');

    Route::get('{jenis}/{transaksi}', [LaporanController::class, 'show'])
        ->whereIn('jenis', ['masuk', 'keluar'])->name('show');

    Route::delete('{jenis}/{transaksi}', [LaporanController::class, 'destroy'])
        ->whereIn('jenis', ['masuk', 'keluar'])->name('destroy');

    // Arahkan ke form edit transaksi yang sudah Anda punya.
    Route::get('{jenis}/{transaksi}/edit', [LaporanController::class, 'edit'])
        ->whereIn('jenis', ['masuk', 'keluar'])->name('edit');
});
