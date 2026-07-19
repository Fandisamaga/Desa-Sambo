@extends('layouts.admin')

@section('title', 'Detail ' . $resource['singular'] . ' | Admin Desa Sambo')
@section('page-title', 'Detail ' . $resource['singular'])

@section('content')
    <section class="mx-auto max-w-5xl space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-2xl font-bold text-slate-900">Detail {{ $resource['singular'] }}</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $resource['title'] }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route($resource['route'] . '.index') }}" class="btn-soft">&larr; Kembali</a>
                <a href="{{ route($resource['route'] . '.edit', $item) }}" class="btn-primary">Edit</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-slate-200">
            <dl class="divide-y divide-slate-100">
                @foreach ($fields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $value = data_get($item, $name);
                        if ($type === 'file' && isset($field['current_path'])) {
                            $value = data_get($item, $field['current_path']);
                        }
                        if ($type === 'select') {
                            $value = ($field['options'] ?? [])[$value] ?? $value;
                        }
                    @endphp
                    <div class="grid gap-2 px-5 py-4 md:grid-cols-[220px_1fr]">
                        <dt class="text-sm font-bold text-slate-500">{{ $field['label'] }}</dt>
                        <dd class="whitespace-pre-line text-sm font-semibold text-slate-900">
                            @if ($type === 'money')
                                Rp {{ number_format((int) $value, 0, ',', '.') }}
                            @elseif ($value instanceof \Illuminate\Support\Carbon)
                                {{ $value->format('d/m/Y') }}
                            @elseif ($type === 'file' && $value)
                                <a class="text-emerald-700" href="{{ asset('storage/' . $value) }}" target="_blank">{{ $value }}</a>
                            @else
                                {{ $value ?: '-' }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>
@endsection
