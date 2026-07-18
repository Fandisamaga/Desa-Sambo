@extends('layouts.admin')

@section('content')
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        {{-- Header Bagian --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-bold text-slate-900">
                    {{ $resource }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Template daftar data untuk proses CRUD.
                </p>
            </div>
            <button type="button" class="btn-primary">
                + Tambah {{ $singular }}
            </button>
        </div>

        {{-- Tabel Data --}}
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-y border-slate-100 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Data</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-5 text-slate-500" colspan="3">
                            Belum ada data. Form tambah dan proses penyimpanan akan dihubungkan pada tahap CRUD berikutnya.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection