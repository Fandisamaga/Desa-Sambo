@extends('layouts.public')

@section('title', $berita->judul . ' | Berita Desa Sambo')

@section('content')
    @php
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

        $excerpt = function (?string $content, int $limit = 120): string {
            return \Illuminate\Support\Str::limit(strip_tags((string) $content), $limit);
        };

        $thumbnail = $thumbnailUrl($berita);
    @endphp

    <article class="bg-white">
        <header class="container-page py-14 lg:py-20">
            <a href="{{ route('berita') }}" class="link-arrow">&larr; Kembali ke berita</a>
            <div class="mt-8 grid gap-10 lg:grid-cols-[.82fr_1.18fr]">
                <div>
                    <p class="eyebrow text-emerald-700">Berita Desa Sambo</p>
                    <h1 class="mt-5 font-display text-4xl font-bold leading-tight text-slate-950 sm:text-5xl lg:text-6xl">{{ $berita->judul }}</h1>
                    <p class="mt-5 text-sm font-bold text-slate-500">{{ $dateLabel($berita) }}</p>
                </div>

                <div class="overflow-hidden rounded-2xl bg-emerald-100 shadow-xl shadow-slate-950/10">
                    @if ($thumbnail)
                        <img src="{{ $thumbnail }}" alt="Thumbnail {{ $berita->judul }}" class="h-80 w-full object-cover lg:h-[28rem]">
                    @else
                        <div class="grid h-80 place-items-center bg-[linear-gradient(135deg,#ecfdf5_0%,#86efac_46%,#115e59_100%)] p-8 text-center lg:h-[28rem]">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-950/70">Berita Desa Sambo</p>
                                <p class="mt-4 font-display text-4xl font-bold leading-tight text-emerald-950">{{ $berita->judul }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <div class="border-y border-slate-200 bg-slate-50">
            <div class="container-page py-4">
                <p class="text-sm font-semibold text-slate-600">Dipublikasikan oleh Pemerintah Desa Sambo</p>
            </div>
        </div>

        <section class="container-page py-14 lg:py-20">
            <div class="mx-auto max-w-3xl">
                <div class="space-y-5 text-base leading-8 text-slate-700">
                    @foreach (preg_split('/\R{2,}/', trim((string) $berita->konten)) as $paragraph)
                        @if (trim($paragraph) !== '')
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </article>

    @if (($relatedBerita ?? collect())->isNotEmpty())
        <section class="bg-slate-50 py-14 lg:py-20">
            <div class="container-page">
                <div class="flex flex-wrap items-end justify-between gap-5">
                    <div>
                        <p class="eyebrow text-emerald-700">Berita lainnya</p>
                        <h2 class="section-title">Publikasi terkait</h2>
                    </div>
                    <a href="{{ route('berita') }}" class="link-arrow">Semua berita &rarr;</a>
                </div>

                <div class="mt-9 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedBerita as $item)
                        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $dateLabel($item) }}</p>
                            <h3 class="mt-3 font-display text-2xl font-bold leading-snug text-slate-950">{{ $item->judul }}</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-500">{{ $excerpt($item->konten) }}</p>
                            <div class="mt-5 flex flex-wrap items-center justify-end gap-3">
                                <a href="{{ route('berita.detail', $item->slug) }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-900">Baca &rarr;</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
