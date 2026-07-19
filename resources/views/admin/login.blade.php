<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk Operator | Desa Sambo</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="grid min-h-screen place-items-center bg-emerald-50 p-5">
        <main class="w-full max-w-md rounded-lg bg-white p-8 shadow-xl shadow-emerald-950/10 ring-1 ring-emerald-900/5">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-700 text-sm font-black text-white">DS</span>
                <span>
                    <span class="block text-[10px] font-bold uppercase tracking-[.16em] text-emerald-700">Panel Operator</span>
                    <span class="font-display text-xl font-bold text-slate-900">Desa Sambo</span>
                </span>
            </a>

            <h1 class="mt-9 font-display text-3xl font-bold text-slate-900">Masuk ke dashboard</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Akses ini khusus untuk administrator website desa.</p>

            @if ($errors->any())
                <p class="mt-5 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="email" class="label">Email</label>
                    <input id="email" class="input" name="email" type="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div>
                    <label for="password" class="label">Kata sandi</label>
                    <input id="password" class="input" name="password" type="password" required>
                </div>

                <button class="btn-primary w-full justify-center" type="submit">Masuk dashboard &rarr;</button>
            </form>

            <a class="mt-6 block text-center text-sm font-bold text-emerald-700" href="{{ route('home') }}">&larr; Kembali ke website publik</a>
        </main>
    </body>
</html>
