@extends('layouts.app')

@section('title', 'Fasilitas - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Fasilitas"
        deskripsi="Sarana dan prasarana yang mendukung kegiatan belajar di sekolah."
        :l-breadcrumb="'Fasilitas'" />

    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ([
                ['Laboratorium Komputer', '40 unit komputer dengan koneksi internet berkecepatan tinggi.'],
                ['Laboratorium Sains', 'Peralatan praktikum biologi, fisika, dan kimia lengkap.'],
                ['Perpustakaan', 'Lebih dari 12.000 judul buku dan pojokan bacaan siswa.'],
                ['Lapangan Olahraga', 'Lapangan basket, futsal, dan voli di area terbuka.'],
                ['Musholla', 'Ruang ibadah yang tenang untuk siswa dan warga sekolah.'],
                ['UKS', 'Unit kesehatan sekolah dengan petugas medis.'],
            ] as [$judul, $ket])
                <div class="rounded-xl border border-slate-200 bg-white p-6">
                    <h2 class="font-semibold">{{ $judul }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $ket }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
