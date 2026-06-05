@section('title', 'Karier & Kolaborasi Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Header --}}
    <section class="section-shell mb-8 grid gap-5 lg:grid-cols-2">
        <div class="space-y-3">
            <p class="section-eyebrow">Karier & Kolaborasi</p>
            <h1 class="section-title max-w-xl">Lowongan, mentoring, dan kolaborasi industri.</h1>
            <p class="section-copy">Peluang kerja aktif, program mentoring, dan bentuk kolaborasi dari jaringan alumni FTI.</p>
            @auth
                <div class="rounded-xl border px-4 py-3 text-sm"
                    style="background:var(--brand-soft);border-color:rgba(var(--brand-rgb),.2);color:var(--brand-deep)">
                    Lowongan menunggu persetujuan: <strong>{{ $myPendingJobs }}</strong>.
                    <a href="{{ route('alumni.submit-job') }}" wire:navigate
                        class="ml-1 font-semibold underline">Ajukan baru</a>
                </div>
            @endauth
        </div>
        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-2">Forum Diskusi Alumni</p>
            <p class="text-sm leading-relaxed text-gray-500">
                Bergabung di kanal komunitas alumni untuk diskusi, berbagi peluang, dan networking lintas angkatan.
            </p>
            <a href="https://discord.com" target="_blank" rel="noreferrer" class="outline-btn mt-4 inline-flex">
                Masuk Kanal Komunitas
            </a>
        </div>
    </section>

    {{-- Jobs --}}
    <section class="section-shell mb-8">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Lowongan Pekerjaan</p>
                <h2 class="section-title">Peluang kerja relevan untuk alumni FTI.</h2>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($jobs as $job)
                <article class="glass-panel interactive-card flex flex-col p-5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="badge-pill">{{ $job->employment_type }}</span>
                        @if ($job->is_featured)
                            <span class="text-xs font-semibold" style="color:var(--brand)">Featured</span>
                        @endif
                    </div>
                    <p class="mt-3 font-display text-xl text-gray-900">{{ $job->title }}</p>
                    <p class="mt-1 text-sm text-gray-600">{{ $job->company }} · {{ $job->location }}</p>
                    <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-gray-500">{{ $job->summary }}</p>
                    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3 text-sm">
                        <span class="text-xs text-gray-400">Tutup {{ $job->closes_at->translatedFormat('d M Y') }}</span>
                        <a href="{{ route('career.show', $job) }}" wire:navigate
                            class="font-semibold transition" style="color:var(--brand)">Lihat detail →</a>
                    </div>

                    @if ($job->submitter)
                        <div class="mt-3 flex items-center gap-2 border-t border-gray-100 pt-3">
                            @if ($job->submitter?->alumniProfile?->photo_url)
                                <img src="{{ $job->submitter->alumniProfile->photo_url }}"
                                    alt="{{ $job->submitter->name }}"
                                    class="h-8 w-8 rounded-full object-cover">
                            @else
                                @php $si = $job->submitter?->alumniProfile?->initials ?? ($job->submitter?->initials() ?? 'AL'); @endphp
                                <div class="avatar-fallback h-8 w-8 rounded-full text-xs">{{ $si }}</div>
                            @endif
                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold text-gray-700">{{ $job->submitter->name }}</p>
                                @if($job->submitter?->alumniProfile?->job_title)
                                    <p class="truncate text-xs text-gray-400">{{ $job->submitter->alumniProfile->job_title }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </article>
            @empty
                <div class="glass-panel col-span-full py-12 text-center text-gray-400">
                    Belum ada lowongan aktif.
                </div>
            @endforelse
        </div>
    </section>

    {{-- Mentors + Collaborations --}}
    <section class="section-shell grid gap-5 lg:grid-cols-2">
        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-4">Mentoring Alumni</p>
            <div class="space-y-3">
                @forelse ($featuredMentors as $mentor)
                    <article class="card-subtle flex gap-3">
                        @if ($mentor->photo_url)
                            <img src="{{ $mentor->photo_url }}" alt="{{ $mentor->name }}"
                                class="h-14 w-14 flex-shrink-0 rounded-xl object-cover">
                        @else
                            <div class="avatar-fallback h-14 w-14 flex-shrink-0 rounded-xl text-base">{{ $mentor->initials }}</div>
                        @endif
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900">{{ $mentor->name }}</p>
                            <p class="text-sm" style="color:var(--brand-deep)">{{ $mentor->job_title }}@if($mentor->employer) · {{ $mentor->employer }}@endif</p>
                            @if($mentor->testimonial_quote)
                                <p class="mt-1 line-clamp-2 text-xs text-gray-500">{{ $mentor->testimonial_quote }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-400">Belum ada mentor terdaftar.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-4">Kolaborasi Industri</p>
            <div class="space-y-3">
                @forelse ($collaborations as $item)
                    <article class="card-subtle">
                        <p class="section-eyebrow">{{ $item->category }}</p>
                        <p class="mt-1 font-display text-lg text-gray-900">{{ $item->title }}</p>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $item->summary }}</p>
                        <p class="mt-1.5 text-xs text-gray-400">Target: {{ $item->impact_target }}</p>
                    </article>
                @empty
                    <p class="text-sm text-gray-400">Belum ada kolaborasi terdaftar.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
