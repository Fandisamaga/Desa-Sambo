<?php

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
