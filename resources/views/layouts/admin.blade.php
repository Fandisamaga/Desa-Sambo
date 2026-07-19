<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin Desa Sambo')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased">
        @php
            $adminNavigation = [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'url' => route('admin.dashboard'), 'icon' => 'D'],
                ['label' => 'Berita', 'route' => 'admin.berita.*', 'url' => route('admin.berita.index'), 'icon' => 'B'],
                ['label' => 'Kategori Berita', 'route' => 'admin.kategori-berita.*', 'url' => route('admin.kategori-berita.index'), 'icon' => 'K'],
                ['label' => 'Produk UMKM', 'route' => 'admin.produk-umkm.*', 'url' => route('admin.produk-umkm.index'), 'icon' => 'U'],
                ['label' => 'Dokumen Publik', 'route' => 'admin.dokumen-publik.*', 'url' => route('admin.dokumen-publik.index'), 'icon' => 'D'],
                ['label' => 'APBDes', 'route' => 'admin.apbdes.*', 'url' => route('admin.apbdes.index'), 'icon' => 'A'],
                ['label' => 'Kartu Keluarga', 'route' => 'admin.kartu-keluarga.*', 'url' => route('admin.kartu-keluarga.index'), 'icon' => 'K'],
                ['label' => 'Penduduk', 'route' => 'admin.penduduk.*', 'url' => route('admin.penduduk.index'), 'icon' => 'P'],
                ['label' => 'Kategori Surat', 'route' => 'admin.kategori-surat.*', 'url' => route('admin.kategori-surat.index'), 'icon' => 'S'],
                ['label' => 'Arsip Surat', 'route' => 'admin.arsip-surat.*', 'url' => route('admin.arsip-surat.index'), 'icon' => 'R'],
                ['label' => 'Pengaduan', 'route' => ['admin.pengaduan.*', 'admin.layanan.*'], 'url' => route('admin.pengaduan.index'), 'icon' => 'L'],
            ];
        @endphp

        <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-950/40 lg:hidden"></div>

        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white px-5 py-6 transition-transform lg:hidden">
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-700 text-sm font-black text-white">DS</span>
                    <span>
                        <span class="block text-[10px] font-bold uppercase tracking-[.16em] text-emerald-700">Operator</span>
                        <span class="font-display text-lg font-bold text-slate-900">Desa Sambo</span>
                    </span>
                </a>
                <button type="button" data-sidebar-close class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 text-slate-500">x</button>
            </div>
            <nav class="mt-7 space-y-1 overflow-y-auto pb-6">
                @foreach ($adminNavigation as $item)
                    @php $isActive = request()->routeIs(...(array) $item['route']); @endphp
                    <a href="{{ $item['url'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold {{ $isActive ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-800' }}">
                        <span class="grid h-6 w-6 place-items-center rounded-md bg-slate-100 text-[11px]">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <aside class="fixed inset-y-0 left-0 hidden w-72 flex-col border-r border-slate-200 bg-white px-5 py-7 lg:flex">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-2">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-700 text-sm font-black text-white">DS</span>
                <span>
                    <span class="block text-[10px] font-bold uppercase tracking-[.16em] text-emerald-700">Operator</span>
                    <span class="font-display text-xl font-bold text-slate-900">Desa Sambo</span>
                </span>
            </a>

            <p class="mt-9 px-3 text-[10px] font-bold uppercase tracking-[.16em] text-slate-400">Menu admin</p>
            <nav class="mt-3 space-y-1 overflow-y-auto pr-1">
                @foreach ($adminNavigation as $item)
                    @php $isActive = request()->routeIs(...(array) $item['route']); @endphp
                    <a href="{{ $item['url'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold {{ $isActive ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-800' }}">
                        <span class="grid h-6 w-6 place-items-center rounded-md bg-slate-100 text-[11px]">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto border-t border-slate-100 pt-5">
                <p class="px-3 text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="px-3 text-xs text-slate-500">Administrator</p>
                <div class="mt-4 flex gap-3 px-3 text-xs font-bold">
                    <a class="text-emerald-700" href="{{ route('home') }}" target="_blank">Lihat publik &rarr;</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="text-slate-500 hover:text-red-600">Keluar</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="lg:pl-72">
            <header class="flex h-20 items-center justify-between border-b border-slate-200 bg-white px-5 sm:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" data-sidebar-open class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 text-slate-600 lg:hidden">=</button>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Panel Operator</p>
                        <p class="truncate font-display text-xl font-bold text-slate-900">@yield('page-title', $heading ?? 'Dashboard')</p>
                    </div>
                </div>
                <span class="hidden rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 sm:inline-flex">Admin aktif</span>
            </header>

            <main class="p-5 sm:p-8">@yield('content')</main>
        </div>
    </body>
</html>
