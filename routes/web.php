<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenPublikController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProdukUmkmController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\StuntingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/profil-desa', [PublicPageController::class, 'profil'])->name('profil');
Route::get('/info-grafis', [PublicPageController::class, 'infoGrafis'])->name('infografis');
Route::get('/berita', [PublicPageController::class, 'berita'])->name('berita');
Route::get('/berita/{berita:slug}', [PublicPageController::class, 'detailBerita'])->name('berita.detail');
Route::get('/umkm', [PublicPageController::class, 'umkm'])->name('umkm');
Route::get('/ppid', [PublicPageController::class, 'ppid'])->name('ppid');
Route::redirect('/dokumen-publik', '/ppid')->name('dokumen-publik');
Route::get('/program-kkn', [PublicPageController::class, 'programKkn'])->name('kkn');

Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::redirect('/layanan/surat-keterangan-domisili', '/layanan')->name('layanan.domisili');
Route::redirect('/layanan/surat-pengantar-kk-ktp', '/layanan')->name('layanan.pengantar');
Route::get('/layanan/pengaduan-masyarakat', [LayananController::class, 'pengaduan'])->name('layanan.pengaduan');
Route::post('/layanan/pengaduan-masyarakat', [PengaduanController::class, 'storePublic'])->middleware('throttle:6,1')->name('layanan.pengaduan.store');

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::redirect('/layanan', '/admin/pengaduan')->name('layanan.index');

    Route::resource('kategori-surat', KategoriSuratController::class)->parameters(['kategori-surat' => 'kategoriSurat']);
    Route::resource('arsip-surat', ArsipSuratController::class)->parameters(['arsip-surat' => 'arsipSurat']);
    Route::resource('apbdes', ApbdesController::class)->parameters(['apbdes' => 'apbde']);
    Route::resource('produk-umkm', ProdukUmkmController::class)->parameters(['produk-umkm' => 'produkUmkm']);
    Route::resource('berita', BeritaController::class)->parameters(['berita' => 'berita']);
    Route::resource('kartu-keluarga', KeluargaController::class)->parameters(['kartu-keluarga' => 'kartuKeluarga']);
    Route::resource('penduduk', PendudukController::class);
    Route::resource('stunting', StuntingController::class);
    Route::resource('pengaduan', PengaduanController::class);
    Route::resource('dokumen-publik', DokumenPublikController::class)->parameters(['dokumen-publik' => 'dokumenPublik']);

    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});
