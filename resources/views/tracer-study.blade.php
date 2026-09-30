@extends('layouts.app')

@section('title', 'Tracer Study - Sekolah Harapan Bangsa')
@section('description', 'Jejak karier lulusan Sekolah Harapan Bangsa.')

@section('konten')
    <x-page-hero
        judul="Tracer Study"
        deskripsi="Jejak karier lulusan sekolah. Data ini dipakai untuk meningkatkan mutu pembelajaran dan pendampingan karier."
        :l-breadcrumb="'Tracer Study'" />

    <section class="mx-auto max-w-5xl space-y-12 px-4 py-16">

        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Tentang Survei</h2>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600">
                Survei ini disampaikan kepada lulusan untuk memetakan arah karier
                mereka. Hasilnya dipakai sekolah untuk menyesuaikan pembelajaran dengan
                kebutuhan dunia kerja yang terus berubah.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Tahapan Surveys</h2>
            <ol class="mt-6 grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['Pengisian daring', 'Lulusan mengisi survei secara sukarela melalui tautan yang dibagikan BKK.'],
                    ['Verifikasi data', 'Data divalidasi dan dicocokkan dengan data kelulusan sekolah.'],
                    ['Analisis', 'Hasil dianalisis per program keahlian dan per tahun kelulusan.'],
                    ['Tindak lanjut', 'Hasil dipakai untuk memperbarui kurikulum dan pendampingan karier.'],
                ] as $i => $langkah)
                    <li class="rounded-xl border border-slate-200 bg-white p-6">
                        <span class="grid h-7 w-7 place-items-center rounded-full bg-amber-100 text-xs font-bold text-amber-800">
                            {{ $i + 1 }}
                        </span>
                        <h3 class="mt-4 font-semibold text-slate-900">{{ $langkah[0] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $langkah[1] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="font-semibold text-slate-900">Cara Mengisi</h2>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Tautan survei dikirim melalui kelasrulusan dan WhatsApp group angkatan.
                Pengisian membutuhkan waktu sekitar 5 menit dan seluruh isian bersifat
                sukarela.
            </p>
            <a href="{{ route('bkk') }}"
               class="mt-5 inline-flex items-center gap-1.5 text-sm font-medium text-slate-700 hover:text-amber-600">
                Lihat lowongan di BKK
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </section>
@endsection
