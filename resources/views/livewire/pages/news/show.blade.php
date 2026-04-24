@section('title', $newsArticle->title)

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
        <article class="glass-panel overflow-hidden p-5">
            <img src="{{ $newsArticle->cover_image_url }}" alt="{{ $newsArticle->title }}"
                class="h-96 w-full rounded-[2rem] object-cover">
            <div class="mt-6 space-y-4">
                <a href="{{ route('news.index') }}" wire:navigate class="section-link">Kembali ke berita & agenda</a>
                <span class="badge-pill">{{ $newsArticle->category }}</span>
                <h1 class="font-display text-5xl text-slate-900">{{ $newsArticle->title }}</h1>
                <p class="text-sm uppercase tracking-[0.22em] text-slate-500">
                    {{ optional($newsArticle->published_at)->translatedFormat('d F Y') }}</p>
                <div
                    class="prose max-w-none space-y-4 text-base leading-8 text-slate-600 prose-headings:font-display prose-a:text-violet-700">
                    <p>{{ $newsArticle->excerpt }}</p>
                    {!! $newsArticle->content !!}
                </div>
            </div>
        </article>

        <aside class="glass-panel p-6">
            <p class="font-display text-3xl text-slate-900">Artikel terkait</p>
            <div class="mt-4 space-y-4">
                @foreach ($relatedArticles as $article)
                    <a href="{{ route('news.show', $article) }}" wire:navigate
                        class="block rounded-[1.5rem] border border-slate-200 p-4 transition hover:border-violet-300">
                        <p class="text-sm text-violet-700">{{ $article->category }}</p>
                        <p class="mt-2 font-display text-2xl text-slate-900">{{ $article->title }}</p>
                        <p class="mt-2 text-sm leading-7 text-slate-500">{{ $article->excerpt }}</p>
                    </a>
                @endforeach
            </div>
        </aside>
    </section>
</div>
