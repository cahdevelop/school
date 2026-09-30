@extends('layouts.app')

@section('title', 'SPMB - Sekolah Harapan Bangsa')
@section('description', 'Selamat datang pada Seleksi Peserta Didik Baru Sekolah Harapan Bangsa.')

@section('konten')
    <x-page-hero
        judul="SPMB"
        deskripsi="Seleksi Peserta Didik Baru Sekolah Harapan Bangsa. Penerimaan terbuka untuk jenjang SD, SMP, dan SMA."
        :l-breadcrumb="'SPMB'" />

    <section class="mx-auto max-w-5xl space-y-12 px-4 py-16">

        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-600">Tentang Kami</p>
            <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-900">Sekolah Harapan Bangsa</h2>
            <div class="mt-4 space-y-4 text-sm leading-relaxed text-slate-600">
                <p>
                    Sekolah Harapan Bangsa adalah sekolah menengah kejuruan yang berdiri
                    sejak 1975. Sekolah melayani jenjang pendidikan dasar sampai
                    menengah atas dengan lingkungan belajar yang terstruktur dan
                    pendampingan yang berkelanjutan.
                </p>
                <p>
                    Setiap jenjang dibuka dengan tiga program keahlian, sehingga siswa
                    dapat memilih bidang yang paling sesuai dengan minatnya. Seluruh
                    program meliputi praktik kerja bersama mitra industri.
                </p>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Informasi Sekolah</h2>
            <dl class="mt-5 grid gap-x-8 gap-y-4 sm:grid-cols-2">
                @foreach ([
                    ['NPSN', '20219876'],
                    ['Jenjang', 'SD, SMP, SMA'],
                    ['Kurikulum', 'Kurikulum Merdeka'],
                    ['Jam belajar', 'Senin sampai Sabtu'],
                ] as [$label, $nilai])
                    <div class="flex items-baseline justify-between gap-4 border-b border-slate-100 pb-3">
                        <dt class="text-sm text-slate-500">{{ $label }}</dt>
                        <dd class="text-sm font-medium text-slate-900">{{ $nilai }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Jadwal Pendaftaran</h2>
            <dl class="mt-5 divide-y divide-slate-100 border-y border-slate-100">
                @foreach ([
                    ['Gelombang pertama', '1 - 15 Desember 2026'],
                    ['Pengumuman gelombang pertama', '20 Desember 2026'],
                    ['Gelombang kedua', '5 - 20 Januari 2027'],
                ] as [$label, $nilai])
                    <div class="flex flex-wrap items-baseline justify-between gap-4 py-3.5">
                        <dt class="text-sm text-slate-600">{{ $label }}</dt>
                        <dd class="text-sm font-medium tabular-nums text-slate-900">{{ $nilai }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Syarat Pendaftaran</h2>
            <ul class="mt-5 divide-y divide-slate-100 border-y border-slate-100">
                @foreach ([
                    'Fotokopi akta kelahiran dan kartu keluarga',
                    'Fotokopi rapor semester terakhir',
                    'Pas foto berwarna ukuran 3 x 4 sebanyak tiga lembar',
                    'Sertifikat prestasi bila ada',
                ] as $syarat)
                    <li class="flex items-start gap-3 py-3.5">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500" aria-hidden="true"></span>
                        <span class="text-sm leading-relaxed text-slate-700">{{ $syarat }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-xl bg-slate-900 p-8 sm:flex sm:items-center sm:justify-between sm:gap-8">
            <div>
                <h2 class="text-lg font-semibold text-white">Pendaftaran dilakukan secara daring</h2>
                <p class="mt-2 text-sm text-white/70">
                    Kanal pendaftaran resmi diumumkan melalui halaman pengumuman sekolah.
                </p>
            </div>
            <a href="{{ route('pengumuman') }}"
               class="mt-6 inline-flex shrink-0 items-center gap-2 rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-amber-300 sm:mt-0">
                Lihat Pengumuman
            </a>
        </div>
    </section>
@endsection
