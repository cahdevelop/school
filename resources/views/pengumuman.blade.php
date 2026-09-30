@extends('layouts.app')

@section('title', 'Pengumuman - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Pengumuman"
        deskripsi="Informasi resmi yang perlu diketahui warga sekolah."
        :l-breadcrumb="'Pengumuman'" />

    <div class="mx-auto max-w-4xl space-y-4 px-4 py-12">

        @foreach ([
            ['Penyesuaian jadwal asesmen semester genap', 'Jadwal asesmen semester genap dimulai 8 Desember. Orang tua dimohon memeriksa jadwal pada kanal resmi sekolah.'],
            ['Pengumpulan Berkas PPDB gelombang pertama', 'Berkas pendaftaran gelombang pertama dikumpulkan paling lambat 15 Desember 2026.'],
            ['Rapat orang tua siswa kelas XII', 'Rapat orang tua siswa kelas XII berlangsung pada Sabtu, 22 November 2026 pukul 09.00 WIB.'],
        ] as [$judul, $isi])
            <article class="rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="font-semibold">{{ $judul }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $isi }}</p>
            </article>
        @endforeach
    </div>
@endsection
