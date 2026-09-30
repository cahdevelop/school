@extends('layouts.app')

@section('title', 'Berita Sekolah - Sekolah Harapan Bangsa')
@section('description', 'Kabar terbaru mengenai kegiatan, prestasi, dan penerimaan siswa baru Sekolah Harapan Bangsa.')

@section('konten')
    <x-page-hero
        judul="Berita Sekolah"
        deskripsi="Kabar terbaru mengenai kegiatan, prestasi, dan pengumuman sekolah, diurutkan dari yang paling baru."
        :l-breadcrumb="'Berita'" />

    <section class="mx-auto max-w-6xl px-4 py-14 sm:py-16">

        {{--
            Berita terbaru dipisah dari sisanya: kartu mendua selebar baris,
            lalu sisanya jadi grid tiga kolom. Pemisahan ini memberi hierarki
            yang jelas tanpa perlu sorting, tab, atau filter.

            Kedua perulangan diberi `:key` dari `slug` supaya Blade bisa
            memakai ulang node DOM saat urutannya berubah, bukan membuatnya
            ulang dari nol.
        --}}
        @if ($berita->isNotEmpty())
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-3">
                    <x-kartu-berita :key="'utama-'.$berita->first()['slug']"
                                   :berita="$berita->first()"
                                   :featured="true" />
                </div>

                @foreach ($berita->slice(1) as $item)
                    <x-kartu-berita :key="$item['slug']" :berita="$item" />
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <p class="text-base font-semibold text-slate-900">Belum ada berita</p>
                <p class="mt-1.5 text-sm text-slate-500">
                    Berita terbaru akan tampil di sini setelah dipublikasikan.
                </p>
            </div>
        @endif
    </section>
@endsection
