@section('title', 'Kelola Program Kerja')

<div class="space-y-6">

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="section-eyebrow">Admin Panel</p>
            <h1 class="section-title">Program Kerja</h1>
            <p class="mt-1 text-sm" style="color:var(--ink-muted)">Kelola program kerja alumni yang tampil di halaman Profil dan Karier.</p>
        </div>
        @if (!$showForm)
            <button wire:click="create" type="button" class="purple-btn">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Program
            </button>
        @endif
    </div>

    @if ($showForm)
        <div class="glass-panel p-6">
            <h2 class="mb-5 text-base font-semibold" style="color:var(--ink)">
                {{ $editingId ? 'Edit Program Kerja' : 'Tambah Program Kerja Baru' }}
            </h2>
            <form wire:submit="save" class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-group sm:col-span-2">
                        <label class="form-label">Judul Program <span class="required">*</span></label>
                        <input wire:model="title" type="text" class="input-shell" placeholder="Mentoring Karier Alumni Muda">
                        @error('title') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori <span class="required">*</span></label>
                        <select wire:model="category" class="input-shell">
                            <option>Karier</option>
                            <option>Kolaborasi</option>
                            <option>Data Alumni</option>
                            <option>Sosial</option>
                            <option>Pendidikan</option>
                            <option>Teknologi</option>
                        </select>
                        @error('category') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="required">*</span></label>
                        <select wire:model="status" class="input-shell">
                            <option>Berjalan</option>
                            <option>Prioritas</option>
                            <option>Perencanaan</option>
                            <option>Selesai</option>
                            <option>Ditunda</option>
                        </select>
                        @error('status') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group sm:col-span-2">
                        <label class="form-label">Ringkasan <span class="required">*</span></label>
                        <textarea wire:model="summary" rows="3" class="input-shell"
                            placeholder="Deskripsi singkat program kerja…"></textarea>
                        @error('summary') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Target Dampak</label>
                        <input wire:model="impact_target" type="text" class="input-shell"
                            placeholder="100 peserta per semester">
                        @error('impact_target') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Urutan</label>
                        <input wire:model="sort_order" type="number" class="input-shell" min="0" placeholder="0">
                        <p class="form-hint">Semakin kecil, semakin awal ditampilkan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editingId ? 'Simpan Perubahan' : 'Tambah Program' }}</span>
                        <span wire:loading>Menyimpan…</span>
                    </button>
                    <button type="button" wire:click="cancel" class="ghost-btn">Batal</button>
                </div>
            </form>
        </div>
    @endif

    @if ($programs->isEmpty())
        <div class="glass-panel py-12 text-center text-sm" style="color:var(--ink-muted)">
            Belum ada program kerja. Tambahkan program pertama.
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($programs as $program)
                <article class="glass-panel p-5">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="badge-pill">{{ $program->category }}</span>
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold
                                    {{ $program->status === 'Berjalan' || $program->status === 'Prioritas' ? 'bg-emerald-50 text-emerald-700' :
                                       ($program->status === 'Selesai' ? 'bg-gray-100 text-gray-600' : 'bg-amber-50 text-amber-700') }}">
                                    {{ $program->status }}
                                </span>
                            </div>
                            <p class="font-semibold" style="color:var(--ink)">{{ $program->title }}</p>
                            <p class="mt-1 text-sm line-clamp-2" style="color:var(--ink-muted)">{{ $program->summary }}</p>
                            @if ($program->impact_target)
                                <p class="mt-1.5 text-xs font-medium" style="color:var(--brand)">
                                    Target: {{ $program->impact_target }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between border-t pt-3" style="border-color:var(--border)">
                        <span class="text-xs" style="color:var(--ink-muted)">Urutan {{ $program->sort_order }}</span>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $program->id }})" type="button"
                                class="ghost-btn px-3 py-1.5 text-xs">Edit</button>
                            <button wire:click="delete({{ $program->id }})"
                                wire:confirm="Hapus program '{{ $program->title }}'?"
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
