@extends('layouts.public')

@section('title', 'Layanan Masyarakat | Desa Sambo')

@section('content')
    @php
        $formatNumber = fn (int $value) => number_format($value, 0, ',', '.');
        $activeFocus = $focus ?? null;

        $services = [
            [
                'key' => 'domisili',
                'icon' => 'SD',
                'eyebrow' => 'Administrasi warga',
                'title' => 'Surat Keterangan Domisili',
                'description' => 'Permohonan keterangan domisili untuk kebutuhan sekolah, kerja, bantuan, pindah administrasi, atau keperluan resmi lain.',
                'href' => route('layanan.domisili') . '#surat-domisili',
                'cta' => 'Lihat persyaratan',
                'tone' => 'bg-emerald-700 text-white',
                'surface' => 'bg-emerald-50 text-emerald-800 ring-emerald-100',
                'requirements' => ['Fotokopi KK atau KTP', 'Keterangan tujuan penggunaan surat', 'Nomor kontak aktif pemohon'],
                'admin' => 'Dicatat sebagai Arsip Surat setelah diterbitkan operator.',
            ],
            [
                'key' => 'pengantar',
                'icon' => 'KK',
                'eyebrow' => 'Kependudukan',
                'title' => 'Surat Pengantar KK/KTP',
                'description' => 'Pengantar untuk pembaruan data keluarga, KTP, perpindahan, perubahan elemen data, dan kebutuhan layanan kependudukan.',
                'href' => route('layanan.pengantar') . '#surat-pengantar',
                'cta' => 'Lihat alur surat',
                'tone' => 'bg-sky-700 text-white',
                'surface' => 'bg-sky-50 text-sky-800 ring-sky-100',
                'requirements' => ['Fotokopi KK', 'Fotokopi KTP pemohon', 'Dokumen pendukung perubahan data'],
                'admin' => 'Mengikuti data Penduduk dan Kartu Keluarga pada panel admin.',
            ],
            [
                'key' => 'pengaduan',
                'icon' => 'PM',
                'eyebrow' => 'Aspirasi warga',
                'title' => 'Pengaduan Masyarakat',
                'description' => 'Sampaikan laporan fasilitas umum, pelayanan, keamanan lingkungan, kebersihan, atau aspirasi pembangunan desa.',
                'href' => route('layanan.pengaduan') . '#pengaduan-form',
                'cta' => 'Isi pengaduan',
                'tone' => 'bg-amber-600 text-white',
                'surface' => 'bg-amber-50 text-amber-800 ring-amber-100',
                'requirements' => ['Nama pengirim', 'Kontak yang bisa dihubungi', 'Uraian aduan yang jelas'],
                'admin' => 'Laporan masyarakat akan masuk ke panel admin desa untuk ditinjau.',
            ],
        ];

        $steps = [
            ['label' => 'Pilih layanan', 'description' => 'Warga memilih jenis surat atau kanal pengaduan yang sesuai kebutuhan.'],
            ['label' => 'Lengkapi data', 'description' => 'Berkas dan identitas disiapkan sesuai kategori layanan.'],
            ['label' => 'Verifikasi operator', 'description' => 'Operator desa mengecek data melalui panel admin.'],
            ['label' => 'Tindak lanjut', 'description' => 'Surat diterbitkan sebagai arsip atau pengaduan ditinjau oleh operator desa.'],
        ];
    @endphp

    <section class="bg-white">
        <div class="container-page grid items-center gap-12 py-16 lg:grid-cols-[1.02fr_.98fr] lg:py-24">
            <div>
                <p class="eyebrow text-emerald-700">Pelayanan Desa</p>
                <h1 class="mt-5 max-w-3xl font-display text-5xl font-bold leading-tight text-slate-950 sm:text-6xl">Layanan Masyarakat Desa Sambo</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                    Akses layanan surat, pengantar administrasi kependudukan, dan pengaduan warga dalam satu halaman yang tersambung dengan data admin desa.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#pengaduan-form" class="btn-primary">Ajukan pengaduan <span aria-hidden="true">&rarr;</span></a>
                    <a href="#layanan-surat" class="btn-soft">Lihat layanan surat</a>
                </div>
            </div>

            <div class="rounded-2xl bg-slate-950 p-6 text-white shadow-xl shadow-slate-950/15">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-white/10 pb-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.18em] text-lime-300">Kantor Desa Sambo</p>
                        <h2 class="mt-3 font-display text-3xl font-bold">Jam pelayanan</h2>
                    </div>
                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-white ring-1 ring-white/10">08.00-15.00 WITA</span>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl bg-white/10 p-4 ring-1 ring-white/10">
                        <p class="text-sm font-bold text-white">Senin-Jumat</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Pelayanan administrasi, surat, dan konsultasi warga.</p>
                    </div>
                    <div class="rounded-xl bg-white/10 p-4 ring-1 ring-white/10">
                        <p class="text-sm font-bold text-white">Tindak lanjut</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Laporan diterima dan akan ditinjau oleh operator desa.</p>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    @foreach ($steps as $step)
                        <div class="flex gap-3 rounded-xl bg-white/[.06] p-4 ring-1 ring-white/10">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-lime-300 text-sm font-black text-emerald-950">{{ $loop->iteration }}</span>
                            <div>
                                <p class="font-bold">{{ $step['label'] }}</p>
                                <p class="mt-1 text-sm leading-6 text-slate-300">{{ $step['description'] }}</p>
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

    <section id="layanan-surat" class="container-page py-16 lg:py-24">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="eyebrow text-emerald-700">Akses cepat</p>
                <h2 class="section-title">Pilih layanan yang dibutuhkan</h2>
                <p class="mt-3 max-w-2xl leading-7 text-slate-600">Kartu layanan disusun mengikuti modul admin: kategori surat, arsip surat, data penduduk, dan pengaduan masyarakat.</p>
            </div>
            <a href="#kategori-surat" class="link-arrow">Lihat kategori surat &rarr;</a>
        </div>

        <div class="mt-9 grid gap-5 lg:grid-cols-3">
            @foreach ($services as $service)
                @php $isFocused = $activeFocus === $service['key']; @endphp
                <article class="flex min-h-[28rem] flex-col rounded-2xl border bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg {{ $isFocused ? 'border-emerald-500 ring-4 ring-emerald-100' : 'border-slate-200' }}">
                    <div class="flex items-start justify-between gap-4">
                        <span class="grid h-12 w-12 place-items-center rounded-xl text-sm font-black {{ $service['tone'] }}">{{ $service['icon'] }}</span>
                        <span class="rounded-full px-3 py-1 text-xs font-bold ring-1 {{ $service['surface'] }}">{{ $service['eyebrow'] }}</span>
                    </div>

                    <h3 class="mt-6 font-display text-2xl font-bold text-slate-950">{{ $service['title'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service['description'] }}</p>

                    <div class="mt-6 space-y-3">
                        @foreach ($service['requirements'] as $requirement)
                            <div class="flex gap-3 text-sm text-slate-600">
                                <span class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full bg-emerald-50 text-xs font-black text-emerald-700">&check;</span>
                                <span>{{ $requirement }}</span>
                            </div>
                        @endforeach
                    </div>

                    <p class="mt-6 rounded-xl bg-slate-50 p-4 text-xs font-semibold leading-5 text-slate-500">{{ $service['admin'] }}</p>
                    <a href="{{ $service['href'] }}" class="btn-soft mt-auto justify-center">{{ $service['cta'] }} <span aria-hidden="true">&rarr;</span></a>
                </article>
            @endforeach
        </div>
    </section>

    <section id="kategori-surat" class="bg-white py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.82fr_1.18fr]">
            <div>
                <p class="eyebrow text-emerald-700">Kategori Surat</p>
                <h2 class="section-title">Jenis surat dari CRUD admin</h2>
                <p class="mt-4 leading-7 text-slate-600">Daftar ini mengikuti data pada menu admin Kategori Surat. Jika operator menambah kategori baru, halaman layanan akan ikut menampilkannya.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <div class="flex flex-wrap gap-3">
                    @foreach ($kategoriSurat as $kategori)
                        <span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-slate-200">{{ $kategori }}</span>
                    @endforeach
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div id="surat-domisili" class="rounded-xl bg-white p-5 ring-1 ring-slate-200">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Domisili</p>
                        <h3 class="mt-3 font-display text-xl font-bold text-slate-950">Surat Keterangan Domisili</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Untuk warga yang membutuhkan keterangan tempat tinggal sesuai wilayah Desa Sambo.</p>
                    </div>
                    <div id="surat-pengantar" class="rounded-xl bg-white p-5 ring-1 ring-slate-200">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-sky-700">Pengantar</p>
                        <h3 class="mt-3 font-display text-xl font-bold text-slate-950">Surat Pengantar KK/KTP</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Untuk kebutuhan administrasi kependudukan yang memerlukan pengantar dari desa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 py-16 lg:py-24">
        <div class="container-page grid gap-10 lg:grid-cols-[.9fr_1.1fr]">
            <div>
                <p class="eyebrow text-emerald-700">Monitoring Pengaduan</p>
                <h2 class="section-title">Ringkasan laporan warga</h2>
                <p class="mt-4 max-w-xl leading-7 text-slate-600">Laporan yang masuk akan ditinjau langsung oleh operator desa melalui panel admin.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="space-y-4 text-sm text-slate-600">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="font-bold text-slate-900">Jumlah laporan masuk</p>
                        <p class="mt-2">{{ $formatNumber((int) ($stats[2]['value'] ?? 0)) }} pengaduan tercatat.</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="font-bold text-slate-900">Perhatian operator</p>
                        <p class="mt-2">Semua laporan akan ditinjau tanpa menampilkan status berjenjang di halaman publik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pengaduan-form" class="container-page py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-[.82fr_1.18fr]">
            <div>
                <p class="eyebrow text-emerald-700">Form Pengaduan</p>
                <h2 class="section-title">Sampaikan laporan ke pemerintah desa</h2>
                <p class="mt-4 leading-7 text-slate-600">Form ini memuat nama pengirim, kontak pengirim, dan isi aduan untuk melaporkan kebutuhan atau masalah masyarakat.</p>

                <div class="mt-7 rounded-2xl bg-emerald-800 p-6 text-white">
                    <p class="font-display text-2xl font-bold">Agar cepat diproses</p>
                    <div class="mt-5 space-y-3 text-sm leading-6 text-emerald-50">
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
                    <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 ring-1 ring-amber-100">Laporan akan ditinjau operator</span>
                    <button type="submit" class="btn-primary">Kirim pengaduan <span aria-hidden="true">&rarr;</span></button>
                </div>
            </form>
        </div>
    </section>
@endsection
