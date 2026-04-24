@section('title', 'Kelola Tema')

<div class="space-y-8">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Pengaturan Situs</p>
                <h1 class="section-title">Pilih tema warna untuk website.</h1>
            </div>
        </div>
    </section>

    <section>
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-slate-900">Tema Tersedia</h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Aurora Coral -->
                <button wire:click="setTheme('coral')" type="button"
                    class="group rounded-2xl border-2 p-6 transition {{ $theme === 'coral' ? 'border-violet-400 bg-violet-50' : 'border-slate-200 hover:border-violet-300' }}">
                    <div class="flex h-24 gap-2 rounded-lg overflow-hidden mb-4">
                        <div class="flex-1 bg-gradient-to-b from-[#e85d57] to-[#ff8a65]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#c64640] to-[#e85d57]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#fff1ec] to-[#ffe5e0]"></div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Aurora Coral</h3>
                    <p class="mt-1 text-sm text-slate-600">Tema merah-oranye yang hangat dan energik</p>
                    <div class="mt-3 flex gap-2">
                        <span
                            class="inline-block rounded-full bg-[#e85d57] px-3 py-1 text-xs font-medium text-white">Coral</span>
                        <span
                            class="inline-block rounded-full bg-[#ff8a65] px-3 py-1 text-xs font-medium text-white">Peach</span>
                    </div>
                    @if ($theme === 'coral')
                        <div class="mt-4 flex items-center gap-2 text-violet-600 font-medium text-sm">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                            </svg>
                            Tema Aktif
                        </div>
                    @endif
                </button>

                <!-- Aurora Mint -->
                <button wire:click="setTheme('mint')" type="button"
                    class="group rounded-2xl border-2 p-6 transition {{ $theme === 'mint' ? 'border-violet-400 bg-violet-50' : 'border-slate-200 hover:border-violet-300' }}">
                    <div class="flex h-24 gap-2 rounded-lg overflow-hidden mb-4">
                        <div class="flex-1 bg-gradient-to-b from-[#2ecc71] to-[#27ae60]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#1e8449] to-[#2ecc71]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#eafaf1] to-[#d5f4e6]"></div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Aurora Mint</h3>
                    <p class="mt-1 text-sm text-slate-600">Tema hijau yang segar dan menenangkan</p>
                    <div class="mt-3 flex gap-2">
                        <span
                            class="inline-block rounded-full bg-[#2ecc71] px-3 py-1 text-xs font-medium text-white">Green</span>
                        <span
                            class="inline-block rounded-full bg-[#27ae60] px-3 py-1 text-xs font-medium text-white">Teal</span>
                    </div>
                    @if ($theme === 'mint')
                        <div class="mt-4 flex items-center gap-2 text-violet-600 font-medium text-sm">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                            </svg>
                            Tema Aktif
                        </div>
                    @endif
                </button>

                <!-- Aurora Indigo -->
                <button wire:click="setTheme('indigo')" type="button"
                    class="group rounded-2xl border-2 p-6 transition {{ $theme === 'indigo' ? 'border-violet-400 bg-violet-50' : 'border-slate-200 hover:border-violet-300' }}">
                    <div class="flex h-24 gap-2 rounded-lg overflow-hidden mb-4">
                        <div class="flex-1 bg-gradient-to-b from-[#5b5bd6] to-[#6366f1]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#4f46e5] to-[#5b5bd6]"></div>
                        <div class="flex-1 bg-gradient-to-b from-[#eef2ff] to-[#e0e7ff]"></div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Aurora Indigo</h3>
                    <p class="mt-1 text-sm text-slate-600">Tema biru-ungu yang profesional dan modern</p>
                    <div class="mt-3 flex gap-2">
                        <span
                            class="inline-block rounded-full bg-[#5b5bd6] px-3 py-1 text-xs font-medium text-white">Indigo</span>
                        <span
                            class="inline-block rounded-full bg-[#6366f1] px-3 py-1 text-xs font-medium text-white">Purple</span>
                    </div>
                    @if ($theme === 'indigo')
                        <div class="mt-4 flex items-center gap-2 text-violet-600 font-medium text-sm">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                            </svg>
                            Tema Aktif
                        </div>
                    @endif
                </button>
            </div>
        </div>
    </section>

    <!-- Info -->
    <section>
        <div class="glass-panel p-6">
            <h3 class="mb-3 text-lg font-semibold text-slate-900">ℹ️ Informasi Tema</h3>
            <div class="space-y-2 text-sm text-slate-600">
                <p>✓ Tema akan langsung diterapkan ke seluruh website setelah dipilih</p>
                <p>✓ Perubahan tema berlaku untuk semua pengunjung website</p>
                <p>✓ Semua fitur dan animasi tetap berfungsi dengan baik di semua tema</p>
                <p>✓ Warna brand akan secara otomatis disesuaikan di buttons, links, hover states, dan elemen lainnya
                </p>
            </div>
        </div>
    </section>
</div>
