@section('title', 'Website Alumni FTI')

<div>

    {{-- ── HERO ── --}}
    <section class="section-shell pb-14 pt-12 lg:pb-20 lg:pt-16"
        x-data="{ active: 0, total: {{ max(count($heroSlides), 1) }} }"
        x-init="setInterval(() => active = (active + 1) % total, 5500)">

        @foreach ($heroSlides as $index => $slide)
            <div x-show="active === {{ $index }}"
                x-transition:enter="transition duration-500"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">

                {{-- Copy --}}
                <div class="space-y-6">
                    <span class="badge-pill">Fakultas Teknologi Informasi</span>
                    <h1 class="text-4xl leading-tight sm:text-5xl lg:text-[3.25rem]">
                        {{ $slide['title'] ?? 'Bersama Membangun Teknologi dan Karier' }}
                    </h1>
                    <p class="section-copy text-base">
                        {{ $slide['subtitle'] ?? 'Platform menghubungkan alumni FTI dalam satu ekosistem modern dan kolaboratif.' }}
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ $slide['cta_url'] ?: route('alumni.index') }}"
                            class="purple-btn">{{ $slide['cta_label'] ?: 'Jelajahi Alumni' }}</a>
                        <a href="{{ route('news.index') }}" wire:navigate class="outline-btn">Berita & Agenda</a>
                    </div>
                </div>

                {{-- Image --}}
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-gray-50 shadow-lg">
                    <img src="{{ $slide['image'] ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1400&q=80' }}"
                        alt="Hero" class="aspect-[4/3] w-full object-cover lg:aspect-[16/10]">
                </div>
            </div>
        @endforeach

        {{-- Dots --}}
        @if(count($heroSlides) > 1)
            <div class="mt-8 flex items-center gap-2">
                @foreach ($heroSlides as $index => $slide)
                    <button type="button"
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="active === {{ $index }} ? 'w-6 bg-[color:var(--brand)]' : 'w-1.5 bg-gray-300'"
                        @click="active = {{ $index }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ── STATS ── --}}
    <section class="section-shell pb-14">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="glass-panel p-5">
                    <p class="section-eyebrow">{{ $stat['label'] }}</p>
                    <p class="mt-2 font-display text-3xl text-gray-900">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ── FEATURED ALUMNI ── --}}
    <section class="section-shell py-14 lg:py-16">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Alumni Unggulan</p>
                <h2 class="section-title">Alumni aktif di industri dan komunitas.</h2>
            </div>
            <a href="{{ route('alumni.index') }}" wire:navigate class="section-link">Lihat semua</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredAlumni as $alumnus)
                <a href="{{ route('alumni.show', $alumnus) }}" wire:navigate
                    class="glass-panel interactive-card group block overflow-hidden p-4">
                    @if ($alumnus->photo_url)
                        <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->name }}"
                            class="h-52 w-full rounded-xl object-cover">
                    @else
                        <div class="avatar-fallback h-52 w-full rounded-xl">
                            {{ $alumnus->initials }}
                        </div>
                    @endif
                    <div class="mt-4 space-y-1">
                        <p class="font-display text-xl text-gray-900">{{ $alumnus->name }}</p>
                        <p class="text-sm font-medium" style="color: var(--brand-deep)">
                            {{ $alumnus->job_title }}
                            @if($alumnus->employer) · {{ $alumnus->employer }} @endif
                        </p>
                        @if($alumnus->testimonial_quote)
                            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-gray-500">
                                "{{ $alumnus->testimonial_quote }}"
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ── NEWS + EVENTS ── --}}
    <section class="section-shell py-14 lg:py-16">
        <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">

            {{-- News --}}
            <div class="glass-panel p-6">
                <div class="mb-6 flex items-end justify-between">
                    <div>
                        <p class="section-eyebrow">Berita Terbaru</p>
                        <h2 class="section-title">Informasi alumni dan kegiatan.</h2>
                    </div>
                    <a href="{{ route('news.index') }}" wire:navigate class="section-link">Semua berita</a>
                </div>
                <div class="space-y-4">
                    @foreach ($latestNews as $article)
                        <a href="{{ route('news.show', $article) }}" wire:navigate
                            class="card-subtle interactive-card flex gap-4">
                            <img src="{{ $article->cover_image_url }}"
                                alt="{{ $article->title }}"
                                class="h-20 w-24 flex-shrink-0 rounded-lg object-cover">
                            <div class="min-w-0 space-y-1">
                                <p class="section-eyebrow">{{ $article->category }}</p>
                                <p class="font-display text-lg leading-snug text-gray-900 line-clamp-2">{{ $article->title }}</p>
                                <p class="line-clamp-2 text-sm text-gray-500">{{ $article->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Events + Testimonials --}}
            <div class="flex flex-col gap-5">
                <div class="glass-panel p-6">
                    <p class="section-eyebrow mb-4">Agenda Mendatang</p>
                    <div class="space-y-3">
                        @foreach ($upcomingEvents as $event)
                            <article class="card-subtle">
                                <p class="text-xs font-medium" style="color: var(--brand)">
                                    {{ $event->starts_at->translatedFormat('d M Y') }} · {{ $event->category }}
                                </p>
                                <p class="mt-1 font-display text-lg text-gray-900">{{ $event->title }}</p>
                                <p class="mt-1 line-clamp-2 text-sm text-gray-500">{{ $event->summary }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <p class="section-eyebrow mb-4">Testimoni Alumni</p>
                    <div class="space-y-3">
                        @foreach ($testimonials as $testimonial)
                            <article class="card-subtle">
                                <p class="text-sm italic leading-relaxed text-gray-600">"{{ $testimonial->quote }}"</p>
                                <p class="mt-2.5 text-sm font-semibold text-gray-800">{{ $testimonial->name }}</p>
                                <p class="text-xs text-gray-500">{{ $testimonial->role }} · {{ $testimonial->company }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CONTACT + FAQ ── --}}
    <section class="section-shell py-14 lg:py-16">
        <div class="grid gap-6 lg:grid-cols-2">

            <div class="glass-panel p-6">
                <div class="mb-5 flex items-end justify-between">
                    <div>
                        <p class="section-eyebrow">Kontak & Bantuan</p>
                        <h2 class="section-title">Kami siap membantu.</h2>
                    </div>
                    <a href="{{ route('contact.index') }}" wire:navigate class="section-link">Halaman kontak</a>
                </div>
                <div class="space-y-2">
                    @foreach ($contactChannels as $channel)
                        <div class="card-subtle flex items-center justify-between gap-4">
                            <span class="text-sm text-gray-500">{{ $channel['label'] }}</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $channel['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="glass-panel p-6">
                <div class="mb-5">
                    <p class="section-eyebrow">FAQ Ringkas</p>
                    <h2 class="section-title">Pertanyaan umum alumni.</h2>
                </div>
                <div class="space-y-3">
                    @forelse ($homeFaqs as $faq)
                        <article class="card-subtle">
                            <p class="text-sm font-semibold text-gray-800">{{ $faq->question }}</p>
                            <p class="mt-1.5 text-sm leading-relaxed text-gray-500">{{ $faq->answer }}</p>
                        </article>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada FAQ.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

</div>
