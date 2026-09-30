{{--
    Section "Kegiatan & Karya Peserta Didik".

    Isinya dari config/kegiatan.php. Ikon putarnya ada di <x-ikon> dengan kunci
    `putar`, jadi file ini tidak menyimpan SVG apa pun.

    ANIMASI: seluruh section muncul dari ATAS ke BAWAH secara berurutan.
    `data-reveal-group` membungkus header, sorotan, dan grid sekaligus, jadi
    hanya ada SATU titik pemicu untuk seluruh section. Kalau tiap kartu dipantau
    sendiri, kartu yang masuk viewport belakangan akan menunggu jeda
    `--reveal-delay` padahal tidak ada yang perlu menunggu.

    Semua elemen memakai `data-reveal-item="down"` di dalam group itu. `down`
    berarti datang DARI ATAS: mulai di atas, bergerak ke bawah, berhenti di 0.
    Jangan tertukar dengan `up` yang arahnya kebalikan.

    Tempo 1s dan jarak tempuh 1rem disengaja: yang dicari gerak yang anggun,
    bukan dramatis. Jarak jauh membuat elemen terlihat jatuh, bukan bergerak
    cepat.

    Strip foto dan video memakai struktur kartu yang sama persis. Yang
    membedakan hanya sisipan tombol putar dan isi baris paling bawah, jadi
    menambah kegiatan baru cukup dengan menambah entri di config/kegiatan.php.
--}}
@php
    /*
     * Menampilkan tepat 4 item: 2 video dan 2 foto, diurutkan dari tanggal terbaru.
     * Item paling baru menjadi sorotan utama, sedangkan 3 lainnya menjadi kartu grid.
     */
    $semua = \Illuminate\Support\Collection::make(config('kegiatan'))
        ->filter(fn ($item) => is_array($item))
        ->sortByDesc('tanggal');

    $videos = $semua->where('tipe', 'video')->take(2);
    $fotos = $semua->where('tipe', 'foto')->take(2);

    $daftar = $videos->concat($fotos)
        ->sortByDesc('tanggal')
        ->values();

    $sorotan = $daftar->first();

    /*
     * `values()` setelah `slice()` itu WAJIB, bukan gaya.
     *
     * slice() mempertahankan kunci asli, jadi tanpa values() indeks kartu
     * dimulai dari 1, bukan 0. Efeknya jeda `--reveal-delay` kartu pertama
     * lompat ke 210ms, bukan 150ms, dan jarak antar unit jadi 120ms -- di luar
     * pita 50-100ms yang menjaga urutannya tetap terbaca.
     */
    $kartu = $daftar->slice(1)->values();

    /*
     * Peta warna lencana. `??` di bawahnya yang menangani kategori yang belum
     * terdaftar, supaya kategori baru tetap dapat lencana, tidak pernah tampil
     * polos tanpa warna. Warna gradien cadangan mengikuti warna lencana yang
     * sama supaya konsisten.
     */
    $gayaKategori = [
        'Praktikum' => 'bg-sky-100 text-sky-800 ring-sky-600/20',
        'Pameran Karya' => 'bg-amber-100 text-amber-800 ring-amber-600/20',
        'Prestasi' => 'bg-emerald-100 text-emerald-800 ring-emerald-600/20',
    ];
    $latarKategori = [
        'Praktikum' => 'from-sky-100 via-sky-50 to-white',
        'Pameran Karya' => 'from-amber-100 via-amber-50 to-white',
        'Prestasi' => 'from-emerald-100 via-emerald-50 to-white',
    ];

    /*
     * Inisial untuk cadangan tanpa gambar.
     *
     * Diambil dari JUDUL, bukan dari kategori: beberapa kategori berbagi dua
     * huruf awal yang sama ("Praktikum" dan "Prestasi" sama-sama "PR"), jadi
     * kalau dari kategori semua kartu cadangan jadi kembar.
     */
    $inisial = fn (string $judul) => \Illuminate\Support\Str::substr($judul, 0, 2);

    $adanyaGambar = function (?string $nama) {
        return filled($nama) && is_file(public_path('images/kegiatan/'.$nama));
    };

    /*
     * Tanggal dirender dengan locale `id` secara eksplisit.
     *
     * APP_LOCALE di .env masih `en` dan tidak ada folder lang/, jadi
     * translatedFormat() tanpa locale menghasilkan bulan berbahasa Inggris di
     * halaman yang seluruh teksnya bahasa Indonesia. Carbon sudah membawa
     * terjemahan `id` sendiri, jadi tidak perlu file locale tambahan.
     */
    $tanggal = fn ($nilai) => \Illuminate\Support\Carbon::parse($nilai)->locale('id');

    // Jeda antar unit. Semuanya di dalam satu group, jadi semua menyala pada
    // titik waktu yang sama dan jeda hanya menggeser permulaannya.
    $jedaSorotan = 90;
    $jedaKartu = 60;
@endphp

@if ($sorotan && filled($sorotan))
    <section aria-labelledby="kegiatan-judul"
             class="relative overflow-hidden border-y border-amber-200/70 bg-gradient-to-b from-amber-50/80 via-orange-50/30 to-amber-50/60"
             style="--reveal-dur: 1s; --reveal-jarak-y: 1rem;">
        {{-- Elemen dekoratif latar belakang agar tampilan lebih hidup dan menarik --}}
        <div class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-amber-300/25 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-1/2 -left-28 h-96 w-96 rounded-full bg-orange-300/20 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 right-1/4 h-80 w-80 rounded-full bg-amber-200/25 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-0 opacity-35 [mask-image:radial-gradient(ellipse_at_center,black_40%,transparent_80%)]"
             style="background-image: radial-gradient(#d97706 0.75px, transparent 0.75px); background-size: 24px 24px;"
             aria-hidden="true"></div>

        <div class="relative mx-auto max-w-6xl px-4 py-16 sm:py-20 lg:py-24">

            <div data-reveal-group>

                {{-- Header --}}
                <div data-reveal-item="down" style="--reveal-delay: 0ms" class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-2xl">
                        <p class="inline-flex items-center gap-2 rounded-full border border-amber-300/80 bg-white/90 px-3.5 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-amber-800 shadow-xs backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500" aria-hidden="true"></span>
                            Dari Murid Kami
                        </p>

                        <h2 id="kegiatan-judul"
                            class="mt-5 text-balance text-2xl font-bold leading-[1.2] tracking-tight text-slate-900 sm:text-3xl">
                            Kegiatan &amp; Karya Peserta Didik
                        </h2>

                        <p class="mt-4 text-pretty text-[0.9375rem] leading-relaxed text-slate-600 sm:text-base">
                            Praktikum, pameran, dan karya yang dikerjakan sendiri oleh peserta didik,
                            dari kelas pertama sampai hari mereka melepas ijazah.
                        </p>
                    </div>

                    <a href="{{ route('galeri') }}"
                       class="group relative hidden sm:inline-flex items-center gap-1.5 pb-1 text-sm font-semibold text-slate-700 transition-colors duration-300 hover:text-amber-700 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-400 after:absolute after:inset-x-0 after:bottom-0 after:h-px after:origin-left after:scale-x-0 after:bg-amber-500 after:transition-transform after:duration-300 hover:after:scale-x-100 motion-reduce:transition-none motion-reduce:after:hidden">
                        Lihat selengkapnya
                        <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                {{--
                    Media sorotan.

                    Satu panel gelap selebar penuh, bukan kartu selebar grid. Ini
                    yang memberi hierarki: sorotan dibaca sebagai satu blok, baru
                    menyusul grid kartu-kartu kecil di bawahnya.

                    Tata letaknya 7:5 di layar lebar. Sisi teks memakai `justify-center`
                    supaya blok teksnya tetap tegak di tengah walau tinggi kolomnya
                    berubah karena panjang judul.
                --}}
                @php
                    $sorotanVideo = ($sorotan['tipe'] ?? null) === 'video';
                    $sorotanTautan = $sorotan['tautan'] ?? null;
                    $sorotanGambar = $sorotan['gambar'] ?? null;
                    $sorotanKategori = $sorotan['kategori'] ?? '';
                    $sorotanJudul = $sorotan['judul'] ?? '';
                    $sorotanRingkasan = $sorotan['ringkasan'] ?? '';
                    $sorotanTanggal = $tanggal($sorotan['tanggal'] ?? now());
                @endphp

                <article data-reveal-item="down"
                         style="--reveal-delay: {{ $jedaSorotan }}ms"
                         class="group relative mt-12 grid overflow-hidden rounded-2xl bg-slate-900 shadow-xl shadow-slate-950/20 ring-1 ring-slate-800 lg:grid-cols-12">

                    <div class="relative lg:col-span-7 lg:min-h-[19rem]">
                        <div class="relative aspect-[16/10] w-full lg:aspect-auto lg:h-full">
                            @if ($adanyaGambar($sorotanGambar))
                                <img src="{{ asset('images/kegiatan/'.$sorotanGambar) }}"
                                     alt="{{ $sorotanVideo ? 'Cuplikan video' : 'Foto' }}: {{ $sorotanJudul }}"
                                     width="1600"
                                     height="1000"
                                     loading="lazy"
                                     decoding="async"
                                     class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105 motion-reduce:transition-none motion-reduce:group-hover:scale-100">
                            @else
                                {{--
                                    Cadangan untuk panel gelap. Warnanya gelap dan
                                    teksnya putih, bukan gradien terang seperti di
                                    kartu: panel ini berbingkai gelap, jadi blok
                                    terang di dalamnya akan terlihat seperti
                                    kesalahan, bukan seperti foto yang belum ada.
                                --}}
                                <div class="flex h-full w-full items-end bg-gradient-to-br from-slate-800 to-slate-950 p-6">
                                    <span class="select-none text-5xl font-bold uppercase leading-none tracking-tight text-white/10" aria-hidden="true">
                                        {{ $inisial($sorotanJudul) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Tirai bawah supaya tombol putar dan teks di atas foto selalu terbaca. --}}
                            <span class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/25 to-transparent" aria-hidden="true"></span>

                            @if ($sorotanVideo)
                                <span class="absolute inset-0 grid place-items-center" aria-hidden="true">
                                    <span class="grid h-16 w-16 place-items-center rounded-full bg-white/95 text-slate-900 shadow-lg ring-1 ring-slate-900/10 transition duration-300 group-hover:scale-105 motion-reduce:transition-none motion-reduce:group-hover:scale-100">
                                        <x-ikon nama="putar" class="h-6 w-6 translate-x-px" />
                                    </span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="relative flex flex-col justify-center p-7 sm:p-9 lg:col-span-5 lg:p-12">
                        <div class="flex items-center gap-3">
                            <span class="h-px w-8 shrink-0 bg-amber-400/70" aria-hidden="true"></span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-300">
                                {{ $sorotanVideo ? 'Video Unggulan' : 'Karya Pilihan' }}
                            </span>
                        </div>

                        <h3 class="mt-5 text-balance text-2xl font-bold leading-[1.2] tracking-tight text-white sm:text-3xl">
                            {{ $sorotanJudul }}
                        </h3>

                        <p class="mt-4 text-pretty text-[0.9375rem] leading-relaxed text-slate-300 sm:text-base">
                            {{ $sorotanRingkasan }}
                        </p>

                        <div class="mt-7 flex flex-wrap items-center gap-3">
                            @if (filled($sorotanTautan))
                                {{--
                                    Tautan ke luar, jadi `target`/`rel` wajib: `noopener`
                                    menutup celah tabnabbing.

                                    `group` diletakkan pada tautan ini, bukan pada
                                    article, supaya `group-hover` panah di bawahnya mengikuti
                                    kursor di tautan saja dan bukan seluruh panel.
                                --}}
                                <a href="{{ $sorotanTautan }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="group inline-flex items-center gap-2 rounded-lg bg-amber-400 px-4 py-2.5 text-xs font-semibold tracking-wide text-slate-950 transition duration-300 hover:bg-amber-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-300 motion-reduce:transition-none">
                                    <x-ikon nama="putar" class="h-3.5 w-3.5" />
                                    Tonton di YouTube
                                    <span class="transition-transform duration-300 group-hover:translate-x-0.5 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2.5 text-xs font-semibold text-white/90 ring-1 ring-inset ring-white/15">
                                    Dokumentasi foto
                                </span>
                            @endif
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-x-4 gap-y-1 border-t border-white/10 pt-5 text-xs text-slate-400">
                            <time datetime="{{ $sorotanTanggal->toDateString() }}" class="tabular-nums">
                                {{ $sorotanTanggal->translatedFormat('d F Y') }}
                            </time>
                            <span class="text-slate-600" aria-hidden="true">/</span>
                            <span>{{ $sorotanKategori }}</span>
                        </div>
                    </div>
                </article>

                {{--
                    Grid kartu.

                    satu tata letak untuk video dan foto; yang membedakan hanya
                    sisipan tombol putar dan isi baris paling bawah. Dua loop
                    terpisah akan menggandakan seluruh struktur kartu dan
                    mudah sekali saling melenceng, jadi bedanya dibuat sekecil
                    mungkin di dalam satu loop.
                --}}
                @if ($kartu->isNotEmpty())
                    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($kartu as $index => $item)
                            @php
                                $video = ($item['tipe'] ?? null) === 'video';
                                $tautan = $item['tautan'] ?? null;
                                $adaTautan = filled($tautan);
                                $gambar = $item['gambar'] ?? null;
                                $kategori = $item['kategori'] ?? '';
                                $itemJudul = $item['judul'] ?? '';
                                $itemTanggal = $tanggal($item['tanggal'] ?? now());
                            @endphp

                            {{--
                                Reveal menempel pada pembungkus, BUKAN pada <article>.
                                Alasannya sama seperti kartu berita: article punya
                                transform hover (`hover:-translate-y-1`) dan gambarnya
                                punya `group-hover:scale-105`. Kalau reveal menempel
                                di elemen yang sama, keduanya saling menimpa dan
                                efek hover mati.
                            --}}
                            <div data-reveal-item="down"
                                 style="--reveal-delay: {{ $jedaSorotan + $jedaKartu + $index * $jedaKartu }}ms"
                                 class="h-full">
                                <article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-amber-900/10 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-amber-300 hover:shadow-xl hover:shadow-amber-950/10 focus-within:-translate-y-1 focus-within:shadow-xl focus-within:shadow-amber-950/10 motion-reduce:transition-none motion-reduce:hover:translate-y-0 motion-reduce:focus-within:translate-y-0">

                                    {{-- Media --}}
                                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                        @if ($adanyaGambar($gambar))
                                            <img src="{{ asset('images/kegiatan/'.$gambar) }}"
                                                 alt="{{ $video ? 'Cuplikan video' : 'Foto' }}: {{ $itemJudul }}"
                                                 width="1600"
                                                 height="1000"
                                                 loading="lazy"
                                                 decoding="async"
                                                 class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105 motion-reduce:transition-none motion-reduce:group-hover:scale-100">
                                        @else
                                            <div class="flex h-full w-full items-end bg-gradient-to-br p-5 {{ $latarKategori[$kategori] ?? 'from-slate-100 via-slate-50 to-white' }}">
                                                <span class="select-none text-3xl font-bold uppercase leading-none tracking-tight text-slate-900/10" aria-hidden="true">
                                                    {{ $inisial($itemJudul) }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- Video: tirai tipis yang memudar saat kursor mendekat, lalu tombol putar. --}}
                                        @if ($video)
                                            <span class="absolute inset-0 bg-slate-950/15 transition-colors duration-300 group-hover:bg-slate-950/0" aria-hidden="true"></span>
                                            <span class="absolute inset-0 grid place-items-center" aria-hidden="true">
                                                <span class="grid h-12 w-12 place-items-center rounded-full bg-white/95 text-slate-900 shadow-md ring-1 ring-slate-900/10 transition duration-300 group-hover:scale-105 motion-reduce:transition-none motion-reduce:group-hover:scale-100">
                                                    <x-ikon nama="putar" class="h-4 w-4 translate-x-px" />
                                                </span>
                                            </span>
                                        @endif

                                        {{-- Lencana kategori. Menimpa gambar, jadi tidak menambah tinggi kartu. --}}
                                        <span class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-[11px] font-semibold tracking-wide ring-1 ring-inset {{ $gayaKategori[$kategori] ?? 'bg-slate-100 text-slate-700 ring-slate-500/20' }}">
                                            {{ $kategori }}
                                        </span>
                                    </div>

                                    {{-- Isi --}}
                                    <div class="flex flex-1 flex-col p-5">
                                        <h3 class="text-base font-bold leading-snug tracking-tight text-slate-900">
                                            @if ($adaTautan)
                                                {{--
                                                    Pola stretched-link: hanya judul yang tautan
                                                    sungguhan, tapi `after:inset-0` membuat
                                                    seluruh kartu bisa diklik. Itu sebabnya baris
                                                    paling bawah HANYA teks, tidak pernah
                                                    <a> kedua di dalam tautan pertama.
                                                --}}
                                                <a href="{{ $tautan }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="after:absolute after:inset-0 after:content-[''] focus-visible:outline-none">
                                                    {{ $itemJudul }}
                                                </a>
                                            @else
                                                {{ $itemJudul }}
                                            @endif
                                        </h3>

                                        <p class="mt-2.5 flex-1 line-clamp-2 text-sm leading-relaxed text-slate-600">
                                            {{ $item['ringkasan'] }}
                                        </p>

                                        <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                            <time datetime="{{ $itemTanggal->toDateString() }}"
                                                  class="text-xs font-medium tabular-nums text-slate-400">
                                                {{ $itemTanggal->translatedFormat('d F Y') }}
                                            </time>

                                            <span class="inline-flex shrink-0 items-center gap-1.5 text-xs font-semibold {{ $video ? 'text-amber-600' : 'text-slate-500' }}">
                                                @if ($video)
                                                    Tonton di YouTube
                                                    <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
                                                @else
                                                    Dokumentasi foto
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Tautan "Lihat Selengkapnya" --}}
                <div data-reveal-item="down"
                     style="--reveal-delay: {{ $jedaSorotan + $jedaKartu * 4 }}ms"
                     class="mt-12 flex justify-center">
                    <a href="{{ route('galeri') }}"
                       class="group inline-flex items-center gap-2.5 rounded-xl border border-amber-300/80 bg-white/95 px-6 py-3 text-sm font-semibold tracking-wide text-slate-800 shadow-sm shadow-amber-950/5 backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:border-amber-400 hover:bg-white hover:text-amber-800 hover:shadow-md hover:shadow-amber-950/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-400 motion-reduce:transition-none">
                        <span>Lihat Selengkapnya</span>
                        <span class="transition-transform duration-300 group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
