@section('title', $job->title . ' - ' . $job->company)

<div class="space-y-8 py-10 lg:py-14">
    <section class="section-shell">
        <a href="{{ route('career.index') }}" wire:navigate
            class="inline-flex items-center gap-2 text-sm text-violet-700 hover:text-violet-800 mb-6">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Lowongan
        </a>

        <div class="glass-panel p-8 space-y-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="space-y-2">
                        <h1 class="font-display text-4xl text-slate-900">{{ $job->title }}</h1>
                        <p class="text-lg text-slate-600">{{ $job->company }}</p>
                        <div class="flex flex-wrap gap-3 mt-4">
                            <span class="badge-pill">{{ $job->employment_type }}</span>
                            <span class="badge-pill">{{ $job->location }}</span>
                            @if ($job->is_featured)
                                <span class="badge-pill bg-violet-100 text-violet-700">Featured</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                        class="purple-btn inline-flex items-center gap-2">
                        Apply Sekarang
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m-4-6l6 6m0 0l-6 6m6-6H3">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-4">Batas Aplikasi</p>
                <p class="text-2xl font-semibold text-slate-900">{{ $job->closes_at->translatedFormat('d MMMM Y') }}</p>
                <p class="text-sm text-slate-600 mt-2">
                    @if ($job->closes_at->isPast())
                        <span class="text-rose-600">Sudah ditutup</span>
                    @elseif ($job->closes_at->diffInDays() === 0)
                        <span class="text-amber-600">Ditutup hari ini</span>
                    @else
                        <span class="text-green-600">{{ $job->closes_at->diffInDays() }} hari tersisa</span>
                    @endif
                </p>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-3">Deskripsi Lengkap</p>
                <div class="prose prose-sm max-w-none text-slate-700 leading-7 whitespace-pre-wrap">
                    {{ $job->summary }}
                </div>
            </div>
        </div>
    </section>

    @if ($job->submitter)
        <section class="section-shell">
            <div class="section-heading">
                <p class="section-eyebrow">Hubungi Pembuat Lowongan</p>
                <h2 class="section-title">Tanya langsung kepada pihak yang membuka lowongan ini.</h2>
            </div>

            <div class="glass-panel p-8">
                <div class="flex gap-6">
                    @if ($job->submitter?->alumniProfile?->photo_url)
                        <img src="{{ $job->submitter->alumniProfile->photo_url }}" alt="{{ $job->submitter->name }}"
                            class="h-32 w-32 rounded-[1.5rem] object-cover flex-shrink-0">
                    @else
                        <div
                            class="h-32 w-32 rounded-[1.5rem] bg-linear-to-br from-violet-400 to-fuchsia-400 flex items-center justify-center text-white font-bold text-3xl flex-shrink-0">
                            {{ substr($job->submitter->name, 0, 1) }}
                        </div>
                    @endif

                    <div class="flex-1">
                        <p class="font-display text-3xl text-slate-900">{{ $job->submitter->name }}</p>
                        @if ($job->submitter?->alumniProfile?->job_title)
                            <p class="text-lg text-violet-700 mt-2">{{ $job->submitter->alumniProfile->job_title }}</p>
                        @endif
                        @if ($job->submitter?->alumniProfile?->employer)
                            <p class="text-sm text-slate-600 mt-1">{{ $job->submitter->alumniProfile->employer }}</p>
                        @endif

                        <div class="mt-6 space-y-3">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <a href="mailto:{{ $job->submitter->email }}"
                                    class="text-slate-700 hover:text-violet-700 font-medium">{{ $job->submitter->email }}</a>
                            </div>
                            @if ($job->submitter?->alumniProfile?->phone)
                                <div class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948.684l1.498 7.492a1 1 0 00.502.756l2.048 1.029a1 1 0 001.092-.219l1.414-1.414a2 2 0 012.828 0l2.122 2.122a2 2 0 010 2.828l-2.5 2.5a2 2 0 01-2.828 0l-4.616-4.616a2 2 0 00-2.828 0l-2.5 2.5a2 2 0 010 2.828">
                                        </path>
                                    </svg>
                                    <a href="tel:{{ $job->submitter->alumniProfile->phone }}"
                                        class="text-slate-700 hover:text-violet-700 font-medium">{{ $job->submitter->alumniProfile->phone }}</a>
                                </div>
                            @endif
                        </div>

                        <p class="text-sm text-slate-500 mt-6 italic">Hubungi pembuat lowongan untuk informasi lebih
                            lengkap atau pertanyaan tambahan.</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section-shell">
        <div class="text-center py-8">
            <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                class="purple-btn inline-flex items-center gap-2">
                Apply Ke Lowongan
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m-4-6l6 6m0 0l-6 6m6-6H3"></path>
                </svg>
            </a>
        </div>
    </section>
</div>
