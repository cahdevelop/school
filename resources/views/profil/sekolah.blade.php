@extends('layouts.app')

@section('title', 'Profil Sekolah - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Profil Sekolah"
        deskripsi="Sekolah Harapan Bangsa berdiri sejak 1975 dan melayani jenjang SD sampai SMA."
        :l-breadcrumb="'Profil Sekolah'" />

    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="grid gap-8 md:grid-cols-3">

            <div class="space-y-4 text-slate-700 md:col-span-2">
                <p>Sekolah Harapan Bangsa berdiri pada tahun 1975 di atas lahan dua hektare di kawasan Jakarta.</p>
                <p>Saat ini sekolah melayani jenjang pendidikan dasar sampai menengah atas.</p>
                <p>Sekolah menerapkan Kurikulum Merdeka dengan program tahunan terstruktur.</p>
            </div>

            <aside class="h-fit rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="font-semibold">Informasi Singkat</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-slate-500">NPSN</dt>
                        <dd class="font-medium">20219876</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Jenjang</dt>
                        <dd class="font-medium">SD, SMP, SMA</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Kurikulum</dt>
                        <dd class="font-medium">Kurikulum Merdeka</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Jam belajar</dt>
                        <dd class="font-medium">Senin sampai Sabtu</dd>
                    </div>
                </dl>
            </aside>
        </div>
    </div>
@endsection
