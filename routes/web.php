<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriBeritaController;
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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::view('/berita', 'admin.resource-index')->name('berita.index');
    Route::view('/umkm', 'admin.resource-index')->name('umkm.index');
    Route::view('/layanan', 'admin.resource-index')->name('layanan.index');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});