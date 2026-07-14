@extends('layouts.public')

@section('content')
    <section class="container-page py-20 lg:py-28">
        <p class="eyebrow text-emerald-700">Desa Sambo</p>
        <h1 class="section-title mt-4">{{ $heading }}</h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Halaman {{ strtolower($heading) }} telah disiapkan sebagai bagian dari template. Konten dan fitur lengkapnya akan kita lanjutkan pada tahap berikutnya.</p>
        <a href="{{ route('home') }}" class="btn-primary mt-8">Kembali ke beranda <span>→</span></a>
    </section>
@endsection
