@extends('layouts.app')

@section('title', $berita['judul'].' - Sekolah Harapan Bangsa')
@section('description', $berita['ringkasan'])

@section('konten')
    <x-page-hero :judul="$berita['judul']" :deskripsi="$berita['ringkasan']" :l-breadcrumb="$berita['kategori']" />

    <article class="mx-auto max-w-3xl px-4 py-14">

        {{-- Thumbnail utama, lebar penuh di atas artikel. --}}
        @if (filled($berita['gambar'] ?? null) && is_file(public_path('images/berita/'.$berita['gambar'])))
            <img src="{{ asset('images/berita/'.$berita['gambar']) }}"
                 alt="Ilustrasi berita: {{ $berita['judul'] }}"
                 width="1600"
                 height="1000"
                 fetchpriority="high"
                 decoding="async"
                 class="aspect-[16/9] w-full rounded-2xl border border-slate-200 object-cover shadow-sm">
        @endif

        <div class="mt-8 flex flex-wrap items-center gap-3">
            <span @class([
                'rounded-full px-3 py-1 text-xs font-semibold tracking-wide ring-1 ring-inset',
                'bg-amber-100 text-amber-800 ring-amber-600/20' => $berita['kategori'] === 'PPDB',
                'bg-emerald-100 text-emerald-800 ring-emerald-600/20' => $berita['kategori'] === 'Prestasi',
                'bg-sky-100 text-sky-800 ring-sky-600/20' => $berita['kategori'] === 'Kegiatan',
                'bg-slate-100 text-slate-700 ring-slate-500/20' => ! in_array($berita['kategori'], ['PPDB', 'Prestasi', 'Kegiatan'], true),
            ])>
                {{ $berita['kategori'] }}
            </span>

            <time class="text-sm tabular-nums text-slate-500"
                  datetime="{{ \Illuminate\Support\Carbon::parse($berita['tanggal'])->toDateString() }}">
                {{ \Illuminate\Support\Carbon::parse($berita['tanggal'])->translatedFormat('d F Y') }}
            </time>

            <span aria-hidden="true" class="text-slate-300">&middot;</span>

            <span class="text-sm text-slate-500">{{ $berita['penulis'] }}</span>
        </div>

        <div class="mt-6 space-y-4 text-base leading-relaxed text-slate-700">
            <p>{{ $berita['isi'] }}</p>
        </div>

        <a href="{{ route('berita.index') }}"
           class="group mt-10 inline-flex items-center gap-2 text-sm font-semibold text-slate-600 transition-colors duration-300 hover:text-amber-600">
            <span class="transition-transform duration-300 group-hover:-translate-x-1 motion-reduce:transition-none" aria-hidden="true">&larr;</span>
            Kembali ke daftar berita
        </a>
    </article>

    @if ($terbaru->isNotEmpty())
        <section class="border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-6xl px-4 py-14 sm:py-16">
                <h2 class="text-lg font-bold tracking-tight text-slate-900 sm:text-xl">Berita Lainnya</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($terbaru as $item)
                        <x-kartu-berita :key="$item['slug']" :berita="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
