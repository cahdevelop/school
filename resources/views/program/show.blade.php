@extends('layouts.app')

@section('title', $program['nama'].' - Sekolah Harapan Bangsa')
@section('description', $program['deskripsi'])

@section('konten')
    <x-page-hero
        :judul="$program['nama']"
        :deskripsi="$program['deskripsi']"
        :l-breadcrumb="$program['nama']" />

    <section class="mx-auto max-w-5xl px-4 py-16">
        <div class="grid gap-10 md:grid-cols-3">

            <div class="md:col-span-2">
                <h2 class="text-xl font-bold tracking-tight text-slate-900">Kompetensi Utama</h2>
                <ul class="mt-5 divide-y divide-slate-100 border-y border-slate-100">
                    @foreach ($program['kompetensi'] as $kompetensi)
                        <li class="flex items-start gap-3 py-3.5">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500" aria-hidden="true"></span>
                            <span class="text-sm leading-relaxed text-slate-700">{{ $kompetensi }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <aside class="h-fit rounded-xl border border-slate-200 bg-white p-6">
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                    Peluang Karir
                </p>
                <p class="mt-3 text-sm leading-relaxed text-slate-700">{{ $program['peluang_kerja'] }}</p>

                <a href="{{ route('spmb') }}"
                   class="mt-6 block rounded-lg bg-slate-900 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-slate-700">
                    Daftar SPMB
                </a>
            </aside>
        </div>
    </section>

    <section class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-14">
            <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Program lain</h2>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($lainnya as $item)
                    <a href="{{ route('program.show', $item['slug']) }}"
                       class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-700 transition hover:border-amber-300 hover:text-amber-700">
                        {{ $item['singkat'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
