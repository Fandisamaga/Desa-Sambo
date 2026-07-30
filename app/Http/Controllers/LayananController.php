<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function index(): View
    {
        return view('pages.layanan', $this->getLayananPageData());
    }

    public function pengaduan(): View
    {
        return view('pages.layanan', $this->getLayananPageData('pengaduan'));
    }

    private function getLayananPageData(?string $focus = null): array
    {
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
            'stats' => [
                ['label' => 'Pengaduan masuk', 'value' => array_sum($statusCounts), 'note' => 'Dikelola operator desa'],
                ['label' => 'Menunggu tindak lanjut', 'value' => $statusCounts['pending'], 'note' => 'Status pending'],
                ['label' => 'Sedang diproses', 'value' => $statusCounts['diproses'], 'note' => 'Dalam tindak lanjut'],
                ['label' => 'Selesai', 'value' => $statusCounts['selesai'], 'note' => 'Aduan sudah ditutup'],
            ],
            'statusCounts' => $statusCounts,
        ];
    }
}
