@section('title', 'Kelola Profil & Kontak')

<div class="space-y-6">
    <section class="glass-panel p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Brand</p>
                <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight text-slate-900">Logo FTI</h2>
                <p class="mt-2 text-sm text-slate-500">Logo tampil di navbar publik dan panel admin.</p>
            </div>
            @if ($logoUrl || $logoUpload)
                <button wire:click="removeLogo" type="button" class="outline-btn">Hapus Logo</button>
            @endif
        </div>

        <div class="mt-5 grid gap-4 lg:grid-cols-[1fr_16rem]">
            <div class="space-y-4">
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Upload Logo</span>
                    <input wire:model="logoUpload" type="file" accept="image/*" class="input-shell">
                    @error('logoUpload')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <label class="space-y-2 text-sm text-slate-600">
                    <span>URL Logo (opsional)</span>
                    <input wire:model.defer="logoUrl" class="input-shell" placeholder="https://...">
                </label>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white/80 p-4">
                @if ($logoUpload)
                    <img src="{{ $logoUpload->temporaryUrl() }}" alt="Preview logo" class="h-28 w-full object-contain">
                @elseif ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="Logo FTI" class="h-28 w-full object-contain">
                @else
                    <div class="flex h-28 items-center justify-center text-sm text-slate-400">Belum ada logo</div>
                @endif
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button wire:click="saveLogo" type="button" class="purple-btn">Simpan Logo</button>
        </div>
    </section>

    <section class="glass-panel p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Profil Alumni</p>
                <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight text-slate-900">Visi, Misi, dan Sejarah</h2>
                <p class="mt-2 text-sm text-slate-500">Atur konten utama halaman profil alumni.</p>
            </div>
            <button wire:click="addTimelineItem" type="button" class="outline-btn">Tambah Sejarah</button>
        </div>
    </section>

    <section class="glass-panel space-y-6 p-6">
        <label class="space-y-2 text-sm font-medium text-slate-600">
            <span>Visi</span>
            <textarea wire:model.defer="vision" rows="4" class="input-shell" placeholder="Tulis visi alumni"></textarea>
        </label>

        <div class="space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm font-semibold text-slate-700">Misi</p>
                <button wire:click="addMission" type="button" class="outline-btn">Tambah Misi</button>
            </div>

            <div class="space-y-3">
                @forelse ($missions as $index => $mission)
                    <div class="flex items-start gap-3" wire:key="mission-{{ $index }}">
                        <input wire:model.defer="missions.{{ $index }}" class="input-shell"
                            placeholder="Tuliskan misi alumni">
                        <button wire:click="removeMission({{ $index }})" type="button"
                            class="text-sm text-rose-600 hover:text-rose-500">Hapus</button>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada misi. Tambahkan misi pertama.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-4">
            <p class="text-sm font-semibold text-slate-700">Sejarah / Timeline</p>
            <div class="space-y-4">
                @forelse ($timeline as $index => $item)
                    <article class="card-subtle space-y-3" wire:key="timeline-{{ $index }}">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-slate-700">Item {{ $index + 1 }}</p>
                            <button wire:click="removeTimelineItem({{ $index }})" type="button"
                                class="text-sm text-rose-600 hover:text-rose-500">Hapus</button>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-2 text-sm text-slate-600">
                                <span>Tahun</span>
                                <input wire:model.defer="timeline.{{ $index }}.year" class="input-shell"
                                    placeholder="2026">
                            </label>
                            <label class="space-y-2 text-sm text-slate-600">
                                <span>Judul</span>
                                <input wire:model.defer="timeline.{{ $index }}.title" class="input-shell"
                                    placeholder="Judul peristiwa">
                            </label>
                        </div>
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Deskripsi</span>
                            <textarea wire:model.defer="timeline.{{ $index }}.description" rows="3" class="input-shell"
                                placeholder="Ringkasan peristiwa"></textarea>
                        </label>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">Belum ada sejarah. Tambahkan item sejarah pertama.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="glass-panel space-y-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Kontak & Bantuan</p>
                <h2 class="mt-1 font-sans text-lg font-semibold tracking-tight text-slate-900">Kontak Utama</h2>
                <p class="mt-2 text-sm text-slate-500">Kontak ini tampil di halaman kontak, beranda, dan footer.</p>
            </div>
            <button wire:click="addContactChannel" type="button" class="outline-btn">Tambah Kontak</button>
        </div>

        <div class="space-y-4">
            @forelse ($contactChannels as $index => $channel)
                <div class="card-subtle grid gap-4 md:grid-cols-[1fr_1.2fr_auto]"
                    wire:key="contact-{{ $index }}">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Label</span>
                        <input wire:model.defer="contactChannels.{{ $index }}.label" class="input-shell"
                            placeholder="Email Humas">
                    </label>
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Value</span>
                        <input wire:model.defer="contactChannels.{{ $index }}.value" class="input-shell"
                            placeholder="humas@alumni-fti.ac.id">
                    </label>
                    <div class="flex items-end">
                        <button wire:click="removeContactChannel({{ $index }})" type="button"
                            class="text-sm text-rose-600 hover:text-rose-500">Hapus</button>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada kontak. Tambahkan kontak pertama.</p>
            @endforelse
        </div>

        <label class="space-y-2 text-sm text-slate-600">
            <span>URL Embed Google Maps</span>
            <input wire:model.defer="mapEmbedUrl" class="input-shell"
                placeholder="https://www.google.com/maps?q=...&output=embed">
            <p class="text-xs text-slate-500">Gunakan URL embed agar peta muncul di halaman kontak.</p>
        </label>
    </section>

    <div class="flex justify-end">
        <button wire:click="save" type="button" class="purple-btn">Simpan Perubahan</button>
    </div>
</div>
