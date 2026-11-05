<?php

namespace App\Http\Controllers;

use App\Models\KategoriDana;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * ASUMSI SKEMA (sesuaikan dengan project Anda):
 *  - Transaksi: id, tanggal (date, di-cast ke Carbon), kategori_id, jenis ('masuk'|'keluar'), uraian, jumlah (integer)
 *              relasi kategori() => belongsTo(KategoriDana::class)
 *  - KategoriDana: id, nama
 */
class LaporanController extends Controller
{
    private const TABS = ['kas-masuk', 'kas-keluar', 'rekap-bulanan', 'laporan-bulanan'];
    private const PER_PAGE = [20, 30, 50];
    private const TONE = [
        'Kas Masjid' => 'green',
        "Kotak Jum'at Berkah" => 'blue',
        'Kotak Pembangunan & Pemeliharaan' => 'orange',
    ];

    /** Halaman utama laporan (hub). */
    public function index(Request $request)
    {
        $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'bulan' => ['nullable', 'date_format:Y-m'],
        ]);

        [$mulai, $akhir, $judul, $preset, $bulan] = $this->periode($request);
        $tab = in_array($request->query('tab'), self::TABS, true) ? $request->query('tab') : 'kas-masuk';

        $data = [
            'tone' => self::TONE,
            'tab' => $tab,
            'judul' => $judul,
            'preset' => $preset,
            'bulan' => $bulan ?? $mulai->format('Y-m'),
            'dari' => $mulai->toDateString(),
            'sampai' => $akhir->toDateString(),
            'bulanOptions' => $this->bulanOptions(),
            'resume' => $this->resume($mulai, $akhir),
            'masuk' => $this->transaksiPeriode('masuk', $mulai, $akhir),
            'keluar' => $this->transaksiPeriode('keluar', $mulai, $akhir),
        ];

        if ($tab === 'kas-masuk') {
            $data += $this->kasData($request, 'masuk');
        } elseif ($tab === 'kas-keluar') {
            $data += $this->kasData($request, 'keluar');
        } elseif ($tab === 'rekap-bulanan') {
            $data += $this->rekapData($request);
        }

        return view('laporan.index', $data);
    }

    /** Halaman Kas Masuk / Kas Keluar mandiri (berpaginasi). */
    public function kas(Request $request, string $jenis)
    {
        abort_unless(in_array($jenis, ['masuk', 'keluar'], true), 404);

        return view('laporan.kas', ['tone' => self::TONE, 'jenis' => $jenis] + $this->kasData($request, $jenis));
    }

    public function show(string $jenis, Transaksi $transaksi)
    {
        abort_unless($transaksi->jenis === $jenis, 404);

        return view('laporan.show', [
            'tone' => self::TONE,
            'jenis' => $jenis,
            'transaksi' => $transaksi->load('kategori'),
        ]);
    }

    public function edit(string $jenis, Transaksi $transaksi)
    {
        abort_unless($transaksi->jenis === $jenis, 404);

        // TODO: ganti dengan form edit transaksi milik Anda, misalnya:
        // return redirect()->route('transaksi.edit', $transaksi);
        abort(501, 'Form edit belum dihubungkan.');
    }

    public function destroy(Request $request, string $jenis, Transaksi $transaksi)
    {
        abort_unless($transaksi->jenis === $jenis, 404);
        $request->validate(['konfirmasi' => ['required', 'in:HAPUS']], [
            'konfirmasi.in' => 'Ketik HAPUS (huruf kapital) untuk mengonfirmasi.',
        ]);

        $transaksi->delete();

        return redirect()->route('admin.laporan.kas', $jenis)->with('status', 'Transaksi berhasil dihapus.');
    }

    // ---------------------------------------------------------------------

    private function kasData(Request $request, string $jenis): array
    {
        $q = trim((string) $request->query('q', ''));
        $dasar = Transaksi::where('jenis', $jenis);

        $query = Transaksi::with('kategori')
            ->where('jenis', $jenis)
            ->when($q !== '', fn ($s) => $s->where(fn ($w) => $w
                ->where('uraian', 'like', "%{$q}%")
                ->orWhereHas('kategori', fn ($k) => $k->where('nama', 'like', "%{$q}%"))))
            ->orderBy('tanggal')
            ->orderBy('id');

        $difilter = (clone $query)->count();

        return [
            'q' => $q,
            'total' => (int) (clone $dasar)->sum('jumlah'),
            'count' => (clone $dasar)->count(),
            'items' => $query->paginate($this->perPage($request, $difilter))->withQueryString(),
        ];
    }

    private function perPage(Request $request, int $jumlahData): int
    {
        $pp = $request->query('per_page', '20');

        if ($pp === 'all') {
            return max($jumlahData, 1); // "Semua": satu halaman berisi seluruh data
        }

        return in_array((int) $pp, self::PER_PAGE, true) ? (int) $pp : 20;
    }

    private function periode(Request $request): array
    {
        if ($request->filled('dari') && $request->filled('sampai')) {
            $mulai = Carbon::parse($request->query('dari'))->startOfDay();
            $akhir = Carbon::parse($request->query('sampai'))->endOfDay();

            return [$mulai, $akhir, $mulai->translatedFormat('d M Y') . ' - ' . $akhir->translatedFormat('d M Y'), 'kustom', null];
        }

        $sekarang = now()->endOfDay();
        $preset = [
            '1-minggu' => [now()->subWeek()->startOfDay(), '1 Minggu Terakhir'],
            '1-bulan' => [now()->subMonth()->startOfDay(), '1 Bulan Terakhir'],
            '3-bulan' => [now()->subMonths(3)->startOfDay(), '3 Bulan Terakhir'],
        ][$request->query('preset')] ?? null;

        if ($preset) {
            return [$preset[0], $sekarang, $preset[1], $request->query('preset'), null];
        }

        $bulan = $request->query('bulan', now()->format('Y-m'));
        $awal = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();

        return [$awal, $awal->copy()->endOfMonth(), $awal->translatedFormat('F Y'), 'bulan', $bulan];
    }

    private function bulanOptions(): array
    {
        $opsi = [];
        for ($i = 0; $i < 12; $i++) {
            $b = now()->startOfMonth()->subMonths($i);
            $opsi[$b->format('Y-m')] = $b->translatedFormat('F Y');
        }

        return $opsi;
    }

    private function transaksiPeriode(string $jenis, Carbon $mulai, Carbon $akhir)
    {
        return Transaksi::with('kategori')
            ->where('jenis', $jenis)
            ->whereBetween('tanggal', [$mulai, $akhir])
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();
    }

    /** Saldo awal / pemasukan / pengeluaran / saldo akhir per kategori untuk satu periode. */
    private function resume(Carbon $mulai, Carbon $akhir): array
    {
        $rows = KategoriDana::orderBy('id')->get()->map(function ($k) use ($mulai, $akhir) {
            $awal = $this->saldoSebelum($k->id, $mulai);
            $masuk = (int) Transaksi::where('kategori_id', $k->id)->where('jenis', 'masuk')->whereBetween('tanggal', [$mulai, $akhir])->sum('jumlah');
            $keluar = (int) Transaksi::where('kategori_id', $k->id)->where('jenis', 'keluar')->whereBetween('tanggal', [$mulai, $akhir])->sum('jumlah');

            return ['nama' => $k->nama, 'awal' => $awal, 'masuk' => $masuk, 'keluar' => $keluar, 'akhir' => $awal + $masuk - $keluar];
        });

        return [
            'rows' => $rows,
            'total' => [
                'awal' => $rows->sum('awal'),
                'masuk' => $rows->sum('masuk'),
                'keluar' => $rows->sum('keluar'),
                'akhir' => $rows->sum('akhir'),
            ],
        ];
    }

    private function saldoSebelum(int $kategoriId, Carbon $tanggal): int
    {
        $masuk = Transaksi::where('kategori_id', $kategoriId)->where('jenis', 'masuk')->where('tanggal', '<', $tanggal)->sum('jumlah');
        $keluar = Transaksi::where('kategori_id', $kategoriId)->where('jenis', 'keluar')->where('tanggal', '<', $tanggal)->sum('jumlah');

        return (int) ($masuk - $keluar);
    }

    private function rekapData(Request $request): array
    {
        $tahun = (int) $request->query('tahun', now()->year);

        $rekap = collect(range(1, 12))->map(function ($m) use ($tahun) {
            $awal = Carbon::create($tahun, $m, 1)->startOfMonth();

            return [
                'nama' => $awal->translatedFormat('F'),
                'singkat' => strtoupper($awal->translatedFormat('M')),
                'tahun' => $tahun,
            ] + $this->resume($awal, $awal->copy()->endOfMonth());
        });

        return [
            'rekap' => $rekap,
            'tahun' => $tahun,
            'tahunOptions' => range(now()->year, now()->year - 4),
        ];
    }
}
