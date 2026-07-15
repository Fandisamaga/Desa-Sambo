<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $title ?? 'Admin Desa Sambo' }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
    <body class="bg-slate-50 text-slate-800 antialiased">
        <aside class="fixed inset-y-0 left-0 hidden w-72 flex-col border-r border-slate-200 bg-white px-5 py-7 lg:flex">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-2"><span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-700 text-sm font-black text-white">DS</span><span><span class="block text-[10px] font-bold uppercase tracking-[.16em] text-emerald-700">Operator</span><span class="font-display text-xl font-bold text-slate-900">Desa Sambo</span></span></a>
            <p class="mt-10 px-3 text-[10px] font-bold uppercase tracking-[.16em] text-slate-400">Monitoring &amp; kelola</p>
            <nav class="mt-3 space-y-1">
                @foreach ($adminNavigation as $item)
                    <a href="{{ $item['url'] }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold {{ request()->routeIs($item['route']) ? 'bg-emerald-50 text-emerald-800' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-800' }}"><span class="grid h-6 w-6 place-items-center rounded-md bg-slate-100 text-[11px]">{{ $item['icon'] }}</span>{{ $item['label'] }}</a>
                @endforeach
            </nav>
            <div class="mt-auto border-t border-slate-100 pt-5"><p class="px-3 text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p><p class="px-3 text-xs text-slate-500">Administrator</p><div class="mt-4 flex gap-3 px-3 text-xs font-bold"><a class="text-emerald-700" href="{{ route('home') }}" target="_blank">Lihat publik ↗</a><form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="text-slate-500 hover:text-red-600">Keluar</button></form></div></div>
        </aside>
        <div class="lg:pl-72"><header class="flex h-20 items-center justify-between border-b border-slate-200 bg-white px-5 sm:px-8"><div><p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Panel Operator</p><p class="font-display text-xl font-bold text-slate-900">{{ $heading ?? 'Dashboard' }}</p></div><span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">Admin aktif</span></header><main class="p-5 sm:p-8">@yield('content')</main></div>
    </body>
</html>
