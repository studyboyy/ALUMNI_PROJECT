@section('title', $job->title . ' — ' . $job->company)

<div class="py-10 lg:py-12">
    <section class="section-shell grid gap-6 lg:grid-cols-[1fr_300px]">

        {{-- Main --}}
        <div class="space-y-5">
            <a href="{{ route('career.index') }}" wire:navigate
                class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Karier & Kolaborasi
            </a>

            <div class="glass-panel p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="flex-1 space-y-2">
                        <h1 class="font-display text-3xl text-gray-900">{{ $job->title }}</h1>
                        <p class="text-base text-gray-600">{{ $job->company }}</p>
                        <div class="flex flex-wrap gap-2 pt-1">
                            <span class="badge-pill">{{ $job->employment_type }}</span>
                            <span class="badge-pill">{{ $job->location }}</span>
                            @if ($job->is_featured)
                                <span class="badge-pill">Featured</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                        class="purple-btn flex-shrink-0">Apply Sekarang ↗</a>
                </div>

                <div class="mt-5 border-t border-gray-100 pt-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">Batas Aplikasi</p>
                    <p class="mt-1.5 text-xl font-semibold text-gray-900">
                        {{ $job->closes_at->translatedFormat('d MMMM Y') }}
                    </p>
                    <p class="mt-0.5 text-sm">
                        @if ($job->closes_at->isPast())
                            <span class="text-red-500">Sudah ditutup</span>
                        @elseif ($job->closes_at->diffInDays() === 0)
                            <span class="text-amber-500">Ditutup hari ini</span>
                        @else
                            <span class="text-emerald-600">{{ $job->closes_at->diffInDays() }} hari tersisa</span>
                        @endif
                    </p>
                </div>

                <div class="mt-5 border-t border-gray-100 pt-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-3">Deskripsi</p>
                    <div class="whitespace-pre-wrap text-sm leading-relaxed text-gray-600">{{ $job->summary }}</div>
                </div>
            </div>
        </div>

        {{-- Sidebar: submitter --}}
        @if ($job->submitter)
            <div class="glass-panel h-fit p-5">
                <p class="section-eyebrow mb-4">Diajukan oleh</p>
                <div class="flex items-center gap-3">
                    @if ($job->submitter?->alumniProfile?->photo_url)
                        <img src="{{ $job->submitter->alumniProfile->photo_url }}"
                            alt="{{ $job->submitter->name }}"
                            class="h-12 w-12 flex-shrink-0 rounded-xl object-cover">
                    @else
                        @php $si = $job->submitter?->alumniProfile?->initials ?? ($job->submitter?->initials() ?? 'AL'); @endphp
                        <div class="avatar-fallback h-12 w-12 flex-shrink-0 rounded-xl text-sm">{{ $si }}</div>
                    @endif
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900">{{ $job->submitter->name }}</p>
                        @if ($job->submitter?->alumniProfile?->job_title)
                            <p class="text-xs text-gray-500">{{ $job->submitter->alumniProfile->job_title }}</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4 space-y-2.5">
                    <a href="mailto:{{ $job->submitter->email }}"
                        class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                        <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ $job->submitter->email }}</span>
                    </a>
                    @if ($job->submitter?->alumniProfile?->phone)
                        <a href="tel:{{ $job->submitter->alumniProfile->phone }}"
                            class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                            <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $job->submitter->alumniProfile->phone }}
                        </a>
                    @endif
                </div>

                <div class="mt-5 border-t border-gray-100 pt-4">
                    <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                        class="purple-btn w-full justify-center">Apply Sekarang ↗</a>
                </div>
            </div>
        @else
            <div class="glass-panel h-fit p-5 text-center">
                <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                    class="purple-btn w-full justify-center">Apply Sekarang ↗</a>
            </div>
        @endif

    </section>
</div>
