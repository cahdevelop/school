@php
    $menuProgram = [
        'kuliner' => [
            'singkat' => 'Kuliner',
            'nama' => 'Kuliner',
            'deskripsi' => 'Seni kuliner, tata boga & pengolahan pangan',
            'warna' => 'bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white',
            'ikon' => 'kuliner',
        ],
        'dkv' => [
            'singkat' => 'DKV',
            'nama' => 'Desain Komunikasi Visual',
            'deskripsi' => 'Desain grafis, multimedia & promosi visual',
            'warna' => 'bg-violet-50 text-violet-600 group-hover:bg-violet-500 group-hover:text-white',
            'ikon' => 'dkv',
        ],
        'tkj' => [
            'singkat' => 'TKJ',
            'nama' => 'Teknik Komputer & Jaringan',
            'deskripsi' => 'Infrastruktur server & keamanan jaringan',
            'warna' => 'bg-sky-50 text-sky-600 group-hover:bg-sky-500 group-hover:text-white',
            'ikon' => 'tkj',
        ],
        'ak' => [
            'singkat' => 'AK',
            'nama' => 'Akuntansi',
            'deskripsi' => 'Pengelolaan laporan & sistem keuangan digital',
            'warna' => 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white',
            'ikon' => 'ak',
        ],
        'mp' => [
            'singkat' => 'MP',
            'nama' => 'Manufaktur & Pemesinan',
            'deskripsi' => 'Permesinan presisi & teknik manufaktur',
            'warna' => 'bg-blue-50 text-blue-600 group-hover:bg-blue-500 group-hover:text-white',
            'ikon' => 'mp',
        ],
        'bd' => [
            'singkat' => 'BD',
            'nama' => 'Bisnis Digital',
            'deskripsi' => 'Pemasaran daring, e-commerce & konten bisnis',
            'warna' => 'bg-rose-50 text-rose-600 group-hover:bg-rose-500 group-hover:text-white',
            'ikon' => 'bd',
        ],
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

            <div class="menu-program group/menu relative">
                <a href="{{ route('program.index') }}"
                   :class="nav({{ $diProgram ? 'true' : 'false' }})"
                   @if ($diProgram) aria-current="page" @endif
                   class="flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-300">
                    <span>Program Keahlian</span>
                    <svg class="h-3.5 w-3.5 opacity-70 transition-transform duration-200 group-hover/menu:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.19l3.71-3.96a.75.75 0 1 1 1.08 1.04l-4.25 4.53a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <div class="menu-program__panel absolute left-0 top-full pt-2">
                    <div class="w-[34rem] max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-slate-200/90 bg-white/98 p-3 shadow-2xl shadow-slate-900/15 ring-1 ring-slate-900/5 backdrop-blur-md">
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ($menuProgram as $slug => $item)
                                <a href="{{ route('program.show', $slug) }}"
                                   @class([
                                       'group flex items-start gap-3 rounded-xl p-2.5 transition duration-200',
                                       'bg-amber-50/90 ring-1 ring-amber-300' => $programIni === $slug,
                                       'hover:bg-slate-50' => $programIni !== $slug,
                                   ])>
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $item['warna'] }} transition-all duration-200 shadow-xs">
                                        @switch($item['ikon'])
                                            @case('kuliner')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                                    <line x1="6" y1="1" x2="6" y2="4"></line>
                                                    <line x1="10" y1="1" x2="10" y2="4"></line>
                                                    <line x1="14" y1="1" x2="14" y2="4"></line>
                                                </svg>
                                                @break

                                            @case('dkv')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.563-2.512 5.563-5.563C22 6.5 17.5 2 12 2z"></path>
                                                </svg>
                                                @break

                                            @case('tkj')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                                    <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                                    <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                                    <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                                </svg>
                                                @break

                                            @case('ak')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="4" y="2" width="16" height="20" rx="2"></rect>
                                                    <line x1="8" y1="6" x2="16" y2="6"></line>
                                                    <line x1="16" y1="14" x2="16" y2="18"></line>
                                                    <path d="M16 10h.01"></path>
                                                    <path d="M12 10h.01"></path>
                                                    <path d="M8 10h.01"></path>
                                                    <path d="M12 14h.01"></path>
                                                    <path d="M8 14h.01"></path>
                                                    <path d="M12 18h.01"></path>
                                                    <path d="M8 18h.01"></path>
                                                </svg>
                                                @break

                                            @case('mp')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                                </svg>
                                                @break

                                            @case('bd')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                                </svg>
                                                @break
                                        @endswitch
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1.5">
                                            <span class="truncate text-xs font-bold text-slate-900 transition-colors group-hover:text-amber-700">
                                                {{ $item['nama'] }}
                                            </span>
                                            <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wider text-slate-500">
                                                {{ $item['singkat'] }}
                                            </span>
                                        </div>
                                        <p class="mt-0.5 line-clamp-1 text-[11px] leading-relaxed text-slate-500">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="-mx-3 -mb-3 mt-2 flex items-center justify-between rounded-b-2xl border-t border-slate-100 bg-slate-50/80 p-3 px-4">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                <span>6 Program Keahlian Siap Kerja</span>
                            </div>
                            <a href="{{ route('program.index') }}"
                               class="group/link inline-flex items-center gap-1 text-xs font-semibold text-amber-700 hover:text-amber-800 transition-colors">
                                <span>Lihat Semua Jurusan</span>
                                <span class="transition-transform duration-200 group-hover/link:translate-x-0.5" aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
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
        @foreach ($menuProgram as $slug => $item)
            <a href="{{ route('program.show', $slug) }}"
               @class([
                   'flex items-center justify-between rounded-lg px-3 py-2 text-sm transition-colors',
                   'bg-amber-50 font-semibold text-amber-800' => $programIni === $slug,
                   'text-slate-700 hover:bg-slate-50' => $programIni !== $slug,
               ])>
                <span class="flex items-center gap-2">
                    <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-bold text-slate-600">{{ $item['singkat'] }}</span>
                    <span>{{ $item['nama'] }}</span>
                </span>
                <span class="text-xs text-slate-400">&rarr;</span>
            </a>
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
