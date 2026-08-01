@extends('layouts.public')

@section('title', 'UMKM Desa Sambo')

@section('content')
    @php
        $produkUmkm = $produkUmkm ?? collect();
        $stats = $stats ?? [
            ['label' => 'UMKM terdata', 'value' => $produkUmkm->count()],
            ['label' => 'Jenis usaha', 'value' => $produkUmkm->pluck('jenis_usaha')->filter()->unique()->count()],
            ['label' => 'Kontak tersedia', 'value' => $produkUmkm->pluck('no_whatsapp')->filter()->count()],
        ];

        $formatHours = function (?string $jamOperasional): ?string {
            if (! $jamOperasional) {
                return null;
            }

            $parts = array_map('trim', explode('-', $jamOperasional, 2));
            $format = function (?string $part): ?string {
                if ($part === null || $part === '') {
                    return null;
                }
                if (! preg_match('/^\d{1,2}$/', trim($part))) {
                    return null;
                }
                $hour = (int) trim($part);
                if ($hour < 0 || $hour > 23) {
                    return null;
                }
                return sprintf('%02d:00', $hour);
            };

            $start = $format($parts[0] ?? null);
            $end = $format($parts[1] ?? null);

            if ($start && $end) {
                return "$start - $end";
            }

            if ($start) {
                return "$start -";
            }

            if ($end) {
                return "- $end";
            }

            return null;
        };

        $formatPriceRange = function ($item): string {
            $low = $item->harga > 0 ? 'Rp ' . number_format($item->harga, 0, ',', '.') : null;
            $high = isset($item->harga_max) && $item->harga_max > 0 ? 'Rp ' . number_format($item->harga_max, 0, ',', '.') : null;

            if ($low && $high) {
                return "$low - $high";
            }

            return $low ?? $high ?? '-';
        };
    @endphp

    <section class="bg-white">
        <div class="container-page grid grid-cols-1 gap-8 py-12 sm:py-16 lg:grid-cols-[.82fr_1.18fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Etalase Warga</p>
                <h1 class="mt-4 font-display text-3xl font-bold leading-tight text-slate-900 sm:mt-5 sm:text-6xl">UMKM Desa Sambo</h1>
                <p class="mt-4 max-w-xl text-base leading-7 text-slate-600 sm:mt-5 sm:text-lg sm:leading-8">Berikut Daftar UMKM yang ada di desa Sambo</p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4">
                @foreach ($stats as $stat)
                    <article class="rounded-xl border border-emerald-900/10 bg-emerald-50 p-4 sm:rounded-2xl sm:p-6 {{ $loop->last ? 'col-span-2 sm:col-span-1' : '' }}">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $stat['label'] }}</p>
                        <p class="mt-3 font-display text-3xl font-bold text-slate-950 sm:mt-4 sm:text-4xl">{{ $stat['value'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-12 sm:py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-wrap items-end justify-between gap-5">
                <div>
                    <p class="eyebrow text-emerald-700">Data UMKM</p>
                    <h2 class="section-title">Daftar usaha desa</h2>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:mt-9 sm:gap-6">
                @forelse ($produkUmkm as $item)
                    @php
                        $photoPath = trim((string) $item->foto_path);
                        $photoUrl = null;
                        if ($photoPath !== '') {
                            $photoUrl = str_starts_with($photoPath, 'http://') || str_starts_with($photoPath, 'https://') || str_starts_with($photoPath, '/')
                                ? $photoPath
                                : asset('storage/' . $photoPath);
                        }

                        $digits = preg_replace('/\D+/', '', (string) $item->no_whatsapp);
                        if ($digits !== '' && str_starts_with($digits, '0')) {
                            $digits = '62' . substr($digits, 1);
                        } elseif ($digits !== '' && ! str_starts_with($digits, '62')) {
                            $digits = '62' . $digits;
                        }
                        $whatsappUrl = $digits !== '' ? 'https://wa.me/' . $digits : null;

                        $products = collect(preg_split('/[\r\n,;]+/', (string) $item->produk_jasa))
                            ->map(fn ($product) => trim($product))
                            ->filter();
                        $initials = strtoupper(substr($item->nama_produk, 0, 2));
                    @endphp

                    <article class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200 sm:rounded-2xl">
                        <div class="grid lg:grid-cols-[.78fr_1.22fr]">
                            <div class="relative h-52 bg-emerald-100 p-4 sm:h-72 sm:p-6">
                                @if ($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="Foto {{ $item->nama_produk }}" class="h-full w-full rounded-xl object-cover sm:rounded-2xl">
                                @else
                                    <div class="grid h-full place-items-center rounded-xl border border-emerald-900/10 bg-[linear-gradient(145deg,#ecfdf5_0%,#bbf7d0_46%,#0f766e_100%)] p-5 text-center sm:rounded-2xl sm:p-8">
                                        <div>
                                            <span class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-white/85 font-display text-2xl font-bold text-emerald-800 shadow-sm sm:h-24 sm:w-24 sm:text-3xl">{{ $initials }}</span>
                                            <p class="mt-4 text-xs font-bold uppercase tracking-[.18em] text-emerald-900/70 sm:mt-6">{{ $item->jenis_usaha ?: 'UMKM Desa' }}</p>
                                            <h3 class="mt-2 font-display text-2xl font-bold text-emerald-950 sm:mt-3 sm:text-4xl">{{ $item->nama_produk }}</h3>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 sm:p-8">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $item->jenis_usaha ?: 'UMKM Desa' }}</p>
                                        <h3 class="mt-2 font-display text-2xl font-bold text-slate-900 sm:text-3xl">{{ $item->nama_produk }}</h3>
                                        <p class="mt-2 max-w-2xl leading-6 text-slate-600 sm:mt-3 sm:leading-7">{{ $item->deskripsi ?: 'Informasi usaha dapat dilengkapi melalui admin Produk UMKM.' }}</p>
                                    </div>
                                </div>

                                <div class="mt-5 grid gap-x-6 gap-y-4 border-y border-slate-200 py-5 sm:mt-7 sm:gap-x-8 sm:gap-y-5 sm:py-6 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Nama Pemilik</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item->nama_pemilik ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Jenis Usaha</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item->jenis_usaha ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Alamat</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $item->alamat ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">WhatsApp</p>
                                        <p class="mt-2 font-bold text-slate-900">
                                            {{ $item->no_whatsapp ?: '-' }}
                                            @if ($item->nama_kontak)
                                                <span class="text-slate-500">({{ $item->nama_kontak }})</span>
                                            @endif
                                        </p>
                                    </div>
                                    @php $formattedHours = $formatHours($item->jam_operasional); @endphp
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Jam Operasional</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $formattedHours ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Harga</p>
                                        <p class="mt-2 font-bold text-slate-900">{{ $formatPriceRange($item) }}</p>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Produk/Jasa yang Dijual</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        @forelse ($products as $product)
                                            <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800">{{ $product }}</span>
                                        @empty
                                            <span class="text-sm font-semibold text-slate-500">Belum ada rincian produk/jasa.</span>
                                        @endforelse
                                    </div>
                                </div>

                                @if ($item->keterangan_tambahan)
                                    <div class="mt-6 rounded-xl bg-slate-50 p-4">
                                        <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-400">Keterangan Tambahan</p>
                                        <p class="mt-2 text-sm font-semibold leading-6 text-slate-700">{{ $item->keterangan_tambahan }}</p>
                                    </div>
                                @endif

                                <div class="mt-6 flex flex-wrap gap-3 sm:mt-8">
                                    @if ($whatsappUrl)
                                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary">Hubungi WhatsApp <span aria-hidden="true">&rarr;</span></a>
                                    @endif
                                    @if ($item->lokasi_maps)
                                        <a href="{{ $item->lokasi_maps }}" target="_blank" rel="noopener noreferrer" class="btn-soft">Lihat lokasi</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                        <p class="font-display text-3xl font-bold text-slate-900">Belum ada data UMKM.</p>
                        <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-500">Data usaha yang ditambahkan dari menu admin Produk UMKM akan tampil otomatis di halaman ini.</p>
                    </article>
                @endforelse
            </div>
        </div>
    </section>
@endsection
