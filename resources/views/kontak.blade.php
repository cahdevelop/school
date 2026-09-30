@extends('layouts.app')

@section('title', 'Kontak - Sekolah Harapan Bangsa')

@section('konten')
    <x-page-hero
        judul="Kontak"
        deskripsi="Alamat dan cara menghubungi sekolah."
        :l-breadcrumb="'Kontak'" />

    <div class="mx-auto max-w-4xl px-4 py-12">
        <div class="grid gap-8 md:grid-cols-2">

            <div class="rounded-xl border border-slate-200 bg-white p-8">
                <h2 class="text-xl font-bold">Alamat</h2>
                <address class="mt-4 space-y-2 text-slate-700 not-italic">
                    <p>Sekolah Harapan Bangsa</p>
                    <p>Jl. Pendidikan No. 10</p>
                    <p>Jakarta 12345</p>
                </address>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-8">
                <h2 class="text-xl font-bold">Telepon dan Email</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Telepon</dt>
                        <dd class="font-medium">(021) 555-0123</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-500">Email</dt>
                        <dd class="font-medium">info@sekolahharapanbangsa.sch.id</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Jam layanan</dt>
                        <dd class="font-medium">Senin - Sabtu, 07.00 - 15.00</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-slate-200 bg-white p-8">
            <h2 class="text-xl font-bold">Petunjuk Arah</h2>
            <p class="mt-3 text-sm text-slate-600">
                Sekolah berada di sisi utara lapangan, bersebelahan dengan pusat pengetahuan.
            </p>
        </div>
    </div>
@endsection
