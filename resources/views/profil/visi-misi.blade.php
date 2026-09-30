@extends('layouts.app')

@section('title', 'Visi & Misi - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Visi dan Misi"
        deskripsi="Arah sekolah yang menjadi pegangan seluruh kegiatan belajar mengajar."
        :l-breadcrumb="'Visi & Misi'" />

    <div class="mx-auto max-w-4xl space-y-8 px-4 py-12">

        <section class="rounded-xl border border-slate-200 bg-white p-8">
            <h2 class="text-xl font-bold text-indigo-600">Visi</h2>
            <p class="mt-3 text-slate-700">
                Menjadi sekolah rujukan nasional yang unggul dalam akademik dan berkarakter.
            </p>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-8">
            <h2 class="text-xl font-bold text-indigo-600">Misi</h2>
            <ul class="mt-3 list-disc space-y-2 pl-5 text-slate-700">
                <li>Menyelenggarakan pembelajaran yang relevan dengan kebutuhan zaman.</li>
                <li>Menumbuhkan karakter dan akhlak mulia dalam keseharian.</li>
                <li>Mengembangkan minat kewirausahaan dan kreativitas siswa.</li>
                <li>Membangun atmosfer sekolah yang aman, bersih, dan suportif.</li>
            </ul>
        </section>
    </div>
@endsection
