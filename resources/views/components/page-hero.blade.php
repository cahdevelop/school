@props(['judul', 'deskripsi' => null, 'lBreadcrumb' => null])

<section class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:py-16">
        @if ($lBreadcrumb)
            <nav class="mb-5 text-xs text-slate-500" aria-label="Remah roti">
                <a href="{{ route('beranda') }}" class="hover:text-slate-900">Beranda</a>
                <span class="mx-1.5 text-slate-300">/</span>
                <span class="text-slate-700">{{ $lBreadcrumb }}</span>
            </nav>
        @endif

        <h1 class="max-w-3xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $judul }}</h1>

        @if ($deskripsi)
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $deskripsi }}</p>
        @endif
    </div>
</section>
