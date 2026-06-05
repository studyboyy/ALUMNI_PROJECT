@section('title', 'Kelola FAQ')

<div class="space-y-6">

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="section-eyebrow">Admin Panel</p>
            <h1 class="section-title">FAQ (Pertanyaan Umum)</h1>
            <p class="mt-1 text-sm" style="color:var(--ink-muted)">Kelola FAQ yang tampil di halaman Kontak dan Beranda.</p>
        </div>
        @if (!$showForm)
            <button wire:click="create" type="button" class="purple-btn">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah FAQ
            </button>
        @endif
    </div>

    @if ($showForm)
        <div class="glass-panel p-6">
            <h2 class="mb-5 text-base font-semibold" style="color:var(--ink)">
                {{ $editingId ? 'Edit FAQ' : 'Tambah FAQ Baru' }}
            </h2>
            <form wire:submit="save" class="space-y-5">
                <div class="form-group">
                    <label class="form-label">Pertanyaan <span class="required">*</span></label>
                    <input wire:model="question" type="text" class="input-shell"
                        placeholder="Bagaimana cara memperbarui data alumni?">
                    @error('question') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Jawaban <span class="required">*</span></label>
                    <textarea wire:model="answer" rows="4" class="input-shell"
                        placeholder="Tuliskan jawaban yang jelas dan ringkas…"></textarea>
                    @error('answer') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group w-32">
                    <label class="form-label">Urutan</label>
                    <input wire:model="sort_order" type="number" class="input-shell" min="0" placeholder="0">
                    <p class="form-hint">Semakin kecil, semakin awal ditampilkan</p>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editingId ? 'Simpan Perubahan' : 'Tambah FAQ' }}</span>
                        <span wire:loading>Menyimpan…</span>
                    </button>
                    <button type="button" wire:click="cancel" class="ghost-btn">Batal</button>
                </div>
            </form>
        </div>
    @endif

    @if ($faqs->isEmpty())
        <div class="glass-panel py-12 text-center text-sm" style="color:var(--ink-muted)">
            Belum ada FAQ. Tambahkan pertanyaan pertama.
        </div>
    @else
        <div class="space-y-3">
            @foreach ($faqs as $faq)
                <article class="glass-panel p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold" style="color:var(--ink)">{{ $faq->question }}</p>
                            <p class="mt-2 text-sm leading-relaxed" style="color:var(--ink-muted)">{{ $faq->answer }}</p>
                        </div>
                        <div class="flex flex-shrink-0 gap-2">
                            <button wire:click="edit({{ $faq->id }})" type="button"
                                class="ghost-btn px-3 py-1.5 text-xs">Edit</button>
                            <button wire:click="delete({{ $faq->id }})"
                                wire:confirm="Hapus FAQ ini?"
                                type="button"
                                class="rounded-lg border px-3 py-1.5 text-xs font-semibold transition hover:bg-red-50"
                                style="border-color:#fca5a5;color:#ef4444">Hapus</button>
                        </div>
                    </div>
                    <p class="mt-3 text-xs" style="color:var(--ink-muted)">Urutan: {{ $faq->sort_order }}</p>
                </article>
            @endforeach
        </div>
    @endif
</div>
