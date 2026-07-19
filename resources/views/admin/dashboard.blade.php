@extends('layouts.admin')

@section('title', 'Dashboard Operator | Desa Sambo')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <a href="{{ route($stat['route']) }}" class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-3 font-display text-3xl font-bold text-slate-900">{{ number_format((int) $stat['value'], 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-semibold text-emerald-700">{{ $stat['note'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.35fr_.65fr]">
        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-900">Aktivitas terbaru</p>
                    <p class="mt-1 text-sm text-slate-500">Ringkasan data terakhir dari modul admin.</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-sm font-bold text-emerald-700">Kelola berita &rarr;</a>
            </div>

            <div class="mt-6 divide-y divide-slate-100">
                @foreach ($activities as $activity)
                    <a href="{{ route($activity['route']) }}" class="flex gap-4 py-4 first:pt-0 hover:bg-slate-50">
                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-emerald-50 text-sm font-bold text-emerald-700">{{ $activity['icon'] }}</span>
                        <span>
                            <span class="block text-sm font-semibold text-slate-800">{{ $activity['text'] }}</span>
                            <span class="mt-1 block text-xs text-slate-500">{{ $activity['time'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg bg-emerald-800 p-6 text-white">
            <p class="text-sm font-bold">Akses cepat CRUD</p>
            <div class="mt-6 space-y-3">
                <a href="{{ route('admin.produk-umkm.index') }}" class="block rounded-lg bg-white/10 px-4 py-3 text-sm font-bold hover:bg-white/15">
                    Kelola UMKM &rarr;
                </a>
                <a href="{{ route('admin.pengaduan.index') }}" class="block rounded-lg bg-white/10 px-4 py-3 text-sm font-bold hover:bg-white/15">
                    Tinjau pengaduan &rarr;
                </a>
                <a href="{{ route('admin.apbdes.index') }}" class="block rounded-lg bg-white/10 px-4 py-3 text-sm font-bold hover:bg-white/15">
                    Kelola APBDes &rarr;
                </a>
            </div>
        </section>
    </div>
@endsection
