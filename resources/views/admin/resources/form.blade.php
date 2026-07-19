@extends('layouts.admin')

@php
    $isEdit = isset($item);
    $formTitle = ($isEdit ? 'Edit ' : 'Tambah ') . $resource['singular'];
@endphp

@section('title', $formTitle . ' | Admin Desa Sambo')
@section('page-title', $formTitle)

@section('content')
    <section class="mx-auto max-w-5xl space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-2xl font-bold text-slate-900">{{ $formTitle }}</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $resource['title'] }}</p>
            </div>
            <a href="{{ route($resource['route'] . '.index') }}" class="btn-soft">&larr; Kembali</a>
        </div>

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">{{ $errors->first() }}</p>
            </div>
        @endif

        <form method="POST" action="{{ $isEdit ? route($resource['route'] . '.update', $item) : route($resource['route'] . '.store') }}" enctype="multipart/form-data" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-slate-200">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($fields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $value = old($name, $isEdit ? data_get($item, $name) : ($field['default'] ?? ''));
                        if ($value instanceof \Illuminate\Support\Carbon) {
                            $value = $value->format('Y-m-d');
                        }
                        $isWide = $type === 'textarea' || $type === 'file';
                    @endphp

                    <div class="{{ $isWide ? 'md:col-span-2' : '' }}">
                        <label for="{{ $name }}" class="label">{{ $field['label'] }}</label>

                        @if ($type === 'textarea')
                            <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $field['rows'] ?? 4 }}" class="input min-h-32" @required($field['required'] ?? false)>{{ $value }}</textarea>
                        @elseif ($type === 'select')
                            <select id="{{ $name }}" name="{{ $name }}" class="input" @required($field['required'] ?? false)>
                                <option value="">Pilih {{ strtolower($field['label']) }}</option>
                                @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif ($type === 'file')
                            <input id="{{ $name }}" name="{{ $name }}" type="file" class="input" accept="{{ $field['accept'] ?? '' }}" @required(($field['required'] ?? false) && ! $isEdit)>
                            @if ($isEdit && isset($field['current_path']) && data_get($item, $field['current_path']))
                                <a class="mt-2 inline-flex text-sm font-bold text-emerald-700" href="{{ asset('storage/' . data_get($item, $field['current_path'])) }}" target="_blank">Lihat file tersimpan</a>
                            @endif
                        @else
                            <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" class="input" min="{{ $field['min'] ?? null }}" max="{{ $field['max'] ?? null }}" @required($field['required'] ?? false)>
                        @endif

                        @error($name)
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="mt-7 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route($resource['route'] . '.index') }}" class="btn-soft">Batal</a>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </section>
@endsection
