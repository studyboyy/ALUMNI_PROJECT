@section('title', 'Data Alumni FTI')

<div class="py-12 lg:py-16">

    {{-- Header --}}
    <section class="section-shell mb-10">
        <div class="grid gap-8 lg:grid-cols-[1fr_320px]">
            <div class="space-y-4">
                <p class="section-eyebrow">Direktori Alumni</p>
                <h1 class="section-title max-w-xl">Temukan alumni FTI berdasarkan angkatan, prodi, atau tempat kerja.</h1>
                <p class="section-copy">Filter tersimpan di URL sehingga mudah dibagikan.</p>
            </div>
            <div class="glass-panel p-5">
                <p class="section-eyebrow mb-3">Top Industri</p>
                <div class="space-y-2">
                    @foreach ($industryStats as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $item->industry }}</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Filter --}}
    <section class="section-shell mb-8">
        <div class="glass-panel p-5">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr_auto]">
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
                        class="ghost-btn w-full justify-center">Reset</button>
                </div>
            </div>
        </div>
    </section>

    {{-- Grid --}}
    <section class="section-shell">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($alumni as $alumnus)
                <a href="{{ route('alumni.show', $alumnus) }}" wire:navigate
                    class="glass-panel interactive-card group block overflow-hidden p-4">
                    @if ($alumnus->photo_url)
                        <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->name }}"
                            class="h-52 w-full rounded-xl object-cover">
                    @else
                        <div class="avatar-fallback h-52 w-full rounded-xl">{{ $alumnus->initials }}</div>
                    @endif
                    <div class="mt-4 space-y-1.5">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <p class="font-display text-xl text-gray-900">{{ $alumnus->name }}</p>
                            <div class="flex flex-wrap gap-1.5">
                                @if ($alumnus->is_featured)
                                    <span class="badge-pill">Featured</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm font-medium" style="color:var(--brand-deep)">
                            {{ $alumnus->program }} · {{ $alumnus->batch_year }}
                        </p>
                        @if($alumnus->job_title || $alumnus->employer)
                            <p class="text-sm text-gray-600">
                                {{ $alumnus->job_title }}@if($alumnus->job_title && $alumnus->employer) di @endif{{ $alumnus->employer }}
                            </p>
                        @endif
                        @if($alumnus->city)
                            <p class="text-xs text-gray-400">{{ $alumnus->city }}@if($alumnus->province), {{ $alumnus->province }}@endif</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="glass-panel col-span-full py-16 text-center">
                    <p class="text-gray-400">Tidak ada alumni yang cocok dengan filter yang dipilih.</p>
                    <button wire:click="clearFilters" type="button" class="purple-btn mt-4">Reset filter</button>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $alumni->links() }}</div>
    </section>

    {{-- CTA Update --}}
    <section class="section-shell mt-12">
        <div class="glass-panel flex flex-col items-start gap-5 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="section-eyebrow">Update Data Alumni</p>
                <h2 class="mt-1 font-display text-2xl text-gray-900">Profil Anda sudah ada di sini?</h2>
                <p class="mt-1 text-sm text-gray-500">Login dan perbarui informasi karier, foto, dan profil Anda.</p>
            </div>
            @auth
                <a href="{{ route('alumni.update-profile') }}" wire:navigate class="purple-btn flex-shrink-0">Update Profil</a>
            @else
                <a href="{{ route('register') }}" wire:navigate class="purple-btn flex-shrink-0">Daftar Sekarang</a>
            @endauth
        </div>
    </section>
</div>
