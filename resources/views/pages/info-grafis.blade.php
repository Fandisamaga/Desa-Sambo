@extends('layouts.public')

@section('content')
    @php
        $statToneClasses = [
            'emerald' => ['card' => 'border-emerald-200 bg-emerald-50', 'accent' => 'bg-emerald-700', 'text' => 'text-emerald-700'],
            'amber' => ['card' => 'border-amber-200 bg-amber-50', 'accent' => 'bg-amber-500', 'text' => 'text-amber-700'],
            'sky' => ['card' => 'border-sky-200 bg-sky-50', 'accent' => 'bg-sky-600', 'text' => 'text-sky-700'],
            'rose' => ['card' => 'border-rose-200 bg-rose-50', 'accent' => 'bg-rose-500', 'text' => 'text-rose-700'],
        ];
        $formatRupiah = fn ($amount) => 'Rp'.number_format($amount, 0, ',', '.');
        $formatShortRupiah = fn ($amount) => 'Rp'.number_format($amount / 1000000000, 2, ',', '.').' M';
        $apbdesChartMax = max(array_merge(array_column($apbdesStats['years'], 'income'), array_column($apbdesStats['years'], 'spending')));
    @endphp

    <section class="bg-white">
        <div class="container-page py-10 sm:py-14 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-[.9fr_1.1fr] lg:items-start">
                <div>
                    <h1 class="max-w-xl text-5xl font-black uppercase leading-tight text-emerald-700 sm:text-6xl lg:text-7xl">
                        Infografis<br>Desa Sambo
                    </h1>
                </div>

                <div class="lg:pt-2">
                    <div class="grid grid-cols-3 border-b border-slate-200" data-infographic-tabs role="tablist" aria-label="Kategori infografis">
                        @foreach ($infographicTabs as $tab)
                            <button type="button" class="group flex min-h-28 flex-col items-center justify-end gap-2 border-b-2 px-2 pb-3 text-center text-sm font-extrabold transition hover:text-emerald-700 {{ $loop->first ? 'border-emerald-700 text-slate-700' : 'border-transparent text-slate-500' }}" data-infographic-tab="{{ $tab['key'] }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}" aria-controls="panel-{{ $tab['key'] }}">
                                @if ($tab['key'] === 'penduduk')
                                    <svg class="h-11 w-11 stroke-current sm:h-14 sm:w-14" viewBox="0 0 64 64" fill="none" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="23" cy="20" r="9"></circle>
                                        <path d="M8 48v-4c0-8 6-14 15-14s15 6 15 14v4"></path>
                                        <circle cx="44" cy="20" r="7"></circle>
                                        <path d="M43 31c7 0 12 5 12 12v5"></path>
                                    </svg>
                                @elseif ($tab['key'] === 'apbdes')
                                    <svg class="h-11 w-11 stroke-current sm:h-14 sm:w-14" viewBox="0 0 64 64" fill="none" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="9" y="13" width="35" height="23" rx="5"></rect>
                                        <rect x="18" y="22" width="35" height="23" rx="5"></rect>
                                        <circle cx="36" cy="33.5" r="5"></circle>
                                    </svg>
                                @else
                                    <svg class="h-11 w-11 stroke-current sm:h-14 sm:w-14" viewBox="0 0 64 64" fill="none" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M10 48h10V31H10z"></path>
                                        <path d="M27 48h10V21H27z"></path>
                                        <path d="M44 48h10V10H44z"></path>
                                    </svg>
                                @endif
                                <span>{{ $tab['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-14">
                @foreach ($infographicTabs as $tab)
                    <section id="panel-{{ $tab['key'] }}" class="{{ $loop->first ? '' : 'hidden' }}" data-infographic-panel="{{ $tab['key'] }}" role="tabpanel">
                        @if ($tab['key'] === 'penduduk')
                            <div>
                                <div class="flex flex-wrap items-end justify-between gap-5">
                                    <div>
                                        <p class="eyebrow text-emerald-700">Data Penduduk</p>
                                        <h2 class="section-title">Ringkasan kependudukan</h2>
                                    </div>
                                    <p class="rounded-full bg-slate-100 px-4 py-2 text-xs font-bold text-slate-500">Data awal, siap disesuaikan</p>
                                </div>

                                <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                    @foreach ($populationStats['summary'] as $stat)
                                        <article class="rounded-2xl border p-6 shadow-sm {{ $statToneClasses[$stat['tone']]['card'] }}">
                                            <span class="block h-1.5 w-12 rounded-full {{ $statToneClasses[$stat['tone']]['accent'] }}"></span>
                                            <p class="mt-5 text-xs font-bold uppercase tracking-[.16em] {{ $statToneClasses[$stat['tone']]['text'] }}">{{ $stat['label'] }}</p>
                                            <div class="mt-3 flex items-end gap-2">
                                                <p class="font-display text-4xl font-bold leading-none text-slate-950">{{ $stat['value'] }}</p>
                                                <p class="pb-1 text-sm font-bold text-slate-500">{{ $stat['unit'] }}</p>
                                            </div>
                                            <p class="mt-4 text-sm leading-6 text-slate-600">{{ $stat['description'] }}</p>
                                        </article>
                                    @endforeach
                                </div>

                                <div class="mt-6 grid gap-6 lg:grid-cols-[.9fr_1.1fr]">
                                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                        <div class="flex flex-wrap items-start justify-between gap-5">
                                            <div>
                                                <p class="eyebrow text-emerald-700">Jenis kelamin</p>
                                                <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Laki-laki dan perempuan</h3>
                                            </div>
                                            <div class="grid h-28 w-28 place-items-center rounded-full" style="background: conic-gradient(#0284c7 0 {{ $populationStats['gender'][0]['percent'] }}%, #e11d48 {{ $populationStats['gender'][0]['percent'] }}% 100%)">
                                                <span class="grid h-20 w-20 place-items-center rounded-full bg-white text-center font-display text-xl font-bold text-slate-900">1.248</span>
                                            </div>
                                        </div>
                                        <div class="mt-7 grid gap-4 sm:grid-cols-2">
                                            @foreach ($populationStats['gender'] as $gender)
                                                <div class="border-t border-slate-200 pt-4">
                                                    <div class="flex items-center justify-between gap-4">
                                                        <p class="font-bold text-slate-800">{{ $gender['label'] }}</p>
                                                        <p class="text-sm font-bold {{ $statToneClasses[$gender['tone']]['text'] }}">{{ $gender['percent'] }}%</p>
                                                    </div>
                                                    <p class="mt-2 font-display text-3xl font-bold text-slate-950">{{ $gender['value'] }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </article>

                                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                        <p class="eyebrow text-emerald-700">Kelompok umur</p>
                                        <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Sebaran berdasarkan usia</h3>
                                        <div class="mt-6 space-y-4">
                                            @foreach ($populationStats['ageGroups'] as $age)
                                                <div class="grid grid-cols-[4.5rem_minmax(0,1fr)_4rem] items-center gap-3">
                                                    <p class="text-sm font-bold text-slate-700">{{ $age['label'] }}</p>
                                                    <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                                                        <div class="h-full rounded-full bg-emerald-600" style="width: {{ $age['percent'] }}%"></div>
                                                    </div>
                                                    <p class="text-right text-sm font-bold text-slate-500">{{ $age['value'] }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </article>
                                </div>

                                <div class="mt-6 grid gap-6 lg:grid-cols-[1.12fr_.88fr]">
                                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                        <p class="eyebrow text-emerald-700">Pekerjaan</p>
                                        <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Pembagian berdasarkan pekerjaan</h3>
                                        <div class="mt-6 grid gap-x-6 gap-y-5 sm:grid-cols-2">
                                            @foreach ($populationStats['jobs'] as $job)
                                                <div>
                                                    <div class="flex items-center justify-between gap-4">
                                                        <p class="text-sm font-bold text-slate-700">{{ $job['label'] }}</p>
                                                        <p class="text-sm font-bold text-slate-500">{{ $job['value'] }}</p>
                                                    </div>
                                                    <div class="mt-2 h-2.5 overflow-hidden rounded-full bg-slate-100">
                                                        <div class="h-full rounded-full bg-sky-600" style="width: {{ $job['percent'] }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </article>

                                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                        <p class="eyebrow text-emerald-700">Agama</p>
                                        <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Pembagian berdasarkan agama</h3>
                                        <div class="mt-6 space-y-5">
                                            @foreach ($populationStats['religions'] as $religion)
                                                <div>
                                                    <div class="flex items-center justify-between gap-4">
                                                        <p class="font-bold text-slate-800">{{ $religion['label'] }}</p>
                                                        <p class="font-display text-2xl font-bold text-slate-950">{{ $religion['value'] }}</p>
                                                    </div>
                                                    <div class="mt-2 flex items-center gap-3">
                                                        <div class="h-2.5 flex-1 overflow-hidden rounded-full bg-slate-100">
                                                            <div class="h-full rounded-full bg-amber-500" style="width: {{ max(3, $religion['percent']) }}%"></div>
                                                        </div>
                                                        <p class="w-12 text-right text-xs font-bold text-slate-500">{{ $religion['percent'] }}%</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </article>
                                </div>
                            </div>
                        @elseif ($tab['key'] === 'apbdes')
                            <div data-apbdes-section>
                                <div class="grid gap-10 lg:grid-cols-[.72fr_1.28fr] lg:items-center">
                                    <div>
                                        <h2 class="font-display text-4xl font-bold leading-tight text-emerald-700 sm:text-5xl">APB Desa Sambo</h2>
                                        <p class="mt-4 max-w-lg text-lg font-semibold leading-9 text-slate-950">{{ $apbdesStats['location'] }}</p>
                                    </div>

                                    <div>
                                        <label for="apbdes-year" class="sr-only">Pilih Filter Tahun</label>
                                        <select id="apbdes-year" class="w-full rounded border border-emerald-700 bg-white px-5 py-4 text-lg font-semibold text-slate-500 outline-none transition focus:ring-4 focus:ring-emerald-100" data-apbdes-year-select>
                                            <option value="" disabled>Pilih Filter Tahun</option>
                                            @foreach ($apbdesStats['years'] as $year)
                                                <option value="{{ $year['year'] }}" @selected($loop->last)>Tahun {{ $year['year'] }}</option>
                                            @endforeach
                                        </select>

                                        <div class="mt-5">
                                            @foreach ($apbdesStats['years'] as $year)
                                                @php
                                                    $surplusDeficit = $year['income'] - $year['spending'];
                                                @endphp
                                                <div class="{{ $loop->last ? '' : 'hidden' }}" data-apbdes-year-panel="{{ $year['year'] }}">
                                                    <div class="grid gap-5 md:grid-cols-2">
                                                        <article class="rounded border border-slate-200 bg-white px-5 py-4 shadow-sm">
                                                            <div class="flex items-center gap-3 text-slate-600">
                                                                <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                                                                <p class="text-lg font-bold">Pendapatan</p>
                                                            </div>
                                                            <p class="mt-3 font-display text-3xl font-bold text-slate-700">{{ $formatRupiah($year['income']) }}</p>
                                                        </article>

                                                        <article class="rounded border border-slate-200 bg-white px-5 py-4 shadow-sm">
                                                            <div class="flex items-center gap-3 text-slate-600">
                                                                <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                                                                <p class="text-lg font-bold">Belanja</p>
                                                            </div>
                                                            <p class="mt-3 font-display text-3xl font-bold text-slate-700">{{ $formatRupiah($year['spending']) }}</p>
                                                        </article>
                                                    </div>

                                                    <article class="mt-5 overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                                                        <div class="border-b border-slate-200 px-5 py-4">
                                                            <p class="text-lg font-bold text-slate-600">Pembiayaan</p>
                                                        </div>
                                                        <div class="grid md:grid-cols-2">
                                                            <div class="px-5 py-4 md:border-r md:border-slate-200">
                                                                <div class="flex items-center gap-3 text-slate-600">
                                                                    <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                                                                    <p class="text-lg font-bold">Penerimaan</p>
                                                                </div>
                                                                <p class="mt-3 font-display text-3xl font-bold text-slate-700">{{ $formatRupiah($year['financingIncome']) }}</p>
                                                            </div>
                                                            <div class="border-t border-slate-200 px-5 py-4 md:border-t-0">
                                                                <div class="flex items-center gap-3 text-slate-600">
                                                                    <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                                                                    <p class="text-lg font-bold">Pengeluaran</p>
                                                                </div>
                                                                <p class="mt-3 font-display text-3xl font-bold text-slate-700">{{ $formatRupiah($year['financingExpense']) }}</p>
                                                            </div>
                                                        </div>
                                                    </article>

                                                    <article class="mt-5 rounded border border-slate-200 bg-white px-5 py-6 text-center shadow-lg shadow-slate-200/50">
                                                        <p class="text-xl font-bold text-slate-600">Surplus/Defisit <span class="ml-2 font-display text-3xl text-slate-700">{{ $formatRupiah($surplusDeficit) }}</span></p>
                                                    </article>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <article class="mt-12 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                    <div class="flex flex-wrap items-end justify-between gap-4">
                                        <div>
                                            <p class="eyebrow text-emerald-700">Grafik APBDes</p>
                                            <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Pendapatan dan belanja desa per tahun</h3>
                                        </div>
                                        <div class="flex gap-4 text-xs font-bold text-slate-500">
                                            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-emerald-600"></span>Pendapatan</span>
                                            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-sm bg-amber-500"></span>Belanja</span>
                                        </div>
                                    </div>

                                    <div class="mt-8 grid min-h-72 grid-cols-3 items-end gap-4 border-b border-l border-slate-200 px-4 pb-6 sm:gap-8 sm:px-8">
                                        @foreach ($apbdesStats['years'] as $year)
                                            @php
                                                $incomeHeight = max(12, round(($year['income'] / $apbdesChartMax) * 100));
                                                $spendingHeight = max(12, round(($year['spending'] / $apbdesChartMax) * 100));
                                            @endphp
                                            <div class="flex h-64 flex-col justify-end gap-3">
                                                <div class="flex flex-1 items-end justify-center gap-3 sm:gap-4">
                                                    <div class="group relative flex h-full w-8 items-end justify-center sm:w-12">
                                                        <span class="w-full rounded-t-xl bg-emerald-600" style="height: {{ $incomeHeight }}%"></span>
                                                        <span class="absolute -top-6 hidden whitespace-nowrap rounded bg-slate-900 px-2 py-1 text-xs font-bold text-white group-hover:block">{{ $formatShortRupiah($year['income']) }}</span>
                                                    </div>
                                                    <div class="group relative flex h-full w-8 items-end justify-center sm:w-12">
                                                        <span class="w-full rounded-t-xl bg-amber-500" style="height: {{ $spendingHeight }}%"></span>
                                                        <span class="absolute -top-6 hidden whitespace-nowrap rounded bg-slate-900 px-2 py-1 text-xs font-bold text-white group-hover:block">{{ $formatShortRupiah($year['spending']) }}</span>
                                                    </div>
                                                </div>
                                                <p class="text-center text-sm font-extrabold text-slate-700">{{ $year['year'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>

                                @foreach ($apbdesStats['years'] as $year)
                                    <div class="mt-6 {{ $loop->last ? '' : 'hidden' }}" data-apbdes-year-panel="{{ $year['year'] }}">
                                        <div class="grid gap-6 lg:grid-cols-2">
                                            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                                <p class="eyebrow text-emerald-700">Data Pendapatan Desa</p>
                                                <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Rincian pendapatan {{ $year['year'] }}</h3>
                                                <div class="mt-6 space-y-4">
                                                    @foreach ($year['incomeItems'] as $item)
                                                        <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-3 last:border-b-0 last:pb-0">
                                                            <p class="font-semibold text-slate-700">{{ $item['label'] }}</p>
                                                            <p class="text-right font-display text-xl font-bold text-slate-950">{{ $formatRupiah($item['amount']) }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </article>

                                            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                                                <p class="eyebrow text-emerald-700">Data Belanja Desa</p>
                                                <h3 class="mt-2 font-display text-2xl font-bold text-slate-900">Rincian belanja {{ $year['year'] }}</h3>
                                                <div class="mt-6 space-y-4">
                                                    @foreach ($year['spendingItems'] as $item)
                                                        <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-3 last:border-b-0 last:pb-0">
                                                            <p class="font-semibold text-slate-700">{{ $item['label'] }}</p>
                                                            <p class="text-right font-display text-xl font-bold text-slate-950">{{ $formatRupiah($item['amount']) }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="min-h-80 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center sm:px-10">
                                <p class="text-sm font-bold uppercase tracking-[.18em] text-emerald-700">{{ $tab['title'] }}</p>
                                <h2 class="mt-4 font-display text-3xl font-bold text-slate-900">Konten {{ $tab['title'] }} siap ditambahkan.</h2>
                                <p class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-slate-500">Bagian ini sudah disiapkan sebagai tempat infografis {{ strtolower($tab['title']) }} Desa Sambo.</p>
                            </div>
                        @endif
                    </section>
                @endforeach
            </div>
        </div>
    </section>
@endsection
