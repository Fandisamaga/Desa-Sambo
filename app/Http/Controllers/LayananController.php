<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Models\KategoriSurat;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function index(): View
    {
        return view('pages.layanan', $this->getLayananPageData());
    }

    public function domisili(): View
    {
        return view('pages.layanan', $this->getLayananPageData('domisili'));
    }

    public function pengantar(): View
    {
        return view('pages.layanan', $this->getLayananPageData('pengantar'));
    }

    public function pengaduan(): View
    {
        return view('pages.layanan', $this->getLayananPageData('pengaduan'));
    }

    private function getLayananPageData(?string $focus = null): array
    {
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
    }
}
