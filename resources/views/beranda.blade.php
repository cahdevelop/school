@extends('layouts.app')

@section('title', 'Beranda - Sekolah Harapan Bangsa')
@section('description', 'Sekolah Menengah Kejuruan dengan program keahlian yang siap memasuki dunia kerja.')

@section('hero')
    <div class="hero-isi">
        <div class="hero-teks mx-auto w-full max-w-6xl px-4" data-hero-teks>
            <p class="hero-muncul flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.22em] text-amber-300">
                <span class="h-px w-8 shrink-0 bg-amber-300/60" aria-hidden="true"></span>
                Sekolah Menengah Kejuruan
            </p>

            <h1 class="hero-isi__judul hero-muncul mt-4 max-w-4xl text-balance text-3xl font-bold leading-[1.1] tracking-tight text-white [text-shadow:0_2px_14px_rgb(2_6_23/0.5)] sm:mt-5 sm:text-4xl lg:text-5xl">
                Unggul dalam Teknologi, Berkarakter dalam Prestasi
            </h1>

            <p class="hero-isi__ringkas hero-muncul mt-4 max-w-xl text-pretty text-base leading-relaxed text-white/85 [text-shadow:0_1px_10px_rgb(2_6_23/0.55)] sm:mt-5">
                Membentuk generasi yang kompeten, kreatif, berkarakter, dan siap
                menghadapi dunia kerja serta masa depan.
            </p>

            <div class="hero-muncul mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('spmb') }}"
                   class="group inline-flex items-center gap-2 rounded-lg bg-amber-400 px-4 py-2.5 text-xs font-semibold tracking-wide text-slate-950 shadow-lg shadow-amber-950/25 transition duration-300 hover:-translate-y-0.5 hover:bg-amber-300 hover:shadow-xl focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-300 sm:px-6 sm:py-3 sm:text-sm">
                    DAFTAR SPMB
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true">&rarr;</span>
                </a>
                <a href="{{ route('program.index') }}"
                   class="group inline-flex items-center gap-2 rounded-lg border border-white/25 bg-white/5 px-4 py-2.5 text-xs font-semibold tracking-wide text-white backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:border-white/45 hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:px-6 sm:py-3 sm:text-sm">
                    PROGRAM KEAHLIAN
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('konten')
    {{-- 1. Sambutan Kepala Sekolah --}}
    <x-sambutan-kepala-sekolah />

    {{-- 2. Mengapa Sekolah Menjadi Pilihan? --}}
    <x-mengapa-sekolah />

    {{-- 3. Kegiatan & Karya Peserta Didik --}}
    <x-kegiatan-karya />

    {{-- 4. Berita Sekolah --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:py-20" aria-labelledby="berita-judul">
        <div data-reveal="up"
             class="flex flex-wrap items-end justify-between gap-x-6 gap-y-4 border-b border-slate-200 pb-6">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-600">
                    Kabar Terbaru
                </p>
                <h2 id="berita-judul"
                    class="mt-2.5 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Berita Sekolah
                </h2>
            </div>

            {{--
                Tautan "Semua berita". Garis bawahnya tumbuh dari kiri saat
                kursor diarahkan, bukan dari tengah, supaya arah geraknya
                konsisten dengan panah yang meluncur ke kanan.
            --}}
            <a href="{{ route('berita.index') }}"
               class="group relative inline-flex items-center gap-1.5 pb-1 text-sm font-semibold text-slate-700 transition-colors duration-300 hover:text-amber-700 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-400 after:absolute after:inset-x-0 after:bottom-0 after:h-px after:origin-left after:scale-x-0 after:bg-amber-500 after:transition-transform after:duration-300 hover:after:scale-x-100 motion-reduce:transition-none motion-reduce:after:hidden">
                Semua berita
                <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
            </a>
        </div>

        {{--
            `data-reveal` dipasang pada pembungkus, BUKAN pada x-kartu-berita.
            Alasannya: kartu itu sendiri punya transform hover
            (`hover:-translate-y-1`). Kalau reveal menempel di kartu yang sama,
            salah satu akan menimpa yang lain dan hover-nya mati.

            Jeda 80ms antar-kartu supaya masuknya berurutan, bukan serempak.
        --}}
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($berita as $index => $item)
                <div data-reveal="up"
                     style="--reveal-delay: {{ $index * 80 }}ms"
                     class="h-full">
                    <x-kartu-berita :key="$item['slug']" :berita="$item" />
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center sm:col-span-2 lg:col-span-3">
                    <p class="text-base font-semibold text-slate-900">Belum ada berita</p>
                    <p class="mt-1.5 text-sm text-slate-500">
                        Berita terbaru akan tampil di sini setelah dipublikasikan.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
