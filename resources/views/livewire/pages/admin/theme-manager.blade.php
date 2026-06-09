@section('title', 'Kelola Tema')

<div class="space-y-8">
    <section class="section-shell">
        <div class="grid gap-5 lg:grid-cols-[1.1fr_0.9fr] lg:items-stretch">
            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow">Pengaturan Situs</p>
                <h1 class="section-title mt-2">Pilih tema warna untuk website.</h1>
                <p class="section-copy mt-3 max-w-2xl">
                    Tema mengganti warna brand utama, hover state, tombol, dan aksen seluruh website secara serentak.
                </p>
            </div>

            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow mb-4">Tema Aktif</p>
                <div class="rounded-2xl border bg-white p-4" style="border-color:var(--border)">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Current</p>
                    <p class="mt-2 text-2xl font-semibold" style="color:var(--ink)">
                        {{ ucfirst($theme) }}
                    </p>
                    <p class="mt-1 text-sm" style="color:var(--ink-muted)">
                        Tema ini sedang diterapkan ke seluruh website.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="mb-5">
            <p class="section-eyebrow">Tema Tersedia</p>
            <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Pilih gaya visual yang paling cocok.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            <button wire:click="setTheme('blue')" type="button"
                class="group text-left transition"
                style="transform:translateZ(0)">
                <div class="glass-panel overflow-hidden p-4 sm:p-5 {{ $theme === 'blue' ? 'ring-2 ring-[color:rgba(var(--brand-rgb),.45)]' : '' }}">
                    <div class="flex h-40 gap-2 overflow-hidden rounded-2xl">
                        <div class="flex-1 bg-gradient-to-b from-[#2563eb] to-[#38bdf8]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#1d4ed8] to-[#06b6d4]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#eff6ff] to-[#dbeafe]"></div>
                    </div>
                    <div class="mt-4 flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold" style="color:var(--ink)">Aurora Blue</h3>
                            <p class="mt-1 text-sm leading-6" style="color:var(--ink-muted)">Bersih, modern, dan terasa lebih profesional untuk dashboard alumni.</p>
                        </div>
                        @if ($theme === 'blue')
                            <span class="rounded-full px-3 py-1 text-xs font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                                Aktif
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background:#2563eb">Blue</span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background:#06b6d4">Cyan</span>
                    </div>
                </div>
            </button>

            <button wire:click="setTheme('mint')" type="button"
                class="group text-left transition"
                style="transform:translateZ(0)">
                <div class="glass-panel overflow-hidden p-4 sm:p-5 {{ $theme === 'mint' ? 'ring-2 ring-[color:rgba(var(--brand-rgb),.45)]' : '' }}">
                    <div class="flex h-40 gap-2 overflow-hidden rounded-2xl">
                        <div class="flex-1 bg-gradient-to-b from-[#2ecc71] to-[#27ae60]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#1e8449] to-[#2ecc71]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#eafaf1] to-[#d5f4e6]"></div>
                    </div>
                    <div class="mt-4 flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold" style="color:var(--ink)">Aurora Mint</h3>
                            <p class="mt-1 text-sm leading-6" style="color:var(--ink-muted)">Segar, tenang, dan terasa lebih ringan di layar.</p>
                        </div>
                        @if ($theme === 'mint')
                            <span class="rounded-full px-3 py-1 text-xs font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                                Aktif
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background:#2ecc71">Green</span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background:#27ae60">Teal</span>
                    </div>
                </div>
            </button>

            <button wire:click="setTheme('indigo')" type="button"
                class="group text-left transition"
                style="transform:translateZ(0)">
                <div class="glass-panel overflow-hidden p-4 sm:p-5 {{ $theme === 'indigo' ? 'ring-2 ring-[color:rgba(var(--brand-rgb),.45)]' : '' }}">
                    <div class="flex h-40 gap-2 overflow-hidden rounded-2xl">
                        <div class="flex-1 bg-gradient-to-b from-[#5b5bd6] to-[#6366f1]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#4f46e5] to-[#5b5bd6]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#eef2ff] to-[#e0e7ff]"></div>
                    </div>
                    <div class="mt-4 flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold" style="color:var(--ink)">Aurora Indigo</h3>
                            <p class="mt-1 text-sm leading-6" style="color:var(--ink-muted)">Profesional, modern, dan paling dekat dengan brand default.</p>
                        </div>
                        @if ($theme === 'indigo')
                            <span class="rounded-full px-3 py-1 text-xs font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                                Aktif
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background:#5b5bd6">Indigo</span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background:#6366f1">Purple</span>
                    </div>
                </div>
            </button>
        </div>
    </section>

    <section class="section-shell">
        <div class="glass-panel p-6">
            <p class="section-eyebrow mb-3">Informasi Tema</p>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    'Tema akan langsung diterapkan ke seluruh website setelah dipilih',
                    'Perubahan tema berlaku untuk semua pengunjung website',
                    'Semua fitur dan animasi tetap berfungsi di semua tema',
                    'Warna brand otomatis menyesuaikan pada tombol, link, dan hover state',
                    'Saat ini tema default tetap paling stabil untuk konsistensi visual',
                ] as $item)
                    <div class="rounded-2xl border bg-white p-4 text-sm leading-6" style="border-color:var(--border);color:var(--ink-2)">
                        {{ $item }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
