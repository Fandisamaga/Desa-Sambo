<?php

namespace App\Http\Controllers;

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
        return [
            'focus' => $focus,
        ];
    }
}
