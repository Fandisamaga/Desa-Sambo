@extends('layouts.public')

@php
    $pages = [
        'profil' => 'Profil Desa',
        'infografis' => 'Info Grafis Desa',
        'berita' => 'Berita Desa',
        'umkm' => 'UMKM Desa Sambo',
        'kkn' => 'Program KKN',
        'layanan' => 'Layanan Masyarakat',
        'layanan.domisili' => 'Surat Keterangan Domisili',
        'layanan.pengantar' => 'Surat Pengantar KK/KTP',
        'layanan.pengaduan' => 'Pengaduan Masyarakat',
    ];
    $heading = $pages[request()->route()->getName()] ?? 'Desa Sambo';
@endphp

@section('title', $heading . ' | Desa Sambo')

@section('content')
    <section class="container-page py-20 lg:py-28">
        <p class="eyebrow text-emerald-700">Desa Sambo</p>
        <h1 class="section-title mt-4">{{ $heading }}</h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Halaman {{ strtolower($heading) }} telah disiapkan sebagai bagian dari template. Konten dan fitur lengkapnya akan kita lanjutkan pada tahap berikutnya.</p>
        <a href="{{ route('home') }}" class="btn-primary mt-8">Kembali ke beranda <span>→</span></a>
    </section>
@endsection
