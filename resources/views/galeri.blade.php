@extends('layouts.app')

@section('title', 'Galeri - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Galeri"
        deskripsi="Dokumentasi kegiatan sekolah."
        :l-breadcrumb="'Galeri'" />

    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">

            @foreach (['Upacara Bendera', 'Juara Turnamen', 'Kegiatan Kelas', 'Literasi', 'Olahraga', 'Pentas Seni'] as $nama)
                <figure class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                    <div class="grid h-32 place-items-center bg-slate-100 text-xs text-slate-500">{{ $nama }}</div>
                    <figcaption class="p-3 text-xs font-medium text-slate-700">{{ $nama }}</figcaption>
                </figure>
            @endforeach
        </div>

        <p class="mt-8 text-sm text-slate-500">
            Galeri lengkap akan ditambahkan setelah tersedia album foto resmi sekolah.
        </p>
    </div>
@endsection
