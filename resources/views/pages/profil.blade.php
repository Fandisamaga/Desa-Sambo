@extends('layouts.public')

@section('title', 'Profil Desa | Desa Sambo')

@section('content')
    @php
        $missions = [
            'Meningkatkan kualitas pelayanan publik yang cepat, terbuka, dan mudah dijangkau masyarakat.',
            'Mendorong pembangunan desa yang merata melalui musyawarah, gotong royong, dan pemanfaatan data desa.',
            'Menguatkan ekonomi warga melalui dukungan UMKM, pertanian, dan potensi lokal Desa Sambo.',
            'Membangun lingkungan desa yang sehat, aman, religius, dan berkelanjutan.',
        ];

        $government = [
            ['role' => 'Kepala Desa', 'name' => 'SARMAN'],
            ['role' => 'Sekretaris Desa', 'name' => 'RISTO'],
            ['role' => 'Kepala Seksi Pemerintahan', 'name' => 'AZHAR'],
            ['role' => 'Kepala Seksi Kesra', 'name' => 'RAHMAYANI'],
            ['role' => 'Kepala Seksi Pelayanan', 'name' => 'WIRZAN'],
            ['role' => 'Kepala Urusan Umum dan Perencanaan', 'name' => 'ASMAWATI'],
            ['role' => 'Kepala Urusan Keuangan', 'name' => 'DEBI RAHMAWATI'],
        ];

        $dusun = [
            ['role' => 'Kepala Dusun I', 'name' => 'SAIFUL'],
            ['role' => 'Kepala Dusun II', 'name' => 'DJISMAN'],
            ['role' => 'Kepala Dusun III', 'name' => 'ARIFIN'],
            ['role' => 'Kepala Dusun IV', 'name' => 'AKBAR SALMI'],
        ];

        $mapsUrl = 'https://maps.app.goo.gl/juBGj5z5D37rCQ1r5';
        $mapsEmbed = 'https://www.google.com/maps?q=Desa%20Sambo%2C%20Dolo%20Selatan%2C%20Kabupaten%20Sigi%2C%20Sulawesi%20Tengah&output=embed';
    @endphp

    <section class="bg-white">
        <div class="container-page grid gap-12 py-16 lg:grid-cols-[.92fr_1.08fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Profil Desa</p>
                <h1 class="mt-5 font-display text-5xl font-bold leading-tight text-slate-900 sm:text-6xl">Mengenal Desa Sambo</h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">Halaman profil ini memuat arah pembangunan desa, struktur pemerintahan, ringkasan sejarah, dan lokasi Desa Sambo.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#visi-misi" class="btn-primary">Lihat visi misi <span aria-hidden="true">&rarr;</span></a>
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-soft">Buka Google Maps</a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <article class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Wilayah</p>
                    <p class="mt-4 font-display text-3xl font-bold text-slate-950">Desa Sambo</p>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Kecamatan Dolo Selatan, Kabupaten Sigi, Provinsi Sulawesi Tengah.</p>
                </article>
                <article class="rounded-2xl border border-sky-200 bg-sky-50 p-6">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-sky-700">Pemerintahan</p>
                    <p class="mt-4 font-display text-3xl font-bold text-slate-950">4 Dusun</p>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Struktur pemerintahan desa disusun untuk pelayanan warga lintas dusun.</p>
                </article>
                <article class="rounded-2xl border border-amber-200 bg-amber-50 p-6 sm:col-span-2">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-amber-700">Ruang Kolaborasi</p>
                    <p class="mt-4 font-display text-3xl font-bold text-slate-950">Pelayanan, data, dan potensi lokal</p>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Website ini menjadi kanal informasi desa, pendataan, pelayanan, UMKM, dan program masyarakat.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="visi-misi" class="bg-slate-50 py-16 lg:py-24">
        <div class="container-page grid gap-8 lg:grid-cols-[.85fr_1.15fr]">
            <article class="rounded-2xl bg-emerald-800 p-8 text-white shadow-sm">
                <p class="eyebrow text-lime-200">Visi</p>
                <h2 class="mt-4 font-display text-3xl font-bold leading-tight">Terwujudnya Desa Sambo yang maju, mandiri, sejahtera, dan berdaya saing melalui pelayanan yang transparan dan partisipatif.</h2>
            </article>

            <article class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="eyebrow text-emerald-700">Misi</p>
                <div class="mt-6 space-y-4">
                    @foreach ($missions as $mission)
                        <div class="flex gap-4">
                            <span class="mt-1 grid h-7 w-7 shrink-0 place-items-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-700">{{ $loop->iteration }}</span>
                            <p class="leading-7 text-slate-600">{{ $mission }}</p>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Bagan Desa</p>
                <h2 class="section-title">Struktur pemerintahan desa</h2>
                <p class="mt-3 max-w-2xl text-slate-600">Bagan ini menampilkan susunan organisasi Pemerintah Desa Sambo, Kecamatan Dolo Selatan, Kabupaten Sigi.</p>
            </div>
        </div>

        <div class="mt-9">
            <div class="mx-auto max-w-sm rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-center shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $government[0]['role'] }}</p>
                <p class="mt-2 font-display text-2xl font-bold text-slate-950">{{ $government[0]['name'] }}</p>
            </div>

            <div class="mx-auto h-10 w-px bg-slate-300"></div>

            <div class="mx-auto max-w-sm rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[.16em] text-slate-500">{{ $government[1]['role'] }}</p>
                <p class="mt-2 font-display text-xl font-bold text-slate-950">{{ $government[1]['name'] }}</p>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach (array_slice($government, 2) as $person)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $person['role'] }}</p>
                        <p class="mt-3 font-display text-xl font-bold text-slate-900">{{ $person['name'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($dusun as $person)
                    <article class="rounded-2xl border border-emerald-900/10 bg-emerald-50 p-5 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $person['role'] }}</p>
                        <p class="mt-3 font-display text-lg font-bold text-slate-900">{{ $person['name'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="eyebrow text-emerald-700">Sejarah Desa Sambo</p>
                <h2 class="section-title">Jejak tumbuh bersama masyarakat</h2>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8">
                <div class="space-y-5 text-base leading-8 text-slate-600">
                    <p>Desa Sambo tumbuh sebagai ruang hidup masyarakat yang menjaga nilai kebersamaan, gotong royong, dan musyawarah dalam menjalankan kehidupan desa.</p>
                    <p>Perkembangan desa berjalan melalui peran warga, tokoh masyarakat, dan pemerintah desa dalam membangun pelayanan, infrastruktur, pendidikan, kesehatan, serta ekonomi lokal.</p>
                    <p>Bagian sejarah ini dapat dilengkapi kembali dengan dokumen resmi desa, cerita tokoh masyarakat, tahun pembentukan desa, dan peristiwa penting yang menjadi identitas Desa Sambo.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.75fr_1.25fr]">
            <div>
                <p class="eyebrow text-emerald-700">Peta Lokasi</p>
                <h2 class="section-title">Lokasi Desa Sambo</h2>
                <p class="mt-4 leading-7 text-slate-600">Titik lokasi Desa Sambo terhubung langsung ke Google Maps melalui tautan lokasi yang telah disediakan.</p>
                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-7">Buka titik lokasi <span aria-hidden="true">&rarr;</span></a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <iframe
                    src="{{ $mapsEmbed }}"
                    class="h-[28rem] w-full"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta lokasi Desa Sambo"></iframe>
                <div class="border-t border-slate-200 p-5">
                    <p class="font-bold text-slate-900">Desa Sambo</p>
                    <p class="mt-1 text-sm text-slate-500">Kecamatan Dolo Selatan, Kabupaten Sigi, Sulawesi Tengah.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
