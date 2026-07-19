@extends('layouts.admin')

@section('title', 'Dashboard Operator | Desa Sambo')

@section('content')
    @php
        $stats = [
            ['label' => 'Berita dipublikasikan', 'value' => '0', 'note' => 'Siap dikelola'],
            ['label' => 'UMKM terdaftar', 'value' => '0', 'note' => 'Siap ditambahkan'],
            ['label' => 'Layanan masuk', 'value' => '0', 'note' => 'Belum ada pengajuan'],
            ['label' => 'Pengunjung hari ini', 'value' => '-', 'note' => 'Integrasi analitik nanti'],
        ];

        $activities = [
            ['icon' => 'B', 'text' => 'Modul berita siap untuk dibuatkan CRUD.', 'time' => 'Template awal'],
            ['icon' => 'U', 'text' => 'Etalase UMKM siap menerima data produk.', 'time' => 'Template awal'],
            ['icon' => 'L', 'text' => 'Pengajuan layanan akan tampil di sini.', 'time' => 'Template awal'],
        ];
    @endphp
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-3 font-display text-3xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                <p class="mt-2 text-xs font-semibold text-emerald-700">{{ $stat['note'] }}</p>
            </article>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.35fr_.65fr]">
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-slate-900">Aktivitas terbaru</p>
                    <p class="mt-1 text-sm text-slate-500">Ringkasan konten yang perlu diperhatikan.</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-sm font-bold text-emerald-700">Kelola berita →</a>
            </div>

            <div class="mt-6 divide-y divide-slate-100">
                @foreach ($activities as $activity)
                    <div class="flex gap-4 py-4 first:pt-0">
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-50 text-sm">{{ $activity['icon'] }}</span>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $activity['text'] }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-emerald-800 p-6 text-white">
            <p class="text-sm font-bold">Akses cepat CRUD</p>
            <p class="mt-2 text-sm leading-6 text-emerald-100">
                Gunakan menu untuk menambah, mengubah, atau menghapus data yang tampil kepada masyarakat.
            </p>

            <div class="mt-6 space-y-3">
                <a href="{{ route('admin.umkm.index') }}" class="block rounded-xl bg-white/10 px-4 py-3 text-sm font-bold hover:bg-white/15">
                    Kelola UMKM →
                </a>
                <a href="{{ route('admin.layanan.index') }}" class="block rounded-xl bg-white/10 px-4 py-3 text-sm font-bold hover:bg-white/15">
                    Tinjau pengajuan layanan →
                </a>
            </div>
        </section>
    </div>
@endsection
