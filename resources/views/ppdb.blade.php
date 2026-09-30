@extends('layouts.app')

@section('title', 'PPDB - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Penerimaan Peserta Didik Baru"
        deskripsi="Informasi jalur pendaftaran siswa baru tahun ajaran 2026/2027."
        :l-breadcrumb="'PPDB'" />

    <div class="mx-auto max-w-4xl space-y-8 px-4 py-12">

        <section class="rounded-xl border border-slate-200 bg-white p-8">
            <h2 class="text-xl font-bold">Jadwal Pendaftaran</h2>
            <dl class="mt-4 divide-y divide-slate-100 text-sm">
                <div class="flex justify-between py-3">
                    <dt class="text-slate-500">Gelombang pertama</dt>
                    <dd class="font-medium">1 - 15 Desember 2026</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="text-slate-500">Pengumuman</dt>
                    <dd class="font-medium">20 Desember 2026</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="text-slate-500">Gelombang kedua</dt>
                    <dd class="font-medium">5 - 20 Januari 2027</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-8">
            <h2 class="text-xl font-bold">Syarat Pendaftaran</h2>
            <ul class="mt-4 list-disc space-y-2 pl-5 text-slate-700">
                <li>Fotokopi akta kelahiran dan kartu keluarga.</li>
                <li>Fotokopi rapor semester terakhir.</li>
                <li>Pas foto berwarna ukuran 3 x 4 sebanyak tiga lembar.</li>
                <li>Sertifikat prestasi bila ada.</li>
            </ul>
        </section>

        <section class="rounded-xl border border-indigo-200 bg-indigo-50 p-8 text-center">
            <h2 class="text-xl font-bold text-indigo-900">Pendaftaran dilakukan daring</h2>
            <p class="mt-2 text-sm text-indigo-900">
                Silakan gunakan kanal pendaftaran resmi yang akan diumumkan sekolah.
            </p>
        </section>
    </div>
@endsection
