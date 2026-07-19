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
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/profil-desa', 'pages.placeholder')->name('profil');
Route::view('/info-grafis', 'pages.placeholder')->name('infografis');
Route::view('/berita', 'pages.placeholder')->name('berita');
Route::view('/umkm', 'pages.placeholder')->name('umkm');
Route::view('/program-kkn', 'pages.placeholder')->name('kkn');
Route::view('/layanan', 'pages.placeholder')->name('layanan');
Route::view('/layanan/surat-keterangan-domisili', 'pages.placeholder')->name('layanan.domisili');
Route::view('/layanan/surat-pengantar-kk-ktp', 'pages.placeholder')->name('layanan.pengantar');
Route::view('/layanan/pengaduan-masyarakat', 'pages.placeholder')->name('layanan.pengaduan');

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
