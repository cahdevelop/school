{{--
    Ikon garis (outline) 24x24, digambar inline sebagai SVG.

    Kenapa inline, bukan icon font atau paket ikon: hanya 9 ikon yang
    tidak pernah berubah, dan menambah dependensi hanya untuk itu tidak
    sepadan. Inline SVG juga ikut mewarisi `currentColor` dan `stroke-width`,
    jadi satu kelas Tailwind mengatur warna dan ketebalan semua ikon sekaligus.

    Kunci ikon datang dari config('keunggulan') dan config('kegiatan'). Kunci
    yang tidak dikenal memakai ikon cadangan, bukan membuat halaman kosong.
    `buku` sengaja TIDAK punya @case: ia adalah cabang @default itu sendiri,
    supaya kunci yang belum dikenal pun tetap dapat tampil.
--}}
@props([
    'nama' => 'buku',
    'class' => 'h-5 w-5',
])

<svg {{ $attributes->merge(['class' => $class]) }}
     fill="none"
     viewBox="0 0 24 24"
     stroke-width="1.5"
     stroke="currentColor"
     aria-hidden="true"
     focusable="false">
    @switch($nama)
        @case('piala')
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.375h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.375h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
            @break

        @case('perisai')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M12 2.25l8.25 3v6c0 5.023-3.478 9.72-8.25 11.025-4.772-1.305-8.25-6.002-8.25-11.025v-6l8.25-3Z" />
            @break

        @case('toga')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
            @break

        @case('perkakas')
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26" />
            @break

        @case('hadiah')
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625V4.875m0 0h1.5a2.625 2.625 0 0 1 0 5.25H12m0 0H9.375a2.625 2.625 0 0 1 0-5.25H12m0 0H10.5a2.625 2.625 0 0 1 0-5.25M3.75 11.25h16.5" />
            @break

        @case('koper')
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.075c0 1.313-.937 2.438-2.238 2.65-1.074.176-2.214.265-3.512.265s-2.438-.09-3.512-.265c-1.301-.212-2.238-1.337-2.238-2.65V14.15M18 18.75h.008v.008H18v-.008ZM8.25 10.5V8.25A2.25 2.25 0 0 1 10.5 6h3a2.25 2.25 0 0 1 2.25 2.25V10.5m-12 0h13.5m-13.5 0a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5V9a1.5 1.5 0 0 1-1.5 1.5m-13.5 0a1.5 1.5 0 0 0-1.5 1.5v6a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-6a1.5 1.5 0 0 0-1.5-1.5Z" />
            @break

        @case('bendera')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
            @break

        {{--
            Ikon putar. Berbeda dari ikon garis di atasnya: segitiga ini pekat
            dan memakai `fill`, bukan `stroke`. Bentuknya tetap satu gaya
            dengan ikon lain, dan dipakai sebagai tombol putar, bukan dekorasi
            kartu.

            `fill` pada path menimpa `fill="none"` milik <svg>, dan stroke
            berwarna sama dipakai hanya untuk membulatkan sudutnya.
        --}}
        @case('putar')
            <path d="M8.5 5.25v13.5L20 12 8.5 5.25Z" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            @break

        @default
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
    @endswitch
</svg>
