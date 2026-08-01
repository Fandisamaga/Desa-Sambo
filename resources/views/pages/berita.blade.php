@extends('layouts.public')

@section('title', 'Berita Desa Sambo')

@section('content')
    @php
        $berita = $berita ?? collect();
        $featuredBerita = $featuredBerita ?? $berita->first();
        $otherBerita = $featuredBerita ? $berita->skip(1) : $berita;

        $excerpt = function (?string $content, int $limit = 150): string {
            return \Illuminate\Support\Str::limit(strip_tags((string) $content), $limit);
        };

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

    <section class="bg-white">
        <div class="container-page grid items-center gap-10 py-16 lg:grid-cols-[.86fr_1.14fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Kabar Sambo</p>
                <h1 class="mt-5 max-w-3xl font-display text-5xl font-bold leading-tight text-slate-950 sm:text-6xl">Berita Desa Sambo</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                    Informasi kegiatan, pengumuman, dan cerita warga yang dipublikasikan pemerintah desa.
                </p>

                <div class="mt-8 grid max-w-lg grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-emerald-50 p-5 ring-1 ring-emerald-100">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Publikasi</p>
                        <p class="mt-3 font-display text-3xl font-bold text-slate-950">{{ number_format($berita->count(), 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-100">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-amber-700">Terbaru</p>
                        <p class="mt-3 text-sm font-bold leading-6 text-slate-900">{{ $featuredBerita ? $dateLabel($featuredBerita) : 'Belum ada berita' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-emerald-100 bg-white p-6 text-slate-900 shadow-xl shadow-emerald-950/10">
                @if ($featuredBerita)
                    @php $featuredThumbnail = $thumbnailUrl($featuredBerita); @endphp
                    <article>
                        <div class="overflow-hidden rounded-xl bg-emerald-50">
                            @if ($featuredThumbnail)
                                <img src="{{ $featuredThumbnail }}" alt="Thumbnail {{ $featuredBerita->judul }}" class="h-72 w-full object-cover">
                            @else
                                <div class="grid h-72 place-items-center bg-[linear-gradient(135deg,#ecfdf5_0%,#86efac_46%,#115e59_100%)] p-8 text-center">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-950/70">Berita terkini</p>
                                        <p class="mt-3 font-display text-4xl font-bold leading-tight text-emerald-950">{{ $featuredBerita->judul }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="pt-6">
                            <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-700">{{ $dateLabel($featuredBerita) }}</p>
                            <h2 class="mt-3 break-words font-display text-3xl font-bold leading-tight text-slate-950">{{ $featuredBerita->judul }}</h2>
                            <p class="mt-4 break-words text-sm leading-6 text-slate-600">{{ $excerpt($featuredBerita->konten, 190) }}</p>
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <a href="{{ route('berita.detail', $featuredBerita->slug) }}" class="btn-primary">Baca lengkap <span aria-hidden="true">&rarr;</span></a>
                            </div>
                        </div>
                    </article>
                @else
                    <div class="py-8">
                        <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-700">Belum ada publikasi</p>
                        <h2 class="mt-3 font-display text-3xl font-bold text-slate-950">Berita akan tampil setelah dipublikasikan.</h2>
                        <p class="mt-4 text-sm leading-6 text-slate-600">Tambahkan berita dari panel admin dan pilih status publish agar muncul di halaman ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Daftar berita</p>
                <h2 class="section-title">Publikasi terbaru</h2>
            </div>
        </div>

        <div class="mt-9 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($otherBerita as $item)
                @php $thumbnail = $thumbnailUrl($item); @endphp
                <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="h-52 bg-emerald-100">
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
                        <h3 class="mt-3 break-words font-display text-2xl font-bold leading-snug text-slate-950">{{ $item->judul }}</h3>
                        <p class="mt-3 break-words text-sm leading-6 text-slate-500">{{ $excerpt($item->konten) }}</p>
                        <div class="mt-5 flex flex-wrap items-center justify-end gap-3">
                            <a href="{{ route('berita.detail', $item->slug) }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-900">Baca lengkap &rarr;</a>
                        </div>
                    </div>
                </article>
            @empty
                @unless ($featuredBerita)
                    <article class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 md:col-span-2 xl:col-span-3">
                        <p class="font-display text-2xl font-bold text-slate-950">Belum ada berita publish.</p>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">Berita yang ditambahkan dari admin dengan status publish akan tampil otomatis di halaman ini.</p>
                    </article>
                @endunless
            @endforelse
        </div>
    </section>
@endsection
