@extends('layouts.app')

@section('title', 'Tenaga Pendidik - Sekolah Harapan Bangsa')
@section('description', 'Daftar tenaga pendidik Sekolah Harapan Bangsa.')

@section('konten')
    <x-page-hero
        judul="Tenaga Pendidik"
        deskripsi="Arahkan kursor ke salah satu foto untuk melihat informasi guru."
        :l-breadcrumb="'Tenaga Pendidik'" />

    <section class="mx-auto max-w-6xl px-4 py-16">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (config('guru') as $orang)
                <x-kartu-guru :guru="$orang" />
            @endforeach
        </div>
    </section>
@endsection
