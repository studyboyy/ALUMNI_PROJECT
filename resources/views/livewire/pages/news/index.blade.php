@section('title', 'Berita & Agenda Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Featured + Sidebar --}}
    <section class="section-shell mb-8 grid gap-5 lg:grid-cols-[1.2fr_0.8fr] lg:items-start">

        {{-- Featured article --}}
        <div class="glass-panel overflow-hidden lg:self-start">
            @if ($featuredArticle)
                <a href="{{ route('news.show', $featuredArticle) }}" wire:navigate
                   class="group relative block overflow-hidden">
                    {{-- Image with zoom on hover --}}
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="{{ $featuredArticle->cover_image_url }}" alt="{{ $featuredArticle->title }}"
                             class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                        {{-- Gradient overlay --}}
                        <div class="absolute inset-0"
                             style="background:linear-gradient(to top, rgba(0,0,0,.75) 0%, rgba(0,0,0,.3) 45%, transparent 100%)"></div>
                        {{-- Content overlay --}}
                        <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <span class="badge-pill">{{ $featuredArticle->category }}</span>
                                @if($featuredArticle->published_at)
                                    <span class="rounded-full border border-white/15 bg-white/10 px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-wide text-white/80 backdrop-blur-sm">
                                        {{ $featuredArticle->published_at->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                            <h1 class="font-display text-2xl leading-snug text-white sm:text-3xl">
                                {{ $featuredArticle->title }}
                            </h1>
                            <p class="mt-2 max-w-2xl line-clamp-2 text-sm leading-relaxed text-white/80">
                                {{ $featuredArticle->excerpt }}
                            </p>
                            <span class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-white/90 transition group-hover:translate-x-0.5">
                                Baca selengkapnya
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @else
                <div class="flex min-h-[24rem] items-center justify-center p-8 text-center">
                    <div>
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl"
                             style="background:var(--brand-soft)">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 style="color:var(--brand)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <p class="font-semibold" style="color:var(--ink)">Belum ada artikel utama</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="flex flex-col gap-4">
            <div class="glass-panel p-4">
                <p class="section-eyebrow mb-3">Agenda Mendatang</p>
                        <div class="space-y-3">
                    @foreach ($upcomingEvents as $event)
                        <article class="card-subtle">
                            <p class="text-xs font-medium" style="color:var(--brand)">
                                {{ $event->starts_at->format('d M Y') }}
                            </p>
                            <p class="mt-1 font-display text-lg" style="color:var(--ink)">{{ $event->title }}</p>
                            <p class="mt-0.5 line-clamp-2 text-sm" style="color:var(--ink-muted)">{{ $event->summary }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            @if($galleryItems->count())
                <div class="glass-panel p-4">
                    <p class="section-eyebrow mb-3">Galeri</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($galleryItems as $item)
                            <div class="group relative overflow-hidden rounded-lg">
                                <img src="{{ $item->media_url }}" alt="{{ $item->title }}"
                                     class="h-24 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Articles grid --}}
    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Berita Alumni</p>
                <h2 class="section-title">Berita, prestasi, dan kegiatan terbaru.</h2>
            </div>
        </div>
        @if($articles->count())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <a href="{{ route('news.show', $article) }}" wire:navigate
                       class="glass-panel group block overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        {{-- Image with hover zoom --}}
                        <div class="relative overflow-hidden h-44">
                            <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            {{-- Category overlay --}}
                            <div class="absolute left-3 top-3">
                                <span class="badge-pill">{{ $article->category }}</span>
                            </div>
                        </div>
                        <div class="p-4 space-y-1.5">
                            <p class="font-display text-xl leading-snug" style="color:var(--ink)">{{ $article->title }}</p>
                            <p class="line-clamp-2 text-sm leading-relaxed" style="color:var(--ink-muted)">{{ $article->excerpt }}</p>
                            @if($article->published_at)
                                <p class="text-xs font-medium uppercase tracking-wider pt-1" style="color:var(--ink-muted)">
                                    {{ $article->published_at->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Enhanced empty state --}}
            <div class="glass-panel py-20 text-center">
                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl"
                     style="background:var(--brand-soft)">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         style="color:var(--brand)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl mb-2" style="color:var(--ink)">Belum ada berita</h3>
                <p class="text-sm max-w-xs mx-auto" style="color:var(--ink-muted)">
                    Berita dan kegiatan terbaru alumni FTI akan muncul di sini.
                </p>
            </div>
        @endif
    </section>
</div>
