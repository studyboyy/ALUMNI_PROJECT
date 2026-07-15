@section('title', 'Kelola Galeri & Media')

<div class="w-full space-y-8">
    <section class="w-full">
        <div class="grid gap-5 lg:grid-cols-[1.08fr_0.92fr] lg:items-stretch">
            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow">Galeri & Media</p>
                <h1 class="section-title mt-2">Kelola Galeri publik dan aset website.</h1>
                <p class="section-copy mt-3 max-w-2xl">
                    Media yang dipublikasikan di sini langsung tampil pada Galeri di halaman Berita & Agenda.
                </p>
            </div>

            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow mb-4">Ringkasan</p>
                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    <div class="rounded-2xl border bg-white px-4 py-3" style="border-color:var(--border)">
                        <p class="text-[0.65rem] font-semibold uppercase tracking-widest text-gray-400">Item Galeri</p>
                        <p class="mt-1 text-2xl font-semibold" style="color:var(--ink)">{{ $galleryItems->count() }}</p>
                    </div>
                    <div class="rounded-2xl border bg-white px-4 py-3" style="border-color:var(--border)">
                        <p class="text-[0.65rem] font-semibold uppercase tracking-widest text-gray-400">Kategori</p>
                        <p class="mt-1 text-2xl font-semibold" style="color:var(--ink)">{{ $categoryCount }}</p>
                    </div>
                    <div class="rounded-2xl border bg-white px-4 py-3" style="border-color:var(--border)">
                        <p class="text-[0.65rem] font-semibold uppercase tracking-widest text-gray-400">Aksi cepat</p>
                        <p class="mt-1 text-sm font-medium" style="color:var(--ink-muted)">Salin URL / hapus media</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full">
        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="glass-panel p-6">
                <div class="mb-4 flex items-end justify-between gap-4">
                    <div>
                        <p class="section-eyebrow">Upload Media</p>
                        <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Tambah gambar baru</h2>
                    </div>
                </div>

                <form wire:submit="upload" class="space-y-4">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Judul Galeri</span>
                        <input wire:model="title" type="text" class="input-shell" placeholder="Contoh: Reuni Akbar Alumni">
                        @error('title') <span class="form-error">{{ $message }}</span> @enderror
                    </label>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Nama kegiatan <span class="text-slate-400">(opsional)</span></span>
                            <input wire:model="eventName" type="text" class="input-shell" placeholder="Nama kegiatan">
                        </label>
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Keterangan <span class="text-slate-400">(opsional)</span></span>
                            <input wire:model="caption" type="text" class="input-shell" placeholder="Keterangan singkat">
                        </label>
                    </div>

                    <label class="block">
                        <input wire:model="file" type="file" accept="image/*" class="sr-only">
                        <div
                            class="flex cursor-pointer flex-col items-center gap-3 rounded-2xl border-2 border-dashed px-6 py-10 text-center transition"
                            style="border-color:rgba(var(--brand-rgb),.2);background:linear-gradient(180deg,rgba(var(--brand-rgb),.04),rgba(var(--brand-rgb),.02))">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl" style="background:var(--brand-soft)">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--brand)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" style="color:var(--ink)">
                                    {{ $file ? 'File: ' . $file->getClientOriginalName() : 'Klik atau drag gambar ke sini' }}
                                </p>
                                <p class="mt-1 text-sm" style="color:var(--ink-muted)">JPG, PNG, GIF, WebP. Maks 10MB</p>
                            </div>
                        </div>
                    </label>

                    @if ($file)
                        <div class="flex gap-3">
                            <button type="submit" class="purple-btn flex-1">Upload Gambar</button>
                            <button type="button" wire:click="$set('file', null)" class="outline-btn">Batal</button>
                        </div>
                    @endif

                    <label class="flex items-center gap-3 text-sm" style="color:var(--ink-2)">
                        <input wire:model="publishNow" type="checkbox" class="h-4 w-4 rounded border-gray-300">
                        Tampilkan langsung di Galeri publik
                    </label>
                </form>
            </div>

            <div class="glass-panel p-6">
                <div class="mb-4 flex items-end justify-between gap-4">
                    <div>
                        <p class="section-eyebrow">Filter</p>
                        <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Cari dan sortir media</h2>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-3">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Cari gambar</span>
                        <input wire:model="searchQuery" type="text" class="input-shell" placeholder="Nama file...">
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Kategori</span>
                        <select wire:model="selectedCategory" class="input-shell">
                            <option value="all">Semua Kategori</option>
                            <option value="gallery-images">Galeri Publik</option>
                            <option value="alumni-photos">Foto Alumni</option>
                            <option value="news-images">Gambar Berita</option>
                            <option value="homepage-images">Gambar Homepage</option>
                        </select>
                    </label>

                    <div class="rounded-2xl border bg-white px-4 py-3" style="border-color:var(--border)">
                        <span class="block text-xs font-semibold uppercase tracking-widest text-gray-400">Total Gambar</span>
                        <span class="mt-2 block text-2xl font-semibold" style="color:var(--ink)">{{ count($images) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full">
        <div class="mb-4 flex items-end justify-between gap-4">
            <div>
                <p class="section-eyebrow">Galeri Publik</p>
                <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Konten yang terhubung ke halaman pengguna</h2>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($galleryItems as $item)
                <article class="overflow-hidden rounded-xl border bg-white" style="border-color:var(--border)">
                    <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="aspect-[4/3] w-full object-cover">
                    <div class="space-y-3 p-4">
                        <div>
                            <p class="font-semibold" style="color:var(--ink)">{{ $item->title }}</p>
                            <p class="mt-1 text-xs" style="color:var(--ink-muted)">{{ $item->event_name ?: 'Tanpa nama kegiatan' }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="toggleGalleryPublication({{ $item->id }})" class="outline-btn text-xs">
                                {{ $item->published_at ? 'Sembunyikan' : 'Tampilkan' }}
                            </button>
                            <button type="button" wire:click="deleteGalleryItem({{ $item->id }})" wire:confirm="Hapus item Galeri ini?" class="ghost-btn text-xs text-rose-600">
                                Hapus
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="glass-panel col-span-full px-8 py-12 text-center">
                    <p class="font-semibold" style="color:var(--ink)">Belum ada item Galeri</p>
                    <p class="mt-1 text-sm" style="color:var(--ink-muted)">Upload media untuk menampilkannya di halaman Berita & Agenda.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="w-full">
        @if (count($images) === 0)
            <div class="glass-panel px-8 py-16 text-center">
                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl" style="background:var(--brand-soft)">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--brand)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="font-semibold" style="color:var(--ink)">Tidak ada gambar</p>
                <p class="mt-1 text-sm" style="color:var(--ink-muted)">Upload gambar terlebih dahulu atau ubah filter pencarian Anda.</p>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($images as $image)
                    <article class="group overflow-hidden rounded-2xl border bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="border-color:var(--border)">
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ $image['url'] }}" alt="{{ $image['name'] }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                            <div class="absolute inset-x-0 top-0 flex justify-between p-3">
                                <span class="rounded-full border bg-white/90 px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wider backdrop-blur-sm"
                                    style="border-color:rgba(255,255,255,.35);color:var(--brand-deep)">
                                    {{ Str::replaceLast('-', ' ', $image['category']) }}
                                </span>
                                <span class="rounded-full bg-black/30 px-2.5 py-1 text-[0.65rem] font-semibold text-white backdrop-blur-sm">
                                    {{ number_format($image['size'] / 1024, 1) }} KB
                                </span>
                            </div>

                            <div class="absolute inset-0 flex items-end justify-between gap-2 bg-gradient-to-t from-black/55 via-black/0 to-transparent p-3 opacity-0 transition group-hover:opacity-100">
                                <button wire:click="copyUrl('{{ $image['url'] }}')" type="button" title="Salin URL"
                                    class="rounded-full bg-white/20 p-2 text-white backdrop-blur transition hover:bg-white/30">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <button wire:click="delete('{{ $image['path'] }}')" type="button" title="Hapus"
                                    class="rounded-full bg-rose-500/85 p-2 text-white backdrop-blur transition hover:bg-rose-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2 p-4">
                            <p class="truncate text-sm font-semibold" title="{{ $image['name'] }}" style="color:var(--ink)">
                                {{ Str::limit($image['name'], 30) }}
                            </p>
                            <div class="flex items-center justify-between gap-3">
                                <span class="truncate text-xs" style="color:var(--ink-muted)">
                                    {{ basename($image['path']) }}
                                </span>
                                <span class="rounded-full px-2 py-1 text-[0.65rem] font-semibold uppercase tracking-wider" style="background:var(--brand-soft);color:var(--brand-deep)">
                                    Media
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="w-full">
        <div class="glass-panel p-6">
            <div class="mb-3 flex items-center gap-2">
                <span class="section-eyebrow">Informasi Media</span>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    'Kelola semua gambar dari satu tempat',
                    'Salin URL gambar dengan mudah untuk editor atau field lainnya',
                    'Gambar otomatis diorganisir berdasarkan kategori',
                    'Hapus gambar yang tidak diperlukan untuk menghemat storage',
                    'Ukuran file maksimal: 10MB per gambar',
                    'Cocok untuk berita, homepage, dan profil alumni',
                ] as $item)
                    <div class="rounded-2xl border bg-white p-4 text-sm leading-6" style="border-color:var(--border);color:var(--ink-2)">
                        {{ $item }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
