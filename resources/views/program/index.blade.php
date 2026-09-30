@extends('layouts.app')

@section('title', 'Program Keahlian - Sekolah Harapan Bangsa')
@section('description', 'Enam program keahlian di Sekolah Harapan Bangsa.')

@section('konten')
    <x-page-hero
        judul="Program Keahlian"
        deskripsi="Enam program keahlian yang membekali siswa dengan keterampilan teknis, soft skill, dan pengalaman kerja nyata."
        :l-breadcrumb="'Program Keahlian'" />

    <section class="mx-auto max-w-6xl px-4 py-16">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($program as $item)
                <a href="{{ route('program.show', $item['slug']) }}"
                   class="group flex flex-col rounded-xl border border-slate-200 bg-white p-6 transition hover:border-amber-300 hover:shadow-sm">
                    <span class="w-fit rounded-md bg-amber-100 px-2.5 py-1 text-xs font-bold tracking-wide text-amber-800">
                        {{ $item['singkat'] }}
                    </span>
                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-slate-900 transition group-hover:text-amber-700">
                        {{ $item['nama'] }}
                    </h2>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">{{ $item['deskripsi'] }}</p>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 transition group-hover:text-amber-600">
                        Lihat detail
                        <span class="transition group-hover:translate-x-0.5" aria-hidden="true">&rarr;</span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endsection
