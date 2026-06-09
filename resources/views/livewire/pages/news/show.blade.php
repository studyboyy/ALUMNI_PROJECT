@section('title', $newsArticle->title)

@php
    $publishedAt = $newsArticle->published_at;
    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    $publishedLabel = $publishedAt
        ? $publishedAt->format('d') . ' ' . $monthNames[(int) $publishedAt->format('n')] . ' ' . $publishedAt->format('Y')
        : null;
@endphp

<div class="py-10 lg:py-12">
    <section class="section-shell mb-6">
        <a href="{{ route('news.index') }}" wire:navigate
           class="inline-flex items-center gap-1.5 text-sm font-medium transition"
           style="color:var(--ink-muted)">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Berita & Agenda
        </a>
    </section>

    <section class="section-shell grid gap-6 lg:grid-cols-[minmax(0,1fr)_300px] lg:items-start">
        <article class="glass-panel overflow-hidden">
            <div class="relative aspect-[16/9]">
                <img src="{{ $newsArticle->cover_image_url }}" alt="{{ $newsArticle->title }}"
                     class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                    <div class="mb-3 flex flex-wrap items-center gap-2">
                        <span class="badge-pill">{{ $newsArticle->category }}</span>
                        @if($publishedLabel)
                            <span class="rounded-full border border-white/15 bg-white/10 px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-wide text-white/80 backdrop-blur-sm">
                                {{ $publishedLabel }}
                            </span>
                        @endif
                    </div>
                    <h1 class="max-w-4xl font-display text-3xl leading-tight text-white sm:text-4xl lg:text-5xl">
                        {{ $newsArticle->title }}
                    </h1>
                </div>
            </div>

            <div class="border-t p-6 sm:p-8" style="border-color:var(--border)">
                <p class="max-w-3xl text-base leading-8" style="color:var(--ink-2)">
                    {{ $newsArticle->excerpt }}
                </p>

                <div class="prose prose-sm mt-6 max-w-none prose-headings:font-display prose-a:text-indigo-600"
                     style="color:var(--ink-2)">
                    {!! $newsArticle->content !!}
                </div>
            </div>
        </article>

        <aside class="glass-panel h-fit p-5 lg:sticky lg:top-24">
            <p class="section-eyebrow mb-4">Artikel Terkait</p>
            <div class="space-y-3">
                @forelse ($relatedArticles as $article)
                    <a href="{{ route('news.show', $article) }}" wire:navigate
                       class="group flex gap-3 rounded-xl border bg-white p-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md"
                       style="border-color:var(--border)">
                        <div class="h-16 w-20 flex-shrink-0 overflow-hidden rounded-lg">
                            <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="min-w-0">
                            <span class="badge-pill mb-1 inline-flex">{{ $article->category }}</span>
                            <p class="text-sm font-semibold leading-snug line-clamp-2" style="color:var(--ink)">{{ $article->title }}</p>
                            @if($article->published_at)
                                <p class="mt-1 text-xs" style="color:var(--ink-muted)">
                                    {{ $article->published_at->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="text-sm" style="color:var(--ink-muted)">Tidak ada artikel terkait.</p>
                @endforelse
            </div>
        </aside>
    </section>
</div>
