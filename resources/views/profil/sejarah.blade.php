@extends('layouts.app')

@section('title', 'Sejarah - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Sejarah Sekolah"
        deskripsi="Perjalanan singkat sekolah sejak berdiri pada tahun 1975."
        :l-breadcrumb="'Sejarah'" />

    <div class="mx-auto max-w-4xl px-4 py-12">
        <ol class="relative space-y-8 border-l-2 border-slate-200 pl-6">

            <li>
                <span class="absolute -left-2.5 grid h-4 w-4 rounded-full bg-indigo-600"></span>
                <h2 class="font-semibold">1975</h2>
                <p class="mt-1 text-slate-700">Sekolah resmi didirikan dengan satu jenjang SMP.</p>
            </li>

            <li>
                <span class="absolute -left-2.5 grid h-4 w-4 rounded-full bg-indigo-600"></span>
                <h2 class="font-semibold">1989</h2>
                <p class="mt-1 text-slate-700">Jenjang SD ditambahkan untuk melayani anak usia sekolah dasar.</p>
            </li>

            <li>
                <span class="absolute -left-2.5 grid h-4 w-4 rounded-full bg-indigo-600"></span>
                <h2 class="font-semibold">2003</h2>
                <p class="mt-1 text-slate-700">Jenjang SMA dibuka sehingga sekolah menjadi jenjang lengkap.</p>
            </li>

            <li>
                <span class="absolute -left-2.5 grid h-4 w-4 rounded-full bg-indigo-600"></span>
                <h2 class="font-semibold">2018</h2>
                <p class="mt-1 text-slate-700">Kurikulum Merdeka mulai diterapkan di seluruh jenjang.</p>
            </li>
        </ol>
    </div>
@endsection
