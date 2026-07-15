<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0f5d45">
        <title>{{ $title ?? 'Desa Sambo' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-stone-50 text-slate-800 antialiased">
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/45 lg:hidden"></div>
        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 flex w-80 -translate-x-full flex-col bg-white px-6 py-6 shadow-2xl transition-transform duration-300 lg:hidden" aria-label="Navigasi utama">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-700 text-sm font-black text-white">DS</span>
                    <span><span class="block text-xs font-semibold uppercase tracking-[.16em] text-emerald-700">Website Resmi</span><span class="font-display text-xl font-bold text-slate-900">Desa Sambo</span></span>
                </a>
                <button type="button" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100" data-sidebar-close aria-label="Tutup menu">✕</button>
            </div>
            <nav class="mt-10 space-y-1">
                @foreach ($navigation as $item)
                    <a href="{{ $item['url'] }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs($item['route']) ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>
            <div class="mt-auto rounded-2xl bg-emerald-800 p-5 text-emerald-50">
                <p class="text-sm font-bold">Butuh bantuan?</p>
                <p class="mt-1 text-xs leading-5 text-emerald-100">Hubungi kantor desa pada jam pelayanan.</p>
                <a href="{{ route('layanan') }}" class="mt-4 inline-flex text-sm font-bold underline underline-offset-4">Layanan masyarakat →</a>
            </div>
        </aside>

        <header class="relative z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur">
            <div class="container-page flex h-20 items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="Beranda Desa Sambo">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-700 text-sm font-black text-white shadow-lg shadow-emerald-900/15">DS</span>
                    <span><span class="block text-[10px] font-bold uppercase tracking-[.18em] text-emerald-700">Website Resmi</span><span class="font-display text-xl font-bold text-slate-900">Desa Sambo</span></span>
                </a>
                <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['url'] }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs($item['route']) ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:text-emerald-700' }}">{{ $item['label'] }}</a>
                    @endforeach
                </nav>
                <a href="{{ route('layanan') }}" class="btn-primary hidden sm:inline-flex">Layanan Online <span aria-hidden="true">→</span></a>
                <button type="button" class="rounded-xl border border-slate-200 p-2.5 text-slate-700 lg:hidden" data-sidebar-open aria-label="Buka menu"><span class="block text-xl leading-none">☰</span></button>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="bg-slate-950 text-slate-300">
            <div class="container-page grid gap-10 py-14 md:grid-cols-[1.3fr_.7fr_.9fr]">
                <div>
                    <p class="font-display text-2xl font-bold text-white">Desa Sambo</p>
                    <p class="mt-3 max-w-sm text-sm leading-6 text-slate-400">Media informasi, pelayanan, dan kolaborasi warga Desa Sambo.</p>
                </div>
                <div><p class="text-sm font-bold text-white">Tautan cepat</p><div class="mt-4 space-y-2 text-sm">@foreach ($navigation as $item)<a class="block hover:text-white" href="{{ $item['url'] }}">{{ $item['label'] }}</a>@endforeach</div></div>
                <div><p class="text-sm font-bold text-white">Kontak kantor desa</p><p class="mt-4 text-sm leading-6 text-slate-400">Desa Sambo, Indonesia<br>Senin–Jumat, 08.00–15.00 WITA</p></div>
            </div>
            <div class="border-t border-white/10"><div class="container-page py-5 text-xs text-slate-500">© {{ date('Y') }} Pemerintah Desa Sambo. Dibangun untuk pelayanan masyarakat.</div></div>
        </footer>
    </body>
</html>
