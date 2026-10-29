<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.users.home');
})->name('home');

Route::get('/agenda', function () {
    return view('pages.users.agenda');
})->name('agenda');

Route::get('/profil', function () {
    return view('pages.users.profil');
})->name('profil');

Route::get('/kontak', function () {
    return view('pages.users.kontak');
})->name('kontak');

// ==================== LAPORAN KEUANGAN PUBLIK ====================
Route::get('/laporan', function () {
    return view('pages.laporan.index');
})->name('laporan.index');

Route::get('/laporan/unduh', function () {
    return view('pages.laporan.export-format');
})->name('laporan.export.format');

Route::get('/laporan/pratinjau', function () {
    return view('pages.laporan.export-preview');
})->name('laporan.export.preview');
