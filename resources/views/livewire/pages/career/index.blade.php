@section('title', 'Karier & Kolaborasi Alumni FTI')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[1fr_1fr]">
        <div class="space-y-5">
            <p class="section-eyebrow">Karier & Kolaborasi</p>
            <h1 class="section-title max-w-2xl">Lowongan, mentoring alumni, dan kolaborasi industri dalam satu hub.</h1>
            <p class="section-copy">Pada fase publik ini, halaman karier difokuskan untuk menampilkan peluang kerja
                aktif, program mentoring, dan bentuk kolaborasi yang bisa segera dipresentasikan.</p>
            @auth
                <div class="rounded-3xl border border-violet-200 bg-violet-50 px-4 py-3 text-sm text-violet-700">
                    Lowongan menunggu persetujuan admin: {{ $myPendingJobs }}.
                    <a href="{{ route('alumni.submit-job') }}" wire:navigate class="font-semibold text-violet-800">Ajukan
                        lowongan baru</a>
                </div>
            @endauth
        </div>
        <div class="glass-panel p-6">
            <p class="font-display text-3xl text-slate-900">Forum Diskusi Alumni</p>
            <p class="mt-4 text-sm leading-7 text-slate-600">Forum interaktif penuh belum dibangun pada fase pertama.
                Sebagai gantinya, halaman ini dapat diarahkan ke kanal komunitas seperti WhatsApp, Discord, atau
                Telegram alumni.</p>
            <a href="https://discord.com" target="_blank" rel="noreferrer"
                class="mt-5 inline-flex rounded-full border border-slate-300 px-5 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Masuk
                Kanal Komunitas</a>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Lowongan Pekerjaan</p>
                <h2 class="section-title">Peluang kerja dan magang yang relevan untuk alumni FTI.</h2>
            </div>
        </div>
        <div class="card-grid-tight lg:grid-cols-3">
            @foreach ($jobs as $job)
                <article class="glass-panel interactive-card overflow-hidden p-5">
                    <div class="flex items-center justify-between gap-3">
                        <span class="badge-pill">{{ $job->employment_type }}</span>
                        @if ($job->is_featured)
                            <span class="text-xs uppercase tracking-[0.22em] text-violet-700">Featured</span>
                        @endif
                    </div>
                    <p class="mt-4 font-display text-2xl text-slate-900">{{ $job->title }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ $job->company }} · {{ $job->location }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">{{ $job->summary }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span>Tutup {{ $job->closes_at->translatedFormat('d M Y') }}</span>
                        <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                            class="text-violet-700 hover:text-violet-800 transition font-semibold">Apply</a>
                    </div>

                    @if ($job->submitter)
                        <div class="mt-5 border-t border-slate-200 pt-4">
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Diajukan oleh</p>
                            <div class="mt-3 flex gap-3">
                                @if ($job->submitter?->alumniProfile?->photo_url)
                                    <img src="{{ $job->submitter->alumniProfile->photo_url }}"
                                        alt="{{ $job->submitter->name }}" class="h-12 w-12 rounded-lg object-cover">
                                @else
                                    @php
                                        $submitterInitials =
                                            $job->submitter?->alumniProfile?->initials ??
                                            ($job->submitter?->initials() ?? 'AL');
                                    @endphp
                                    <div class="avatar-fallback h-12 w-12 rounded-lg text-base">
                                        {{ $submitterInitials }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-slate-900">{{ $job->submitter->name }}</p>
                                    @if ($job->submitter?->alumniProfile?->job_title)
                                        <p class="text-xs text-slate-500">
                                            {{ $job->submitter->alumniProfile->job_title }}</p>
                                    @endif
                                    <div class="mt-2 space-y-1 text-xs text-slate-600">
                                        <a href="mailto:{{ $job->submitter->email }}"
                                            class="block hover:text-violet-700">{{ $job->submitter->email }}</a>
                                        @if ($job->submitter?->alumniProfile?->phone)
                                            <a href="tel:{{ $job->submitter->alumniProfile->phone }}"
                                                class="block hover:text-violet-700">{{ $job->submitter->alumniProfile->phone }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-shell grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="glass-panel p-6">
            <p class="section-eyebrow">Mentoring Alumni</p>
            <div class="mt-4 space-y-4">
                @foreach ($featuredMentors as $mentor)
                    <article class="card-subtle flex gap-4">
                        @if ($mentor->photo_url)
                            <img src="{{ $mentor->photo_url }}" alt="{{ $mentor->name }}"
                                class="h-18 w-18 rounded-[1.2rem] object-cover">
                        @else
                            <div class="avatar-fallback h-18 w-18 rounded-[1.2rem] text-lg">
                                {{ $mentor->initials }}
                            </div>
                        @endif
                        <div>
                            <p class="font-display text-2xl text-slate-900">{{ $mentor->name }}</p>
                            <p class="text-sm text-violet-700">{{ $mentor->job_title }} · {{ $mentor->employer }}</p>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $mentor->testimonial_quote }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="glass-panel p-6">
            <p class="section-eyebrow">Kolaborasi Industri</p>
            <div class="mt-4 space-y-4">
                @foreach ($collaborations as $item)
                    <article class="card-subtle">
                        <p class="text-sm uppercase tracking-[0.22em] text-violet-700">{{ $item->category }}</p>
                        <p class="mt-3 font-display text-2xl text-slate-900">{{ $item->title }}</p>
                        <p class="mt-3 text-sm leading-7 text-slate-500">{{ $item->summary }}</p>
                        <p class="mt-3 text-sm text-slate-600">Target dampak: {{ $item->impact_target }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
