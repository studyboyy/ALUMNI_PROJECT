@section('title', 'Data Alumni FTI')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-5">
            <p class="section-eyebrow">Data Alumni</p>
            <h1 class="section-title max-w-2xl">Direktori alumni yang bisa difilter berdasarkan angkatan, prodi, dan
                tempat kerja.</h1>
            <p class="section-copy">Semua filter di halaman ini disimpan ke URL sehingga mudah dibagikan dan konsisten
                dengan pola aplikasi Livewire modern.</p>
        </div>
        <div class="glass-panel p-6">
            <p class="font-display text-3xl text-slate-900">Statistik industri</p>
            <div class="mt-4 space-y-3">
                @foreach ($industryStats as $item)
                    <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                        <span>{{ $item->industry }}</span>
                        <span class="font-semibold text-slate-900">{{ $item->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="glass-panel p-6">
            <div class="grid gap-4 lg:grid-cols-[1.4fr_1fr_1fr_1fr_auto]">
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Cari nama atau pekerjaan</span>
                    <input wire:model.live.debounce.300ms="search" type="text" class="input-shell"
                        placeholder="Mis. Raka, engineer, Jakarta">
                </label>
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Program Studi</span>
                    <select wire:model.live="program" class="input-shell">
                        <option value="">Semua prodi</option>
                        @foreach ($programs as $programOption)
                            <option value="{{ $programOption }}">{{ $programOption }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Angkatan</span>
                    <select wire:model.live="batchYear" class="input-shell">
                        <option value="">Semua angkatan</option>
                        @foreach ($batchYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Tempat kerja</span>
                    <input wire:model.live.debounce.300ms="employer" type="text" class="input-shell"
                        placeholder="Mis. Tokopedia">
                </label>
                <button wire:click="clearFilters" type="button"
                    class="rounded-full border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Reset</button>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="card-grid-tight lg:grid-cols-3">
            @forelse ($alumni as $alumnus)
                <a href="{{ route('alumni.show', $alumnus) }}" wire:navigate
                    class="glass-panel interactive-card block overflow-hidden p-4">
                    <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->name }}"
                        class="h-60 w-full rounded-[1.5rem] object-cover">
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-display text-2xl text-slate-900">{{ $alumnus->name }}</p>
                            @if ($alumnus->is_featured)
                                <span class="badge-pill">Featured</span>
                            @endif
                        </div>
                        <p class="text-sm text-violet-700">{{ $alumnus->program }} · Angkatan
                            {{ $alumnus->batch_year }}</p>
                        <p class="text-sm text-slate-500">{{ $alumnus->campus_name ?: 'Kampus belum diisi' }}</p>
                        <p class="text-sm text-slate-600">{{ $alumnus->job_title }} di {{ $alumnus->employer }}</p>
                        <p class="text-sm leading-7 text-slate-500">{{ $alumnus->city }}, {{ $alumnus->province }}</p>
                    </div>
                </a>
            @empty
                <div class="glass-panel col-span-full p-8 text-center text-slate-500">Belum ada alumni yang cocok dengan
                    filter yang dipilih.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $alumni->links() }}</div>
    </section>

    <section id="update-data" class="section-shell">
        <div class="glass-panel grid gap-6 p-6 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <p class="section-eyebrow">Update Data Alumni</p>
                <h2 class="section-title">Kelola profil alumni langsung dari dashboard internal.</h2>
                <p class="section-copy">Alumni bisa mendaftar, login, lalu memperbarui data profil tanpa perlu formulir eksternal.</p>
            </div>
            @auth
                <a href="{{ route('alumni.update-profile') }}" wire:navigate class="purple-btn">Update Profil Saya</a>
            @else
                <a href="{{ route('register') }}" wire:navigate class="purple-btn">Join Alumni</a>
            @endauth
        </div>
    </section>
</div>
