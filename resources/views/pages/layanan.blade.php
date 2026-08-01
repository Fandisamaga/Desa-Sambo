@extends('layouts.public')

@section('title', 'Layanan Pengaduan | Desa Sambo')

@section('content')
    @php
        $steps = [
            ['label' => 'Tulis laporan', 'description' => 'Warga mengisi nama, kontak, dan isi pengaduan dengan jelas.'],
            ['label' => 'Tersimpan untuk admin', 'description' => 'Laporan masuk ke panel admin desa untuk dibaca.'],
            ['label' => 'Dibaca admin desa', 'description' => 'Admin desa dapat melihat isi laporan dan kontak pengirim tanpa proses status atau balasan di website.'],
        ];
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

    <section id="pengaduan-form" class="container-page py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-[.82fr_1.18fr]">
            <div>
                <p class="eyebrow text-emerald-700">Form Pengaduan</p>
                <h2 class="section-title">Sampaikan laporan ke pemerintah desa</h2>
                <p class="mt-4 leading-7 text-slate-600">Tuliskan laporan dengan jelas agar pemerintah desa dapat memahami kebutuhan, lokasi, dan kontak yang bisa dihubungi.</p>
                <div class="mt-7 rounded-2xl border border-emerald-100 bg-emerald-50 p-6 text-slate-900">
                        <p class="font-display text-2xl font-bold text-slate-950">Agar mudah dibaca</p>
                        <div class="mt-5 space-y-3 text-sm leading-6 text-slate-600">
                            <p>Sertakan lokasi kejadian atau layanan yang dimaksud.</p>
                            <p>Gunakan kontak aktif agar admin desa dapat mengenali pengirim laporan.</p>
                            <p>Laporan akan tersimpan dan dapat dibaca oleh admin desa.</p>
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
                    <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 ring-1 ring-emerald-100">Tersimpan untuk admin desa</span>
                    <button type="submit" class="btn-primary">Kirim pengaduan <span aria-hidden="true">&rarr;</span></button>
                </div>
            </form>
        </div>
    </section>
@endsection
