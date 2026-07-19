@extends('layouts.admin')

@section('title', $resource['title'] . ' | Admin Desa Sambo')
@section('page-title', $resource['title'])

@section('content')
    <section class="space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-2xl font-bold text-slate-900">{{ $resource['title'] }}</h1>
                @isset($resource['description'])
                    <p class="mt-1 text-sm text-slate-500">{{ $resource['description'] }}</p>
                @endisset
            </div>
            <a href="{{ route($resource['route'] . '.create') }}" class="btn-primary">
                <span class="text-lg leading-none">+</span>
                Tambah {{ $resource['singular'] }}
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="px-4 py-3 font-bold">{{ $column['label'] }}</th>
                            @endforeach
                            <th class="px-4 py-3 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <tr class="align-top hover:bg-slate-50/70">
                                @foreach ($columns as $column)
                                    @php
                                        $value = data_get($item, $column['key']);
                                        $type = $column['type'] ?? 'text';
                                        $secondary = isset($column['secondary']) ? data_get($item, $column['secondary']) : null;
                                    @endphp
                                    <td class="px-4 py-4">
                                        @if ($type === 'badge')
                                            @php
                                                $status = strtolower((string) $value);
                                                $badgeClass = match ($status) {
                                                    'publish', 'selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
                                                    'pending', 'draft' => 'bg-amber-50 text-amber-700 ring-amber-100',
                                                    'diproses' => 'bg-sky-50 text-sky-700 ring-sky-100',
                                                    'ditolak' => 'bg-red-50 text-red-700 ring-red-100',
                                                    default => 'bg-slate-50 text-slate-600 ring-slate-100',
                                                };
                                            @endphp
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold capitalize ring-1 {{ $badgeClass }}">{{ $value ?: '-' }}</span>
                                        @elseif ($type === 'money')
                                            <span class="font-semibold text-slate-900">Rp {{ number_format((int) $value, 0, ',', '.') }}</span>
                                        @elseif ($type === 'date')
                                            <span class="text-slate-700">{{ $value ? $value->format('d/m/Y') : '-' }}</span>
                                        @else
                                            <span class="font-semibold text-slate-900">{{ \Illuminate\Support\Str::limit((string) ($value ?: '-'), 70) }}</span>
                                            @if ($secondary)
                                                <span class="mt-1 block text-xs text-slate-500">{{ \Illuminate\Support\Str::limit((string) $secondary, 90) }}</span>
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route($resource['route'] . '.show', $item) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600 hover:border-emerald-200 hover:text-emerald-700">Detail</a>
                                        <a href="{{ route($resource['route'] . '.edit', $item) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600 hover:border-emerald-200 hover:text-emerald-700">Edit</a>
                                        <form method="POST" action="{{ route($resource['route'] . '.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-100 px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-8 text-center text-sm text-slate-500" colspan="{{ count($columns) + 1 }}">
                                    Belum ada data {{ strtolower($resource['singular']) }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($items instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="border-t border-slate-100 px-4 py-3">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
