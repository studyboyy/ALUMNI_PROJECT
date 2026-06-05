@section('title', 'Kelola Testimoni')

<div class="space-y-6">

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="section-eyebrow">Admin Panel</p>
            <h1 class="section-title">Testimoni Alumni</h1>
            <p class="mt-1 text-sm" style="color:var(--ink-muted)">Kelola kutipan testimoni alumni yang tampil di beranda.</p>
        </div>
        @if (!$showForm)
            <button wire:click="create" type="button" class="purple-btn">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Testimoni
            </button>
        @endif
    </div>

    @if ($showForm)
        <div class="glass-panel p-6">
            <h2 class="mb-5 text-base font-semibold" style="color:var(--ink)">
                {{ $editingId ? 'Edit Testimoni' : 'Tambah Testimoni Baru' }}
            </h2>
            <form wire:submit="save" class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama <span class="required">*</span></label>
                        <input wire:model="name" type="text" class="input-shell" placeholder="Raka Pratama">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jabatan / Profesi <span class="required">*</span></label>
                        <input wire:model="role" type="text" class="input-shell" placeholder="Software Engineer">
                        @error('role') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Perusahaan</label>
                        <input wire:model="company" type="text" class="input-shell" placeholder="Tokopedia">
                        @error('company') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Angkatan</label>
                        <input wire:model="batch_year" type="number" class="input-shell" placeholder="2018">
                        @error('batch_year') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group sm:col-span-2">
                        <label class="form-label">Kutipan / Testimoni <span class="required">*</span></label>
                        <textarea wire:model="quote" rows="3" class="input-shell"
                            placeholder="Tuliskan kutipan inspiratif dari alumni…"></textarea>
                        @error('quote') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Foto --}}
                <div class="form-group">
                    <label class="form-label">Foto</label>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                        <div class="flex flex-col items-center gap-1.5">
                            @if ($photo_file)
                                <img src="{{ $photo_file->temporaryUrl() }}" class="h-16 w-16 rounded-full object-cover border" style="border-color:var(--border-md)">
                                <span class="text-xs" style="color:var(--ink-muted)">Preview</span>
                            @elseif ($photo_url)
                                <img src="{{ $photo_url }}" class="h-16 w-16 rounded-full object-cover border" style="border-color:var(--border-md)">
                                <span class="text-xs" style="color:var(--ink-muted)">Saat ini</span>
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-full" style="background:var(--bg-base);border:1px dashed var(--border-md)">
                                    <svg class="h-7 w-7" style="color:var(--border-md)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 space-y-3">
                            <input wire:model="photo_file" type="file" accept="image/*"
                                class="block w-full text-sm file:mr-3 file:cursor-pointer file:rounded-lg file:border-0 file:px-3 file:py-2 file:text-sm file:font-medium" style="color:var(--ink-muted)">
                            <div class="form-group">
                                <label class="form-label">atau URL Foto</label>
                                <input wire:model="photo_url" type="url" class="input-shell" placeholder="https://…">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group w-32">
                    <label class="form-label">Urutan</label>
                    <input wire:model="sort_order" type="number" class="input-shell" min="0" placeholder="0">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editingId ? 'Simpan Perubahan' : 'Tambah Testimoni' }}</span>
                        <span wire:loading>Menyimpan…</span>
                    </button>
                    <button type="button" wire:click="cancel" class="ghost-btn">Batal</button>
                </div>
            </form>
        </div>
    @endif

    @if ($testimonials->isEmpty())
        <div class="glass-panel py-12 text-center text-sm" style="color:var(--ink-muted)">
            Belum ada testimoni. Tambahkan testimoni pertama.
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($testimonials as $t)
                <article class="glass-panel p-5">
                    <div class="flex items-center gap-3">
                        @if ($t->photo_url)
                            <img src="{{ $t->photo_url }}" alt="{{ $t->name }}"
                                class="h-12 w-12 flex-shrink-0 rounded-full object-cover">
                        @else
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full font-bold"
                                style="background:var(--brand-soft);color:var(--brand-deep)">
                                {{ mb_strtoupper(mb_substr($t->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="font-semibold truncate" style="color:var(--ink)">{{ $t->name }}</p>
                            <p class="text-xs truncate" style="color:var(--ink-muted)">
                                {{ $t->role }}@if($t->company) · {{ $t->company }}@endif
                            </p>
                        </div>
                    </div>
                    <p class="mt-3 text-sm italic leading-relaxed line-clamp-3" style="color:var(--ink-muted)">"{{ $t->quote }}"</p>
                    <div class="mt-4 flex items-center justify-between border-t pt-3" style="border-color:var(--border)">
                        <span class="text-xs" style="color:var(--ink-muted)">
                            @if($t->batch_year) Angkatan {{ $t->batch_year }} · @endif Urutan {{ $t->sort_order }}
                        </span>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $t->id }})" type="button"
                                class="ghost-btn px-3 py-1.5 text-xs">Edit</button>
                            <button wire:click="delete({{ $t->id }})"
                                wire:confirm="Hapus testimoni dari {{ $t->name }}?"
                                type="button"
                                class="rounded-lg border px-3 py-1.5 text-xs font-semibold transition hover:bg-red-50"
                                style="border-color:#fca5a5;color:#ef4444">Hapus</button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
