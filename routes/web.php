<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenPublikController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProdukUmkmController;
use App\Models\Apbdes;
use App\Models\ArsipSurat;
use App\Models\KartuKeluarga;
use App\Models\KategoriSurat;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\ProdukUmkm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

$layananPageData = function (?string $focus = null): array {
    $kategoriSurat = Schema::hasTable('kategori_surat')
        ? KategoriSurat::query()->orderBy('nama_kategori')->pluck('nama_kategori')
        : collect();

    $availableSurat = $kategoriSurat->isNotEmpty()
        ? $kategoriSurat
        : collect(['Surat Keterangan Domisili', 'Surat Pengantar KK/KTP', 'Surat Keterangan Usaha']);

    $statusCounts = [
        'pending' => 0,
        'diproses' => 0,
        'selesai' => 0,
        'ditolak' => 0,
    ];

    if (Schema::hasTable('pengaduan')) {
        foreach (array_keys($statusCounts) as $status) {
            $statusCounts[$status] = Pengaduan::query()->where('status', $status)->count();
        }
    }

    return [
        'focus' => $focus,
        'kategoriSurat' => $availableSurat,
        'stats' => [
            ['label' => 'Kategori surat', 'value' => $availableSurat->count(), 'note' => 'Dari CRUD Kategori Surat'],
            ['label' => 'Arsip diterbitkan', 'value' => Schema::hasTable('arsip_surat') ? ArsipSurat::query()->count() : 0, 'note' => 'Tercatat di Arsip Surat'],
            ['label' => 'Pengaduan masuk', 'value' => array_sum($statusCounts), 'note' => 'Dikelola operator desa'],
            ['label' => 'Menunggu tindak lanjut', 'value' => $statusCounts['pending'], 'note' => 'Status pending'],
        ],
        'statusCounts' => $statusCounts,
    ];
};

Route::get('/', function () {
    return view('pages.home', [
        'featuredUmkm' => Schema::hasTable('produk_umkm') ? ProdukUmkm::latest()->take(3)->get() : collect(),
    ]);
})->name('home');
Route::view('/profil-desa', 'pages.profil')->name('profil');
Route::get('/info-grafis', function () {
    $penduduk = Schema::hasTable('penduduk') ? Penduduk::query()->get(['tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'agama']) : collect();
    $totalPenduduk = $penduduk->count();
    $totalKk = Schema::hasTable('kartu_keluarga') ? KartuKeluarga::query()->count() : 0;
    $totalLakiLaki = $penduduk->where('jenis_kelamin', 'Laki-laki')->count();
    $totalPerempuan = $penduduk->where('jenis_kelamin', 'Perempuan')->count();
    $percent = fn (int $value, int $total = null) => ($total ?? $totalPenduduk) > 0 ? round(($value / ($total ?? $totalPenduduk)) * 100, 1) : 0;
    $formatCount = fn (int $value) => number_format($value, 0, ',', '.');

    $ageBuckets = [
        '0-5' => 0,
        '6-12' => 0,
        '13-17' => 0,
        '18-30' => 0,
        '31-45' => 0,
        '46-60' => 0,
        '60+' => 0,
    ];

    foreach ($penduduk as $item) {
        if (! $item->tanggal_lahir) {
            continue;
        }

        $age = $item->tanggal_lahir->age;
        $bucket = match (true) {
            $age <= 5 => '0-5',
            $age <= 12 => '6-12',
            $age <= 17 => '13-17',
            $age <= 30 => '18-30',
            $age <= 45 => '31-45',
            $age <= 60 => '46-60',
            default => '60+',
        };
        $ageBuckets[$bucket]++;
    }

    $groupStats = function (string $field) use ($penduduk, $percent, $formatCount) {
        return $penduduk
            ->groupBy(fn ($item) => trim((string) $item->{$field}) ?: 'Belum diisi')
            ->map(fn ($items, $label) => [
                'label' => $label,
                'value' => $formatCount($items->count()),
                'percent' => $percent($items->count()),
            ])
            ->sortByDesc(fn ($item) => (float) $item['percent'])
            ->values();
    };

    $apbdesYears = Schema::hasTable('apbdes')
        ? Apbdes::query()
            ->orderBy('tahun')
            ->get()
            ->map(fn (Apbdes $item) => [
                'year' => (string) $item->tahun,
                'income' => $item->pendapatan,
                'spending' => $item->belanja,
                'financingIncome' => $item->penerimaan_pembiayaan,
                'financingExpense' => $item->pengeluaran_pembiayaan,
                'incomeItems' => [
                    ['label' => 'Pendapatan', 'amount' => $item->pendapatan],
                    ['label' => 'Penerimaan pembiayaan', 'amount' => $item->penerimaan_pembiayaan],
                ],
                'spendingItems' => [
                    ['label' => 'Belanja', 'amount' => $item->belanja],
                    ['label' => 'Pengeluaran pembiayaan', 'amount' => $item->pengeluaran_pembiayaan],
                ],
            ])
            ->values()
        : collect();

    return view('pages.info-grafis', [
        'populationStats' => [
            'summary' => [
                ['label' => 'Jumlah Penduduk', 'value' => $formatCount($totalPenduduk), 'unit' => 'Jiwa', 'description' => 'Total warga yang tercatat pada CRUD Penduduk.', 'tone' => 'emerald'],
                ['label' => 'Kepala Keluarga', 'value' => $formatCount($totalKk), 'unit' => 'KK', 'description' => 'Jumlah kartu keluarga yang tercatat di admin.', 'tone' => 'amber'],
                ['label' => 'Laki-laki', 'value' => $formatCount($totalLakiLaki), 'unit' => 'Jiwa', 'description' => $percent($totalLakiLaki) . '% dari total penduduk.', 'tone' => 'sky'],
                ['label' => 'Perempuan', 'value' => $formatCount($totalPerempuan), 'unit' => 'Jiwa', 'description' => $percent($totalPerempuan) . '% dari total penduduk.', 'tone' => 'rose'],
            ],
            'gender' => [
                ['label' => 'Laki-laki', 'value' => $formatCount($totalLakiLaki), 'percent' => $percent($totalLakiLaki), 'tone' => 'sky'],
                ['label' => 'Perempuan', 'value' => $formatCount($totalPerempuan), 'percent' => $percent($totalPerempuan), 'tone' => 'rose'],
            ],
            'ageGroups' => collect($ageBuckets)->map(fn ($count, $label) => [
                'label' => $label,
                'value' => $formatCount($count),
                'percent' => $percent($count),
            ])->values(),
            'jobs' => $groupStats('pekerjaan'),
            'religions' => $groupStats('agama'),
            'total' => $formatCount($totalPenduduk),
            'hasData' => $totalPenduduk > 0,
        ],
        'apbdesStats' => [
            'location' => 'Desa Sambo, Kecamatan Dolo Selatan, Kabupaten Sigi, Provinsi Sulawesi Tengah',
            'years' => $apbdesYears,
            'hasData' => $apbdesYears->isNotEmpty(),
        ],
        'stuntingStats' => [
            'hasData' => false,
        ],
    ]);
})->name('infografis');
Route::view('/berita', 'pages.placeholder')->name('berita');
Route::get('/umkm', function () {
    $produkUmkm = Schema::hasTable('produk_umkm') ? ProdukUmkm::latest()->get() : collect();

    return view('pages.umkm', [
        'produkUmkm' => $produkUmkm,
        'stats' => [
            ['label' => 'UMKM terdata', 'value' => $produkUmkm->count()],
            ['label' => 'Jenis usaha', 'value' => $produkUmkm->pluck('jenis_usaha')->filter()->unique()->count()],
            ['label' => 'Kontak tersedia', 'value' => $produkUmkm->pluck('no_whatsapp')->filter()->count()],
        ],
    ]);
})->name('umkm');
Route::view('/program-kkn', 'pages.placeholder')->name('kkn');
Route::get('/layanan', fn () => view('pages.layanan', $layananPageData()))->name('layanan');
Route::get('/layanan/surat-keterangan-domisili', fn () => view('pages.layanan', $layananPageData('domisili')))->name('layanan.domisili');
Route::get('/layanan/surat-pengantar-kk-ktp', fn () => view('pages.layanan', $layananPageData('pengantar')))->name('layanan.pengantar');
Route::get('/layanan/pengaduan-masyarakat', fn () => view('pages.layanan', $layananPageData('pengaduan')))->name('layanan.pengaduan');
Route::post('/layanan/pengaduan-masyarakat', [PengaduanController::class, 'storePublic'])->middleware('throttle:6,1')->name('layanan.pengaduan.store');

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::redirect('/layanan', '/admin/pengaduan')->name('layanan.index');

    Route::resource('kategori-surat', KategoriSuratController::class)->parameters(['kategori-surat' => 'kategoriSurat']);
    Route::resource('arsip-surat', ArsipSuratController::class)->parameters(['arsip-surat' => 'arsipSurat']);
    Route::resource('apbdes', ApbdesController::class)->parameters(['apbdes' => 'apbde']);
    Route::resource('produk-umkm', ProdukUmkmController::class)->parameters(['produk-umkm' => 'produkUmkm']);
    Route::resource('berita', BeritaController::class)->parameters(['berita' => 'berita']);
    Route::resource('kategori-berita', KategoriBeritaController::class)->parameters(['kategori-berita' => 'kategoriBerita']);
    Route::resource('kartu-keluarga', KeluargaController::class)->parameters(['kartu-keluarga' => 'kartuKeluarga']);
    Route::resource('penduduk', PendudukController::class);
    Route::resource('pengaduan', PengaduanController::class);
    Route::resource('dokumen-publik', DokumenPublikController::class)->parameters(['dokumen-publik' => 'dokumenPublik']);

    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});
