@section('title', 'Kelola Berita')

<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="section-eyebrow">Admin Panel</p>
            <h1 class="section-title">Kelola Berita & Artikel</h1>
            <p class="mt-1 text-sm" style="color:var(--ink-muted)">Buat, edit, dan publish berita alumni.</p>
        </div>
        <a href="{{ route('news.index') }}" wire:navigate class="ghost-btn">
            Lihat halaman berita publik
        </a>
    </div>

    {{-- Form --}}
    <div class="glass-panel p-6">
        <h2 class="mb-5 text-base font-semibold" style="color:var(--ink)">
            {{ $editingId ? 'Edit Berita' : 'Buat Berita Baru' }}
        </h2>

        <div class="space-y-5">

            {{-- Judul + Kategori --}}
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="form-group">
                    <label class="form-label">Judul Berita <span class="required">*</span></label>
                    <input wire:model.blur="title" type="text" class="input-shell"
                        placeholder="Judul berita yang menarik…">
                    @error('title') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select wire:model="category" class="input-shell">
                        <option>Berita</option>
                        <option>Agenda</option>
                        <option>Prestasi</option>
                        <option>Kolaborasi</option>
                        <option>Workshop</option>
                    </select>
                </div>
            </div>

            {{-- Cover Image --}}
            <div class="form-group">
                <label class="form-label">Cover Image</label>
                <div class="grid gap-3 sm:grid-cols-2">
                    <input wire:model.blur="coverImageUrl" type="url" class="input-shell"
                        placeholder="https://… atau upload file di samping">
                    <input wire:model="coverImageFile" type="file" accept="image/*"
                        class="block w-full text-sm file:mr-3 file:cursor-pointer file:rounded-lg file:border-0 file:px-3 file:py-2 file:text-sm file:font-medium"
                        style="color:var(--ink-muted)">
                </div>
                @if ($coverImageFile)
                    <img src="{{ $coverImageFile->temporaryUrl() }}" alt="Preview"
                        class="mt-3 h-32 w-full rounded-xl object-cover border" style="border-color:var(--border)">
                @elseif ($coverImageUrl)
                    <img src="{{ $coverImageUrl }}" alt="Preview"
                        class="mt-3 h-32 w-full rounded-xl object-cover border" style="border-color:var(--border)">
                @endif
                @error('coverImageUrl') <span class="form-error">{{ $message }}</span> @enderror
                @error('coverImageFile') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Quill Editor --}}
            <div class="form-group">
                <label class="form-label">Isi Berita <span class="required">*</span></label>

                {{-- wire:ignore supaya Livewire tidak re-render area Quill --}}
                <div wire:ignore class="quill-container">
                    <div id="quill-editor-wrapper"
                        class="ql-container-reset"
                        data-content="{{ htmlspecialchars($content, ENT_QUOTES, 'UTF-8') }}">
                    </div>
                </div>

                @error('content') <span class="form-error mt-2">{{ $message }}</span> @enderror
            </div>

            {{-- Options --}}
            <div class="flex flex-wrap items-center gap-6">
                <label class="flex cursor-pointer items-center gap-2.5 text-sm font-medium" style="color:var(--ink-2)">
                    <input wire:model="isFeatured" type="checkbox"
                        class="h-4 w-4 rounded" style="accent-color:var(--brand)">
                    Featured
                </label>
                <label class="flex cursor-pointer items-center gap-2.5 text-sm font-medium" style="color:var(--ink-2)">
                    <input wire:model="publishNow" type="checkbox"
                        class="h-4 w-4 rounded" style="accent-color:var(--brand)">
                    Publish sekarang
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-3 border-t pt-5" style="border-color:var(--border)">
                @if ($editingId)
                    <button wire:click="update" type="button" class="purple-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                        <span wire:loading wire:target="update">Menyimpan…</span>
                    </button>
                    <button wire:click="resetForm" type="button" class="ghost-btn">Batal Edit</button>
                @else
                    <button wire:click="create" type="button" class="purple-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="create">Buat Berita</span>
                        <span wire:loading wire:target="create">Menyimpan…</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Daftar Berita --}}
    <div>
        <div class="mb-4 flex items-end justify-between">
            <div>
                <p class="section-eyebrow">Daftar Berita</p>
                <h2 class="section-title">Semua artikel yang ada.</h2>
            </div>
        </div>

        <div class="space-y-3">
            @forelse ($articles as $article)
                <article class="glass-panel p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="badge-pill">{{ $article->category }}</span>
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold
                                    {{ $article->published_at ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $article->published_at ? 'Published' : 'Draft' }}
                                </span>
                                @if ($article->is_featured)
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                        style="background:var(--brand-soft);color:var(--brand-deep)">Featured</span>
                                @endif
                            </div>
                            <p class="font-sans text-xl" style="color:var(--ink)">{{ $article->title }}</p>
                            <p class="mt-1 text-sm line-clamp-2" style="color:var(--ink-muted)">{{ $article->excerpt }}</p>
                            @if ($article->published_at)
                                <p class="mt-1 text-xs" style="color:var(--ink-muted)">
                                    {{ $article->published_at->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                        <div class="flex flex-shrink-0 flex-wrap gap-2">
                            <button wire:click="edit({{ $article->id }})" type="button"
                                class="ghost-btn px-3 py-1.5 text-xs">Edit</button>
                            <button wire:click="togglePublish({{ $article->id }})" type="button"
                                class="ghost-btn px-3 py-1.5 text-xs">
                                {{ $article->published_at ? 'Unpublish' : 'Publish' }}
                            </button>
                            <button wire:click="delete({{ $article->id }})"
                                wire:confirm="Hapus artikel '{{ $article->title }}'?"
                                type="button"
                                class="rounded-lg border px-3 py-1.5 text-xs font-semibold transition hover:bg-red-50"
                                style="border-color:#fca5a5;color:#ef4444">Hapus</button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="glass-panel py-12 text-center text-sm" style="color:var(--ink-muted)">
                    Belum ada berita. Buat artikel pertama di form di atas.
                </div>
            @endforelse
        </div>

        <div class="mt-5">{{ $articles->links() }}</div>
    </div>
</div>

@push('scripts')
<script>
    // URL upload gambar — disuntikkan dari PHP agar editor.js bisa akses
    window.__uploadImageUrl = @js(route('admin.upload-image'));
</script>
@endpush
