@props(['guru'])

<div class="kartu-guru group relative flex flex-col items-center overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-sm">

    <img src="{{ asset('images/guru/'.$guru['foto']) }}"
         alt="Foto {{ $guru['nama'] }}"
         class="kartu-guru__foto aspect-square w-full object-cover"
         width="640"
         height="640"
         loading="lazy">

    <div class="w-full px-5 py-4 text-center">
        <h3 class="text-sm font-semibold leading-snug text-slate-900">{{ $guru['nama'] }}</h3>
        <p class="mt-0.5 text-xs text-amber-600">{{ $guru['jabatan'] }}</p>
    </div>

    {{-- Popup informasi guru, muncul saat kartu disorot atau difokus. --}}
    <div class="kartu-guru__popup pointer-events-none absolute inset-x-0 bottom-0 bg-slate-900/95 p-5 text-center backdrop-blur">
        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-amber-300">
            {{ $guru['jabatan'] }}
        </p>
        <p class="mt-1.5 text-xs leading-relaxed text-white/80">
            {{ $guru['nama'] }}
        </p>
        <p class="mt-3 border-t border-white/15 pt-3 text-xs text-white/60">
            Mengampu {{ $guru['mapel'] }}
        </p>
    </div>
</div>
