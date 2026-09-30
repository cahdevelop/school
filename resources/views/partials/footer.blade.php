@php
    $tautanProfil = [
        'profil.sekolah' => 'Profil Sekolah',
        'profil.visi-misi' => 'Visi & Misi',
        'profil.sejarah' => 'Sejarah Sekolah',
        'profil.fasilitas' => 'Fasilitas',
    ];

    $tautanLain = [
        'berita.index' => 'Berita Sekolah',
        'pengumuman' => 'Pengumuman',
        'ppdb' => 'PPDB',
        'galeri' => 'Galeri',
        'kontak' => 'Kontak',
    ];
@endphp

<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 md:grid-cols-4">

        <div>
            <div class="flex items-center gap-2.5">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-slate-900 text-sm font-bold text-white">SHB</span>
                <span class="text-sm font-semibold leading-tight text-slate-900">
                    Sekolah Harapan Bangsa
                </span>
            </div>
            <p class="mt-4 text-sm leading-relaxed text-slate-600">
                Sekolah menengah kejuruan yang menyiapkan siswa melalui
                praktik langsung, soft skill, dan pendampingan karier.
            </p>
        </div>

        <div>
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Menu Utama</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                @foreach (['beranda' => 'Beranda', 'profil.guru-staf' => 'Tenaga Pendidik', 'bkk' => 'BKK', 'tracer-study' => 'Tracer Study', 'spmb' => 'SPMB'] as $nama => $label)
                    <li>
                        <a href="{{ route($nama) }}" class="text-slate-600 transition hover:text-amber-600">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Halaman</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                @foreach ($tautanProfil + $tautanLain as $nama => $label)
                    <li>
                        <a href="{{ route($nama) }}" class="text-slate-600 transition hover:text-amber-600">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Kontak</h2>
            <address class="mt-4 space-y-1.5 text-sm not-italic text-slate-600">
                <p>Jl. Pendidikan No. 10, Jakarta</p>
                <p>Telp: (021) 555-0123</p>
                <p>info@sekolahharapanbangsa.sch.id</p>
            </address>
        </div>
    </div>

    <div class="border-t border-slate-200 py-5 text-center text-xs text-slate-500">
        &copy; {{ now()->year }} Sekolah Harapan Bangsa. Seluruh hak cipta dilindungi.
    </div>
</footer>
