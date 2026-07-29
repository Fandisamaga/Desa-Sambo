<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Models\ProdukUmkm;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'featuredUmkm' => Schema::hasTable('produk_umkm') ? ProdukUmkm::latest()->take(3)->get() : collect(),
        ]);
    }

    public function profil(): View
    {
        return view('pages.profil');
    }

    public function infoGrafis(): View
    {
        $penduduk = Schema::hasTable('penduduk')
            ? Penduduk::query()->get(['tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'agama'])
            : collect();

        $totalPenduduk = $penduduk->count();
        $totalKk = Schema::hasTable('kartu_keluarga') ? KartuKeluarga::query()->count() : 0;
        $totalLakiLaki = $penduduk->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = $penduduk->where('jenis_kelamin', 'Perempuan')->count();

        $percent = fn (int $value, int $total = null) => ($total ?? $totalPenduduk) > 0
            ? round(($value / ($total ?? $totalPenduduk)) * 100, 1)
            : 0;

        $formatCount = fn (int $value) => number_format($value, 0, ',', '.');

        $ageBuckets = $this->buildAgeBuckets($penduduk);
        $groupStats = fn (string $field) => $this->buildGroupStats($penduduk, $field, $percent, $formatCount);

        $apbdesYears = Schema::hasTable('apbdes')
            ? Apbdes::query()
                ->orderBy('tahun')
                ->get()
                ->map(fn (Apbdes $item) => [
                    'year' => (string) $item->tahun,
                    'income' => $item->pendapatan,
                    'spending' => $item->belanja,
                    'financingIncome' => $item->penerimaan_pembiayaan,
                    'financingExpense' => $item->pengeluaran_pembiayaan,
                    'incomeItems' => [
                        ['label' => 'Pendapatan', 'amount' => $item->pendapatan],
                        ['label' => 'Penerimaan pembiayaan', 'amount' => $item->penerimaan_pembiayaan],
                    ],
                    'spendingItems' => [
                        ['label' => 'Belanja', 'amount' => $item->belanja],
                        ['label' => 'Pengeluaran pembiayaan', 'amount' => $item->pengeluaran_pembiayaan],
                    ],
                ])
                ->values()
            : collect();

        return view('pages.info-grafis', [
            'populationStats' => [
                'summary' => [
                    ['label' => 'Jumlah Penduduk', 'value' => $formatCount($totalPenduduk), 'unit' => 'Jiwa', 'description' => 'Total warga yang tercatat pada CRUD Penduduk.', 'tone' => 'emerald'],
                    ['label' => 'Kepala Keluarga', 'value' => $formatCount($totalKk), 'unit' => 'KK', 'description' => 'Jumlah kartu keluarga yang tercatat di admin.', 'tone' => 'amber'],
                    ['label' => 'Laki-laki', 'value' => $formatCount($totalLakiLaki), 'unit' => 'Jiwa', 'description' => $percent($totalLakiLaki) . '% dari total penduduk.', 'tone' => 'sky'],
                    ['label' => 'Perempuan', 'value' => $formatCount($totalPerempuan), 'unit' => 'Jiwa', 'description' => $percent($totalPerempuan) . '% dari total penduduk.', 'tone' => 'rose'],
                ],
                'gender' => [
                    ['label' => 'Laki-laki', 'value' => $formatCount($totalLakiLaki), 'percent' => $percent($totalLakiLaki), 'tone' => 'sky'],
                    ['label' => 'Perempuan', 'value' => $formatCount($totalPerempuan), 'percent' => $percent($totalPerempuan), 'tone' => 'rose'],
                ],
                'ageGroups' => collect($ageBuckets)->map(fn ($count, $label) => [
                    'label' => $label,
                    'value' => $formatCount($count),
                    'percent' => $percent($count),
                ])->values(),
                'jobs' => $groupStats('pekerjaan'),
                'religions' => $groupStats('agama'),
                'total' => $formatCount($totalPenduduk),
                'hasData' => $totalPenduduk > 0,
            ],
            'apbdesStats' => [
                'location' => 'Desa Sambo, Kecamatan Dolo Selatan, Kabupaten Sigi, Provinsi Sulawesi Tengah',
                'years' => $apbdesYears,
                'hasData' => $apbdesYears->isNotEmpty(),
            ],
            'stuntingStats' => [
                'hasData' => false,
            ],
        ]);
    }

    public function berita(): View
    {
        return view('pages.placeholder');
    }

    public function umkm(): View
    {
        $produkUmkm = Schema::hasTable('produk_umkm') ? ProdukUmkm::latest()->get() : collect();

        return view('pages.umkm', [
            'produkUmkm' => $produkUmkm,
            'stats' => [
                ['label' => 'UMKM terdata', 'value' => $produkUmkm->count()],
                ['label' => 'Jenis usaha', 'value' => $produkUmkm->pluck('jenis_usaha')->filter()->unique()->count()],
                ['label' => 'Kontak tersedia', 'value' => $produkUmkm->pluck('no_whatsapp')->filter()->count()],
            ],
        ]);
    }

    public function programKkn(): View
    {
        return view('pages.placeholder');
    }

    private function buildAgeBuckets($penduduk): array
    {
        $ageBuckets = [
            '0-5' => 0,
            '6-12' => 0,
            '13-17' => 0,
            '18-30' => 0,
            '31-45' => 0,
            '46-60' => 0,
            '60+' => 0,
        ];

        foreach ($penduduk as $item) {
            if (! $item->tanggal_lahir) {
                continue;
            }

            $age = $item->tanggal_lahir->age;
            $bucket = match (true) {
                $age <= 5 => '0-5',
                $age <= 12 => '6-12',
                $age <= 17 => '13-17',
                $age <= 30 => '18-30',
                $age <= 45 => '31-45',
                $age <= 60 => '46-60',
                default => '60+',
            };
            $ageBuckets[$bucket]++;
        }

        return $ageBuckets;
    }

    private function buildGroupStats($penduduk, string $field, callable $percent, callable $formatCount)
    {
        return $penduduk
            ->groupBy(fn ($item) => trim((string) $item->{$field}) ?: 'Belum diisi')
            ->map(fn ($items, $label) => [
                'label' => $label,
                'value' => $formatCount($items->count()),
                'percent' => $percent($items->count()),
            ])
            ->sortByDesc(fn ($item) => (float) $item['percent'])
            ->values();
    }
}
