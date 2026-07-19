@section('title', 'Galeri Alumni')

<div class="page-shell space-y-8">
    <section class="glass-panel overflow-hidden p-7 sm:p-10">
        <p class="section-eyebrow">Galeri</p>
        <h1 class="section-title mt-2">Dokumentasi kegiatan alumni</h1>
        <p class="section-copy mt-3 max-w-2xl">
            Kumpulan dokumentasi kegiatan, kolaborasi, dan kebersamaan alumni FTI yang dipublikasikan oleh admin.
        </p>
    </section>

    <section>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($galleryItems as $item)
                <article class="group overflow-hidden rounded-2xl border bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    style="border-color:var(--border)">
                    <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                        <img src="{{ $item->media_url }}" alt="{{ $item->title }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="space-y-2 p-5">
                        @if ($item->event_name)
                            <p class="section-eyebrow">{{ $item->event_name }}</p>
                        @endif
                        <h2 class="text-lg font-semibold" style="color:var(--ink)">{{ $item->title }}</h2>
                        @if ($item->caption)
                            <p class="text-sm leading-6" style="color:var(--ink-muted)">{{ $item->caption }}</p>
                        @endif
                        <p class="text-xs" style="color:var(--ink-muted)">
                            Dipublikasikan {{ $item->published_at->format('d M Y') }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="glass-panel col-span-full px-8 py-16 text-center">
                    <p class="font-semibold" style="color:var(--ink)">Belum ada dokumentasi yang dipublikasikan</p>
                    <p class="mt-1 text-sm" style="color:var(--ink-muted)">Galeri akan tampil setelah admin mempublikasikan media.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
