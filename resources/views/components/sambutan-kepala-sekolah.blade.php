{{--
    Sambutan Kepala Sekolah.

    Data teksnya di config/sambutan.php. Identitas kepala sekolah (nama,
    gelar, jabatan, foto) TIDAK ada di config itu, tapi diambil dari
    config('guru') dengan memilih entri berjabatan 'Kepala Sekolah'.

    Alasannya supaya hanya ada satu sumber kebenaran. Kalau nama dan fotonya
    ditulis ulang di sini, perubahan pada config('guru') tidak akan ikut
    terlihat di bagian ini, dan halaman /profil/guru-dan-staf akan
    menampilkan nama yang berbeda dari yang tampil di section ini.

    Section ini dilewati sepenuhnya kalau entri 'Kepala Sekolah' tidak ada di
    config('guru'), jadi halaman tidak pernah menampilkan section kosong.
--}}
@php
    $kepala = collect(config('guru'))->firstWhere('jabatan', 'Kepala Sekolah');
    $sambutan = config('sambutan');

    $foto = $kepala['foto'] ?? null;
    $adaFoto = filled($foto) && is_file(public_path('images/guru/'.$foto));

    // Jeda antarbaris saat teks masuk satu per satu.
    //
    // 70ms itu pilihan yang disengaja. Lebih kecil dari ~50ms, urutannya
    // tak terbaca karena semua baris bergerak bersama. Lebih besar dari
    // ~100ms, kolomnya berubah jadi antrean: mata menunggu tiap baris
    // selesai sebelum membaca baris berikutnya. Yang dicari adalah
    // "satu per satu", bukan "satu demi satu".
    $jeda = 70;
@endphp

@if ($kepala && is_array($sambutan) && filled($sambutan))
    <section aria-labelledby="sambutan-kepsek-judul"
             class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:py-20 lg:py-24">

            {{--
                Reveal: teks masuk dari KIRI baris per baris, foto masuk dari
                KANAN sebagai satu kesatuan.

                Arah gerak searah dengan arah baca mata, dari kiri ke kanan.

                PENTING: pembungkus kolom memakai `data-reveal-group`,
                dan tiap baris memakai `data-reveal-item`. Baris-baris ini
                tidak dipantau satu per satu; semuanya dinyalakan bersamaan
                oleh grupnya, lalu jeda `--reveal-delay` yang membuatnya
                berurutan. Kalau barisnya dipantau sendiri, baris yang
                masuk viewport belakangan akan menunggu jeda yang sudah tak
                relevan -- persis jeda ganda yang bikin terasa lambat.

                Tempo di kolom ini lebih cepat dari nilai default app.css,
                karena isinya baris kalimat pendek, bukan satu blok besar.
                Jarak tempuh juga dipendekkan: baris kecil yang meluncur
                1.5rem akan terlihat seperti melompat, bukan seperti masuk.
            --}}
            <div class="grid gap-10 lg:grid-cols-12 lg:items-center lg:gap-16">

                {{-- Teks --}}
                <div data-reveal-group
                     style="--reveal-dur: 560ms; --reveal-jarak-x: 0.75rem;"
                     class="lg:col-span-7">
                    <p data-reveal-item="left"
                       style="--reveal-delay: {{ $jeda * 0 }}ms"
                       class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-600">
                        <span class="h-px w-8 shrink-0 bg-amber-500/50" aria-hidden="true"></span>
                        Sambutan Kepala Sekolah
                    </p>

                    <h2 id="sambutan-kepsek-judul"
                        data-reveal-item="left"
                        style="--reveal-delay: {{ $jeda * 1 }}ms"
                        class="mt-5 max-w-2xl text-balance text-3xl font-bold leading-[1.15] tracking-tight text-slate-900 sm:text-4xl">
                        {{ $kepala['nama'] }}
                    </h2>

                    <p data-reveal-item="left"
                       style="--reveal-delay: {{ $jeda * 2 }}ms"
                       class="mt-3 flex flex-wrap items-center gap-x-2.5 gap-y-1 text-sm font-medium text-slate-500">
                        <span>{{ $kepala['jabatan'] }}</span>
                        <span class="h-1 w-1 rounded-full bg-slate-300" aria-hidden="true"></span>
                        <span>Sekolah Harapan Bangsa</span>
                    </p>

                    {{-- Garis aksen pendek, pemisah identitas dari isi. --}}
                    <div data-reveal-item="left"
                         style="--reveal-delay: {{ $jeda * 3 }}ms"
                         class="mt-7 h-px w-16 bg-amber-500/60"
                         aria-hidden="true"></div>

                    <div class="mt-7 max-w-2xl space-y-4 text-[0.9375rem] leading-[1.75] text-slate-600 sm:text-base">
                        <p data-reveal-item="left" style="--reveal-delay: {{ $jeda * 4 }}ms">
                            {{ $sambutan['sapaan'] }}
                        </p>

                        @foreach ($sambutan['paragraf'] as $i => $paragraf)
                            <p data-reveal-item="left" style="--reveal-delay: {{ $jeda * (5 + $i) }}ms">
                                {{ $paragraf }}
                            </p>
                        @endforeach
                    </div>

                    @if (filled($sambutan['motto'] ?? null))
                        <figure data-reveal-item="left"
                                style="--reveal-delay: {{ $jeda * (5 + count($sambutan['paragraf'])) }}ms"
                                class="mt-8 border-l-2 border-amber-500 pl-5">
                            <figcaption class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                                Motto
                            </figcaption>
                            <blockquote class="mt-1.5 text-lg font-semibold tracking-tight text-slate-800">
                                {{ $sambutan['motto'] }}
                            </blockquote>
                        </figure>
                    @endif
                </div>

                {{-- Foto --}}
                <div data-reveal="right" class="lg:col-span-5">
                    <div class="relative mx-auto max-w-sm lg:max-w-none">

                        {{--
                            Bingkai tipis yang digeser ke luar. Satu detail
                            editorial supaya foto terasa dirancang, bukan
                            ditempel. Sengaja sangat tipis: bukan ornamen,
                            hanya penanda kedalaman.
                        --}}
                        <div class="pointer-events-none absolute -right-3 -top-3 hidden h-full w-full rounded-2xl border border-amber-200/80 sm:block"
                             aria-hidden="true"></div>

                        @if ($adaFoto)
                            <img src="{{ asset('images/guru/'.$foto) }}"
                                 alt="Potret {{ $kepala['nama'] }}, {{ $kepala['jabatan'] }} Sekolah Harapan Bangsa"
                                 width="640"
                                 height="800"
                                 loading="lazy"
                                 decoding="async"
                                 class="relative aspect-4/5 w-full rounded-2xl bg-slate-100 object-cover shadow-[0_28px_60px_-38px_rgb(15_23_42/0.45)]">
                        @else
                            <div class="relative flex aspect-4/5 w-full items-end rounded-2xl bg-slate-100 p-6 shadow-[0_28px_60px_-38px_rgb(15_23_42/0.45)]">
                                <span class="text-4xl font-bold uppercase leading-none tracking-tight text-slate-900/10" aria-hidden="true">
                                    {{ \Illuminate\Support\Str::substr($kepala['nama'], 0, 2) }}
                                </span>
                            </div>
                        @endif

                        {{--
                            Keterangan di bawah foto. Mengulang nama di sini
                            itu disengaja: potret jadi punya identitas sendiri
                            kalau nanti dipotong atau dibagikan terpisah dari
                            teks sambutan.
                        --}}
                        <figcaption class="mt-5 border-t border-slate-200 pt-4 text-sm">
                            <span class="block font-semibold text-slate-900">{{ $kepala['nama'] }}</span>
                            <span class="mt-0.5 block text-slate-500">{{ $kepala['jabatan'] }}</span>
                        </figcaption>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
