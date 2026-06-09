@section('title', 'Profil Alumni FTI')

<div class="py-10 lg:py-12">

    <section class="section-shell mb-10">
        <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_340px] lg:items-stretch">
            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow">Profil Alumni FTI</p>
                <h1 class="section-title mt-2 max-w-2xl">Sejarah, visi misi, dan program kerja alumni.</h1>
                <p class="section-copy mt-3 max-w-2xl">
                    Pusat informasi kelembagaan Ikatan Alumni FTI - sejarah, struktur organisasi, dan program prioritas.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    <div class="surface-card px-4 py-3">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ count($timeline) }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Tonggak sejarah</p>
                    </div>
                    <div class="surface-card px-4 py-3">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $organizationMembers->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Pengurus aktif</p>
                    </div>
                    <div class="surface-card px-4 py-3">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $workPrograms->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Program kerja</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel flex flex-col justify-between p-6 sm:p-7">
                <div>
                    <p class="section-eyebrow mb-2">Ringkasan</p>
                    <p class="text-sm leading-7" style="color:var(--ink-muted)">
                        Halaman ini merangkum arah gerak komunitas alumni, dari visi dan misi sampai inisiatif yang berjalan.
                    </p>
                </div>
                <a href="{{ route('alumni.index') }}" wire:navigate class="outline-btn mt-5 w-full">
                    Lihat Direktori Alumni
                </a>
            </div>
        </div>
    </section>

    <section class="section-shell mb-10">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Visi & Misi</p>
                <h2 class="section-title">Arah dan komitmen kami.</h2>
            </div>
        </div>
        <div class="grid gap-5 lg:grid-cols-[1fr_1.2fr]">
            <div class="relative overflow-hidden rounded-2xl p-7"
                 style="background:linear-gradient(135deg,rgba(var(--brand-rgb),.07) 0%,rgba(var(--brand-2-rgb),.05) 100%);border:1px solid rgba(var(--brand-rgb),.15)">
                <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full opacity-10" style="background:var(--brand)"></div>
                <p class="section-eyebrow mb-3">Visi</p>
                <p class="font-display text-2xl leading-snug" style="color:var(--ink)">{{ $vision }}</p>
            </div>

            <div class="glass-panel p-6">
                <p class="section-eyebrow mb-4">Misi</p>
                <ul class="space-y-3">
                    @foreach ($missions as $mission)
                        <li class="flex items-start gap-3 rounded-xl border bg-white p-4 text-sm leading-7" style="border-color:var(--border);color:var(--ink-2)">
                            <span class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full"
                                  style="background:var(--brand-soft)">
                                <svg class="h-3 w-3" viewBox="0 0 12 12" fill="none">
                                    <path d="M2 6l3 3 5-5" stroke="currentColor" stroke-width="1.8"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          style="color:var(--brand)"/>
                                </svg>
                            </span>
                            <span>{{ $mission }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="section-shell mb-10">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Sejarah</p>
                <h2 class="section-title">Perjalanan komunitas alumni FTI.</h2>
            </div>
        </div>

        <div class="relative">
            <div class="absolute left-8 top-0 bottom-0 hidden w-px sm:block"
                 style="background:linear-gradient(180deg,transparent,rgba(var(--brand-rgb),.3) 10%,rgba(var(--brand-rgb),.3) 90%,transparent)"></div>

            <div class="space-y-5">
                @foreach ($timeline as $item)
                    <div class="relative flex gap-5 sm:gap-8">
                        <div class="hidden w-16 flex-shrink-0 flex-col items-center sm:flex">
                            <div class="relative z-10 flex h-9 w-9 items-center justify-center rounded-full border-2"
                                 style="background:var(--bg-surface);border-color:var(--brand)">
                                <div class="h-2.5 w-2.5 rounded-full" style="background:var(--brand)"></div>
                            </div>
                        </div>
                        <article class="glass-panel flex-1 p-5 sm:p-6">
                            <p class="font-display text-3xl leading-none" style="color:var(--brand)">{{ $item['year'] }}</p>
                            <p class="mt-2 font-semibold text-base" style="color:var(--ink)">{{ $item['title'] }}</p>
                            <p class="mt-1.5 text-sm leading-7" style="color:var(--ink-muted)">{{ $item['description'] }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-shell mb-10">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Struktur Organisasi</p>
                <h2 class="section-title">Pengurus aktif Alumni FTI.</h2>
            </div>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($organizationMembers as $member)
                <article class="glass-panel group flex flex-col overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative overflow-hidden bg-gradient-to-b from-slate-100 to-slate-200">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                             class="h-48 w-full object-cover object-[center_18%] transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="flex flex-1 flex-col p-5 text-center">
                        <p class="font-semibold text-base leading-snug" style="color:var(--ink)">{{ $member->name }}</p>
                        <p class="mt-1 text-sm font-medium" style="color:var(--brand-deep)">{{ $member->role }}</p>
                        @if($member->division)
                            <span class="mt-3 inline-flex self-center rounded-full px-3 py-1 text-xs font-medium"
                                  style="background:var(--brand-soft);color:var(--brand-deep)">{{ $member->division }}</span>
                        @endif
                        @if($member->focus_area)
                            <p class="mt-3 text-xs leading-6" style="color:var(--ink-muted)">{{ $member->focus_area }}</p>
                        @endif
                        <p class="mt-auto pt-4 text-xs uppercase tracking-wider" style="color:var(--ink-muted)">{{ $member->period }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Program Kerja</p>
                <h2 class="section-title">Inisiatif dan agenda prioritas.</h2>
            </div>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($workPrograms as $program)
                @php
                    $statusColor = match(strtolower($program->status ?? '')) {
                        'berjalan'    => 'background:#dcfce7;color:#15803d;border-color:#bbf7d0',
                        'prioritas'   => 'background:#f3e8ff;color:#7c3aed;border-color:#e9d5ff',
                        'perencanaan' => 'background:#fef9c3;color:#a16207;border-color:#fef08a',
                        default       => 'background:var(--brand-soft);color:var(--brand-deep);border-color:rgba(var(--brand-rgb),.2)',
                    };
                    $categoryIcons = [
                        'Pendidikan' => '<path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>',
                        'Karier' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                        'Sosial' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>',
                        'Teknologi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    ];
                    $icon = $categoryIcons[$program->category] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>';
                @endphp
                <article class="glass-panel group flex flex-col p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-3 flex items-start justify-between gap-3">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl" style="background:var(--brand-soft)">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--brand)">{!! $icon !!}</svg>
                        </div>
                        <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wide"
                              style="{{ $statusColor }}">{{ $program->status }}</span>
                    </div>
                    <span class="badge-pill self-start">{{ $program->category }}</span>
                    <p class="mt-3 font-semibold text-base leading-snug" style="color:var(--ink)">{{ $program->title }}</p>
                    <p class="mt-2 text-sm leading-7" style="color:var(--ink-muted)">{{ $program->summary }}</p>
                    @if($program->impact_target)
                        <div class="mt-4 border-t pt-4" style="border-color:var(--border)">
                            <p class="text-xs font-semibold" style="color:var(--brand)">Target: {{ $program->impact_target }}</p>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
</div>
