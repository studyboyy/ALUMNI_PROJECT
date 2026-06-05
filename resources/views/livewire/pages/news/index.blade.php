@section('title', 'Berita & Agenda Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Featured + Sidebar --}}
    <section class="section-shell mb-8 grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="glass-panel overflow-hidden p-4">
            @if ($featuredArticle)
                <img src="{{ $featuredArticle->cover_image_url }}" alt="{{ $featuredArticle->title }}"
                    class="h-64 w-full rounded-xl object-cover">
                <div class="mt-4 space-y-2">
                    <span class="badge-pill">{{ $featuredArticle->category }}</span>
                    <h1 class="font-display text-2xl text-gray-900">{{ $featuredArticle->title }}</h1>
                    <p class="text-sm leading-relaxed text-gray-500">{{ $featuredArticle->excerpt }}</p>
                    <a href="{{ route('news.show', $featuredArticle) }}" wire:navigate class="section-link">Baca selengkapnya</a>
                </div>
            @endif
        </div>

        <div class="flex flex-col gap-4">
            <div class="glass-panel p-4">
                <p class="section-eyebrow mb-3">Agenda Mendatang</p>
                <div class="space-y-3">
                    @foreach ($upcomingEvents as $event)
                        <article class="card-subtle">
                            <p class="text-xs font-medium" style="color:var(--brand)">
                                {{ $event->starts_at->translatedFormat('d M Y') }}
                            </p>
                            <p class="mt-1 font-display text-lg text-gray-900">{{ $event->title }}</p>
                            <p class="mt-0.5 line-clamp-2 text-sm text-gray-500">{{ $event->summary }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            @if($galleryItems->count())
                <div class="glass-panel p-4">
                    <p class="section-eyebrow mb-3">Galeri</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($galleryItems as $item)
                            <img src="{{ $item->media_url }}" alt="{{ $item->title }}"
                                class="h-24 w-full rounded-lg object-cover">
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
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($articles as $article)
                <a href="{{ route('news.show', $article) }}" wire:navigate
                    class="glass-panel interactive-card block overflow-hidden p-4">
                    <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                        class="h-44 w-full rounded-xl object-cover">
                    <div class="mt-3 space-y-1.5">
                        <span class="badge-pill">{{ $article->category }}</span>
                        <p class="font-display text-xl text-gray-900">{{ $article->title }}</p>
                        <p class="line-clamp-2 text-sm leading-relaxed text-gray-500">{{ $article->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
