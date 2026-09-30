<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sekolah')</title>
    <meta name="description" content="@yield('description', 'Website resmi sekolah.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

@if (trim((string) $__env->yieldContent('hero')) !== '')
    {{--
        Halaman beranda.

        Efek "foto diam, konten menutupnya" dirancang dari dua hal yang
        saling melengkapi, keduanya wajib ada:

        1. <section class="hero-kanvas"> dibuat `position: sticky` oleh CSS,
           jadi fotonya tertahan di atas viewport. Section ini harus tetap
           setinggi viewport persis, kalau tidak bagian bawahnya terpotong.

        2. <main> di bawahnya punya margin atas negatif dan z-index lebih
           tinggi, jadi konten masuk sedikit ke area hero lalu terus naik
           menutupinya. Latarnya opaque (bg-slate-50) supaya benar-benar
           menutup, bukan transparan.

        Navbar dan hero adalah saudara, bukan anak-beranak. Itu wajib: navbar
        berpindah dari `absolute` ke `fixed` (dikendalikan Alpine), dan
        `fixed` hanya dihitung terhadap viewport selama tidak ada leluhur
        yang punya transform/filter.
    --}}
    <div class="relative">
        @include('partials.navbar')

        <section class="hero-kanvas" data-hero>
            <div class="hero-latar" style="--hero-gambar: url('{{ asset('images/baground.png') }}')">
                <div class="hero-latar__foto"></div>
            </div>
            <div class="hero-tirai"></div>

            {!! $__env->yieldContent('hero') !!}
        </section>

        <main class="relative z-20 -mt-8 rounded-t-2xl bg-slate-50 shadow-[0_-18px_40px_-30px_rgb(2_6_23/0.5)] sm:-mt-16">
            {!! $__env->yieldContent('konten') !!}
        </main>
    </div>
@else
    {{-- Halaman dalam: tidak ada hero, jadi navbar langsung solid. --}}
    @include('partials.navbar', ['solid' => true])

    <main>
        {!! $__env->yieldContent('konten') !!}
    </main>
@endif

@include('partials.footer')

</body>
</html>
