@extends('layouts.public')

@section('title', 'Desa Sambo | Website Resmi')

@section('content')
    @php
        $services = [
            ['icon' => 'PP', 'title' => 'PPID', 'description' => 'Akses arsip dokumen publik desa.', 'href' => route('ppid'), 'cta' => 'Buka'],
            ['icon' => 'DK', 'title' => 'Data Kependudukan', 'description' => 'Informasi dan pembaruan data warga.', 'href' => route('infografis'), 'cta' => 'Lihat'],
            ['icon' => 'AW', 'title' => 'Aspirasi Warga', 'description' => 'Sampaikan saran dan laporan Anda.', 'href' => route('layanan'), 'cta' => 'Kirim'],
            ['icon' => 'BD', 'title' => 'Berita Desa', 'description' => 'Kabar dan kegiatan terbaru warga.', 'href' => route('berita'), 'cta' => 'Baca'],
        ];

        $statToneClasses = [
            'emerald' => ['card' => 'border-emerald-200 bg-emerald-50', 'accent' => 'bg-emerald-700', 'text' => 'text-emerald-700'],
            'amber' => ['card' => 'border-amber-200 bg-amber-50', 'accent' => 'bg-amber-500', 'text' => 'text-amber-700'],
            'sky' => ['card' => 'border-sky-200 bg-sky-50', 'accent' => 'bg-sky-600', 'text' => 'text-sky-700'],
            'rose' => ['card' => 'border-rose-200 bg-rose-50', 'accent' => 'bg-rose-500', 'text' => 'text-rose-700'],
        ];

        $infoPreviewStats = collect($populationStats['summary'] ?? [])->take(4);
        $homeBerita = $homeBerita ?? collect();
        $featuredBerita = $featuredBerita ?? $homeBerita->first();
        $homeStats = $homeStats ?? [];
        $heroBackgrounds = collect(\Illuminate\Support\Facades\Storage::disk('public')->files('background'))
            ->filter(fn ($path) => preg_match('/\.(jpe?g|png|webp|avif)$/i', $path))
            ->sort()
            ->take(4)
            ->map(fn ($path) => asset('storage/' . $path))
            ->values();

        $umkm = ($featuredUmkm ?? collect())->map(fn ($item) => [
            'icon' => strtoupper(substr($item->nama_produk, 0, 2)),
            'name' => $item->nama_produk,
            'category' => $item->jenis_usaha ?: 'UMKM Desa',
            'owner' => $item->deskripsi ? \Illuminate\Support\Str::limit($item->deskripsi, 70) : ($item->produk_jasa ?: 'Produk dan jasa warga Desa Sambo'),
            'color' => 'umkm-sage',
        ]);

        $excerpt = fn (?string $content, int $limit = 150): string => \Illuminate\Support\Str::limit(strip_tags((string) $content), $limit);

        $thumbnailUrl = function ($item): ?string {
            $path = trim((string) $item->thumbnail_path);

            if ($path === '') {
                return null;
            }

            return str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')
                ? $path
                : asset('storage/' . $path);
        };

        $dateLabel = function ($item): string {
            $date = $item->tanggal_upload ?? $item->created_at;

            return $date ? $date->locale('id')->translatedFormat('d F Y') : '-';
        };
    @endphp
<section class="hero-section">
    @if ($heroBackgrounds->isNotEmpty())
        <div class="hero-background" data-hero-background aria-hidden="true">
            @foreach ($heroBackgrounds as $image)
                <div
                    class="hero-background__image {{ $loop->first ? 'is-active' : '' }}"
                    data-hero-slide
                    style="--hero-bg: url('{{ $image }}');"
                ></div>
            @endforeach
        </div>
    @endif

    <div class="container-page relative py-16 lg:py-24">
        <div class="hero-content relative z-10 text-center mx-auto">
            <p class="eyebrow text-emerald-100">
                Selamat datang di ruang digital kami
            </p>

            <h1 class="mt-5 font-display text-5xl font-bold leading-[1.05] text-white sm:text-6xl">
                Sambo tumbuh melalui <br>
                <span class="text-lime-300">kebersamaan</span>
            </h1>

            <p class="mt-6 mx-auto max-w-2xl text-base leading-7 text-emerald-50 sm:text-lg">
                Informasi desa, PPID, layanan pengaduan, UMKM lokal, dan kegiatan masyarakat tersedia dalam satu tempat yang mudah diakses.
            </p>

            <div class="mt-8 flex justify-center flex-wrap gap-3">
                <a href="{{ route('profil') }}" class="btn-primary">
                    Jelajahi Desa →
                </a>

                <a href="{{ route('ppid') }}" class="btn-soft">
                    Akses PPID
                </a>
            </div>
        </div>
    </div>
</section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Etalase warga</p>
                <h2 class="section-title">UMKM Desa Sambo</h2>
                <p class="mt-3 max-w-xl text-slate-600">Temukan produk dan jasa terbaik yang dibuat oleh warga Sambo.</p>
            </div>
            <a href="{{ route('umkm') }}" class="link-arrow">Jelajahi UMKM &rarr;</a>
        </div>

        <div class="mt-9 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($umkm as $item)
                <article class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="umkm-cover {{ $item['color'] }}">
                        <span>{{ $item['icon'] }}</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">{{ $item['category'] }}</p>
                        <h3 class="mt-2 font-display text-xl font-bold text-slate-900">{{ $item['name'] }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $item['owner'] }}</p>
                        <a href="{{ route('umkm') }}" class="mt-5 inline-block text-sm font-bold text-emerald-700">Lihat produk &rarr;</a>
                    </div>
                </article>
            @empty
                <article class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 sm:col-span-2 xl:col-span-3">
                    <p class="font-display text-2xl font-bold text-slate-900">Belum ada data UMKM.</p>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">Data yang ditambahkan melalui admin Produk UMKM akan tampil di bagian ini.</p>
                </article>
            @endforelse
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Akses cepat</p>
                <h2 class="section-title">Akses untuk masyarakat</h2>
            </div>
            <a href="{{ route('ppid') }}" class="link-arrow">Buka PPID &rarr;</a>
        </div>

        <div class="mt-9 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($services as $service)
                <a href="{{ $service['href'] }}" class="service-card">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-sm font-black text-emerald-800">{{ $service['icon'] }}</span>
                    <h3>{{ $service['title'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                    <span class="mt-auto text-sm font-bold text-emerald-700">{{ $service['cta'] }} &rarr;</span>
                </a>
            @endforeach
        </div>
    </section>

    <section id="infografis" class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Data Penduduk</p>
                <h2 class="section-title">Ringkasan kependudukan</h2>
                <p class="mt-3 max-w-xl text-slate-600">Preview data yang sama dengan tab Penduduk di halaman Info Grafis.</p>
            </div>
            <a href="{{ route('infografis') }}" class="link-arrow">Lihat info grafis &rarr;</a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($infoPreviewStats as $stat)
                @php $tone = $statToneClasses[$stat['tone']] ?? $statToneClasses['emerald']; @endphp
                <article class="rounded-2xl border p-6 shadow-sm {{ $tone['card'] }}">
                    <span class="block h-1.5 w-12 rounded-full {{ $tone['accent'] }}"></span>
                    <p class="mt-5 text-xs font-bold uppercase tracking-[.16em] {{ $tone['text'] }}">{{ $stat['label'] }}</p>
                    <div class="mt-3 flex items-end gap-2">
                        <p class="font-display text-4xl font-bold leading-none text-slate-950">{{ $stat['value'] }}</p>
                        <p class="pb-1 text-sm font-bold text-slate-500">{{ $stat['unit'] }}</p>
                    </div>
                    <p class="mt-4 text-sm leading-6 text-slate-600">{{ $stat['description'] }}</p>
                </article>
            @endforeach
        </div>

        @unless ($populationStats['hasData'] ?? false)
            <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                <p class="font-display text-2xl font-bold text-slate-900">Belum ada data penduduk.</p>
                <p class="mt-2 text-sm leading-6 text-slate-500">Data penduduk dari admin akan tampil otomatis di beranda dan halaman Info Grafis.</p>
            </div>
        @endunless
    </section>

    <section class="bg-emerald-50/70 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="eyebrow text-emerald-700">Kabar Sambo</p>
                <h2 class="section-title">Berita Desa Sambo</h2>
                <p class="mt-4 max-w-sm leading-7 text-slate-600">Informasi kegiatan, pengumuman, dan cerita warga yang dipublikasikan pemerintah desa.</p>

                <div class="mt-8 grid max-w-sm grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-emerald-50 p-5 ring-1 ring-emerald-100">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Publikasi</p>
                        <p class="mt-3 font-display text-3xl font-bold text-slate-950">{{ $publishedBeritaCount ?? '0' }}</p>
                    </div>
                    <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-100">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-amber-700">Terbaru</p>
                        <p class="mt-3 text-sm font-bold leading-6 text-slate-900">{{ $featuredBerita ? $dateLabel($featuredBerita) : 'Belum ada berita' }}</p>
                    </div>
                </div>

                <a href="{{ route('berita') }}" class="btn-primary mt-7">Semua berita <span aria-hidden="true">&rarr;</span></a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                @forelse ($homeBerita as $item)
                    @php $thumbnail = $thumbnailUrl($item); @endphp
                    <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="h-44 bg-emerald-100">
                            @if ($thumbnail)
                                <img src="{{ $thumbnail }}" alt="Thumbnail {{ $item->judul }}" class="h-full w-full object-cover">
                            @else
                                <div class="grid h-full place-items-center bg-[linear-gradient(135deg,#f0fdf4_0%,#bbf7d0_48%,#0f766e_100%)] p-6 text-center">
                                    <span class="rounded-full bg-white/85 px-4 py-2 text-xs font-bold uppercase tracking-[.16em] text-emerald-800">Berita Desa</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $dateLabel($item) }}</p>
                            <h3 class="mt-3 font-display text-2xl font-bold leading-snug text-slate-950">{{ $item->judul }}</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-500">{{ $excerpt($item->konten) }}</p>
                            <div class="mt-5 flex justify-end">
                                <a href="{{ route('berita.detail', $item->slug) }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-900">Baca lengkap &rarr;</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 sm:col-span-2">
                        <p class="font-display text-2xl font-bold text-slate-950">Belum ada berita publish.</p>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">Berita yang ditambahkan dari admin dengan status publish akan tampil otomatis di beranda dan halaman Berita.</p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="rounded-4xl bg-slate-900 px-7 py-10 text-white sm:px-12 lg:flex lg:items-center lg:justify-between">
            <div>
                <p class="eyebrow text-lime-300">Kolaborasi Warga</p>
                <h2 class="mt-3 font-display text-3xl font-bold">Punya ide untuk Desa Sambo?</h2>
                <p class="mt-3 max-w-xl text-slate-300">Mari berkolaborasi untuk kegiatan yang bermanfaat bagi warga dan masa depan desa.</p>
            </div>
            <a href="{{ route('layanan') }}" class="btn-light mt-7 lg:mt-0">Kirim Aspirasi <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>
@endsection
