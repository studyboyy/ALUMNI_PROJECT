@section('title', 'Admin Kelola Alumni')

<div class="space-y-8">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Admin Panel</p>
                <h1 class="section-title">Kelola data alumni.</h1>
            </div>
            <a href="{{ route('admin.jobs') }}" wire:navigate class="section-link">Ke approval lowongan</a>
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
                <article class="glass-panel flex items-start justify-between gap-4 p-5">
                    <div class="flex-1">
                        <p class="font-display text-2xl text-slate-900">{{ $item->name }}</p>
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
                            class="rounded-full border px-3 py-2 text-xs uppercase tracking-[0.1em] transition {{ $item->is_featured ? 'border-violet-300 bg-violet-50 text-violet-800 hover:bg-violet-100' : 'border-slate-300 text-slate-700 hover:border-violet-300 hover:text-violet-700' }}">
                            {{ $item->is_featured ? 'Unggulan' : 'Featured' }}
                        </button>
                        <button wire:click="delete({{ $item->id }})" type="button"
                            class="rounded-full border border-rose-300 px-3 py-2 text-xs text-rose-600 transition hover:bg-rose-50">Hapus</button>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $alumni->links() }}</div>
    </section>

    <!-- Edit Modal -->
    @if ($editingId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white p-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-slate-900">Edit Alumni</h2>
                    <button wire:click="resetForm" type="button" class="text-slate-500 hover:text-slate-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
                        <div class="flex gap-4">
                            @if ($photo_file)
                                <img src="{{ $photo_file->temporaryUrl() }}" alt="Preview"
                                    class="h-24 w-24 rounded object-cover">
                            @elseif ($photo_url)
                                <img src="{{ $photo_url }}" alt="Foto" class="h-24 w-24 rounded object-cover">
                            @else
                                <div class="h-24 w-24 rounded bg-slate-200"></div>
                            @endif
                            <label class="self-center">
                                <input wire:model="photo_file" type="file" accept="image/*" class="sr-only">
                                <span class="text-sm text-violet-600 hover:text-violet-700 cursor-pointer">Ganti
                                    foto</span>
                            </label>
                        </div>
                    </div>

                    <!-- Info Dasar -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Nama *</span>
                            <input wire:model="name" type="text" class="input-shell text-sm">
                            @error('name')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Email *</span>
                            <input wire:model="email" type="email" class="input-shell text-sm">
                            @error('email')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Program *</span>
                            <input wire:model="program" type="text" class="input-shell text-sm">
                            @error('program')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Nama Kampus *</span>
                            <input wire:model="campus_name" type="text" class="input-shell text-sm">
                            @error('campus_name')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Tahun Masuk *</span>
                            <input wire:model="batch_year" type="number" class="input-shell text-sm">
                            @error('batch_year')
                                <span class="text-xs text-rose-500">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Tahun Lulus</span>
                            <input wire:model="graduation_year" type="number" class="input-shell text-sm">
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Telepon</span>
                            <input wire:model="phone" type="tel" class="input-shell text-sm">
                        </label>
                    </div>

                    <!-- Karir -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Status Pekerjaan *</span>
                            <select wire:model="employment_status" class="input-shell text-sm">
                                <option>Bekerja</option>
                                <option>Menganggur</option>
                                <option>Melanjutkan Kuliah</option>
                                <option>Berwiraswasta</option>
                            </select>
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Perusahaan</span>
                            <input wire:model="employer" type="text" class="input-shell text-sm">
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Jabatan</span>
                            <input wire:model="job_title" type="text" class="input-shell text-sm">
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Industri</span>
                            <input wire:model="industry" type="text" class="input-shell text-sm">
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Kota</span>
                            <input wire:model="city" type="text" class="input-shell text-sm">
                        </label>

                        <label class="space-y-1">
                            <span class="text-sm font-medium text-slate-700">Provinsi</span>
                            <input wire:model="province" type="text" class="input-shell text-sm">
                        </label>
                    </div>

                    <!-- Bio -->
                    <label class="space-y-1">
                        <span class="text-sm font-medium text-slate-700">Bio</span>
                        <textarea wire:model="bio" class="input-shell text-sm min-h-16" maxlength="500"></textarea>
                    </label>

                    <!-- LinkedIn -->
                    <label class="space-y-1">
                        <span class="text-sm font-medium text-slate-700">LinkedIn URL</span>
                        <input wire:model="linkedin_url" type="url" class="input-shell text-sm">
                    </label>

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
