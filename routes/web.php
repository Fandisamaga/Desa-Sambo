<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\ProdukUmkmController;
use Illuminate\Support\Facades\Route;

$navigation = [
    ['label' => 'Beranda', 'route' => 'home', 'url' => '/', 'icon' => '⌂'],
    ['label' => 'Profil Desa', 'route' => 'profil', 'url' => '/profil-desa', 'icon' => '◈'],
    ['label' => 'Berita', 'route' => 'berita', 'url' => '/berita', 'icon' => '◫'],
    ['label' => 'UMKM Desa', 'route' => 'umkm', 'url' => '/umkm', 'icon' => '♧'],
    ['label' => 'Program KKN', 'route' => 'kkn', 'url' => '/program-kkn', 'icon' => '✦'],
    ['label' => 'Layanan', 'route' => 'layanan', 'url' => '/layanan', 'icon' => '✉'],
];

Route::get('/', function () use ($navigation) {
    return view('pages.home', [
        'title' => 'Desa Sambo | Website Resmi',
        'navigation' => $navigation,
        'services' => [
            ['icon' => '📝', 'title' => 'Surat Pengantar', 'description' => 'Ajukan surat pengantar dari rumah.'],
            ['icon' => '👨‍👩‍👧', 'title' => 'Data Kependudukan', 'description' => 'Informasi dan pembaruan data warga.'],
            ['icon' => '📣', 'title' => 'Aspirasi Warga', 'description' => 'Sampaikan saran dan laporan Anda.'],
            ['icon' => '📅', 'title' => 'Jadwal Kegiatan', 'description' => 'Agenda desa dan kegiatan masyarakat.'],
        ],
        'news' => [
            ['category' => 'Kegiatan Desa', 'title' => 'Musyawarah warga untuk program 2026', 'excerpt' => 'Warga dan perangkat desa menyusun prioritas pembangunan bersama.', 'date' => '12 Juli 2026'],
            ['category' => 'KKN', 'title' => 'Mahasiswa KKN mulai program literasi digital', 'excerpt' => 'Pelatihan praktis untuk mendampingi warga menggunakan layanan digital.', 'date' => '8 Juli 2026'],
        ],
        'umkm' => [
            ['icon' => '🍪', 'name' => 'Dapur Sambo', 'category' => 'Kuliner', 'owner' => 'Aneka kue & camilan rumahan', 'color' => 'umkm-cream'],
            ['icon' => '🧺', 'name' => 'Anyam Lestari', 'category' => 'Kerajinan', 'owner' => 'Anyaman khas karya warga', 'color' => 'umkm-sage'],
            ['icon' => '🌿', 'name' => 'Kebun Hijau', 'category' => 'Pertanian', 'owner' => 'Sayur segar hasil kebun lokal', 'color' => 'umkm-sky'],
        ],
    ]);
})->name('home');

foreach ([
    '/profil-desa' => ['name' => 'profil', 'heading' => 'Profil Desa'],
    '/berita' => ['name' => 'berita', 'heading' => 'Berita Desa'],
    '/umkm' => ['name' => 'umkm', 'heading' => 'UMKM Desa Sambo'],
    '/program-kkn' => ['name' => 'kkn', 'heading' => 'Program KKN'],
    '/layanan' => ['name' => 'layanan', 'heading' => 'Layanan Masyarakat'],
] as $path => $page) {
    Route::view($path, 'pages.placeholder', [
        'title' => $page['heading'].' | Desa Sambo',
        'heading' => $page['heading'],
        'navigation' => $navigation,
    ])->name($page['name']);
}

$adminNavigation = [
    ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'url' => '/admin', 'icon' => 'D'],
    ['label' => 'Kelola Berita', 'route' => 'admin.berita.*', 'url' => '/admin/berita', 'icon' => 'B'],
    ['label' => 'Kelola UMKM', 'route' => 'admin.umkm.*', 'url' => '/admin/umkm', 'icon' => 'U'],
    ['label' => 'Layanan Masuk', 'route' => 'admin.layanan.*', 'url' => '/admin/layanan', 'icon' => 'L'],
];

Route::resource('kategori-surat', KategoriSuratController::class);
Route::resource('arsip-surat', ArsipSuratController::class);
Route::resource('apbdes', ApbdesController::class);
Route::resource('produk-umkm', ProdukUmkmController::class);
Route::resource('berita', BeritaController::class);
Route::resource('kategori-berita', KategoriBeritaController::class);

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () use ($adminNavigation) {
    Route::get('/', function () use ($adminNavigation) {
        return view('admin.dashboard', [
            'title' => 'Dashboard Operator | Desa Sambo', 'heading' => 'Dashboard', 'adminNavigation' => $adminNavigation,
            'stats' => [
                ['label' => 'Berita dipublikasikan', 'value' => '0', 'note' => 'Siap dikelola'],
                ['label' => 'UMKM terdaftar', 'value' => '0', 'note' => 'Siap ditambahkan'],
                ['label' => 'Layanan masuk', 'value' => '0', 'note' => 'Belum ada pengajuan'],
                ['label' => 'Pengunjung hari ini', 'value' => '-', 'note' => 'Integrasi analitik nanti'],
            ],
            'activities' => [
                ['icon' => 'B', 'text' => 'Modul berita siap untuk dibuatkan CRUD.', 'time' => 'Template awal'],
                ['icon' => 'U', 'text' => 'Etalase UMKM siap menerima data produk.', 'time' => 'Template awal'],
                ['icon' => 'L', 'text' => 'Pengajuan layanan akan tampil di sini.', 'time' => 'Template awal'],
            ],
        ]);
    })->name('dashboard');

    foreach (['berita' => ['resource' => 'Berita Desa', 'singular' => 'berita'], 'umkm' => ['resource' => 'UMKM Desa', 'singular' => 'UMKM'], 'layanan' => ['resource' => 'Pengajuan Layanan', 'singular' => 'pengajuan']] as $slug => $resource) {
        Route::get('/'.$slug, function () use ($adminNavigation, $resource) {
            return view('admin.resource-index', ['title' => $resource['resource'].' | Operator Desa Sambo', 'heading' => $resource['resource'], 'resource' => $resource['resource'], 'singular' => $resource['singular'], 'adminNavigation' => $adminNavigation]);
        })->name($slug.'.index');
    }

    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});