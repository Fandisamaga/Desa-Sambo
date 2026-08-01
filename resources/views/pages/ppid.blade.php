@extends('layouts.public')

@section('title', 'PPID | Desa Sambo')

@section('content')
    @php
        $formatStat = fn ($value) => is_numeric($value) ? number_format((int) $value, 0, ',', '.') : $value;
        $documentsByYear = ($documents ?? collect())->groupBy('year');
        $latestUpdate = ($documents ?? collect())->pluck('updated_at')->filter()->sortDesc()->first();
    @endphp

    <section class="bg-white">
        <div class="container-page grid grid-cols-1 items-center gap-8 py-12 sm:py-16 lg:grid-cols-[1.02fr_.98fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">PPID Desa Sambo</p>
                <h1 class="mt-4 max-w-3xl font-display text-3xl font-bold leading-tight text-slate-950 sm:mt-5 sm:text-6xl">Arsip dokumen publik desa</h1>
                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600 sm:mt-6 sm:text-lg sm:leading-8">
                    Akses informasi publik yang disiapkan pemerintah desa untuk warga.
                </p>
                <div class="mt-6 flex flex-wrap gap-3 sm:mt-8">
                    <a href="#daftar-dokumen" class="btn-primary">Lihat dokumen <span aria-hidden="true">&rarr;</span></a>
                    <a href="{{ route('layanan') }}" class="btn-soft">Kanal pengaduan</a>
                </div>
            </div>

            <div class="rounded-xl border border-emerald-100 bg-white p-4 text-slate-900 shadow-xl shadow-emerald-950/10 sm:rounded-2xl sm:p-6">
                <div class="border-b border-emerald-100 pb-4 sm:pb-6">
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-700">Layanan informasi</p>
                    <h2 class="mt-2 font-display text-2xl font-bold text-slate-950 sm:mt-3 sm:text-3xl">Transparansi dokumen desa</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Dokumen disusun berdasarkan tahun agar mudah ditemukan dan dibuka kembali.</p>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 sm:mt-6 sm:grid-cols-3">
                    @foreach ($stats as $stat)
                        <div class="rounded-xl bg-emerald-50 p-3 ring-1 ring-emerald-100 sm:p-4 {{ $loop->last ? 'col-span-2 sm:col-span-1' : '' }}">
                            <p class="text-xs font-bold uppercase tracking-[.14em] text-emerald-700">{{ $stat['label'] }}</p>
                            <p class="mt-2 font-display text-2xl font-bold text-slate-950 sm:mt-3 sm:text-3xl">{{ $formatStat($stat['value']) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 rounded-xl bg-emerald-50 p-3 text-sm leading-6 text-slate-600 ring-1 ring-emerald-100 sm:mt-6 sm:p-4">
                    Pembaruan terakhir:
                    <span class="font-bold text-emerald-800">
                        {{ $latestUpdate ? $latestUpdate->translatedFormat('d F Y') : 'Belum ada dokumen' }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-slate-50">
        <div class="container-page grid grid-cols-1 gap-5 py-7 sm:py-8 lg:grid-cols-[.82fr_1.18fr]">
            <div>
                <p class="eyebrow text-emerald-700">Kategori akses</p>
                <h2 class="section-title">Informasi tersedia untuk warga</h2>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5">
                    <p class="text-sm font-bold text-slate-900">Dokumen perencanaan</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Rencana kerja, program, dan informasi pembangunan desa.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5">
                    <p class="text-sm font-bold text-slate-900">Dokumen keuangan</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Ringkasan anggaran dan laporan yang dapat dipublikasikan.</p>
                </article>
                <article class="col-span-2 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:col-span-1 sm:rounded-2xl sm:p-5">
                    <p class="text-sm font-bold text-slate-900">Dokumen layanan</p>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Informasi pelayanan, kegiatan, dan dokumen umum pemerintah desa.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="daftar-dokumen" class="container-page py-12 sm:py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Arsip PPID</p>
                <h2 class="section-title">Daftar dokumen publik</h2>
                <p class="mt-3 max-w-2xl leading-7 text-slate-600">Pilih tahun arsip atau buka dokumen yang tersedia sesuai kebutuhan informasi.</p>
            </div>

            @if (($years ?? collect())->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach ($years as $year)
                        <a href="#tahun-{{ $year }}" class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800 ring-1 ring-emerald-100">{{ $year }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-7 space-y-7 sm:mt-9 sm:space-y-8">
            @forelse ($documentsByYear as $year => $yearDocuments)
                <div id="tahun-{{ $year }}" class="scroll-mt-24">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-700 text-sm font-black text-white">{{ $year }}</span>
                        <h3 class="font-display text-2xl font-bold text-slate-950">Dokumen tahun {{ $year }}</h3>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        @foreach ($yearDocuments as $document)
                            @php
                                $fileName = basename(str_replace('\\', '/', $document['file_path']));
                            @endphp
                            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:rounded-2xl sm:p-6">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Dokumen publik</p>
                                        <h4 class="mt-3 font-display text-xl font-bold leading-snug text-slate-950 sm:text-2xl">{{ $document['title'] }}</h4>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $document['year'] }}</span>
                                </div>

                                <div class="mt-4 rounded-xl bg-slate-50 p-3 text-sm text-slate-600 ring-1 ring-slate-100 sm:mt-5 sm:p-4">
                                    <p class="font-semibold text-slate-800">{{ $fileName ?: 'File dokumen' }}</p>
                                    <p class="mt-1 text-xs">Diperbarui {{ $document['updated_at'] ? $document['updated_at']->translatedFormat('d F Y') : '-' }}</p>
                                </div>

                                <a href="{{ $document['url'] }}" class="btn-primary mt-5" target="_blank" rel="noopener">Buka dokumen <span aria-hidden="true">&rarr;</span></a>
                            </article>
                        @endforeach
                    </div>
                </div>
            @empty
                <article class="rounded-xl border border-dashed border-slate-300 bg-white p-5 sm:rounded-2xl sm:p-8">
                    <p class="font-display text-2xl font-bold text-slate-950">Belum ada dokumen publik.</p>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">Dokumen akan tampil di halaman ini setelah tersedia dari pemerintah desa.</p>
                    <a href="{{ route('layanan') }}" class="btn-soft mt-6">Hubungi pemerintah desa</a>
                </article>
            @endforelse
        </div>
    </section>
@endsection
