@section('title', 'Admin Kelola Alumni')

<div class="space-y-8">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Admin Panel</p>
                <h1 class="section-title">Kelola data alumni.</h1>
            </div>
            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.alumni.export') }}"
                    class="ghost-btn flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Excel
                </a>
                <button wire:click="create" type="button" class="section-link">Tambah alumni</button>
                <a href="{{ route('admin.jobs') }}" wire:navigate class="section-link">Ke approval lowongan</a>
            </div>
        </div>

        <div class="glass-panel p-6">
            <label class="space-y-2 text-sm text-slate-600">
                <span>Cari alumni</span>
                <input wire:model.live.debounce.300ms="search" class="input-shell"
                    placeholder="Nama / prodi / perusahaan">
            </label>
        </div>
    </section>

    <section>
        <div class="grid gap-5 lg:grid-cols-2">
            @foreach ($alumni as $item)
                <article class="glass-panel relative flex items-start justify-between gap-4 p-5 pb-12">
                    <div class="flex-1">
                        <p class="font-display text-2xl text-slate-900">{{ $item->name }}</p>
                        <p class="mt-1 text-sm text-slate-600">NIM: {{ $item->nim ?: '-' }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $item->program }} · Angkatan {{ $item->batch_year }}
                        </p>
                        <p class="mt-1 text-sm text-slate-500">{{ $item->campus_name ?: 'Kampus belum diisi' }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $item->job_title ?? '-' }} di
                            {{ $item->employer ?? '-' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="edit({{ $item->id }})" type="button"
                            class="rounded-full border border-slate-300 px-3 py-2 text-xs text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Edit</button>
                        <button wire:click="toggleFeatured({{ $item->id }})" type="button"
                            class="rounded-full border px-3 py-2 text-xs uppercase tracking-widest transition {{ $item->is_featured ? 'border-violet-300 bg-violet-50 text-violet-800 hover:bg-violet-100' : 'border-slate-300 text-slate-700 hover:border-violet-300 hover:text-violet-700' }}">
                            {{ $item->is_featured ? 'Unggulan' : 'Featured' }}
                        </button>
                        <button wire:click="delete({{ $item->id }})" type="button"
                            class="rounded-full border border-rose-300 px-3 py-2 text-xs text-rose-600 transition hover:bg-rose-50">Hapus</button>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        @if ($item->user_id)
                            <span
                                class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-emerald-700">Terdaftar</span>
                        @else
                            <span
                                class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-slate-500">Belum
                                Terdaftar</span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $alumni->links() }}</div>
    </section>

    <!-- Form Modal (Create / Edit) -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white p-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-slate-900">{{ $editingId ? 'Edit Alumni' : 'Tambah Alumni' }}
                    </h2>
                    <button wire:click="resetForm" type="button" class="text-slate-500 hover:text-slate-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <!-- Info Dasar -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">NIM *</span>
                            <input wire:model="nim" type="text" class="input-shell text-sm"
                                placeholder="Masukkan NIM">
                            @error('nim')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Nama *</span>
                            <input wire:model="name" type="text" class="input-shell text-sm"
                                placeholder="Nama lengkap">
                            @error('name')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Program Studi *</span>
                            <input wire:model="program" type="text" class="input-shell text-sm"
                                placeholder="Contoh: Teknik Informatika">
                            @error('program')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Nama Kampus *</span>
                            <input wire:model="campus_name" type="text" class="input-shell text-sm"
                                placeholder="Contoh: Universitas Indonesia">
                            @error('campus_name')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Angkatan *</span>
                            <input wire:model="batch_year" type="number" class="input-shell text-sm"
                                placeholder="Contoh: 2018">
                            @error('batch_year')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button wire:click="resetForm" type="button"
                            class="rounded-full border border-slate-300 px-6 py-2 text-sm font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-full bg-violet-600 px-6 py-2 text-sm font-semibold text-white transition hover:bg-violet-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
