@section('title', $newsArticle->title)

<div class="py-10 lg:py-12">
    <section class="section-shell grid gap-6 lg:grid-cols-[1fr_320px]">

        {{-- Main article --}}
        <article class="glass-panel overflow-hidden p-5">
            <img src="{{ $newsArticle->cover_image_url }}" alt="{{ $newsArticle->title }}"
                class="h-72 w-full rounded-xl object-cover">
            <div class="mt-5 space-y-3">
                <a href="{{ route('news.index') }}" wire:navigate
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Berita & Agenda
                </a>
                <span class="badge-pill">{{ $newsArticle->category }}</span>
                <h1 class="font-display text-3xl text-gray-900">{{ $newsArticle->title }}</h1>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                    {{ optional($newsArticle->published_at)->translatedFormat('d F Y') }}
                </p>
                <div class="prose prose-sm max-w-none text-gray-600 prose-headings:font-display prose-a:text-indigo-600">
                    <p>{{ $newsArticle->excerpt }}</p>
                    {!! $newsArticle->content !!}
                </div>
            </div>
        </article>

        {{-- Sidebar --}}
        <aside class="glass-panel h-fit p-5">
            <p class="section-eyebrow mb-3">Artikel Terkait</p>
            <div class="space-y-3">
                @forelse ($relatedArticles as $article)
                    <a href="{{ route('news.show', $article) }}" wire:navigate
                        class="card-subtle interactive-card block">
                        <p class="section-eyebrow">{{ $article->category }}</p>
                        <p class="mt-1 font-display text-lg text-gray-900 line-clamp-2">{{ $article->title }}</p>
                        <p class="mt-1 line-clamp-2 text-sm text-gray-500">{{ $article->excerpt }}</p>
                    </a>
                @empty
                    <p class="text-sm text-gray-400">Tidak ada artikel terkait.</p>
                @endforelse
            </div>
        </aside>
    </section>
</div>
