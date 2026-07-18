@extends('layouts.public')

@section('content')
    <section class="bg-white">
        <div class="container-page grid gap-10 py-16 lg:grid-cols-[.82fr_1.18fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Etalase Warga</p>
                <h1 class="mt-5 font-display text-5xl font-bold leading-tight text-slate-900 sm:text-6xl">UMKM Desa Sambo</h1>
                <p class="mt-5 max-w-xl text-lg leading-8 text-slate-600">Direktori usaha warga yang memuat data pemilik, jenis usaha, kontak, jam operasional, produk, dan lokasi.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ($stats as $stat)
                    <article class="rounded-2xl border border-emerald-900/10 bg-emerald-50 p-6">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $stat['label'] }}</p>
                        <p class="mt-4 font-display text-4xl font-bold text-slate-950">{{ $stat['value'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-wrap items-end justify-between gap-5">
                <div>
                    <p class="eyebrow text-emerald-700">Data UMKM</p>
                    <h2 class="section-title">Daftar usaha desa</h2>
                </div>
                <p class="rounded-full bg-white px-4 py-2 text-xs font-bold text-slate-500 ring-1 ring-slate-200">Data awal hasil pendataan</p>
            </div>

            <div class="mt-9 grid gap-6">
                @foreach ($umkmListings as $item)
                    <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                        <div class="grid lg:grid-cols-[.78fr_1.22fr]">
                            <div class="relative min-h-72 bg-emerald-100 p-6">
                                @if ($item['photo'])
                                    <img src="{{ $item['photo'] }}" alt="Foto {{ $item['name'] }}" class="h-full min-h-72 w-full rounded-2xl object-cover">
                                @else
                                    <div class="grid h-full min-h-72 place-items-center rounded-2xl border border-emerald-900/10 bg-[linear-gradient(145deg,#ecfdf5_0%,#bbf7d0_46%,#0f766e_100%)] p-8 text-center">
                                        <div>
                                            <span class="mx-auto grid h-24 w-24 place-items-center rounded-full bg-white/85 font-display text-3xl font-bold text-emerald-800 shadow-sm">{{ $item['icon'] }}</span>
                                            <p class="mt-6 text-xs font-bold uppercase tracking-[.18em] text-emerald-900/70">{{ $item['category'] }}</p>
                                            <h3 class="mt-3 font-display text-4xl font-bold text-emerald-950">{{ $item['name'] }}</h3>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6 sm:p-8">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $item['category'] }}</p>
                                        <h3 class="mt-2 font-display text-3xl font-bold text-slate-900">{{ $item['name'] }}</h3>
                                        <p class="mt-3 max-w-2xl leading-7 text-slate-600">{{ $item['description'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-700">{{ $item['hours'] }}</span>
                                </div>

                                <div class="mt-7 grid gap-x-8 gap-y-5 border-y border-slate-200 py-6 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Nama Pemilik</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item['owner'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Jenis Usaha</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item['type'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Alamat</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item['address'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">WhatsApp</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item['phone'] }} <span class="text-slate-500">({{ $item['contactName'] }})</span></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Jam Operasional</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item['hours'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Keterangan Tambahan</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item['note'] }}</p>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Produk/Jasa yang Dijual</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        @foreach ($item['products'] as $product)
                                            <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800">{{ $product }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-8 flex flex-wrap gap-3">
                                    <a href="{{ $item['whatsappUrl'] }}" target="_blank" rel="noopener noreferrer" class="btn-primary">Hubungi WhatsApp <span aria-hidden="true">&rarr;</span></a>
                                    <a href="{{ $item['mapUrl'] }}" target="_blank" rel="noopener noreferrer" class="btn-soft">Lihat lokasi</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
