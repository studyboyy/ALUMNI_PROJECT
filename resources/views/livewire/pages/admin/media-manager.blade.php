@section('title', 'Kelola Media')

<div class="space-y-8">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Media Gallery</p>
                <h1 class="section-title">Tempat terpusat untuk mengelola semua gambar di website.</h1>
            </div>
        </div>
    </section>

    <!-- Upload Section -->
    <section>
        <div class="glass-panel p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Upload Gambar Baru</h2>

            <form wire:submit="upload" class="space-y-4">
                <label class="block">
                    <div class="relative">
                        <input wire:model="file" type="file" accept="image/*" class="sr-only">
                        <div
                            class="flex flex-col items-center gap-3 rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-8 cursor-pointer transition hover:border-violet-400 hover:bg-violet-50">
                            <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <div class="text-center">
                                <p class="font-semibold text-slate-700">
                                    {{ $file ? 'File: ' . $file->getClientOriginalName() : 'Klik atau drag gambar ke sini' }}
                                </p>
                                <p class="text-sm text-slate-500">JPG, PNG, GIF, WebP. Max 10MB</p>
                            </div>
                        </div>
                    </div>
                </label>

                @if ($file)
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 purple-btn">Upload Gambar</button>
                        <button type="button" wire:click="$set('file', null)"
                            class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-red-300 hover:text-red-700">Batal</button>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Search & Filter -->
    <section>
        <div class="glass-panel p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Galeri Gambar</h2>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Search -->
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Cari gambar</span>
                    <input wire:model="searchQuery" type="text" class="input-shell" placeholder="Nama file...">
                </label>

                <!-- Category Filter -->
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Kategori</span>
                    <select wire:model="selectedCategory" class="input-shell">
                        <option value="all">Semua Kategori</option>
                        <option value="alumni-photos">Foto Alumni</option>
                        <option value="news-images">Gambar Berita</option>
                        <option value="homepage-images">Gambar Homepage</option>
                    </select>
                </label>

                <!-- Stats -->
                <div class="space-y-2 text-sm text-slate-600">
                    <span class="block">Total Gambar</span>
                    <span
                        class="block rounded-full border border-slate-300 px-4 py-2 text-center font-semibold text-slate-900">
                        {{ count($images) }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section>
        @if (count($images) === 0)
            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-8 py-16 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-4 font-semibold text-slate-600">Tidak ada gambar</p>
                <p class="text-sm text-slate-500">Upload gambar terlebih dahulu atau ubah filter pencarian Anda</p>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($images as $image)
                    <div class="group overflow-hidden rounded-xl border border-slate-200 transition hover:shadow-lg">
                        <!-- Image -->
                        <div class="relative h-40 overflow-hidden bg-slate-100">
                            <img src="{{ $image['url'] }}" alt="{{ $image['name'] }}"
                                class="h-full w-full object-cover transition group-hover:scale-105">

                            <!-- Overlay -->
                            <div
                                class="absolute inset-0 flex items-end justify-between gap-2 bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 transition group-hover:opacity-100">
                                <button wire:click="copyUrl('{{ $image['url'] }}')" type="button" title="Salin URL"
                                    class="rounded-full bg-white/20 p-2 text-white backdrop-blur transition hover:bg-white/30">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <button wire:click="delete('{{ $image['path'] }}')" type="button" title="Hapus"
                                    class="rounded-full bg-rose-500/80 p-2 text-white backdrop-blur transition hover:bg-rose-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="space-y-2 border-t border-slate-200 bg-white p-3">
                            <p class="truncate text-xs font-medium text-slate-900" title="{{ $image['name'] }}">
                                {{ Str::limit($image['name'], 25) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-600">
                                    {{ Str::replaceLast('-', '', $image['category']) }}
                                </span>
                                <span class="text-xs text-slate-500">
                                    {{ number_format($image['size'] / 1024, 1) }}KB
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Info -->
    <section>
        <div class="glass-panel p-6">
            <h3 class="mb-3 text-lg font-semibold text-slate-900">📋 Informasi Media</h3>
            <div class="space-y-2 text-sm text-slate-600">
                <p>✓ Kelola semua gambar dari satu tempat</p>
                <p>✓ Salin URL gambar dengan mudah untuk digunakan di editor atau fields lainnya</p>
                <p>✓ Gambar otomatis diorganisir berdasarkan kategori</p>
                <p>✓ Hapus gambar yang tidak diperlukan untuk menghemat storage</p>
                <p>✓ Ukuran file maksimal: 10MB per gambar</p>
            </div>
        </div>
    </section>
</div>
