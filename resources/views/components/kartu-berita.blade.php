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
    $kategori = $berita['kategori'];

    /*
     * Warna badge per kategori. Nilai `??` menangani kategori yang nanti
     * ditambahkan ke data tanpa entri di sini, supaya kategori baru tidak
     * pernah tampil tanpa badge atau tanpa warna.
     */
    $gayaKategori = [
        'PPDB' => 'bg-amber-100 text-amber-800 ring-amber-600/20',
        'Prestasi' => 'bg-emerald-100 text-emerald-800 ring-emerald-600/20',
        'Kegiatan' => 'bg-sky-100 text-sky-800 ring-sky-600/20',
    ];
    $badge = $gayaKategori[$kategori] ?? 'bg-slate-100 text-slate-700 ring-slate-500/20';

    // Warna gradien cadangan mengikuti warna badge, supaya konsisten.
    $gradien = [
        'PPDB' => 'from-amber-100 via-amber-50 to-white',
        'Prestasi' => 'from-emerald-100 via-emerald-50 to-white',
        'Kegiatan' => 'from-sky-100 via-sky-50 to-white',
    ];
    $latar = $gradien[$kategori] ?? 'from-slate-100 via-slate-50 to-white';

    $gambar = $berita['gambar'] ?? null;
    $adaGambar = filled($gambar) && is_file(public_path('images/berita/'.$gambar));

    $tanggal = \Illuminate\Support\Carbon::parse($berita['tanggal']);
@endphp

<article @class([
    'group relative flex h-full overflow-hidden rounded-2xl border border-slate-200 bg-white',
    'shadow-sm transition duration-300',
    'hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-900/[0.08]',
    'focus-within:-translate-y-1 focus-within:shadow-xl focus-within:shadow-slate-900/[0.08]',
    'flex-col' => ! $featured,
    'sm:flex-row' => $featured,
])>

    {{-- Thumbnail --}}
    <div @class([
        'relative shrink-0 overflow-hidden bg-slate-100',
        'aspect-[16/10]' => ! $featured,
        'sm:aspect-auto sm:w-[46%]' => $featured,
    ])>
        @if ($adaGambar)
            <img src="{{ asset('images/berita/'.$gambar) }}"
                 alt="Ilustrasi berita: {{ $berita['judul'] }}"
                 width="1600"
                 height="1000"
                 loading="lazy"
                 decoding="async"
                 class="kartu-berita__foto h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105 motion-reduce:transition-none motion-reduce:group-hover:scale-100">
        @else
            {{--
                Cadangan: halaman tetap rapi walau file gambarnya belum ada.
                Inisial kategori sengaja dibuat sangat redup (slate-900/10)
                supaya tetap terbaca sebagai dekorasi, bukan teks.
            --}}
            <div class="flex h-full w-full items-end bg-gradient-to-br p-5 {{ $latar }}">
                <span class="select-none text-3xl font-bold uppercase leading-none tracking-tight text-slate-900/10" aria-hidden="true">
                    {{ \Illuminate\Support\Str::substr($kategori, 0, 2) }}
                </span>
            </div>
        @endif

        {{-- Badge kategori menimpa gambar, jadi tidak menambah tinggi kartu. --}}
        <span class="absolute left-4 top-4 rounded-full px-2.5 py-1 text-[11px] font-semibold tracking-wide ring-1 ring-inset {{ $badge }}">
            {{ $kategori }}
        </span>
    </div>

    {{-- Isi --}}
    <div class="flex min-w-0 flex-1 flex-col p-5 sm:p-6">

        <time class="text-xs font-medium tabular-nums text-slate-400"
              datetime="{{ $tanggal->toDateString() }}">
            {{ $tanggal->translatedFormat('d F Y') }}
        </time>

        <h3 @class([
            'mt-2 font-bold leading-snug tracking-tight text-slate-900 transition-colors duration-300 group-hover:text-amber-700',
            'text-lg' => ! $featured,
            'text-xl sm:text-2xl' => $featured,
        ])>
            <a href="{{ $url }}"
               class="after:absolute after:inset-0 after:content-[''] focus-visible:outline-none">
                {{ $berita['judul'] }}
            </a>
        </h3>

        <p @class([
            'mt-2.5 flex-1 text-sm leading-relaxed text-slate-600',
            'line-clamp-2' => ! $featured,
            'line-clamp-3' => $featured,
        ])>
            {{ $berita['ringkasan'] }}
        </p>

        <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
            <span class="truncate text-xs text-slate-500">
                {{ $berita['penulis'] }}
            </span>

            <span class="inline-flex shrink-0 items-center gap-1.5 text-xs font-semibold text-amber-600">
                Baca selengkapnya
                <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
            </span>
        </div>
    </div>
</article>
