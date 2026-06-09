@section('title', 'Website Alumni FTI')

<div>

    {{-- ── HERO ── --}}
    <section class="section-shell pt-10 pb-6"
        x-data="{ active: 0, total: {{ max(count($heroSlides), 1) }} }"
        x-init="setInterval(() => active = (active + 1) % total, 5500)">

        @foreach ($heroSlides as $index => $slide)
            <div x-show="active === {{ $index }}"
                x-transition:enter="transition duration-700 ease-out"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="grid items-center gap-10 lg:grid-cols-[1.03fr_0.97fr] lg:gap-16">

                {{-- Copy --}}
                <div class="space-y-7 lg:pr-2">
                    <div class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold uppercase tracking-wider"
                         style="background:var(--brand-soft);border-color:rgba(var(--brand-rgb),.2);color:var(--brand-deep)">
                        <span class="h-1.5 w-1.5 rounded-full animate-pulse" style="background:var(--brand)"></span>
                        Fakultas Teknologi Informasi
                    </div>
                    <h1 class="max-w-2xl font-display text-4xl leading-[1.08] sm:text-5xl lg:text-[3.5rem]">
                        {{ $slide['title'] ?? 'Bersama Membangun Teknologi dan Karier' }}
                    </h1>
                    <p class="max-w-[52ch] text-base leading-relaxed" style="color:var(--ink-muted)">
                        {{ $slide['subtitle'] ?? 'Platform menghubungkan alumni FTI dalam satu ekosistem modern dan kolaboratif.' }}
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ $slide['cta_url'] ?: route('alumni.index') }}"
                            class="purple-btn group gap-2 px-6 py-3">
                            {{ $slide['cta_label'] ?: 'Jelajahi Alumni' }}
                            <svg class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('news.index') }}" wire:navigate class="outline-btn px-6 py-3">Berita & Agenda</a>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <div class="flex -space-x-2">
                            @foreach($featuredAlumni->take(4) as $a)
                                @if($a->photo_url)
                                    <img src="{{ $a->photo_url }}" class="h-8 w-8 rounded-full border-2 border-white object-cover" alt="">
                                @endif
                            @endforeach
                        </div>
                        <p class="text-sm" style="color:var(--ink-muted)">
                            Bergabung bersama <strong style="color:var(--ink)">{{ $stats[0]['value'] }}+</strong> alumni terdaftar
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="badge-pill">Mentoring</span>
                        <span class="badge-pill">Lowongan aktif</span>
                        <span class="badge-pill">Kolaborasi industri</span>
                    </div>
                </div>

                {{-- Image --}}
                <div class="relative">
                    <div class="relative overflow-hidden rounded-[28px] border shadow-2xl" style="border-color:var(--border)">
                        <img src="{{ $slide['image'] ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1400&q=80' }}"
                            alt="Hero" class="aspect-[4/3] w-full object-cover lg:aspect-[16/10]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                        
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Slide dots --}}
        @if(count($heroSlides) > 1)
            <div class="mt-8 flex items-center gap-2">
                @foreach ($heroSlides as $index => $slide)
                    <button type="button"
                        class="h-1.5 rounded-full transition-all duration-300 focus:outline-none"
                        :class="active === {{ $index }} ? 'w-8 opacity-100' : 'w-1.5 opacity-30'"
                        :style="active === {{ $index }} ? 'background:var(--brand)' : 'background:var(--ink-muted)'"
                        @click="active = {{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ── STATS ── --}}
    <section class="section-shell py-6">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $statsConfig = [
                    0 => ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>','bg'=>'rgba(79,70,229,0.09)','ring'=>'rgba(79,70,229,0.15)','text'=>'#4f46e5','dot'=>'#4f46e5','note'=>'Data alumni terkini'],
                    1 => ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>','bg'=>'rgba(124,58,237,0.09)','ring'=>'rgba(124,58,237,0.15)','text'=>'#7c3aed','dot'=>'#7c3aed','note'=>'Lowongan terbaru'],
                    2 => ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>','bg'=>'rgba(5,150,105,0.09)','ring'=>'rgba(5,150,105,0.15)','text'=>'#059669','dot'=>'#059669','note'=>'Agenda aktif'],
                    3 => ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>','bg'=>'rgba(217,119,6,0.09)','ring'=>'rgba(217,119,6,0.15)','text'=>'#d97706','dot'=>'#d97706','note'=>'Sebaran lokasi kerja'],
                ];
            @endphp

            @foreach ($stats as $i => $stat)
                @php $cfg = $statsConfig[$i] ?? $statsConfig[0]; @endphp
                <div class="relative overflow-hidden rounded-2xl border bg-white p-5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                     style="border-color:{{ $cfg['ring'] }}">
                    <div class="absolute inset-y-0 left-0 w-[3px] rounded-l-2xl" style="background:{{ $cfg['dot'] }}"></div>
                    <div class="flex items-start justify-between pl-1">
                        <p class="text-[0.65rem] font-semibold uppercase tracking-widest text-gray-400">{{ $stat['label'] }}</p>
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl" style="background:{{ $cfg['bg'] }}">
                            <svg class="h-5 w-5" fill="none" stroke="{{ $cfg['text'] }}" viewBox="0 0 24 24">{!! $cfg['icon'] !!}</svg>
                        </div>
                    </div>
                    <p class="mt-3 pl-1 font-display text-4xl leading-none" style="color:{{ $cfg['dot'] }}">{{ $stat['value'] }}</p>
                    <p class="mt-2 pl-1 text-xs leading-5" style="color:var(--ink-muted)">{{ $cfg['note'] }}</p>
                    <div class="mt-3 ml-1 h-0.5 w-10 rounded-full" style="background:{{ $cfg['dot'] }};opacity:.28"></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ── FEATURED ALUMNI ── --}}
    <section class="section-shell py-10">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="section-eyebrow">Alumni Unggulan</p>
                <h2 class="section-title">Alumni aktif di industri dan komunitas.</h2>
            </div>
            <a href="{{ route('alumni.index') }}" wire:navigate class="section-link">Lihat semua</a>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredAlumni as $alumnus)
                <a href="{{ route('alumni.show', $alumnus) }}" wire:navigate
                    class="group relative overflow-hidden rounded-2xl border bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                    style="border-color:var(--border)">

                    {{-- Photo --}}
                    <div class="relative overflow-hidden">
                        @if ($alumnus->photo_url)
                            <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->name }}"
                                class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="avatar-fallback h-56 w-full">{{ $alumnus->initials }}</div>
                        @endif
                        {{-- Gradient overlay on hover --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                        {{-- Hover label --}}
                        <div class="absolute bottom-3 left-0 right-0 flex justify-center opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 translate-y-2">
                            <span class="rounded-full bg-white/90 px-4 py-1 text-xs font-semibold backdrop-blur-sm" style="color:var(--brand-deep)">Lihat Profil →</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <p class="font-display text-lg text-gray-900 leading-snug">{{ $alumnus->name }}</p>
                        @if($alumnus->job_title || $alumnus->employer)
                            <p class="mt-1 text-sm font-medium leading-snug" style="color:var(--brand-deep)">
                                {{ $alumnus->job_title }}@if($alumnus->job_title && $alumnus->employer) · @endif{{ $alumnus->employer }}
                            </p>
                        @endif
                        @if($alumnus->testimonial_quote)
                            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-gray-400 italic">"{{ $alumnus->testimonial_quote }}"</p>
                        @endif
                    </div>

                    {{-- Bottom accent line on hover --}}
                    <div class="absolute inset-x-0 bottom-0 h-0.5 scale-x-0 transition-transform duration-300 group-hover:scale-x-100"
                         style="background:linear-gradient(90deg,var(--brand),var(--brand-2))"></div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ── NEWS + EVENTS ── --}}
    <section class="section-shell py-10">
        <div class="grid gap-6 lg:grid-cols-[1.08fr_0.92fr] lg:items-start">

            {{-- News --}}
            <div class="glass-panel p-5 sm:p-6 lg:self-start">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <p class="section-eyebrow">Berita Terbaru</p>
                        <h2 class="mt-2 font-display text-3xl leading-tight" style="color:var(--ink)">Informasi alumni dan kegiatan.</h2>
                    </div>
                    <a href="{{ route('news.index') }}" wire:navigate
                        class="career-detail-btn mt-1 inline-flex flex-shrink-0 items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold">
                        Semua
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                <div class="space-y-3">
                    @foreach ($latestNews as $i => $article)
                        <a href="{{ route('news.show', $article) }}" wire:navigate
                            class="group flex gap-3 rounded-xl border bg-white p-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md"
                            style="border-color:var(--border)">
                            <div class="relative flex-shrink-0 overflow-hidden rounded-lg bg-slate-100">
                                <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                                    class="h-20 w-24 object-cover transition-transform duration-300 group-hover:scale-105 sm:h-24 sm:w-32">
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[0.6rem] font-bold uppercase tracking-wider"
                                      style="background:var(--brand-soft);color:var(--brand-deep)">{{ $article->category }}</span>
                                <p class="mt-2 text-sm font-semibold leading-snug text-gray-900 line-clamp-2">{{ $article->title }}</p>
                                <p class="mt-1 line-clamp-2 text-xs leading-5 text-gray-500">{{ $article->excerpt }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Events + Testimonials --}}
            <div class="flex flex-col gap-5">

                {{-- Events --}}
                <div class="glass-panel p-5">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <p class="section-eyebrow">Agenda Mendatang</p>
                        <span class="rounded-full px-2.5 py-1 text-[0.65rem] font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                            {{ $upcomingEvents->count() }} agenda
                        </span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($upcomingEvents as $event)
                            <article class="group flex gap-3 rounded-xl border bg-white p-3 transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color:var(--border)">
                                {{-- Date badge --}}
                                <div class="flex w-11 flex-shrink-0 flex-col items-center justify-start rounded-xl py-2 text-center"
                                     style="background:var(--brand-soft)">
                                    <span class="text-[0.6rem] font-bold uppercase leading-none" style="color:var(--brand)">
                                        {{ $event->starts_at->format('M') }}
                                    </span>
                                    <span class="mt-0.5 text-lg font-bold leading-none" style="color:var(--brand-deep)">
                                        {{ $event->starts_at->format('d') }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-medium text-gray-400">{{ $event->category }}</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-800 leading-snug line-clamp-2">{{ $event->title }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                {{-- Testimonials --}}
                <div class="glass-panel p-5">
                    <p class="section-eyebrow mb-4">Testimoni Alumni</p>
                    <div class="space-y-3">
                        @foreach ($testimonials as $testimonial)
                            <article class="rounded-xl border bg-white p-4" style="border-color:var(--border)">
                                <div class="flex gap-3">
                                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0 opacity-20" fill="currentColor" style="color:var(--brand)" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                    <p class="text-sm leading-6 text-gray-600 italic line-clamp-2">{{ $testimonial->quote }}</p>
                                </div>
                                <div class="mt-3 flex items-center gap-2.5 border-t pt-3" style="border-color:var(--border)">
                                    @if($testimonial->photo_url ?? false)
                                        <img src="{{ $testimonial->photo_url }}" class="h-7 w-7 rounded-full object-cover" alt="">
                                    @else
                                        <div class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold"
                                             style="background:var(--brand-soft);color:var(--brand-deep)">
                                            {{ mb_strtoupper(mb_substr($testimonial->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-xs font-semibold text-gray-800">{{ $testimonial->name }}</p>
                                        <p class="text-[0.65rem] text-gray-400">{{ $testimonial->role }}@if($testimonial->company) · {{ $testimonial->company }}@endif</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CONTACT + FAQ ── --}}
    <section class="section-shell py-10">
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Kontak --}}
            <div class="relative overflow-hidden rounded-2xl border bg-white p-6" style="border-color:var(--border)">
                {{-- Decorative bg spot --}}
                <div class="absolute right-0 top-0 h-40 w-40 -translate-y-1/2 translate-x-1/2 rounded-full opacity-[0.06]"
                     style="background:var(--brand)"></div>
                <div class="relative">
                    <div class="mb-5 flex items-end justify-between">
                        <div>
                            <p class="section-eyebrow">Kontak & Bantuan</p>
                            <h2 class="section-title">Kami siap membantu.</h2>
                        </div>
                        <a href="{{ route('contact.index') }}" wire:navigate class="section-link">Halaman kontak</a>
                    </div>
                    <div class="space-y-2.5">
                        @foreach ($contactChannels as $channel)
                            <div class="flex items-center justify-between gap-4 rounded-xl p-3 transition hover:bg-gray-50">
                                <span class="text-sm text-gray-400">{{ $channel['label'] }}</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $channel['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- FAQ --}}
            <div class="rounded-2xl border bg-white p-6" style="border-color:var(--border)"
                 x-data="{ open: null }">
                <div class="mb-5">
                    <p class="section-eyebrow">FAQ Ringkas</p>
                    <h2 class="section-title">Pertanyaan umum alumni.</h2>
                </div>
                <div class="space-y-2">
                    @forelse ($homeFaqs as $fi => $faq)
                        <div class="rounded-xl border overflow-hidden transition"
                             style="border-color:var(--border)">
                            <button type="button"
                                @click="open = open === {{ $fi }} ? null : {{ $fi }}"
                                class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left transition hover:bg-gray-50">
                                <span class="text-sm font-semibold text-gray-800">{{ $faq->question }}</span>
                                <svg class="h-4 w-4 flex-shrink-0 text-gray-400 transition-transform duration-200"
                                     :class="open === {{ $fi }} ? 'rotate-45' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <div x-show="open === {{ $fi }}"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="border-t px-4 py-3 text-sm leading-relaxed text-gray-500"
                                 style="border-color:var(--border);background:var(--bg-base)">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada FAQ.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

</div>
