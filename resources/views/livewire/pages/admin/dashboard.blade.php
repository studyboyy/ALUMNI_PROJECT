@section('title', 'Dashboard Admin')

<div x-data="{ tab: 'ringkasan' }" class="w-full space-y-6">
    <section class="grid gap-5 xl:grid-cols-[1.05fr_0.95fr]">
        <div class="glass-panel overflow-hidden p-5 sm:p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="max-w-2xl">
                    <p class="section-eyebrow">Dashboard Admin</p>
                    <h1 class="section-title mt-2">Pusat kontrol alumni yang lebih mudah dibaca.</h1>
                    <p class="section-copy mt-3">
                        Pantau registrasi, lowongan, tracer study, berita, agenda, dan distribusi alumni dalam tampilan yang ringkas.
                    </p>
                </div>

                <span class="rounded-full px-3 py-1 text-xs font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                    Real-time
                </span>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('admin.alumni') }}" wire:navigate class="purple-btn">Kelola Alumni</a>
                <a href="{{ route('admin.jobs') }}" wire:navigate class="outline-btn">Approval Lowongan</a>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            @foreach ($stats as $stat)
                <article class="glass-panel p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[0.65rem] font-semibold uppercase tracking-widest text-gray-400">{{ $stat['label'] }}</p>
                            <p class="mt-2 font-sans text-2xl font-semibold tracking-tight" style="color:var(--ink)">{{ $stat['value'] }}</p>
                            <p class="mt-1 text-xs leading-5" style="color:var(--ink-muted)">{{ $stat['note'] }}</p>
                        </div>
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl" style="background:var(--brand-soft)">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--brand)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="admin-tab-bar">
        @foreach ([
            'ringkasan' => 'Ringkasan',
            'registrasi' => 'Registrasi',
            'lowongan' => 'Lowongan',
            'program' => 'Program Studi',
            'kota' => 'Sebaran Kota',
            'konten' => 'Konten Publik',
        ] as $key => $label)
            <button type="button" class="admin-tab" :class="tab === '{{ $key }}' ? 'admin-tab-active' : ''"
                x-on:click="tab = '{{ $key }}'">
                {{ $label }}
            </button>
        @endforeach
    </section>

    <section x-show="tab === 'ringkasan'" x-cloak class="grid gap-5 xl:grid-cols-[1.1fr_0.9fr]">
        <article class="admin-chart-card p-5">
            <div class="mb-5 flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="section-eyebrow">Snapshot</p>
                    <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Aktivitas utama</h2>
                    <p class="mt-1 text-sm" style="color:var(--ink-muted)">Konten dan aktivitas yang paling sering dipantau admin.</p>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($contentHighlights as $item)
                    <div class="rounded-2xl border bg-white p-4" style="border-color:var(--border)">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold" style="color:var(--ink-2)">{{ $item['label'] }}</p>
                                <p class="mt-2 font-sans text-2xl font-semibold tracking-tight" style="color:var(--ink)">{{ $item['value'] }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-wider" style="background:var(--brand-soft);color:var(--brand-deep)">
                                Aktif
                            </span>
                        </div>
                        <div class="admin-chart-track mt-4">
                            <div class="admin-chart-fill" style="width: {{ (int) round(($item['value'] / max($contentMax, 1)) * 100) }}%"></div>
                        </div>
                        <p class="mt-2 text-xs leading-5" style="color:var(--ink-muted)">{{ $item['note'] }}</p>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Kesehatan Data</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Prioritas hari ini</h2>
            <div class="mt-5 space-y-3">
                <div class="rounded-2xl border bg-white p-4" style="border-color:var(--border)">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm font-medium" style="color:var(--ink-2)">Registrasi alumni</span>
                        <span class="text-sm font-semibold" style="color:var(--ink)">{{ $registrationBreakdown[0]['percent'] ?? 0 }}%</span>
                    </div>
                    <div class="admin-chart-track mt-3">
                        <div class="admin-chart-fill" style="width: {{ $registrationBreakdown[0]['percent'] ?? 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border bg-white p-4" style="border-color:var(--border)">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm font-medium" style="color:var(--ink-2)">Lowongan disetujui</span>
                        <span class="text-sm font-semibold" style="color:var(--ink)">{{ $jobBreakdown[0]['percent'] ?? 0 }}%</span>
                    </div>
                    <div class="admin-chart-track mt-3">
                        <div class="h-full rounded-full bg-emerald-400" style="width: {{ $jobBreakdown[0]['percent'] ?? 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border p-4" style="border-color:rgba(var(--brand-rgb),.16);background:var(--brand-soft)">
                    <p class="text-sm font-semibold" style="color:var(--brand-deep)">Gunakan tab di atas untuk membuka detail tanpa harus scroll panjang.</p>
                </div>
            </div>
        </article>
    </section>

    <section x-show="tab === 'registrasi'" x-cloak class="grid gap-5 xl:grid-cols-[0.9fr_1.1fr]">
        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Registrasi</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Status akun alumni</h2>
            <div class="mt-5 space-y-4">
                @foreach ($registrationBreakdown as $item)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium" style="color:var(--ink-2)">{{ $item['label'] }}</span>
                            <span class="font-semibold" style="color:var(--ink)">{{ $item['value'] }} alumni</span>
                        </div>
                        <div class="admin-chart-track">
                            <div class="h-full rounded-full {{ $item['bar'] }}" style="width: {{ $item['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Grafik</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Perbandingan registrasi</h2>
            <div class="mt-6 flex h-64 items-end gap-4 rounded-2xl border bg-white p-5" style="border-color:var(--border)">
                @foreach ($registrationBreakdown as $item)
                    <div class="flex min-w-0 flex-1 flex-col items-center gap-3">
                        <div class="flex h-44 w-full max-w-28 items-end rounded-2xl bg-slate-100 p-2">
                            <div class="w-full rounded-xl {{ $item['bar'] }}" style="height: {{ max($item['percent'], 8) }}%"></div>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-semibold" style="color:var(--ink)">{{ $item['percent'] }}%</p>
                            <p class="text-[0.7rem]" style="color:var(--ink-muted)">{{ $item['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <section x-show="tab === 'lowongan'" x-cloak class="grid gap-5 xl:grid-cols-[0.9fr_1.1fr]">
        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Lowongan</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Status approval</h2>
            <div class="mt-5 space-y-4">
                @foreach ($jobBreakdown as $item)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium" style="color:var(--ink-2)">{{ $item['label'] }}</span>
                            <span class="font-semibold" style="color:var(--ink)">{{ $item['value'] }} lowongan</span>
                        </div>
                        <div class="admin-chart-track">
                            <div class="h-full rounded-full {{ $item['bar'] }}" style="width: {{ $item['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Grafik</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Distribusi approval</h2>
            <div class="mt-6 grid gap-3 sm:grid-cols-3">
                @foreach ($jobBreakdown as $item)
                    <div class="rounded-2xl border bg-white p-4 text-center" style="border-color:var(--border)">
                        <div class="mx-auto flex h-32 w-full max-w-20 items-end rounded-2xl bg-slate-100 p-2">
                            <div class="w-full rounded-xl {{ $item['bar'] }}" style="height: {{ max($item['percent'], 8) }}%"></div>
                        </div>
                        <p class="mt-3 font-sans text-xl font-semibold" style="color:var(--ink)">{{ $item['value'] }}</p>
                        <p class="text-xs" style="color:var(--ink-muted)">{{ $item['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <section x-show="tab === 'program'" x-cloak class="grid gap-5 xl:grid-cols-[1.15fr_0.85fr]">
        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Program Studi</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Top distribusi alumni</h2>
            <div class="mt-5 space-y-4">
                @forelse ($programStats as $item)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium" style="color:var(--ink-2)">{{ $item['label'] }}</span>
                            <span class="font-semibold" style="color:var(--ink)">{{ $item['value'] }}</span>
                        </div>
                        <div class="admin-chart-track">
                            <div class="admin-chart-fill" style="width: {{ (int) round(($item['value'] / max($programMax, 1)) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="rounded-2xl border bg-white p-5 text-sm" style="border-color:var(--border);color:var(--ink-muted)">
                        Belum ada data program studi.
                    </p>
                @endforelse
            </div>
        </article>

        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Highlight</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Program paling aktif</h2>
            <div class="mt-5 rounded-2xl border bg-white p-5" style="border-color:var(--border)">
                <p class="text-sm" style="color:var(--ink-muted)">Jumlah tertinggi pada data saat ini</p>
                <p class="mt-2 font-sans text-4xl font-semibold tracking-tight" style="color:var(--brand)">{{ $programMax }}</p>
                <p class="mt-2 text-sm" style="color:var(--ink-2)">Gunakan data ini untuk melihat jurusan yang paling aktif di jaringan alumni.</p>
            </div>
        </article>
    </section>

    <section x-show="tab === 'kota'" x-cloak class="grid gap-5 xl:grid-cols-[1.15fr_0.85fr]">
        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Sebaran Kota</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Top kota kerja alumni</h2>
            <div class="mt-5 space-y-4">
                @forelse ($cityStats as $item)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium" style="color:var(--ink-2)">{{ $item['label'] }}</span>
                            <span class="font-semibold" style="color:var(--ink)">{{ $item['value'] }}</span>
                        </div>
                        <div class="admin-chart-track">
                            <div class="admin-chart-fill" style="width: {{ (int) round(($item['value'] / max($cityMax, 1)) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="rounded-2xl border bg-white p-5 text-sm" style="border-color:var(--border);color:var(--ink-muted)">
                        Belum ada data kota alumni.
                    </p>
                @endforelse
            </div>
        </article>

        <article class="admin-chart-card p-5">
            <p class="section-eyebrow">Highlight</p>
            <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">Kota paling dominan</h2>
            <div class="mt-5 rounded-2xl border bg-white p-5" style="border-color:var(--border)">
                <p class="text-sm" style="color:var(--ink-muted)">Jumlah tertinggi pada data saat ini</p>
                <p class="mt-2 font-sans text-4xl font-semibold tracking-tight" style="color:var(--brand)">{{ $cityMax }}</p>
                <p class="mt-2 text-sm" style="color:var(--ink-2)">Membantu membaca wilayah kerja alumni yang paling terkonsentrasi.</p>
            </div>
        </article>
    </section>

    <section x-show="tab === 'konten'" x-cloak class="grid gap-5 lg:grid-cols-2 xl:grid-cols-4">
        @foreach ($contentHighlights as $item)
            <article class="admin-chart-card p-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $item['label'] }}</p>
                <p class="mt-3 font-sans text-3xl font-semibold tracking-tight" style="color:var(--ink)">{{ $item['value'] }}</p>
                <div class="admin-chart-track mt-4">
                    <div class="admin-chart-fill" style="width: {{ (int) round(($item['value'] / max($contentMax, 1)) * 100) }}%"></div>
                </div>
                <p class="mt-3 text-sm leading-6" style="color:var(--ink-muted)">{{ $item['note'] }}</p>
            </article>
        @endforeach
    </section>
</div>
