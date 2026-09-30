@extends('layouts.app')

@section('title', 'BKK - Sekolah Harapan Bangsa')
@section('description', 'Bursa Kerja SMK: informasi lowongan pekerjaan dari mitra industri.')

@section('konten')
    <x-page-hero
        judul="Bursa Kerja SMK"
        deskripsi="Informasi lowongan pekerjaan dari mitra industri dan perusahaan mitra sekolah."
        :l-breadcrumb="'BKK'" />

    <section class="mx-auto max-w-5xl px-4 py-16">
        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-600">Lowongan Terbuka</p>

        <div class="mt-6 space-y-4">
            @foreach ([
                ['Koki Restoran', 'PT Rasa Nusantara', 'Jakarta Selatan', 'Full Time', 'Lulusan Kuliner'],
                ['Graphic Designer', 'Studio Visara', 'Jakarta Pusat', 'Full Time', 'Lulusan DKV'],
                ['IT Support', 'Kantor Pusat Digital', 'Jakarta Barat', 'Full Time', 'Lulusan TKJ'],
                ['Staf Keuangan', 'CV Berkah Jaya', 'Jakarta Timur', 'Part Time', 'Lulusan AK'],
                ['Operator Produksi', 'PT Metal Nusantara', 'Bekasi', 'Full Time', 'Lulusan MP'],
                ['Digital Marketing', 'UMKM Lokal Nusantara', 'Jakarta Selatan', 'Part Time', 'Lulusan BD'],
            ] as [$posisi, $perusahaan, $lokasi, $tipe, $syarat])
                <article class="rounded-xl border border-slate-200 bg-white p-6 transition hover:border-amber-300 hover:shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold tracking-tight text-slate-900">{{ $posisi }}</h2>
                            <p class="mt-1 text-sm text-slate-600">{{ $perusahaan }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="rounded-md bg-slate-100 px-2.5 py-1 font-medium text-slate-600">{{ $lokasi }}</span>
                            <span class="rounded-md bg-slate-100 px-2.5 py-1 font-medium text-slate-600">{{ $tipe }}</span>
                        </div>
                    </div>
                    <p class="mt-4 border-t border-slate-100 pt-4 text-sm text-slate-600">
                        Kualifikasi: {{ $syarat }} yang telah menyelesaikan praktik kerja lapangan.
                    </p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="font-semibold text-slate-900">Cara Melamar</h2>
            <ol class="mt-4 space-y-2.5 text-sm leading-relaxed text-slate-600">
                <li><span class="font-medium text-slate-800">1.</span> Siapkan berkas: CV, ijazah terakhir, dan sertifikat praktik.</li>
                <li><span class="font-medium text-slate-800">2.</span> Daftarkan melalui BKK sekolah dengan melampirkan berkas.</li>
                <li><span class="font-medium text-slate-800">3.</span> Ikuti sesi wawancara yang dijadwalkan BKK.</li>
            </ol>
        </div>
    </section>
@endsection
