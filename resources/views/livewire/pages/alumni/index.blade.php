@section('title', 'Data Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Header --}}
    <section class="section-shell mb-8">
        <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-stretch">
            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow">Direktori Alumni</p>
                <h1 class="section-title mt-2 max-w-2xl">Temukan alumni FTI berdasarkan angkatan, prodi, atau tempat kerja.</h1>
                <p class="section-copy mt-3 max-w-2xl">
                    Filter tersimpan di URL sehingga mudah dibagikan. Gunakan pencarian untuk menyaring nama, jabatan, atau perusahaan.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    <div class="surface-card px-4 py-3">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $alumni->total() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Hasil tampil</p>
                    </div>
                    <div class="surface-card px-4 py-3">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $programs->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Program studi</p>
                    </div>
                    <div class="surface-card px-4 py-3">
                        <p class="text-2xl font-semibold leading-none" style="color:var(--ink)">{{ $batchYears->count() }}</p>
                        <p class="mt-1 text-xs font-medium" style="color:var(--ink-muted)">Angkatan</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel flex flex-col justify-between p-6 sm:p-7">
                <div>
                    <p class="section-eyebrow mb-2">Top Industri</p>
                    <div class="space-y-3">
                        @foreach ($industryStats as $item)
                            <div class="flex items-center justify-between rounded-xl border px-4 py-3" style="border-color:var(--border);background:var(--bg-base)">
                                <span class="truncate pr-3 text-sm font-medium" style="color:var(--ink-2)">{{ $item->industry }}</span>
                                <span class="flex-shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                                    {{ $item->total }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                @auth
                    <a href="{{ route('alumni.update-profile') }}" wire:navigate class="outline-btn mt-5 w-full">
                        Update Profil
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Filter --}}
    <section class="section-shell mb-8">
        <div class="glass-panel p-5 sm:p-6">
            <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="section-eyebrow">Filter Alumni</p>
                    <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Saring data dengan cepat.</h2>
                </div>
                <button wire:click="clearFilters" type="button" class="ghost-btn">
                    Reset
                </button>
            </div>

            <div class="grid gap-3 lg:grid-cols-[1.4fr_1fr_1fr_1fr_auto]">
                <label class="space-y-1.5 text-sm">
                    <span class="font-medium text-gray-600">Cari nama atau pekerjaan</span>
                    <input wire:model.live.debounce.300ms="search" type="text" class="input-shell"
                        placeholder="Nama, engineer, Jakarta…">
                </label>
                <label class="space-y-1.5 text-sm">
                    <span class="font-medium text-gray-600">Program Studi</span>
                    <select wire:model.live="program" class="input-shell">
                        <option value="">Semua prodi</option>
                        @foreach ($programs as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="space-y-1.5 text-sm">
                    <span class="font-medium text-gray-600">Angkatan</span>
                    <select wire:model.live="batchYear" class="input-shell">
                        <option value="">Semua angkatan</option>
                        @foreach ($batchYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="space-y-1.5 text-sm">
                    <span class="font-medium text-gray-600">Tempat kerja</span>
                    <input wire:model.live.debounce.300ms="employer" type="text" class="input-shell"
                        placeholder="Mis. Tokopedia">
                </label>
                <div class="flex items-end">
                    <button wire:click="clearFilters" type="button"
                        class="ghost-btn w-full justify-center lg:w-auto">Reset</button>
                </div>
            </div>
        </div>
    </section>

    {{-- Grid --}}
    <section class="section-shell">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($alumni as $alumnus)
                <a href="{{ route('alumni.show', $alumnus) }}" wire:navigate
                    class="group glass-panel flex h-full flex-col overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative overflow-hidden bg-gradient-to-b from-slate-100 to-slate-200">
                        @if ($alumnus->photo_url)
                            <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->name }}"
                                class="h-56 w-full object-cover object-[center_18%] transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="avatar-fallback h-56 w-full">{{ $alumnus->initials }}</div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                        @if ($alumnus->is_featured)
                            <div class="absolute left-3 top-3">
                                <span class="rounded-full border border-white/15 bg-white/90 px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wider text-[var(--brand-deep)] backdrop-blur-sm">
                                    ⭐ Featured
                                </span>
                            </div>
                        @endif

                        <div class="absolute inset-x-0 bottom-3 flex justify-center opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100 translate-y-2">
                            <span class="rounded-full bg-white/95 px-4 py-1.5 text-xs font-semibold shadow-sm" style="color:var(--brand-deep)">
                                Lihat Profil
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <div>
                            <p class="font-display text-2xl leading-tight" style="color:var(--ink)">{{ $alumnus->name }}</p>
                            <p class="mt-2 inline-flex flex-wrap gap-1.5 text-sm font-medium" style="color:var(--brand-deep)">
                                <span>{{ $alumnus->program }}</span>
                                <span>•</span>
                                <span>{{ $alumnus->batch_year }}</span>
                            </p>
                        </div>

                        <div class="my-4 border-t" style="border-color:var(--border)"></div>

                        <div class="space-y-2 text-sm">
                            @if($alumnus->job_title || $alumnus->employer)
                                <p class="leading-relaxed" style="color:var(--ink-2)">
                                    {{ $alumnus->job_title }}@if($alumnus->job_title && $alumnus->employer) di @endif{{ $alumnus->employer }}
                                </p>
                            @endif
                            @if($alumnus->city)
                                <p class="flex items-center gap-1.5 text-xs" style="color:var(--ink-muted)">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $alumnus->city }}@if($alumnus->province), {{ $alumnus->province }}@endif
                                </p>
                            @endif
                        </div>

                        <div class="mt-auto pt-4">
                            <span class="career-detail-btn inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold">
                                Lihat Profil
                                <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="h-1 w-full scale-x-0 transition-transform duration-300 group-hover:scale-x-100"
                         style="background:linear-gradient(90deg,var(--brand),var(--brand-2))"></div>
                </a>
            @empty
                <div class="glass-panel col-span-full py-20 text-center">
                    <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl"
                         style="background:var(--brand-soft)">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             style="color:var(--brand)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-2" style="color:var(--ink)">Belum ada data</h3>
                    <p class="text-sm max-w-xs mx-auto" style="color:var(--ink-muted)">
                        Tidak ada alumni yang cocok dengan filter yang dipilih.
                    </p>
                    <button wire:click="clearFilters" type="button" class="purple-btn mt-5">Reset filter</button>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $alumni->links() }}</div>
    </section>

    {{-- CTA Update --}}
    <section class="section-shell mt-12">
        <div class="relative overflow-hidden rounded-2xl p-8 sm:p-10"
             style="background:linear-gradient(135deg,var(--brand) 0%,var(--brand-2) 100%)">
            <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full opacity-10 bg-white"></div>
            <div class="absolute -bottom-8 -left-8 h-36 w-36 rounded-full opacity-10 bg-white"></div>
            <div class="relative flex flex-col items-start gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white/60">Update Data Alumni</p>
                    <h2 class="mt-1 font-display text-2xl text-white">Profil Anda sudah ada di sini?</h2>
                    <p class="mt-1 text-sm text-white/70">Login dan perbarui informasi karier, foto, dan profil Anda.</p>
                </div>
                @auth
                    <a href="{{ route('alumni.update-profile') }}" wire:navigate
                        class="flex-shrink-0 rounded-xl bg-white px-6 py-3 text-sm font-bold transition hover:bg-white/90"
                        style="color:var(--brand-deep)">Update Profil →</a>
                @else
                    <a href="{{ route('register') }}" wire:navigate
                        class="flex-shrink-0 rounded-xl bg-white px-6 py-3 text-sm font-bold transition hover:bg-white/90"
                        style="color:var(--brand-deep)">Daftar Sekarang →</a>
                @endauth
            </div>
        </div>
    </section>
</div>
