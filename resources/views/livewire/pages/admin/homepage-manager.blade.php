@section('title', 'Kelola Homepage')

<div class="space-y-6">
    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Hero Carousel</p>
                <h2 class="mt-1 font-display text-3xl text-slate-900">Atur slide hero halaman utama</h2>
            </div>
            <button wire:click="addSlide" type="button"
                class="rounded-full border border-violet-200 bg-violet-50 px-4 py-2 text-sm font-semibold text-violet-700 transition hover:bg-violet-100">Tambah
                Slide</button>
        </div>
    </section>

    <div class="space-y-4">
        @foreach ($slides as $index => $slide)
            <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-800">Slide {{ $index + 1 }}</p>
                    <button wire:click="removeSlide({{ $index }})" type="button"
                        class="text-sm text-rose-600 hover:text-rose-500">Hapus</button>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Judul</span>
                        <input wire:model="slides.{{ $index }}.title" class="input-shell"
                            placeholder="Judul slide">
                    </label>
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Subtitle</span>
                        <input wire:model="slides.{{ $index }}.subtitle" class="input-shell"
                            placeholder="Subtitle slide">
                    </label>
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>URL Gambar</span>
                        <input wire:model="slides.{{ $index }}.image" class="input-shell"
                            placeholder="https://... atau gunakan upload lokal di bawah">
                    </label>
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Label Tombol</span>
                        <input wire:model="slides.{{ $index }}.cta_label" class="input-shell"
                            placeholder="Lihat Direktori">
                    </label>
                    <div class="space-y-2 text-sm text-slate-600 md:col-span-2">
                        <span>Upload Gambar Lokal</span>
                        <div class="grid gap-4 lg:grid-cols-[1fr_15rem]">
                            <label class="block">
                                <input wire:model="slideUploads.{{ $index }}" type="file" accept="image/*"
                                    class="sr-only">
                                <div
                                    class="flex cursor-pointer items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-4 py-5 text-center transition hover:border-violet-300 hover:bg-violet-50">
                                    <div>
                                        <p class="font-medium text-slate-700">Pilih file gambar</p>
                                        <p class="mt-1 text-xs text-slate-500">JPG, PNG, GIF, WebP. Maks 5MB</p>
                                    </div>
                                </div>
                            </label>

                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                                @if (isset($slideUploads[$index]) && $slideUploads[$index])
                                    <img src="{{ $slideUploads[$index]->temporaryUrl() }}"
                                        alt="Preview slide {{ $index + 1 }}" class="h-40 w-full object-cover">
                                @elseif (!empty($slide['image']))
                                    <img src="{{ $slide['image'] }}" alt="Slide {{ $index + 1 }}"
                                        class="h-40 w-full object-cover">
                                @else
                                    <div
                                        class="flex h-40 items-center justify-center px-4 text-center text-xs text-slate-400">
                                        Preview gambar akan muncul di sini
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('slideUploads.' . $index)
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-slate-500">Jika upload file lokal, gambar hasil upload akan dipakai saat
                            disimpan.</p>
                    </div>
                    <label class="space-y-2 text-sm text-slate-600 md:col-span-2">
                        <span>URL Tombol</span>
                        <input wire:model="slides.{{ $index }}.cta_url" class="input-shell"
                            placeholder="/data-alumni">
                    </label>
                </div>
            </article>
        @endforeach
    </div>

    <div class="flex justify-end">
        <button wire:click="save" type="button" class="purple-btn">Simpan Carousel</button>
    </div>
</div>
