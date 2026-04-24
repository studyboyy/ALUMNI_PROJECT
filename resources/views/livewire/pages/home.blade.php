@section('title', 'Website Alumni FTI')

<div>
    <section class="mx-auto max-w-7xl px-4 pb-16 pt-8 sm:px-6 lg:px-8 lg:pb-20 lg:pt-12" x-data="{ active: 0, total: {{ max(count($heroSlides), 1) }} }"
        x-init="setInterval(() => active = (active + 1) % total, 5500)">
        <div class="relative overflow-hidden rounded-4xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60">
            @foreach ($heroSlides as $index => $slide)
                <article x-show="active === {{ $index }}" x-transition:enter="transition duration-500"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="grid gap-8 p-6 md:grid-cols-[1fr_1.1fr] md:p-10">
                    <div class="space-y-6">
                        <span class="badge-pill">Website Alumni Fakultas Teknologi Informasi</span>
                        <div class="space-y-4">
                            <h1 class="font-display text-4xl leading-tight text-slate-900 sm:text-5xl">
                                {{ $slide['title'] ?? 'Bersama Membangun Teknologi dan Karier' }}</h1>
                            <p class="max-w-2xl text-base leading-8 text-slate-600">
                                {{ $slide['subtitle'] ?? 'Platform ini menghubungkan alumni FTI dalam satu ekosistem modern dan kolaboratif.' }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ $slide['cta_url'] ?: route('alumni.index') }}"
                                class="purple-btn">{{ $slide['cta_label'] ?: 'Jelajahi Sekarang' }}</a>
                            <a href="{{ route('news.index') }}" wire:navigate
                                class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Berita
                                & Agenda</a>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-3xl border border-slate-200">
                        <img src="{{ $slide['image'] ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80' }}"
                            alt="Hero slide {{ $index + 1 }}" class="h-72 w-full object-cover md:h-full">
                    </div>
                </article>
            @endforeach

            <div
                class="absolute bottom-4 left-1/2 flex -translate-x-1/2 items-center gap-2 rounded-full border border-slate-200 bg-white/85 px-3 py-2 backdrop-blur">
                @foreach ($heroSlides as $index => $slide)
                    <button type="button" class="h-2.5 w-2.5 rounded-full transition"
                        :class="active === {{ $index }} ? 'bg-violet-600' : 'bg-slate-300'"
                        @click="active = {{ $index }}"></button>
                @endforeach
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="glass-panel p-5">
                    <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    <p class="mt-3 font-display text-4xl text-slate-900">{{ $stat['value'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Alumni Unggulan</p>
                <h2 class="section-title">Profil singkat alumni yang aktif di industri dan komunitas.</h2>
            </div>
            <a href="{{ route('alumni.index') }}" wire:navigate class="section-link">Jelajahi semua alumni</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-4">
            @foreach ($featuredAlumni as $alumnus)
                <a href="{{ route('alumni.show', $alumnus) }}" wire:navigate
                    class="glass-panel block overflow-hidden p-4 transition hover:-translate-y-1 hover:border-violet-200">
                    <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->name }}"
                        class="h-56 w-full rounded-3xl object-cover">
                    <div class="mt-4 space-y-2">
                        <p class="font-display text-2xl text-slate-900">{{ $alumnus->name }}</p>
                        <p class="text-sm text-violet-700">{{ $alumnus->job_title }} · {{ $alumnus->employer }}</p>
                        <p class="text-sm leading-7 text-slate-500">{{ $alumnus->testimonial_quote }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section-shell grid gap-8 lg:grid-cols-[1fr_0.9fr]">
        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">Berita Terbaru</p>
                    <h2 class="section-title">Informasi terkini tentang alumni, prestasi, dan kegiatan.</h2>
                </div>
            </div>
            <div class="space-y-4">
                @foreach ($latestNews as $article)
                    <a href="{{ route('news.show', $article) }}" wire:navigate
                        class="flex flex-col gap-4 rounded-3xl border border-slate-200 p-4 transition hover:border-violet-200 sm:flex-row">
                        <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                            class="h-36 w-full rounded-[1.25rem] object-cover sm:w-40">
                        <div class="space-y-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-violet-600">{{ $article->category }}</p>
                            <p class="font-display text-2xl text-slate-900">{{ $article->title }}</p>
                            <p class="text-sm leading-7 text-slate-500">{{ $article->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass-panel p-6">
                <p class="section-eyebrow">Agenda Mendatang</p>
                <div class="mt-5 space-y-4">
                    @foreach ($upcomingEvents as $event)
                        <article class="rounded-3xl border border-slate-200 p-4">
                            <p class="text-sm text-violet-600">{{ $event->starts_at->translatedFormat('d M Y') }} ·
                                {{ $event->category }}</p>
                            <p class="mt-2 font-display text-2xl text-slate-900">{{ $event->title }}</p>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $event->summary }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="glass-panel p-6">
                <p class="section-eyebrow">Testimoni Alumni</p>
                <div class="mt-5 space-y-4">
                    @foreach ($testimonials as $testimonial)
                        <article class="rounded-3xl border border-slate-200 p-4">
                            <p class="text-sm leading-7 text-slate-600">"{{ $testimonial->quote }}"</p>
                            <p class="mt-3 font-semibold text-slate-900">{{ $testimonial->name }}</p>
                            <p class="text-sm text-slate-500">{{ $testimonial->role }} · {{ $testimonial->company }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">Kontak & Bantuan</p>
                    <h2 class="section-title">Akses bantuan alumni sekarang langsung tersedia di beranda.</h2>
                </div>
                <a href="{{ route('contact.index') }}" wire:navigate class="section-link">Halaman kontak lengkap</a>
            </div>

            <div class="space-y-3">
                @foreach ($contactChannels as $channel)
                    <div class="card-subtle flex items-center justify-between gap-4 text-sm text-slate-600">
                        <span>{{ $channel['label'] }}</span>
                        <span class="text-right font-semibold text-slate-900">{{ $channel['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">FAQ Ringkas</p>
                    <h2 class="section-title">Jawaban cepat untuk kebutuhan alumni yang paling sering muncul.</h2>
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($homeFaqs as $faq)
                    <article class="rounded-3xl border border-slate-200 p-4">
                        <p class="font-semibold text-slate-900">{{ $faq->question }}</p>
                        <p class="mt-2 text-sm leading-7 text-slate-500">{{ $faq->answer }}</p>
                    </article>
                @empty
                    <div class="rounded-3xl border border-slate-200 p-4 text-sm text-slate-500">
                        Belum ada FAQ yang ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
