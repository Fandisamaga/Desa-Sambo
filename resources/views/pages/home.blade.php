@extends('layouts.public')

@section('content')
    <section class="hero-section overflow-hidden">
        <div class="container-page relative grid items-center gap-12 py-16 lg:grid-cols-[1.05fr_.95fr] lg:py-24">
            <div class="relative z-10">
                <p class="eyebrow text-emerald-700">Selamat datang di ruang digital kami</p>
                <h1 class="mt-5 max-w-3xl font-display text-5xl font-bold leading-[1.05] text-slate-900 sm:text-6xl">
                    Sambo tumbuh melalui <span class="text-emerald-700">kebersamaan.</span>
                </h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-slate-600 sm:text-lg">
                    Informasi desa, layanan masyarakat, UMKM lokal, dan kegiatan KKN tersedia dalam satu tempat yang mudah diakses.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('profil') }}" class="btn-primary">Jelajahi Desa <span>→</span></a>
                    <a href="{{ route('layanan') }}" class="btn-soft">Ajukan Layanan</a>
                </div>

                <div class="mt-12 grid max-w-lg grid-cols-3 gap-5 border-t border-emerald-900/10 pt-6">
                    <div>
                        <p class="font-display text-2xl font-bold text-slate-900">1.248</p>
                        <p class="mt-1 text-xs text-slate-500">Warga terlayani</p>
                    </div>
                    <div>
                        <p class="font-display text-2xl font-bold text-slate-900">4</p>
                        <p class="mt-1 text-xs text-slate-500">Dusun</p>
                    </div>
                    <div>
                        <p class="font-display text-2xl font-bold text-slate-900">12</p>
                        <p class="mt-1 text-xs text-slate-500">Program aktif</p>
                    </div>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-lg">
                <div class="hero-orb hero-orb-one"></div>
                <div class="hero-orb hero-orb-two"></div>
                <div class="relative overflow-hidden rounded-4xl border border-emerald-900/10 bg-white p-5 shadow-xl">
                    <div class="rounded-[1.4rem] bg-[linear-gradient(145deg,#edf7e8_0%,#b7dbb9_45%,#49876b_100%)] p-7 pt-32">
                        <p class="max-w-56 font-display text-3xl font-bold leading-tight text-emerald-950">
                            Alam, budaya, dan warga yang saling menguatkan.
                        </p>
                    </div>

                    <div class="-mt-5 mx-3 rounded-2xl bg-white p-5 shadow-lg ring-1 ring-slate-900/5">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Info terkini</p>
                        <p class="mt-2 font-display text-xl font-bold text-slate-900">Gotong royong bersih desa</p>
                        <p class="mt-2 text-sm text-slate-500">Minggu, 20 Juli · Lapangan Desa</p>
                    </div>
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
            <a href="{{ route('umkm') }}" class="link-arrow">Jelajahi UMKM →</a>
        </div>

        <div class="mt-9 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($umkm as $item)
                <article class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="umkm-cover {{ $item['color'] }}">
                        <span>{{ $item['icon'] }}</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">{{ $item['category'] }}</p>
                        <h3 class="mt-2 font-display text-xl font-bold text-slate-900">{{ $item['name'] }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $item['owner'] }}</p>
                        <a href="{{ route('umkm') }}" class="mt-5 inline-block text-sm font-bold text-emerald-700">Lihat produk →</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Akses cepat</p>
                <h2 class="section-title">Layanan untuk masyarakat</h2>
            </div>
            <a href="{{ route('layanan') }}" class="link-arrow">Lihat semua layanan →</a>
        </div>

        <div class="mt-9 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($services as $service)
                <a href="{{ route('layanan') }}" class="service-card">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-xl">{{ $service['icon'] }}</span>
                    <h3>{{ $service['title'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                    <span class="mt-auto text-sm font-bold text-emerald-700">Ajukan →</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Infografis Desa</p>
                <h2 class="section-title">Sekilas data Desa Sambo</h2>
                <p class="mt-3 max-w-xl text-slate-600">Visualisasi singkat tentang layanan, partisipasi warga, dan keberlanjutan desa.</p>
            </div>
            <a href="{{ route('infografis') }}" class="link-arrow">Lihat info grafis →</a>
        </div>

        <div class="mt-9 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border border-emerald-900/10 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Cakupan digital</p>
                <p class="mt-4 text-4xl font-display font-bold text-slate-900">100%</p>
                <p class="mt-2 text-sm leading-6 text-slate-500">Akses informasi desa dan layanan online tersedia untuk seluruh warga.</p>
            </article>

            <article class="rounded-3xl border border-emerald-900/10 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Partisipasi warga</p>
                <p class="mt-4 text-4xl font-display font-bold text-slate-900">4</p>
                <p class="mt-2 text-sm leading-6 text-slate-500">Dusun aktif berkolaborasi dalam program pembangunan dan kegiatan komunitas.</p>
            </article>

            <article class="rounded-3xl border border-emerald-900/10 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Program desa</p>
                <p class="mt-4 text-4xl font-display font-bold text-slate-900">12</p>
                <p class="mt-2 text-sm leading-6 text-slate-500">Inisiatif aktif yang mendukung lingkungan, edukasi, kesehatan, dan UMKM lokal.</p>
            </article>

            <article class="rounded-3xl border border-emerald-900/10 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Kebersamaan</p>
                <p class="mt-4 text-4xl font-display font-bold text-slate-900">97%</p>
                <p class="mt-2 text-sm leading-6 text-slate-500">Tingkat kepuasan warga terhadap pelayanan desa dan komunikasi publik.</p>
            </article>
        </div>
    </section>

    <section class="bg-emerald-50/70 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="eyebrow text-emerald-700">Kabar Sambo</p>
                <h2 class="section-title">Cerita dan kegiatan desa</h2>
                <p class="mt-4 max-w-sm leading-7 text-slate-600">Ikuti pembaruan program desa dan kontribusi mahasiswa KKN untuk Sambo.</p>
                <a href="{{ route('berita') }}" class="btn-primary mt-7">Semua berita <span>→</span></a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($news as $item)
                    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-emerald-950/5">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">{{ $item['category'] }}</p>
                        <h3 class="mt-3 font-display text-xl font-bold text-slate-900">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-500">{{ $item['excerpt'] }}</p>
                        <p class="mt-5 text-xs font-medium text-slate-400">{{ $item['date'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container-page py-16 lg:py-24">
        <div class="rounded-4xl bg-slate-900 px-7 py-10 text-white sm:px-12 lg:flex lg:items-center lg:justify-between">
            <div>
                <p class="eyebrow text-lime-300">Kolaborasi KKN</p>
                <h2 class="mt-3 font-display text-3xl font-bold">Punya ide untuk Desa Sambo?</h2>
                <p class="mt-3 max-w-xl text-slate-300">Mari berkolaborasi untuk kegiatan yang bermanfaat bagi warga dan masa depan desa.</p>
            </div>
            <a href="{{ route('kkn') }}" class="btn-light mt-7 lg:mt-0">Program KKN <span>→</span></a>
        </div>
    </section>
@endsection
