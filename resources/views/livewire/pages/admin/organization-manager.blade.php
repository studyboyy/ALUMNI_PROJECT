@section('title', 'Kelola Struktur Organisasi')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="section-eyebrow">Admin Panel</p>
            <h1 class="section-title">Struktur Organisasi</h1>
            <p class="mt-1 text-sm" style="color:var(--ink-muted)">Kelola data pengurus Ikatan Alumni FTI.</p>
        </div>
        @if (!$showForm)
            <button wire:click="create" type="button" class="purple-btn">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengurus
            </button>
        @endif
    </div>

    {{-- Form --}}
    @if ($showForm)
        <div class="glass-panel p-6">
            <h2 class="mb-5 text-base font-semibold" style="color:var(--ink)">
                {{ $editingId ? 'Edit Pengurus' : 'Tambah Pengurus Baru' }}
            </h2>
            <form wire:submit="save" class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input wire:model="name" type="text" class="input-shell" placeholder="Dr. Hendra Wijaya">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jabatan / Peran <span class="required">*</span></label>
                        <input wire:model="role" type="text" class="input-shell" placeholder="Ketua Ikatan Alumni">
                        @error('role') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Divisi / Bidang <span class="required">*</span></label>
                        <input wire:model="division" type="text" class="input-shell" placeholder="Pengurus Harian">
                        @error('division') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Periode <span class="required">*</span></label>
                        <input wire:model="period" type="text" class="input-shell" placeholder="2025–2029">
                        @error('period') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group sm:col-span-2">
                        <label class="form-label">Fokus / Area Kerja</label>
                        <input wire:model="focus_area" type="text" class="input-shell"
                            placeholder="Penguatan jejaring dan kemitraan industri">
                        @error('focus_area') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Foto --}}
                <div class="form-group">
                    <label class="form-label">Foto</label>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                        <div class="flex flex-col items-center gap-1.5">
                            @if ($photo_file)
                                <img src="{{ $photo_file->temporaryUrl() }}" class="h-20 w-20 rounded-xl object-cover border" style="border-color:var(--border-md)">
                                <span class="text-xs" style="color:var(--ink-muted)">Preview baru</span>
                            @elseif ($photo_url)
                                <img src="{{ $photo_url }}" class="h-20 w-20 rounded-xl object-cover border" style="border-color:var(--border-md)">
                                <span class="text-xs" style="color:var(--ink-muted)">Foto saat ini</span>
                            @else
                                <div class="flex h-20 w-20 items-center justify-center rounded-xl" style="background:var(--bg-base);border:1px dashed var(--border-md)">
                                    <svg class="h-8 w-8" style="color:var(--border-md)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            @error('photo_file') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group w-32">
                    <label class="form-label">Urutan</label>
                    <input wire:model="sort_order" type="number" class="input-shell" min="0" placeholder="0">
                    <p class="form-hint">Semakin kecil, semakin awal ditampilkan</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editingId ? 'Simpan Perubahan' : 'Tambah Pengurus' }}</span>
                        <span wire:loading>Menyimpan…</span>
                    </button>
                    <button type="button" wire:click="cancel" class="ghost-btn">Batal</button>
                </div>
            </form>
        </div>
    @endif

    {{-- List --}}
    @if ($members->isEmpty())
        <div class="glass-panel py-12 text-center text-sm" style="color:var(--ink-muted)">
            Belum ada data pengurus. Tambahkan pengurus pertama.
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($members as $member)
                <article class="glass-panel flex flex-col gap-4 p-5">
                    <div class="flex items-center gap-3">
                        @if ($member->photo_url)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                class="h-14 w-14 flex-shrink-0 rounded-xl object-cover">
                        @else
                            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl text-lg font-bold"
                                style="background:var(--brand-soft);color:var(--brand-deep)">
                                {{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="font-semibold truncate" style="color:var(--ink)">{{ $member->name }}</p>
                            <p class="text-sm truncate" style="color:var(--brand-deep)">{{ $member->role }}</p>
                            <p class="text-xs" style="color:var(--ink-muted)">{{ $member->division }}</p>
                        </div>
                    </div>
                    @if ($member->focus_area)
                        <p class="text-sm" style="color:var(--ink-muted)">{{ $member->focus_area }}</p>
                    @endif
                    <div class="flex items-center justify-between border-t pt-3" style="border-color:var(--border)">
                        <span class="text-xs" style="color:var(--ink-muted)">{{ $member->period }} · Urutan {{ $member->sort_order }}</span>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $member->id }})" type="button"
                                class="ghost-btn px-3 py-1.5 text-xs">Edit</button>
                            <button wire:click="delete({{ $member->id }})"
                                wire:confirm="Hapus pengurus {{ $member->name }}?"
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
