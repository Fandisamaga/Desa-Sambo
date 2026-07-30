@extends('layouts.public')

@section('title', 'Layanan Pengaduan | Desa Sambo')

@section('content')
    @php
        $formatNumber = fn (int $value) => number_format($value, 0, ',', '.');

        $channels = [
            [
                'icon' => 'LP',
                'eyebrow' => 'Fasilitas umum',
                'title' => 'Laporan lingkungan',
                'description' => 'Laporkan jalan, lampu, kebersihan, keamanan, atau fasilitas desa yang perlu perhatian.',
                'tone' => 'bg-emerald-700 text-white',
                'surface' => 'bg-emerald-50 text-emerald-800 ring-emerald-100',
            ],
            [
                'icon' => 'PM',
                'eyebrow' => 'Pelayanan publik',
                'title' => 'Masukan pelayanan',
                'description' => 'Sampaikan kendala, saran, atau pengalaman saat mengakses pelayanan pemerintah desa.',
                'tone' => 'bg-sky-700 text-white',
                'surface' => 'bg-sky-50 text-sky-800 ring-sky-100',
            ],
            [
                'icon' => 'AD',
                'eyebrow' => 'Aspirasi desa',
                'title' => 'Usulan pembangunan',
                'description' => 'Kirim ide kegiatan, kebutuhan dusun, atau prioritas pembangunan untuk ditinjau operator.',
                'tone' => 'bg-amber-600 text-white',
                'surface' => 'bg-amber-50 text-amber-800 ring-amber-100',
            ],
        ];

        $steps = [
            ['label' => 'Tulis laporan', 'description' => 'Warga mengisi nama, kontak, dan isi pengaduan dengan jelas.'],
            ['label' => 'Masuk ke operator', 'description' => 'Laporan diterima petugas dengan status awal pending.'],
            ['label' => 'Ditindaklanjuti', 'description' => 'Operator memberi status diproses, selesai, atau ditolak sesuai hasil pemeriksaan.'],
        ];

        $statusLabels = [
            'pending' => ['label' => 'Pending', 'class' => 'bg-amber-500'],
            'diproses' => ['label' => 'Diproses', 'class' => 'bg-sky-500'],
            'selesai' => ['label' => 'Selesai', 'class' => 'bg-emerald-600'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-red-500'],
        ];
        $maxStatus = max(1, max($statusCounts ?? [0]));
    @endphp

    <section class="bg-white">
        <div class="container-page grid items-center gap-12 py-16 lg:grid-cols-[1.02fr_.98fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Pelayanan Desa</p>
                <h1 class="mt-5 max-w-3xl font-display text-5xl font-bold leading-tight text-slate-950 sm:text-6xl">Layanan Pengaduan Desa Sambo</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                    Kanal resmi untuk menyampaikan laporan, masukan pelayanan, dan aspirasi warga kepada pemerintah desa.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#pengaduan-form" class="btn-primary">Ajukan pengaduan <span aria-hidden="true">&rarr;</span></a>
                    <a href="{{ route('ppid') }}" class="btn-soft">Buka PPID</a>
                </div>
            </div>

            <div class="rounded-2xl border border-emerald-100 bg-white p-6 text-slate-900 shadow-xl shadow-emerald-950/10">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-emerald-100 pb-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-700">Kantor Desa Sambo</p>
                        <h2 class="mt-3 font-display text-3xl font-bold text-slate-950">Alur pengaduan</h2>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800 ring-1 ring-emerald-100">08.00-15.00 WITA</span>
                </div>

                <div class="mt-6 space-y-3">
                    @foreach ($steps as $step)
                        <div class="flex gap-3 rounded-xl bg-emerald-50 p-4 ring-1 ring-emerald-100">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-emerald-700 text-sm font-black text-white">{{ $loop->iteration }}</span>
                            <div>
                                <p class="font-bold text-slate-950">{{ $step['label'] }}</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ $step['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-slate-50">
        <div class="container-page grid gap-4 py-6 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-500">{{ $stat['label'] }}</p>
                    <p class="mt-3 font-display text-4xl font-bold text-slate-950">{{ $formatNumber((int) $stat['value']) }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $stat['note'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Kanal warga</p>
                <h2 class="section-title">Pilih jenis laporan</h2>
                <p class="mt-3 max-w-2xl leading-7 text-slate-600">Semua laporan diterima petugas desa untuk dipantau status dan tindak lanjutnya.</p>
            </div>
            <a href="#pengaduan-form" class="link-arrow">Isi form &rarr;</a>
        </div>

        <div class="mt-9 grid gap-5 lg:grid-cols-3">
            @foreach ($channels as $channel)
                <article class="flex min-h-80 flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-start justify-between gap-4">
                        <span class="grid h-12 w-12 place-items-center rounded-xl text-sm font-black {{ $channel['tone'] }}">{{ $channel['icon'] }}</span>
                        <span class="rounded-full px-3 py-1 text-xs font-bold ring-1 {{ $channel['surface'] }}">{{ $channel['eyebrow'] }}</span>
                    </div>
                    <h3 class="mt-6 font-display text-2xl font-bold text-slate-950">{{ $channel['title'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $channel['description'] }}</p>
                    <a href="#pengaduan-form" class="btn-soft mt-auto justify-center">Kirim laporan <span aria-hidden="true">&rarr;</span></a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-slate-50 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.9fr_1.1fr]">
            <div>
                <p class="eyebrow text-emerald-700">Monitoring Pengaduan</p>
                <h2 class="section-title">Status tindak lanjut warga</h2>
                <p class="mt-4 max-w-xl leading-7 text-slate-600">Ringkasan status membantu warga melihat alur penanganan laporan dari masuk hingga selesai.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="space-y-5">
                    @foreach ($statusLabels as $status => $meta)
                        @php
                            $count = (int) ($statusCounts[$status] ?? 0);
                            $width = max(6, round(($count / $maxStatus) * 100));
                        @endphp
                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-bold text-slate-700">{{ $meta['label'] }}</p>
                                <p class="text-sm font-bold text-slate-950">{{ $formatNumber($count) }}</p>
                            </div>
                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full {{ $meta['class'] }}" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="pengaduan-form" class="container-page py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-[.82fr_1.18fr]">
            <div>
                <p class="eyebrow text-emerald-700">Form Pengaduan</p>
                <h2 class="section-title">Sampaikan laporan ke pemerintah desa</h2>
                <p class="mt-4 leading-7 text-slate-600">Tuliskan laporan dengan jelas agar pemerintah desa dapat memahami kebutuhan, lokasi, dan kontak yang bisa dihubungi.</p>
                <div class="mt-7 rounded-2xl border border-emerald-100 bg-emerald-50 p-6 text-slate-900">
                    <p class="font-display text-2xl font-bold text-slate-950">Agar cepat diproses</p>
                    <div class="mt-5 space-y-3 text-sm leading-6 text-slate-600">
                        <p>Sertakan lokasi kejadian atau layanan yang dimaksud.</p>
                        <p>Gunakan kontak aktif agar operator dapat meminta konfirmasi tambahan.</p>
                        <p>Catatan tindak lanjut akan dikelola oleh admin desa.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('layanan.pengaduan.store') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf

                @if (session('success'))
                    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="nama_pengirim" class="label">Nama pengirim</label>
                        <input id="nama_pengirim" name="nama_pengirim" type="text" value="{{ old('nama_pengirim') }}" class="input" required>
                        @error('nama_pengirim')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kontak_pengirim" class="label">Kontak pengirim</label>
                        <input id="kontak_pengirim" name="kontak_pengirim" type="text" value="{{ old('kontak_pengirim') }}" class="input" placeholder="Nomor HP atau WhatsApp" required>
                        @error('kontak_pengirim')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="isi_aduan" class="label">Isi aduan</label>
                        <textarea id="isi_aduan" name="isi_aduan" rows="7" class="input min-h-44" required>{{ old('isi_aduan') }}</textarea>
                        @error('isi_aduan')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5">
                    <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 ring-1 ring-amber-100">Status awal: pending</span>
                    <button type="submit" class="btn-primary">Kirim pengaduan <span aria-hidden="true">&rarr;</span></button>
                </div>
            </form>
        </div>
    </section>
@endsection
