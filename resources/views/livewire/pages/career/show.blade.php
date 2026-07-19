@section('title', $job->title . ' - ' . $job->company)

@php
    $deadline = $job->closes_at;
    $daysLeft = $deadline ? (int) now()->startOfDay()->diffInDays($deadline->copy()->startOfDay(), false) : null;
    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    $deadlineLabel = $deadline
        ? $deadline->format('d') . ' ' . $monthNames[(int) $deadline->format('n')] . ' ' . $deadline->format('Y')
        : 'Tidak ditentukan';

    if ($daysLeft === null) {
        $statusLabel = 'Tanggal belum ditentukan';
        $statusClass = 'text-slate-500';
        $statusDot = '#94a3b8';
    } elseif ($daysLeft < 0) {
        $statusLabel = 'Sudah ditutup';
        $statusClass = 'text-red-600';
        $statusDot = '#ef4444';
    } elseif ($daysLeft === 0) {
        $statusLabel = 'Ditutup hari ini';
        $statusClass = 'text-amber-600';
        $statusDot = '#f59e0b';
    } else {
        $statusLabel = $daysLeft . ' hari tersisa';
        $statusClass = 'text-emerald-600';
        $statusDot = '#10b981';
    }
@endphp

<div class="py-10 lg:py-12">
    <section class="section-shell">
        <a href="{{ route('career.index') }}" wire:navigate
            class="mb-5 inline-flex items-center gap-2 text-sm font-semibold transition"
            style="color:var(--ink-muted)">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Karier & Kolaborasi
        </a>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
            <article class="glass-panel overflow-hidden">
                <div class="border-b p-6 sm:p-8" style="border-color:var(--border)">
                    <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                        <div class="min-w-0">
                            <div class="mb-3 flex flex-wrap gap-2">
                                <span class="badge-pill">{{ $job->employment_type }}</span>
                                <span class="badge-pill">{{ $job->location }}</span>
                                @if ($job->is_featured)
                                    <span class="badge-pill">Lowongan Prioritas</span>
                                @endif
                            </div>

                            <h1 class="font-sans text-3xl font-semibold leading-tight sm:text-4xl" style="color:var(--ink)">
                                {{ $job->title }}
                            </h1>
                            <p class="mt-2 text-base font-medium" style="color:var(--ink-muted)">
                                {{ $job->company }}
                            </p>
                        </div>

                        <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                            class="purple-btn w-full md:w-auto">
                            Apply Sekarang
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M9 7h8v8"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 border-b p-6 sm:grid-cols-2 sm:p-8" style="border-color:var(--border)">
                    <div class="rounded-xl border bg-white p-4" style="border-color:var(--border)">
                        <p class="section-eyebrow">Batas Aplikasi</p>
                        <p class="mt-2 text-2xl font-semibold leading-tight" style="color:var(--ink)">
                            {{ $deadlineLabel }}
                        </p>
                    </div>

                    <div class="rounded-xl border p-4" style="background:var(--brand-soft);border-color:rgba(var(--brand-rgb),.16)">
                        <p class="section-eyebrow">Status</p>
                        <p class="mt-2 flex items-center gap-2 text-lg font-semibold {{ $statusClass }}">
                            <span class="h-2.5 w-2.5 rounded-full" style="background:{{ $statusDot }}"></span>
                            {{ $statusLabel }}
                        </p>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <p class="section-eyebrow mb-3">Deskripsi</p>
                    <div class="max-w-3xl whitespace-pre-wrap text-sm leading-7" style="color:var(--ink-2)">{{ $job->summary }}</div>
                </div>
            </article>

            <aside class="glass-panel h-fit p-5 lg:sticky lg:top-24">
                @if ($job->submitter)
                    <p class="section-eyebrow mb-4">Diajukan oleh</p>
                    <div class="flex items-center gap-3">
                        @if ($job->submitter?->alumniProfile?->photo_url)
                            <img src="{{ $job->submitter->alumniProfile->photo_url }}"
                                alt="{{ $job->submitter->name }}"
                                class="h-14 w-14 flex-shrink-0 rounded-2xl object-cover"
                                style="outline:2px solid rgba(var(--brand-rgb),.14);outline-offset:2px">
                        @else
                            @php $si = $job->submitter?->alumniProfile?->initials ?? ($job->submitter?->initials() ?? 'AL'); @endphp
                            <div class="avatar-fallback h-14 w-14 flex-shrink-0 rounded-2xl text-base">{{ $si }}</div>
                        @endif

                        <div class="min-w-0">
                            <p class="truncate font-semibold" style="color:var(--ink)">{{ $job->submitter->name }}</p>
                            @if ($job->submitter?->alumniProfile?->job_title)
                                <p class="truncate text-sm" style="color:var(--ink-muted)">{{ $job->submitter->alumniProfile->job_title }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 space-y-3 border-t pt-5" style="border-color:var(--border)">
                        <a href="mailto:{{ $job->submitter->email }}"
                            class="flex min-w-0 items-center gap-3 rounded-lg px-1 text-sm transition hover:text-[var(--brand-deep)]"
                            style="color:var(--ink-muted)">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="truncate">{{ $job->submitter->email }}</span>
                        </a>

                        @if ($job->submitter?->alumniProfile?->phone)
                            <a href="tel:{{ $job->submitter->alumniProfile->phone }}"
                                class="flex items-center gap-3 rounded-lg px-1 text-sm transition hover:text-[var(--brand-deep)]"
                                style="color:var(--ink-muted)">
                                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>{{ $job->submitter->alumniProfile->phone }}</span>
                            </a>
                        @endif
                    </div>

                    <div class="mt-5 border-t pt-5" style="border-color:var(--border)">
                        <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                            class="purple-btn w-full">
                            Apply Sekarang
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M9 7h8v8"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <p class="section-eyebrow mb-4">Pendaftaran</p>
                    <p class="mb-5 text-sm leading-6" style="color:var(--ink-muted)">
                        Buka tautan aplikasi untuk melihat instruksi pendaftaran dari perusahaan.
                    </p>
                    <a href="{{ $job->apply_url }}" target="_blank" rel="noreferrer"
                        class="purple-btn w-full">
                        Apply Sekarang
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M9 7h8v8"/>
                        </svg>
                    </a>
                @endif
            </aside>
        </div>
    </section>
</div>
