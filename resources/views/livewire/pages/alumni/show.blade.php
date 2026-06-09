@section('title', $alumniProfile->name)

<div class="py-10 lg:py-12">
    <section class="section-shell">
        <div class="mb-5">
            <a href="{{ route('alumni.index') }}" wire:navigate
                class="inline-flex items-center gap-1.5 text-sm font-medium transition"
                style="color:var(--ink-muted)">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Direktori Alumni
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[300px_minmax(0,1fr)] lg:items-start">
            <div class="glass-panel overflow-hidden">
                <div class="relative aspect-[3/4] overflow-hidden bg-gradient-to-b from-slate-100 to-slate-200">
                    @if ($alumniProfile->photo_url)
                        <img src="{{ $alumniProfile->photo_url }}" alt="{{ $alumniProfile->name }}"
                             class="h-full w-full object-cover object-[center_18%]">
                    @else
                        <div class="avatar-fallback h-full w-full" style="font-size:3.25rem">{{ $alumniProfile->initials }}</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-transparent to-transparent"></div>
                    @if($alumniProfile->linkedin_url)
                        <a href="{{ $alumniProfile->linkedin_url }}" target="_blank" rel="noreferrer noopener"
                            class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-full border bg-white/95 px-3 py-1.5 text-xs font-semibold shadow-sm backdrop-blur-sm"
                            style="border-color:rgba(var(--brand-rgb),.16);color:var(--brand-deep)">
                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                    @endif
                </div>

                <div class="p-5">
                    <p class="section-eyebrow">Ringkasan</p>
                    <p class="mt-2 font-sans text-xl font-semibold leading-tight" style="color:var(--ink)">
                        {{ $alumniProfile->program }}
                    </p>
                    <p class="mt-1 text-sm" style="color:var(--ink-muted)">
                        Angkatan {{ $alumniProfile->batch_year }}
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <article class="glass-panel p-6 sm:p-7">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0">
                            <p class="section-eyebrow">Profil Alumni</p>
                            <h1 class="mt-2 font-display text-4xl leading-tight sm:text-5xl" style="color:var(--ink)">
                                {{ $alumniProfile->name }}
                            </h1>
                            @if($alumniProfile->job_title || $alumniProfile->employer)
                                <p class="mt-3 text-lg font-semibold" style="color:var(--brand-deep)">
                                    {{ $alumniProfile->job_title }}
                                    @if($alumniProfile->job_title && $alumniProfile->employer) di @endif
                                    {{ $alumniProfile->employer }}
                                </p>
                            @endif
                            <div class="mt-3 flex flex-wrap items-center gap-2 text-sm" style="color:var(--ink-muted)">
                                <span class="badge-pill">{{ $alumniProfile->program }}</span>
                                <span class="badge-pill">Angkatan {{ $alumniProfile->batch_year }}</span>
                                @if($alumniProfile->city)
                                    <span class="badge-pill">
                                        {{ $alumniProfile->city }}@if($alumniProfile->province), {{ $alumniProfile->province }}@endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>

                @if($alumniProfile->bio)
                    <article class="glass-panel p-6">
                        <p class="section-eyebrow mb-3">Tentang</p>
                        <p class="text-sm leading-7" style="color:var(--ink-2)">{{ $alumniProfile->bio }}</p>
                    </article>
                @endif

                <article class="glass-panel p-6">
                    <p class="section-eyebrow mb-4">Informasi</p>
                    <dl class="grid gap-3 sm:grid-cols-2">
                        @if($alumniProfile->email)
                            <div class="card-subtle flex gap-3">
                                <div class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg"
                                     style="background:var(--brand-soft)">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         style="color:var(--brand)">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <dt class="text-xs font-medium" style="color:var(--ink-muted)">Email</dt>
                                    <dd class="mt-0.5 break-all text-sm" style="color:var(--ink)">{{ $alumniProfile->email }}</dd>
                                </div>
                            </div>
                        @endif

                        <div class="card-subtle flex gap-3">
                            <div class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg"
                                 style="background:var(--brand-soft)">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     style="color:var(--brand)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <dt class="text-xs font-medium" style="color:var(--ink-muted)">Status</dt>
                                <dd class="mt-0.5 text-sm" style="color:var(--ink)">{{ $alumniProfile->employment_status }}</dd>
                            </div>
                        </div>

                        @if($alumniProfile->industry)
                            <div class="card-subtle flex gap-3">
                                <div class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg"
                                     style="background:var(--brand-soft)">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         style="color:var(--brand)">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <dt class="text-xs font-medium" style="color:var(--ink-muted)">Industri</dt>
                                    <dd class="mt-0.5 text-sm" style="color:var(--ink)">{{ $alumniProfile->industry }}</dd>
                                </div>
                            </div>
                        @endif

                        @if($alumniProfile->campus_name)
                            <div class="card-subtle flex gap-3">
                                <div class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg"
                                     style="background:var(--brand-soft)">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                         style="color:var(--brand)">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <dt class="text-xs font-medium" style="color:var(--ink-muted)">Kampus</dt>
                                    <dd class="mt-0.5 text-sm" style="color:var(--ink)">{{ $alumniProfile->campus_name }}</dd>
                                </div>
                            </div>
                        @endif
                    </dl>
                </article>

                @if(!empty($alumniProfile->achievements))
                    <article class="glass-panel p-6">
                        <p class="section-eyebrow mb-4">Pencapaian</p>
                        <div class="space-y-3">
                            @foreach ($alumniProfile->achievements as $achievement)
                                <div class="flex gap-3 rounded-xl border bg-white p-4" style="border-color:var(--border)">
                                    <span class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full"
                                          style="background:var(--brand-soft)">
                                        <span class="h-2 w-2 rounded-full" style="background:var(--brand)"></span>
                                    </span>
                                    <p class="text-sm leading-7" style="color:var(--ink-2)">{{ $achievement }}</p>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endif

                @if($alumniProfile->testimonial_quote)
                    <article class="relative overflow-hidden rounded-2xl p-6"
                             style="background:var(--brand-soft);border:1px solid rgba(var(--brand-rgb),.15)">
                        <svg class="absolute -right-2 -top-3 h-24 w-24 opacity-10"
                             viewBox="0 0 24 24" fill="currentColor" style="color:var(--brand)">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <p class="section-eyebrow mb-3">Testimoni</p>
                        <blockquote class="relative text-base italic leading-relaxed" style="color:var(--ink-2)">
                            "{{ $alumniProfile->testimonial_quote }}"
                        </blockquote>
                        <p class="mt-3 text-sm font-semibold" style="color:var(--brand)">- {{ $alumniProfile->name }}</p>
                    </article>
                @endif
            </div>
        </div>
    </section>

    @if($relatedAlumni->isNotEmpty())
        <section class="section-shell mt-14">
            <div class="section-heading">
                <div>
                    <p class="section-eyebrow">Alumni Terkait</p>
                    <h2 class="section-title">Dari program studi yang sama.</h2>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($relatedAlumni as $related)
                    <a href="{{ route('alumni.show', $related) }}" wire:navigate
                        class="glass-panel group flex flex-col overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative overflow-hidden bg-gradient-to-b from-slate-100 to-slate-200">
                            @if($related->photo_url)
                                <img src="{{ $related->photo_url }}" alt="{{ $related->name }}"
                                    class="h-44 w-full object-cover object-[center_18%] transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="avatar-fallback h-44 w-full">{{ $related->initials }}</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <p class="font-display text-2xl leading-tight" style="color:var(--ink)">{{ $related->name }}</p>
                            @if($related->job_title)
                                <p class="mt-2 text-sm font-medium" style="color:var(--brand-deep)">{{ $related->job_title }}</p>
                            @endif
                            <p class="mt-1 text-sm" style="color:var(--ink-muted)">
                                {{ $related->employer }}@if($related->employer && $related->city) · @endif{{ $related->city }}
                            </p>
                            <div class="mt-auto pt-4">
                                <span class="career-detail-btn inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold">
                                    Lihat Profil
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
