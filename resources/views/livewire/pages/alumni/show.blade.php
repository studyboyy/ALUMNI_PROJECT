@section('title', $alumniProfile->name)

<div class="py-12 lg:py-16">

    {{-- Profile Section --}}
    <section class="section-shell">
        <div class="mb-5">
            <a href="{{ route('alumni.index') }}" wire:navigate
                class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Direktori Alumni
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_1fr]">

            {{-- Photo --}}
            <div class="space-y-4">
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-gray-50">
                    @if ($alumniProfile->photo_url)
                        <img src="{{ $alumniProfile->photo_url }}" alt="{{ $alumniProfile->name }}"
                            class="aspect-square w-full object-cover">
                    @else
                        <div class="avatar-fallback aspect-square w-full">{{ $alumniProfile->initials }}</div>
                    @endif
                </div>
                @if($alumniProfile->linkedin_url)
                    <a href="{{ $alumniProfile->linkedin_url }}" target="_blank" rel="noreferrer noopener"
                        class="outline-btn w-full justify-center">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>
                @endif
            </div>

            {{-- Info --}}
            <div class="space-y-6">
                <div>
                    <h1 class="font-display text-4xl text-gray-900">{{ $alumniProfile->name }}</h1>
                    @if($alumniProfile->job_title || $alumniProfile->employer)
                        <p class="mt-2 text-lg font-medium" style="color:var(--brand-deep)">
                            {{ $alumniProfile->job_title }}
                            @if($alumniProfile->job_title && $alumniProfile->employer) · @endif
                            {{ $alumniProfile->employer }}
                        </p>
                    @endif
                    <div class="mt-2 flex flex-wrap gap-3 text-sm text-gray-500">
                        <span>{{ $alumniProfile->program }}</span>
                        <span>·</span>
                        <span>Angkatan {{ $alumniProfile->batch_year }}</span>
                        @if($alumniProfile->city)
                            <span>·</span>
                            <span>{{ $alumniProfile->city }}@if($alumniProfile->province), {{ $alumniProfile->province }}@endif</span>
                        @endif
                    </div>
                </div>

                {{-- Bio --}}
                @if($alumniProfile->bio)
                    <div class="glass-panel p-5">
                        <p class="section-eyebrow mb-3">Tentang</p>
                        <p class="text-sm leading-relaxed text-gray-600">{{ $alumniProfile->bio }}</p>
                    </div>
                @endif

                {{-- Detail grid --}}
                <div class="glass-panel p-5">
                    <p class="section-eyebrow mb-4">Informasi</p>
                    <dl class="grid gap-3 sm:grid-cols-2">
                        @if($alumniProfile->email)
                            <div class="card-subtle">
                                <dt class="text-xs font-medium text-gray-400">Email</dt>
                                <dd class="mt-0.5 text-sm text-gray-700">{{ $alumniProfile->email }}</dd>
                            </div>
                        @endif
                        <div class="card-subtle">
                            <dt class="text-xs font-medium text-gray-400">Status</dt>
                            <dd class="mt-0.5 text-sm text-gray-700">{{ $alumniProfile->employment_status }}</dd>
                        </div>
                        @if($alumniProfile->industry)
                            <div class="card-subtle">
                                <dt class="text-xs font-medium text-gray-400">Industri</dt>
                                <dd class="mt-0.5 text-sm text-gray-700">{{ $alumniProfile->industry }}</dd>
                            </div>
                        @endif
                        @if($alumniProfile->campus_name)
                            <div class="card-subtle">
                                <dt class="text-xs font-medium text-gray-400">Kampus</dt>
                                <dd class="mt-0.5 text-sm text-gray-700">{{ $alumniProfile->campus_name }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Achievements --}}
                @if(!empty($alumniProfile->achievements))
                    <div class="glass-panel p-5">
                        <p class="section-eyebrow mb-4">Pencapaian</p>
                        <ul class="space-y-2">
                            @foreach ($alumniProfile->achievements as $achievement)
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <span class="mt-1 h-1.5 w-1.5 flex-shrink-0 rounded-full" style="background:var(--brand)"></span>
                                    {{ $achievement }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Testimonial --}}
                @if($alumniProfile->testimonial_quote)
                    <blockquote class="border-l-2 pl-4 text-sm italic leading-relaxed text-gray-600" style="border-color:var(--brand)">
                        "{{ $alumniProfile->testimonial_quote }}"
                    </blockquote>
                @endif
            </div>
        </div>
    </section>

    {{-- Related Alumni --}}
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
                        class="glass-panel interactive-card block p-5">
                        <p class="font-display text-xl text-gray-900">{{ $related->name }}</p>
                        @if($related->job_title)
                            <p class="mt-1 text-sm font-medium" style="color:var(--brand-deep)">{{ $related->job_title }}</p>
                        @endif
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $related->employer }}@if($related->employer && $related->city) · @endif{{ $related->city }}
                        </p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
