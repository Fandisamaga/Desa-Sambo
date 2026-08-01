<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\Berita;
use App\Models\DokumenPublik;
use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\ProdukUmkm;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            ['label' => 'Berita', 'value' => Berita::count(), 'note' => Berita::where('status', 'publish')->count() . ' publish', 'route' => 'admin.berita.index'],
            ['label' => 'Produk UMKM', 'value' => ProdukUmkm::count(), 'note' => 'Produk terdaftar', 'route' => 'admin.produk-umkm.index'],
            ['label' => 'Dokumen Publik', 'value' => DokumenPublik::count(), 'note' => 'Tampil di PPID', 'route' => 'admin.dokumen-publik.index'],
            ['label' => 'Pengaduan', 'value' => Pengaduan::count(), 'note' => 'Laporan warga', 'route' => 'admin.pengaduan.index'],
        ];

        $activities = [
            ['icon' => 'B', 'text' => optional(Berita::latest()->first())->judul ?? 'Belum ada berita.', 'time' => 'Berita terbaru', 'route' => 'admin.berita.index'],
            ['icon' => 'U', 'text' => optional(ProdukUmkm::latest()->first())->nama_produk ?? 'Belum ada produk UMKM.', 'time' => 'Produk terbaru', 'route' => 'admin.produk-umkm.index'],
            ['icon' => 'D', 'text' => optional(DokumenPublik::latest('tahun')->first())->judul_dokumen ?? 'Belum ada dokumen publik.', 'time' => 'Dokumen PPID terbaru', 'route' => 'admin.dokumen-publik.index'],
            ['icon' => 'L', 'text' => optional(Pengaduan::latest()->first())->nama_pengirim ?? 'Belum ada pengaduan.', 'time' => 'Pengaduan terbaru', 'route' => 'admin.pengaduan.index'],
            ['icon' => 'P', 'text' => Penduduk::count() . ' penduduk / ' . KartuKeluarga::count() . ' KK', 'time' => 'Data kependudukan', 'route' => 'admin.penduduk.index'],
            ['icon' => 'A', 'text' => optional(Apbdes::latest('tahun')->first())->tahun ?? 'Belum ada APBDes.', 'time' => 'APBDes terbaru', 'route' => 'admin.apbdes.index'],
        ];

        return view('admin.dashboard', compact('stats', 'activities'));
    }
}
