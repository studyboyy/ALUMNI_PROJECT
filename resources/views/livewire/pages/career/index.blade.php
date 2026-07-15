@section('title', 'Karier & Kolaborasi Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Header --}}
    <section class="section-shell mb-10">
        <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_380px] lg:items-stretch">
            <div class="flex flex-col justify-between gap-6">
                <div>
                    <p class="section-eyebrow">Karier & Kolaborasi</p>
                    <h1 class="section-title max-w-3xl">Temukan peluang kerja, mentor, dan kolaborasi industri.</h1>
                    <p class="section-copy mt-3">
                        Jelajahi lowongan aktif dari jaringan alumni FTI, akses mentoring, dan ikuti program kolaborasi yang relevan dengan perkembangan industri.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-xl border bg-white px-4 py-3 shadow-sm" style="border-color:var(--border)">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $jobs->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Lowongan aktif</p>
                    </div>
                    <div class="rounded-xl border bg-white px-4 py-3 shadow-sm" style="border-color:var(--border)">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $workingAlumni->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Alumni profesional</p>
                    </div>
                    <div class="rounded-xl border bg-white px-4 py-3 shadow-sm" style="border-color:var(--border)">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $collaborations->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Program kolaborasi</p>
                    </div>
                </div>

                @auth
                    <div class="rounded-xl border px-4 py-3 text-sm"
                        style="background:var(--brand-soft);border-color:rgba(var(--brand-rgb),.2);color:var(--brand-deep)">
                        Lowongan menunggu persetujuan: <strong>{{ $myPendingJobs }}</strong>.
                        <a href="{{ route('alumni.submit-job') }}" wire:navigate class="ml-1 font-semibold underline">
                            Ajukan baru
                        </a>
                    </div>
                @endauth
            </div>

            <div class="glass-panel flex flex-col justify-between p-6">
                <div>
                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl"
                        style="background:var(--brand-soft);color:var(--brand-deep)">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v7a2 2 0 01-2 2h-6l-4 4v-4H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m2-4h6a2 2 0 012 2v7a2 2 0 01-2 2H9l-4 4V6a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <p class="section-eyebrow mb-2">Forum Diskusi Alumni</p>
                    <p class="text-sm leading-7" style="color:var(--ink-muted)">
                        Bergabung di kanal komunitas untuk berbagi peluang, berdiskusi, dan membangun koneksi lintas angkatan.
                    </p>
                </div>

                <a href="https://discord.com" target="_blank" rel="noreferrer" class="outline-btn mt-5 w-full sm:w-fit">
                    Masuk Kanal Komunitas
                </a>
            </div>
        </div>
    </section>

    {{-- Jobs --}}
    <section class="section-shell mb-10">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Lowongan Pekerjaan</p>
                <h2 class="section-title">Peluang kerja relevan untuk alumni FTI.</h2>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($jobs as $job)
                @php
                    $daysLeft = $job->closes_at ? (int) now()->startOfDay()->diffInDays($job->closes_at->copy()->startOfDay(), false) : null;

                    if ($daysLeft === null) {
                        $urgencyStyle = 'background:#f8fafc;color:#64748b;border-color:#e2e8f0';
                        $urgencyLabel = 'Tanpa batas';
                    } elseif ($daysLeft < 0) {
                        $urgencyStyle = 'background:#f8fafc;color:#64748b;border-color:#e2e8f0';
                        $urgencyLabel = 'Sudah ditutup';
                    } elseif ($daysLeft === 0) {
                        $urgencyStyle = 'background:#fef2f2;color:#dc2626;border-color:#fecaca';
                        $urgencyLabel = 'Tutup hari ini';
                    } elseif ($daysLeft < 7) {
                        $urgencyStyle = 'background:#fef2f2;color:#dc2626;border-color:#fecaca';
                        $urgencyLabel = 'Tutup ' . $daysLeft . ' hari lagi';
                    } elseif ($daysLeft <= 14) {
                        $urgencyStyle = 'background:#fffbeb;color:#d97706;border-color:#fde68a';
                        $urgencyLabel = 'Tutup ' . $daysLeft . ' hari lagi';
                    } else {
                        $urgencyStyle = 'background:#f0fdf4;color:#16a34a;border-color:#bbf7d0';
                        $urgencyLabel = 'Tutup ' . $daysLeft . ' hari lagi';
                    }
                @endphp

                <a href="{{ route('career.show', $job) }}" wire:navigate
                    class="glass-panel group flex min-h-[295px] flex-col overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex flex-1 flex-col p-5">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="badge-pill">{{ $job->employment_type }}</span>
                            @if ($job->is_featured)
                                <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wide"
                                    style="background:rgba(var(--brand-rgb),.08);color:var(--brand-deep);border-color:rgba(var(--brand-rgb),.18)">
                                    Featured
                                </span>
                            @endif
                            <span class="ml-auto inline-flex items-center rounded-full border px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wide"
                                style="{{ $urgencyStyle }}">
                                {{ $urgencyLabel }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm font-semibold" style="color:var(--ink)">{{ $job->company }}</p>
                            <h3 class="mt-1 font-sans text-xl font-semibold leading-snug" style="color:var(--ink)">
                                {{ $job->title }}
                            </h3>
                            <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">{{ $job->location }}</p>
                        </div>

                        <div class="my-4 border-t" style="border-color:var(--border)"></div>

                        <p class="line-clamp-3 text-sm leading-7" style="color:var(--ink-muted)">
                            {{ $job->summary }}
                        </p>
                    </div>

                    <div class="mt-auto flex items-center justify-between gap-3 border-t bg-white/70 px-5 py-4"
                        style="border-color:var(--border)">
                        @if ($job->submitter)
                            <div class="flex min-w-0 items-center gap-2.5">
                                @if ($job->submitter?->alumniProfile?->photo_url)
                                    <img src="{{ $job->submitter->alumniProfile->photo_url }}"
                                        alt="{{ $job->submitter->name }}"
                                        class="h-9 w-9 flex-shrink-0 rounded-full object-cover"
                                        style="outline:2px solid rgba(var(--brand-rgb),.15);outline-offset:1px">
                                @else
                                    @php $si = $job->submitter?->alumniProfile?->initials ?? ($job->submitter?->initials() ?? 'AL'); @endphp
                                    <div class="avatar-fallback h-9 w-9 flex-shrink-0 rounded-full text-xs">{{ $si }}</div>
                                @endif
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-semibold" style="color:var(--ink)">{{ $job->submitter->name }}</p>
                                    @if($job->submitter?->alumniProfile?->job_title)
                                        <p class="truncate text-xs" style="color:var(--ink-muted)">{{ $job->submitter->alumniProfile->job_title }}</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-xs font-medium" style="color:var(--ink-muted)">Dipublikasikan admin</p>
                        @endif

                        <span class="career-detail-btn flex-shrink-0 inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold">
                            Lihat Detail
                            <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="glass-panel col-span-full py-20 text-center">
                    <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl"
                        style="background:var(--brand-soft)">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color:var(--brand)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-2" style="color:var(--ink)">Belum ada lowongan</h3>
                    <p class="text-sm max-w-xs mx-auto" style="color:var(--ink-muted)">
                        Lowongan dari jaringan alumni FTI akan muncul di sini setelah disetujui admin.
                    </p>
                    @auth
                        <a href="{{ route('alumni.submit-job') }}" wire:navigate class="purple-btn mt-5 inline-flex">
                            Ajukan Lowongan
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>
    </section>

    {{-- Working alumni + collaborations --}}
    <section class="section-shell grid gap-5 lg:grid-cols-2">
        <div class="glass-panel p-6">
            <div class="mb-5 flex items-end justify-between gap-4">
                <div>
                    <p class="section-eyebrow">Jejaring Profesional</p>
                    <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Alumni yang aktif di dunia kerja.</h2>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($workingAlumni as $mentor)
                    <a href="{{ route('alumni.show', $mentor) }}" wire:navigate class="flex gap-4 rounded-xl border bg-white p-4 transition hover:shadow-md" style="border-color:var(--border)">
                        <div class="flex-shrink-0">
                            @if ($mentor->photo_url)
                                <img src="{{ $mentor->photo_url }}" alt="{{ $mentor->name }}"
                                    class="h-14 w-14 rounded-full object-cover shadow-sm"
                                    style="outline:2px solid rgba(var(--brand-rgb),.14);outline-offset:2px">
                            @else
                                <div class="avatar-fallback h-14 w-14 rounded-full text-base shadow-sm">{{ $mentor->initials }}</div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold" style="color:var(--ink)">{{ $mentor->name }}</p>
                            <p class="text-sm" style="color:var(--brand-deep)">
                                {{ $mentor->job_title }}@if($mentor->employer) di {{ $mentor->employer }}@endif
                            </p>
                            @if($mentor->testimonial_quote)
                                <p class="mt-2 line-clamp-2 text-xs leading-6" style="color:var(--ink-muted)">
                                    "{{ $mentor->testimonial_quote }}"
                                </p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="py-10 text-center">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl"
                            style="background:var(--brand-soft)">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="color:var(--brand)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-sm" style="color:var(--ink)">Belum ada alumni bekerja</p>
                        <p class="text-xs mt-1" style="color:var(--ink-muted)">Alumni dengan data pekerjaan akan tampil di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="glass-panel p-6">
            <div class="mb-5">
                <p class="section-eyebrow">Kolaborasi Industri</p>
                <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Program bersama mitra dan alumni.</h2>
            </div>

            <div class="space-y-3">
                @forelse ($collaborations as $item)
                    @php
                        $accentColors = [
                            'Riset' => 'var(--brand)',
                            'Magang' => '#059669',
                            'Pelatihan' => '#d97706',
                            'CSR' => '#0284c7',
                            'Rekrutmen' => '#7c3aed',
                            'Karier' => '#4f46e5',
                            'Kolaborasi' => '#059669',
                        ];
                        $accent = $accentColors[$item->category] ?? 'var(--brand)';
                    @endphp
                    <article class="relative overflow-hidden rounded-xl border bg-white p-4 pl-5" style="border-color:var(--border)">
                        <div class="absolute inset-y-0 left-0 w-1" style="background:{{ $accent }}"></div>
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="section-eyebrow" style="color:{{ $accent }}">{{ $item->category }}</p>
                                <p class="mt-1 font-semibold leading-snug" style="color:var(--ink)">{{ $item->title }}</p>
                            </div>
                            @if($item->status)
                                <span class="rounded-full border px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wide"
                                    style="background:var(--brand-soft);border-color:rgba(var(--brand-rgb),.16);color:var(--brand-deep)">
                                    {{ $item->status }}
                                </span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm leading-6 line-clamp-2" style="color:var(--ink-muted)">{{ $item->summary }}</p>
                        @if($item->impact_target)
                            <p class="mt-2 text-xs font-medium" style="color:var(--ink-muted)">Target: {{ $item->impact_target }}</p>
                        @endif
                    </article>
                @empty
                    <div class="py-10 text-center">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl"
                            style="background:var(--brand-soft)">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="color:var(--brand)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-sm" style="color:var(--ink)">Belum ada kolaborasi</p>
                        <p class="text-xs mt-1" style="color:var(--ink-muted)">Program kolaborasi industri akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
