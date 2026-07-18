<?php

use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

$navigation = [
    ['label' => 'Beranda', 'route' => 'home', 'url' => '/', 'icon' => '⌂'],
    ['label' => 'Profil Desa', 'route' => 'profil', 'url' => '/profil-desa', 'icon' => '◈'],
    ['label' => 'Berita', 'route' => 'berita', 'url' => '/berita', 'icon' => '◫'],
    ['label' => 'Info Grafis', 'route' => 'infografis', 'url' => '/info-grafis', 'icon' => 'IG'],
    ['label' => 'UMKM Desa', 'route' => 'umkm', 'url' => '/umkm', 'icon' => '♧'],
    ['label' => 'Program KKN', 'route' => 'kkn', 'url' => '/program-kkn', 'icon' => '✦'],
    ['label' => 'Layanan', 'route' => 'layanan', 'url' => '/layanan', 'icon' => '✉'],
];

$umkmListings = [
    [
        'name' => 'Kios Arul',
        'owner' => 'Nur Ita',
        'type' => 'Jualan sembako & voucher internet',
        'category' => 'Sembako & Voucher',
        'address' => 'RT 7 Dusun 4',
        'phone' => '082259494859',
        'contactName' => 'Ibu Risa',
        'whatsappUrl' => 'https://wa.me/6282259494859',
        'hours' => '06.30 - 22.00',
        'products' => ['Sembako', 'Voucher internet'],
        'mapUrl' => 'https://maps.app.goo.gl/bdEhJqaXLe5dwcVY8?g_st=ac',
        'photo' => null,
        'note' => '-',
        'description' => 'Kios warga yang menyediakan kebutuhan harian dan voucher internet untuk masyarakat sekitar.',
        'icon' => 'KA',
        'color' => 'umkm-sage',
    ],
];

Route::get('/', function () use ($navigation, $umkmListings) {
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
        'umkm' => $umkmListings,
    ]);
})->name('home');

Route::get('/info-grafis', function () use ($navigation) {
    return view('pages.info-grafis', [
        'title' => 'Info Grafis | Desa Sambo',
        'navigation' => $navigation,
        'infographicTabs' => [
            ['key' => 'penduduk', 'label' => 'Penduduk', 'title' => 'Data Penduduk'],
            ['key' => 'apbdes', 'label' => 'APBDes', 'title' => 'APBDes'],
            ['key' => 'stunting', 'label' => 'Stunting', 'title' => 'Stunting'],
        ],
        'populationStats' => [
            'summary' => [
                ['label' => 'Jumlah Penduduk', 'value' => '1.248', 'unit' => 'Jiwa', 'description' => 'Total warga yang tercatat dalam administrasi desa.', 'tone' => 'emerald'],
                ['label' => 'Kepala Keluarga', 'value' => '363', 'unit' => 'KK', 'description' => 'Jumlah keluarga yang terdata di seluruh dusun.', 'tone' => 'amber'],
                ['label' => 'Laki-laki', 'value' => '628', 'unit' => 'Jiwa', 'description' => '50,3% dari total penduduk Desa Sambo.', 'tone' => 'sky'],
                ['label' => 'Perempuan', 'value' => '620', 'unit' => 'Jiwa', 'description' => '49,7% dari total penduduk Desa Sambo.', 'tone' => 'rose'],
            ],
            'gender' => [
                ['label' => 'Laki-laki', 'value' => '628', 'percent' => 50.3, 'tone' => 'sky'],
                ['label' => 'Perempuan', 'value' => '620', 'percent' => 49.7, 'tone' => 'rose'],
            ],
            'ageGroups' => [
                ['label' => '0-5', 'value' => '92', 'percent' => 7.4],
                ['label' => '6-12', 'value' => '151', 'percent' => 12.1],
                ['label' => '13-17', 'value' => '116', 'percent' => 9.3],
                ['label' => '18-30', 'value' => '244', 'percent' => 19.6],
                ['label' => '31-45', 'value' => '287', 'percent' => 23],
                ['label' => '46-60', 'value' => '210', 'percent' => 16.8],
                ['label' => '60+', 'value' => '148', 'percent' => 11.8],
            ],
            'jobs' => [
                ['label' => 'Petani', 'value' => '312', 'percent' => 25],
                ['label' => 'Pelajar/Mahasiswa', 'value' => '241', 'percent' => 19.3],
                ['label' => 'Ibu Rumah Tangga', 'value' => '196', 'percent' => 15.7],
                ['label' => 'Wiraswasta', 'value' => '128', 'percent' => 10.3],
                ['label' => 'Buruh', 'value' => '84', 'percent' => 6.7],
                ['label' => 'ASN/TNI/Polri', 'value' => '23', 'percent' => 1.8],
                ['label' => 'Belum/Tidak Bekerja', 'value' => '264', 'percent' => 21.2],
            ],
            'religions' => [
                ['label' => 'Islam', 'value' => '1.224', 'percent' => 98.1],
                ['label' => 'Kristen', 'value' => '16', 'percent' => 1.3],
                ['label' => 'Katolik', 'value' => '6', 'percent' => 0.5],
                ['label' => 'Hindu', 'value' => '2', 'percent' => 0.1],
            ],
        ],
        'apbdesStats' => [
            'location' => 'Desa Sambo, Kecamatan Dolo Selatan, Kabupaten Sigi, Provinsi Sulawesi Tengah',
            'years' => [
                [
                    'year' => '2024',
                    'income' => 1285000000,
                    'spending' => 1218000000,
                    'financingIncome' => 45000000,
                    'financingExpense' => 18000000,
                    'incomeItems' => [
                        ['label' => 'Dana Desa', 'amount' => 780000000],
                        ['label' => 'Alokasi Dana Desa', 'amount' => 360000000],
                        ['label' => 'Bagi Hasil Pajak dan Retribusi', 'amount' => 95000000],
                        ['label' => 'Pendapatan Asli Desa', 'amount' => 50000000],
                    ],
                    'spendingItems' => [
                        ['label' => 'Penyelenggaraan Pemerintahan', 'amount' => 365000000],
                        ['label' => 'Pembangunan Desa', 'amount' => 485000000],
                        ['label' => 'Pembinaan Kemasyarakatan', 'amount' => 122000000],
                        ['label' => 'Pemberdayaan Masyarakat', 'amount' => 168000000],
                        ['label' => 'Penanggulangan Bencana', 'amount' => 78000000],
                    ],
                ],
                [
                    'year' => '2025',
                    'income' => 1398000000,
                    'spending' => 1326000000,
                    'financingIncome' => 57000000,
                    'financingExpense' => 24000000,
                    'incomeItems' => [
                        ['label' => 'Dana Desa', 'amount' => 840000000],
                        ['label' => 'Alokasi Dana Desa', 'amount' => 392000000],
                        ['label' => 'Bagi Hasil Pajak dan Retribusi', 'amount' => 106000000],
                        ['label' => 'Pendapatan Asli Desa', 'amount' => 60000000],
                    ],
                    'spendingItems' => [
                        ['label' => 'Penyelenggaraan Pemerintahan', 'amount' => 384000000],
                        ['label' => 'Pembangunan Desa', 'amount' => 548000000],
                        ['label' => 'Pembinaan Kemasyarakatan', 'amount' => 136000000],
                        ['label' => 'Pemberdayaan Masyarakat', 'amount' => 178000000],
                        ['label' => 'Penanggulangan Bencana', 'amount' => 80000000],
                    ],
                ],
                [
                    'year' => '2026',
                    'income' => 1465000000,
                    'spending' => 1388000000,
                    'financingIncome' => 85000000,
                    'financingExpense' => 25000000,
                    'incomeItems' => [
                        ['label' => 'Dana Desa', 'amount' => 890000000],
                        ['label' => 'Alokasi Dana Desa', 'amount' => 405000000],
                        ['label' => 'Bagi Hasil Pajak dan Retribusi', 'amount' => 112000000],
                        ['label' => 'Pendapatan Asli Desa', 'amount' => 58000000],
                    ],
                    'spendingItems' => [
                        ['label' => 'Penyelenggaraan Pemerintahan', 'amount' => 398000000],
                        ['label' => 'Pembangunan Desa', 'amount' => 585000000],
                        ['label' => 'Pembinaan Kemasyarakatan', 'amount' => 146000000],
                        ['label' => 'Pemberdayaan Masyarakat', 'amount' => 184000000],
                        ['label' => 'Penanggulangan Bencana', 'amount' => 75000000],
                    ],
                ],
            ],
        ],
    ]);
})->name('infografis');

Route::get('/umkm', function () use ($navigation, $umkmListings) {
    return view('pages.umkm', [
        'title' => 'UMKM Desa Sambo',
        'navigation' => $navigation,
        'umkmListings' => $umkmListings,
        'stats' => [
            ['label' => 'UMKM terdata', 'value' => count($umkmListings)],
            ['label' => 'Jenis usaha', 'value' => collect($umkmListings)->pluck('category')->unique()->count()],
            ['label' => 'Dusun aktif', 'value' => collect($umkmListings)->pluck('address')->unique()->count()],
        ],
    ]);
})->name('umkm');

foreach ([
    '/profil-desa' => ['name' => 'profil', 'heading' => 'Profil Desa'],
    '/berita' => ['name' => 'berita', 'heading' => 'Berita Desa'],
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
