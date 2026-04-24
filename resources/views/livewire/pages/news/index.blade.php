@section('title', 'Berita & Agenda Alumni FTI')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="glass-panel overflow-hidden p-5">
            @if ($featuredArticle)
                <img src="{{ $featuredArticle->cover_image_url }}" alt="{{ $featuredArticle->title }}"
                    class="h-80 w-full rounded-4xl object-cover">
                <div class="mt-6 space-y-3">
                    <span class="badge-pill">{{ $featuredArticle->category }}</span>
                    <h1 class="font-display text-4xl text-slate-900">{{ $featuredArticle->title }}</h1>
                    <p class="text-base leading-8 text-slate-600">{{ $featuredArticle->excerpt }}</p>
                    <a href="{{ route('news.show', $featuredArticle) }}" wire:navigate class="section-link">Baca
                        selengkapnya</a>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="glass-panel p-6">
                <p class="section-eyebrow">Agenda</p>
                <div class="mt-4 space-y-4">
                    @foreach ($upcomingEvents as $event)
                        <article class="card-subtle">
                            <p class="text-sm text-violet-600">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                            <p class="mt-2 font-display text-2xl text-slate-900">{{ $event->title }}</p>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $event->summary }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="glass-panel p-6">
                <p class="section-eyebrow">Galeri</p>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    @foreach ($galleryItems as $item)
                        <img src="{{ $item->media_url }}" alt="{{ $item->title }}"
                            class="h-28 w-full rounded-[1.25rem] object-cover">
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Berita Alumni</p>
                <h2 class="section-title">Kumpulan berita, prestasi, dan kegiatan terbaru.</h2>
            </div>
        </div>
        <div class="card-grid-tight lg:grid-cols-3">
            @foreach ($articles as $article)
                <a href="{{ route('news.show', $article) }}" wire:navigate
                    class="glass-panel interactive-card block overflow-hidden p-4">
                    <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                        class="h-48 w-full rounded-3xl object-cover">
                    <div class="mt-4 space-y-2">
                        <span class="badge-pill">{{ $article->category }}</span>
                        <p class="font-display text-2xl text-slate-900">{{ $article->title }}</p>
                        <p class="text-sm leading-7 text-slate-500">{{ $article->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
