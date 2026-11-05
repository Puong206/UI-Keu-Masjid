<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

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

// ==================== ADMIN ====================
Route::get('/admin/login', function () {
    if (Auth::check() && strtolower((string) Auth::user()->role) === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('pages.admin.login');
})->name('admin.login');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    if (strtolower((string) Auth::user()->role) !== 'admin' || strtolower((string) Auth::user()->status) !== 'aktif') {
        Auth::logout();

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Akun tidak memiliki akses admin aktif.',
        ]);
    }

    $request->session()->regenerate();

    return redirect()->intended(route('admin.dashboard'));
})->name('admin.login.attempt');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::get('/admin/dashboard', function () {
    if (!Auth::check() || strtolower((string) Auth::user()->role) !== 'admin') {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    return view('pages.admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/laporan', function () {
    if (!Auth::check() || strtolower((string) Auth::user()->role) !== 'admin') {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    $rows = Transaksi::query()->orderByDesc('tanggal')->orderByDesc('id')->get();
    $pemasukan = $rows->where('jenis', 'MASUK')->values();
    $pengeluaran = $rows->where('jenis', 'KELUAR')->values();
    $formatRows = static function ($items): array {
        return $items->map(static function (Transaksi $item): array {
            return [
                'title' => $item->uraian,
                'date' => $item->tanggal->format('j F Y'),
                'category' => $item->nama_kategori,
                'cat_color' => 'green',
                'amount' => number_format((float) $item->nominal, 0, ',', '.'),
            ];
        })->all();
    };
    $reportData = [
        'pemasukan' => $formatRows($pemasukan),
        'pengeluaran' => $formatRows($pengeluaran),
        'total_pemasukan' => number_format((float) $pemasukan->sum('nominal'), 0, ',', '.'),
        'total_pengeluaran' => number_format((float) $pengeluaran->sum('nominal'), 0, ',', '.'),
        'count_pemasukan' => $pemasukan->count(),
        'count_pengeluaran' => $pengeluaran->count(),
    ];

    return view('pages.admin.laporan', [
        'data' => $reportData,
        'tab' => request()->query('tab', 'masuk'),
        'page' => max(1, (int) request()->query('page', 1)),
        'search' => trim((string) request()->query('search', '')),
    ]);
})->name('admin.laporan');

Route::get('/admin/laporan/transaksi/{type}', function (string $type) {
    abort_unless(in_array($type, ['masuk', 'keluar'], true), 404);

    return redirect()->route('admin.laporan', [
        'tab' => $type,
        'page' => request()->query('page', 1),
        'search' => request()->query('search', ''),
    ]);
})->name('admin.laporan.transactions');

Route::get('/admin/laporan/transaksi/{type}/{index}', function (string $type, int $index) {
    abort_unless(in_array($type, ['masuk', 'keluar'], true), 404);
    $item = Transaksi::query()
        ->where('jenis', strtoupper($type))
        ->orderByDesc('tanggal')
        ->orderByDesc('id')
        ->skip($index)
        ->firstOrFail();

    return view('pages.admin.laporan-detail', [
        'item' => [
            'title' => $item->uraian,
            'date' => $item->tanggal->format('j F Y'),
            'category' => $item->nama_kategori,
            'amount' => number_format((float) $item->nominal, 0, ',', '.'),
        ],
        'type' => $type,
    ]);
})->name('admin.laporan.transaction.detail');

// ==================== LAPORAN KEUANGAN PUBLIK ====================
Route::post('/laporan/akses', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'token' => ['required', 'string'],
    ], [
        'token.required' => 'Kode akses wajib diisi.',
    ]);

    $validToken = (string) config('report.access_token');
    if ($validToken === '' || !hash_equals($validToken, (string) $request->input('token'))) {
        return back()->withInput()->with([
            'open_laporan_access' => true,
        ])->withErrors([
            'token' => 'Kode akses tidak valid. Silakan coba lagi.',
        ]);
    }

    $request->session()->put('laporan.verified', true);

    return redirect()->intended(route('laporan.index'));
})->name('laporan.access.verify');

Route::get('/laporan', function () {
    if (!session('laporan.verified')) {
        return redirect()->route('home');
    }

    return view('pages.laporan.index');
})->name('laporan.index');

Route::get('/laporan/unduh', function () {
    if (!session('laporan.verified')) {
        return redirect()->route('home');
    }

    return view('pages.laporan.export-format');
})->name('laporan.export.format');

Route::get('/laporan/pratinjau', function () {
    if (!session('laporan.verified')) {
        return redirect()->route('home');
    }

    return view('pages.laporan.export-preview');
})->name('laporan.export.preview');
