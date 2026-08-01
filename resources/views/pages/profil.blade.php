@extends('layouts.public')

@section('title', 'Profil Desa | Desa Sambo')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;

        $missions = [
            'Meningkatkan kualitas pelayanan publik yang cepat, terbuka, dan mudah dijangkau masyarakat.',
            'Mendorong pembangunan desa yang merata melalui musyawarah, gotong royong, dan pemanfaatan data desa.',
            'Menguatkan ekonomi warga melalui dukungan UMKM, pertanian, dan potensi lokal Desa Sambo.',
            'Membangun lingkungan desa yang sehat, aman, religius, dan berkelanjutan.',
        ];

        $government = [
            ['role' => 'Kepala Desa', 'name' => 'SARMAN', 'photo' => 'aparat-desa/sarman.jpeg'],
            ['role' => 'Sekretaris Desa', 'name' => 'RISTO', 'photo' => 'aparat-desa/risto.jpeg'],
            ['role' => 'Kepala Seksi Pemerintahan', 'name' => 'AZHAR', 'photo' => 'aparat-desa/azhar.jpeg'],
            ['role' => 'Kepala Seksi Kesra', 'name' => 'RAHMAYANI', 'photo' => 'aparat-desa/rahmayani.jpeg'],
            ['role' => 'Kepala Seksi Pelayanan', 'name' => 'WIRZAN', 'photo' => 'aparat-desa/wirzan.jpeg'],
            ['role' => 'Kepala Urusan Umum dan Perencanaan', 'name' => 'ASMAWATI', 'photo' => 'aparat-desa/asmawati.jpeg'],
            ['role' => 'Kepala Urusan Keuangan', 'name' => 'DEBI RAHMAWATI', 'photo' => 'aparat-desa/debi-rahmawati.jpeg'],
        ];

        $dusun = [
            ['role' => 'Kepala Dusun I', 'name' => 'SAIFUL', 'photo' => 'aparat-desa/saiful.jpeg'],
            ['role' => 'Kepala Dusun II', 'name' => 'DJISMAN', 'photo' => 'aparat-desa/djisman.jpeg'],
            ['role' => 'Kepala Dusun III', 'name' => 'ARIFIN', 'photo' => 'aparat-desa/arifin.jpeg'],
            ['role' => 'Kepala Dusun IV', 'name' => 'AKBAR SALMI', 'photo' => 'aparat-desa/akbar-salmi.jpeg'],
        ];

        $mapsUrl = 'https://maps.app.goo.gl/juBGj5z5D37rCQ1r5';
        $mapsEmbed = 'https://www.google.com/maps?q=Desa%20Sambo%2C%20Dolo%20Selatan%2C%20Kabupaten%20Sigi%2C%20Sulawesi%20Tengah&output=embed';
    @endphp

    <section class="bg-white">
        <div class="container-page grid grid-cols-1 gap-10 py-12 sm:py-16 lg:grid-cols-[.92fr_1.08fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Profil Desa</p>
                <h1 class="mt-4 font-display text-3xl font-bold leading-tight text-slate-900 sm:mt-5 sm:text-6xl">Mengenal Desa Sambo</h1>
                <p class="mt-4 max-w-xl text-base leading-7 text-slate-600 sm:mt-6 sm:text-lg sm:leading-8">Halaman profil ini memuat arah pembangunan desa, struktur pemerintahan, ringkasan sejarah, dan lokasi Desa Sambo.</p>
                <div class="mt-6 flex flex-wrap gap-3 sm:mt-8">
                    <a href="#visi-misi" class="btn-primary">Lihat visi misi <span aria-hidden="true">&rarr;</span></a>
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-soft">Buka Google Maps</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <article class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 sm:rounded-2xl sm:p-6">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Wilayah</p>
                    <p class="mt-3 font-display text-2xl font-bold text-slate-950 sm:mt-4 sm:text-3xl">Desa Sambo</p>
                    <p class="mt-2 text-xs leading-5 text-slate-600 sm:mt-3 sm:text-sm sm:leading-6">Kecamatan Dolo Selatan, Kabupaten Sigi, Provinsi Sulawesi Tengah.</p>
                </article>
                <article class="rounded-xl border border-sky-200 bg-sky-50 p-4 sm:rounded-2xl sm:p-6">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-sky-700">Pemerintahan</p>
                    <p class="mt-3 font-display text-2xl font-bold text-slate-950 sm:mt-4 sm:text-3xl">4 Dusun</p>
                    <p class="mt-2 text-xs leading-5 text-slate-600 sm:mt-3 sm:text-sm sm:leading-6">Struktur pemerintahan desa disusun untuk pelayanan warga lintas dusun.</p>
                </article>
                <article class="col-span-2 rounded-xl border border-amber-200 bg-amber-50 p-4 sm:rounded-2xl sm:p-6">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-amber-700">Ruang Kolaborasi</p>
                    <p class="mt-3 font-display text-2xl font-bold text-slate-950 sm:mt-4 sm:text-3xl">Pelayanan, data, dan potensi lokal</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3">Website ini menjadi kanal informasi desa, pendataan, pelayanan, UMKM, dan program masyarakat.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="visi-misi" class="bg-slate-50 py-12 sm:py-16 lg:py-24">
        <div class="container-page grid grid-cols-1 gap-8 lg:grid-cols-[.85fr_1.15fr]">
            <article class="rounded-2xl bg-emerald-800 p-5 text-white shadow-sm sm:p-8">
                <p class="eyebrow text-lime-200">Visi</p>
                <h2 class="mt-4 font-display text-2xl font-bold leading-tight sm:text-3xl">Terwujudnya Desa Sambo yang maju, mandiri, sejahtera, dan berdaya saing melalui pelayanan yang transparan dan partisipatif.</h2>
            </article>

            <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 sm:p-8">
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

    <section class="container-page py-12 sm:py-16 lg:py-24">
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

            <div class="mt-6 grid gap-3 min-[360px]:grid-cols-2 sm:mt-8 sm:gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach (array_slice($government, 2) as $person)
                    <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:rounded-2xl sm:p-5">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $person['role'] }}</p>
                        <p class="mt-3 font-display text-xl font-bold text-slate-900">{{ $person['name'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-5 grid gap-3 min-[360px]:grid-cols-2 sm:mt-6 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($dusun as $person)
                    <article class="rounded-xl border border-emerald-900/10 bg-emerald-50 p-4 shadow-sm sm:rounded-2xl sm:p-5">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">{{ $person['role'] }}</p>
                        <p class="mt-3 font-display text-lg font-bold text-slate-900">{{ $person['name'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 sm:mt-16">
                <div class="flex flex-wrap items-end justify-between gap-5">
                    <div>
                        <p class="eyebrow text-emerald-700">Aparat Desa</p>
                        <h2 class="section-title">Foto aparat desa</h2>
                        <p class="mt-3 max-w-2xl text-slate-600">Perkenalkan aparat desa dan kepala dusun yang mendukung struktur pemerintahan Desa Sambo.</p>
                    </div>
                </div>

                <div class="mt-7 grid gap-3 min-[360px]:grid-cols-2 sm:mt-9 sm:gap-5 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach (array_merge($government, $dusun) as $person)
                        @php
                            $photoUrl = Storage::disk('public')->exists($person['photo'])
                                ? asset('storage/' . $person['photo'])
                                : 'https://ui-avatars.com/api/?name=' . urlencode($person['name']) . '&background=10b981&color=ffffff&size=512';
                        @endphp

                        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm sm:rounded-3xl">
                            <img src="{{ $photoUrl }}" alt="Foto {{ $person['name'] }}" class="h-40 w-full object-cover sm:h-56">
                            <div class="p-3 sm:p-5">
                                <p class="text-[10px] font-bold uppercase tracking-[.12em] text-emerald-700 sm:text-xs sm:tracking-[.16em]">{{ $person['role'] }}</p>
                                <p class="mt-2 font-display text-base font-bold text-slate-950 sm:mt-3 sm:text-xl">{{ $person['name'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-12 sm:py-16 lg:py-24">
        <div class="container-page grid grid-cols-1 gap-10 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="eyebrow text-emerald-700">Sejarah Desa Sambo</p>
                <h2 class="section-title">Jejak tumbuh bersama masyarakat</h2>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-8">
                <div class="space-y-5 text-base leading-8 text-slate-600">
                    <p>Desa Sambo tumbuh sebagai ruang hidup masyarakat yang menjaga nilai kebersamaan, gotong royong, dan musyawarah dalam menjalankan kehidupan desa.</p>
                    <p>Perkembangan desa berjalan melalui peran warga, tokoh masyarakat, dan pemerintah desa dalam membangun pelayanan, infrastruktur, pendidikan, kesehatan, serta ekonomi lokal.</p>
                    <p>Bagian sejarah ini dapat dilengkapi kembali dengan dokumen resmi desa, cerita tokoh masyarakat, tahun pembentukan desa, dan peristiwa penting yang menjadi identitas Desa Sambo.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-12 sm:py-16 lg:py-24">
        <div class="container-page grid grid-cols-1 gap-10 lg:grid-cols-[.75fr_1.25fr]">
            <div>
                <p class="eyebrow text-emerald-700">Peta Lokasi</p>
                <h2 class="section-title">Lokasi Desa Sambo</h2>
                <p class="mt-4 leading-7 text-slate-600">Titik lokasi Desa Sambo terhubung langsung ke Google Maps melalui tautan lokasi yang telah disediakan.</p>
                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-7">Buka titik lokasi <span aria-hidden="true">&rarr;</span></a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <iframe
                    src="{{ $mapsEmbed }}"
                    class="h-80 w-full sm:h-[28rem]"
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
