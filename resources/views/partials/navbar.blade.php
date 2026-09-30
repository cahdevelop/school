@php
    $menuProgram = [
        'kuliner' => 'Kuliner',
        'dkv' => 'DKV',
        'tkj' => 'TKJ',
        'ak' => 'AK',
        'mp' => 'MP',
        'bd' => 'BD',
    ];

    $menuUtama = [
        'beranda' => 'Beranda',
        'profil.guru-staf' => 'Tenaga Pendidik',
        'bkk' => 'BKK',
        'tracer-study' => 'Tracer Study',
        'spmb' => 'SPMB',
    ];

    $solidAwal = $solid ?? false;
    $diProgram = request()->routeIs('program.*');
    $programIni = request()->routeIs('program.show') ? request()->route('slug') : null;
@endphp

{{--
    Navbar melayang di atas hero.

    `scrolled` adalah satu-satunya sumber kebenaran. Setiap warna, tinggi, dan
    bayangan diturunkan dari nilai itu lewat method, sehingga tidak ada bagian
    navbar yang bisa lupa ikut berubah.

    Halaman dalam ($solidAwal) tidak punya hero di belakang, jadi startsolid.
--}}
<header
    x-data="{
        scrolled: {{ $solidAwal ? 'true' : 'false' }},
        buka: false,

        kepala() {
            return this.scrolled
                ? 'fixed border-b border-slate-200 bg-white/95 shadow-[0_2px_16px_-6px_rgb(2_6_23/0.28)] backdrop-blur'
                : 'absolute border-b border-transparent bg-transparent';
        },

        tinggi() {
            return this.scrolled ? 'h-[4.5rem]' : 'h-[5.5rem]';
        },

        nav(aktif) {
            if (aktif) {
                return this.scrolled ? 'bg-slate-100 text-slate-900' : 'bg-white/15 text-white';
            }

            return this.scrolled
                ? 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                : 'text-white/85 hover:bg-white/10 hover:text-white';
        },

        lencana() {
            return this.scrolled ? 'bg-slate-900 text-white' : 'bg-amber-400 text-slate-950';
        },

        nama() {
            return this.scrolled ? 'text-slate-900' : 'text-white';
        },

        sub() {
            return this.scrolled ? 'text-slate-500' : 'text-white/60';
        },

        panel() {
            return this.scrolled
                ? 'border-slate-200 bg-white shadow-slate-900/10'
                : 'border-white/15 bg-slate-950/95 shadow-black/30';
        },

        tombol() {
            return this.scrolled
                ? 'border border-slate-200 text-slate-700 hover:bg-slate-50'
                : 'text-white hover:bg-white/10';
        },
    }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 }, { passive: true })"
    @keydown.escape.window="buka = false"
    :class="kepala()"
    class="inset-x-0 top-0 z-50 w-full transition-[background-color,border-color,box-shadow] duration-300 ease-out">

    <div :class="tinggi()"
         class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 transition-[height] duration-300 ease-out">

        <a href="{{ route('beranda') }}" class="flex shrink-0 items-center gap-2.5">
            <span :class="lencana()"
                  class="grid h-9 w-9 place-items-center rounded-lg text-sm font-bold transition-colors duration-300">SHB</span>
            <span class="leading-tight">
                <span :class="nama()"
                      class="block text-sm font-semibold tracking-tight transition-colors duration-300">Sekolah Harapan Bangsa</span>
                <span :class="sub()"
                      class="hidden text-[11px] uppercase tracking-[0.18em] transition-colors duration-300 sm:block">Sekolah Menengah Kejuruan</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Menu utama">
            <a href="{{ route('beranda') }}"
               :class="nav({{ request()->routeIs('beranda') ? 'true' : 'false' }})"
               @if (request()->routeIs('beranda')) aria-current="page" @endif
               class="rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-300">Beranda</a>

            <div class="menu-program relative">
                <a href="{{ route('program.index') }}"
                   :class="nav({{ $diProgram ? 'true' : 'false' }})"
                   @if ($diProgram) aria-current="page" @endif
                   class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-300">
                    Program Keahlian
                    <svg class="h-3.5 w-3.5 opacity-70" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.19l3.71-3.96a.75.75 0 1 1 1.08 1.04l-4.25 4.53a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <div class="menu-program__panel absolute left-0 top-full pt-3">
                    <div :class="panel()"
                         class="w-52 overflow-hidden rounded-xl border py-1.5 shadow-lg transition-colors duration-300">
                        @foreach ($menuProgram as $slug => $label)
                            <a href="{{ route('program.show', $slug) }}"
                               @class([
                                   'flex items-center justify-between px-4 py-2 text-sm transition-colors',
                                   'text-amber-600' => $programIni === $slug,
                                   'text-slate-700 hover:bg-slate-50 hover:text-slate-900' => $programIni !== $slug,
                               ])>
                                <span>{{ $label }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-slate-400">{{ $loop->iteration }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @foreach ($menuUtama as $nama => $label)
                @continue($nama === 'beranda')
                <a href="{{ route($nama) }}"
                   :class="nav({{ request()->routeIs($nama) ? 'true' : 'false' }})"
                   @if (request()->routeIs($nama)) aria-current="page" @endif
                   class="rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-300">{{ $label }}</a>
            @endforeach
        </nav>

        <button type="button"
                x-on:click="buka = ! buka"
                :class="tombol()"
                :aria-expanded="buka"
                :aria-label="buka ? 'Tutup menu' : 'Buka menu'"
                class="grid h-10 w-10 place-items-center rounded-lg transition-colors duration-300 lg:hidden">
            <svg x-show="! buka" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" />
            </svg>
            <svg x-show="buka" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    {{-- Panel mobile: selalu terang, karena mobile tidak bisa andalkan kontras
         foto hero di belakangnya. --}}
    <nav x-show="buka" x-cloak
         class="max-h-[calc(100svh-4rem)] overflow-y-auto border-t border-slate-200 bg-white p-3 lg:hidden"
         aria-label="Menu mobile">
        <a href="{{ route('beranda') }}"
           @class([
               'block rounded-lg px-3 py-2 text-sm',
               'bg-slate-100 font-medium text-slate-900' => request()->routeIs('beranda'),
               'text-slate-700' => ! request()->routeIs('beranda'),
           ])>
            Beranda
        </a>

        <p class="px-3 pb-1 pt-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Program Keahlian</p>
        @foreach ($menuProgram as $slug => $label)
            <a href="{{ route('program.show', $slug) }}"
               @class([
                   'block rounded-lg px-3 py-2 text-sm',
                   'bg-slate-100 font-medium text-slate-900' => $programIni === $slug,
                   'text-slate-700' => $programIni !== $slug,
               ])>{{ $label }}</a>
        @endforeach

        @foreach ($menuUtama as $nama => $label)
            @continue($nama === 'beranda')
            <a href="{{ route($nama) }}"
               @class([
                   'mt-1 block rounded-lg px-3 py-2 text-sm',
                   'bg-slate-100 font-medium text-slate-900' => request()->routeIs($nama),
                   'text-slate-700' => ! request()->routeIs($nama),
               ])>{{ $label }}</a>
        @endforeach
    </nav>
</header>
