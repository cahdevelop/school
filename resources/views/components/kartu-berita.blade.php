{{--
    Kartu berita.

    Dua varian:
      - vertikal (default) : gambar di atas, dipakai di grid 3 kolom.
      - mendua (featured)  : gambar di kiri pada layar lebar, dipakai untuk
                             berita terbaru di halaman /berita.

    Pola stretched-link dipakai di kedua varian. Teks tautannya adalah judul
    berita, jadi tetap deskriptif untuk SEO dan pembaca layar, sementara
    `after:inset-0` membuat seluruh kartu bisa diklik tanpa bersarang tautan.

    Konsekuensinya: hanya judul yang jadi tautan sungguhan, sedangkan baris
    "Baca selengkapnya" murni hiasan visual.

    `line-clamp-*` is core in Tailwind v4, no plugin needed. It keeps every
    card in a row the same height even when titles and excerpts differ in
    length, which is what makes the grid line up.

    If `gambar` is missing or the file was deleted, a gradient tile keyed to
    the category is drawn instead. The page therefore never shows a broken
    image, and real photos can be dropped in later by overwriting the same
    filenames.
--}}
@props([
    'berita',
    'featured' => false,
])

@php
    $url = route('berita.show', $berita['slug']);
    $kategori = $berita['kategori'] ?? 'Berita';

    /*
     * Warna badge per kategori. Nilai `??` menangani kategori yang nanti
     * ditambahkan ke data tanpa entri di sini, supaya kategori baru tidak
     * pernah tampil tanpa badge atau tanpa warna.
     */
    $gayaKategori = [
        'PPDB' => 'bg-amber-100 text-amber-800 ring-amber-600/20',
        'Prestasi' => 'bg-emerald-100 text-emerald-800 ring-emerald-600/20',
        'Kegiatan' => 'bg-sky-100 text-sky-800 ring-sky-600/20',
        'Edukasi' => 'bg-purple-100 text-purple-800 ring-purple-600/20',
    ];
    $badge = $gayaKategori[$kategori] ?? 'bg-slate-100 text-slate-700 ring-slate-500/20';

    // Warna gradien cadangan mengikuti warna badge, supaya konsisten.
    $gradien = [
        'PPDB' => 'from-amber-100 via-amber-50 to-white',
        'Prestasi' => 'from-emerald-100 via-emerald-50 to-white',
        'Kegiatan' => 'from-sky-100 via-sky-50 to-white',
        'Edukasi' => 'from-purple-100 via-purple-50 to-white',
    ];
    $latar = $gradien[$kategori] ?? 'from-slate-100 via-slate-50 to-white';

    $gambar = $berita['gambar'] ?? null;
    $adaGambar = filled($gambar) && is_file(public_path('images/berita/'.$gambar));

    $tanggal = \Illuminate\Support\Carbon::parse($berita['tanggal']);
    $waktuBaca = $berita['waktu_baca'] ?? '3 mnt baca';
@endphp

<article @class([
    'group relative flex h-full overflow-hidden rounded-2xl border border-slate-200/90 bg-white transition duration-300',
    'shadow-sm hover:-translate-y-1 hover:border-amber-300 hover:shadow-xl hover:shadow-slate-900/[0.08]',
    'focus-within:-translate-y-1 focus-within:shadow-xl focus-within:shadow-slate-900/[0.08]',
    'flex-col' => ! $featured,
    'sm:flex-row' => $featured,
])>

    {{-- Thumbnail --}}
    <div @class([
        'relative shrink-0 overflow-hidden bg-slate-100',
        'aspect-[16/10]' => ! $featured,
        'sm:aspect-auto sm:w-[48%]' => $featured,
    ])>
        @if ($adaGambar)
            <img src="{{ asset('images/berita/'.$gambar) }}"
                 alt="Ilustrasi berita: {{ $berita['judul'] }}"
                 width="1600"
                 height="1000"
                 loading="lazy"
                 decoding="async"
                 class="kartu-berita__foto h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 motion-reduce:transition-none motion-reduce:group-hover:scale-100">
        @else
            <div class="flex h-full w-full items-end bg-gradient-to-br p-6 {{ $latar }}">
                <span class="select-none text-4xl font-bold uppercase leading-none tracking-tight text-slate-900/10" aria-hidden="true">
                    {{ \Illuminate\Support\Str::substr($kategori, 0, 2) }}
                </span>
            </div>
        @endif

        {{-- Lencana kategori --}}
        <span class="absolute left-4 top-4 rounded-full px-3 py-1 text-[11px] font-bold tracking-wide shadow-xs backdrop-blur-sm ring-1 ring-inset {{ $badge }}">
            {{ $kategori }}
        </span>
    </div>

    {{-- Isi --}}
    <div class="flex min-w-0 flex-1 flex-col p-5 sm:p-6 lg:p-7">

        {{-- Tanggal & Estimasi Baca --}}
        <div class="flex items-center gap-2 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1 font-medium tabular-nums">
                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <time datetime="{{ $tanggal->toDateString() }}">
                    {{ $tanggal->translatedFormat('d M Y') }}
                </time>
            </span>
            <span class="text-slate-300" aria-hidden="true">&bull;</span>
            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-500">
                <svg class="h-3 w-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                {{ $waktuBaca }}
            </span>
        </div>

        <h3 @class([
            'mt-2.5 font-bold leading-snug tracking-tight text-slate-900 transition-colors duration-300 group-hover:text-amber-700',
            'text-lg' => ! $featured,
            'text-xl sm:text-2xl lg:text-3xl' => $featured,
        ])>
            <a href="{{ $url }}"
               class="after:absolute after:inset-0 after:content-[''] focus-visible:outline-none">
                {{ $berita['judul'] }}
            </a>
        </h3>

        <p @class([
            'mt-3 flex-1 text-sm leading-relaxed text-slate-600',
            'line-clamp-2' => ! $featured,
            'line-clamp-3 sm:text-base' => $featured,
        ])>
            {{ $berita['ringkasan'] }}
        </p>

        <div class="mt-6 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
            <div class="flex items-center gap-2">
                <span class="grid h-6 w-6 place-items-center rounded-full bg-amber-50 text-[10px] font-bold text-amber-700 ring-1 ring-amber-200/60">
                    {{ \Illuminate\Support\Str::substr($berita['penulis'] ?? 'H', 0, 1) }}
                </span>
                <span class="truncate text-xs font-medium text-slate-600">
                    {{ $berita['penulis'] ?? 'Humas' }}
                </span>
            </div>

            @if ($featured)
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-400 px-3.5 py-1.5 text-xs font-bold text-slate-950 shadow-xs transition duration-200 group-hover:bg-amber-300">
                    Baca Artikel Lengkap
                    <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
                </span>
            @else
                <span class="inline-flex shrink-0 items-center gap-1 text-xs font-semibold text-amber-600 transition-colors group-hover:text-amber-700">
                    Baca
                    <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
                </span>
            @endif
        </div>
    </div>
</article>
