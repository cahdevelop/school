{{--
    Section "Mengapa Sekolah Menjadi Pilihan?".

    Isi dari config/keunggulan.php. Ikon SVG-nya ada di komponen
    <x-ikon>, jadi file ini hanya mengatur tata letak dan urutan.

    ANIMASI: seluruh section muncul dari ATAS ke BAWAH secara berurutan.
    Semua elemen memakai `data-reveal-item="down"` di dalam satu
    `data-reveal-group`, jadi:

    - satu titik pemicu untuk seluruh section, bukan satu per kartu. Kalau tiap
      kartu dipantau sendiri, kartu yang masuk viewport belakangan akan
      menunggu jeda `--reveal-delay` padahal tidak ada yang perlu menunggu.
    - `down` berarti datang dari atas, bukan bergerak naik dari bawah.

    Tempo 1s dan jarak tempuh pendek sengaja: yang dicari gerak yang anggun,
    bukan gerak yang dramatis. Jarak jauh membuat elemen terlihat jatuh,
    bukan bergerak cepat.
--}}
@php
    $sekolah = config('app.name') === 'Laravel'
        ? 'Sekolah Harapan Bangsa'
        : config('app.name');

    $jeda = 90;

    // Jeda dikecilkan setelah kartu ke-4 supaya baris kedua tidak terasa
    // tertinggal jauh dari baris pertama di layar lebar.
    $jedaKartu = 60;
@endphp

@php
    $daftar = config('keunggulan');

    $daftar = is_array($daftar) ? $daftar : [];
@endphp

@if (filled($daftar))
    <section aria-labelledby="mengapa-judul"
             class="border-t border-slate-200 bg-slate-50"
             style="--reveal-dur: 1s; --reveal-jarak-y: 1rem;">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:py-20 lg:py-24">

            {{--
                `data-reveal-group` membungkus header DAN grid sekaligus, jadi
                keduanya masuk sebagai satu rangkaian dari atas ke bawah.
            --}}
            <div data-reveal-group>

                {{-- Header --}}
                <div data-reveal-item="down"
                     style="--reveal-delay: 0ms"
                     class="max-w-2xl">
                    <p class="inline-flex items-center gap-2 rounded-full border border-amber-200/80 bg-amber-50/60 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-700">
                        Mengapa Kami?
                    </p>

                    <h2 id="mengapa-judul"
                        class="mt-5 text-balance text-2xl font-bold leading-[1.2] tracking-tight text-slate-900 sm:text-3xl">
                        Mengapa {{ $sekolah }} Menjadi Pilihan?
                    </h2>

                    <p class="mt-4 text-pretty text-[0.9375rem] leading-relaxed text-slate-600 sm:text-base">
                        Delapan hal yang membedakan sekolah ini, dirangkum apa adanya.
                    </p>
                </div>

                {{--
                    Grid keunggulan. 4 kolom di desktop, 2 di tablet, 1 di
                    ponsel. Kartu memakai `h-full` supaya tinggi baris tetap
                    rata walau panjang deskripsi tiap poin berbeda.
                --}}
                <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                    @foreach ($daftar as $index => $item)
                        <div data-reveal-item="down"
                             style="--reveal-delay: {{ $jeda + $index * $jedaKartu }}ms"
                             class="h-full">
                            <article class="group flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-amber-300 hover:shadow-md focus-within:-translate-y-1 motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                                {{--
                                    Ikon diberi kotak berlatar slate-100 yang
                                    berubah jadi amber saat hover. Warna ikon
                                    sendiri mengikuti `currentColor`, jadi satu
                                    kelas di wrapper cukup untuk dua efek itu.
                                --}}
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-slate-100 text-slate-700 transition-colors duration-300 group-hover:bg-amber-100 group-hover:text-amber-700">
                                    <x-ikon :nama="$item['ikon'] ?? 'buku'" class="h-5 w-5" />
                                </span>

                                <h3 class="mt-5 text-[0.9375rem] font-bold leading-snug tracking-tight text-slate-900">
                                    {{ $item['judul'] ?? 'Keunggulan' }}
                                </h3>

                                <p class="mt-2.5 text-sm leading-relaxed text-slate-600">
                                    {{ $item['deskripsi'] ?? '' }}
                                </p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
