@section('title', 'Submit Lowongan Alumni')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[1fr_1fr]">
        <div class="space-y-5">
            <p class="section-eyebrow">Lowongan Oleh Alumni</p>
            <h1 class="section-title max-w-2xl">Ajukan lowongan pekerjaan, kemudian tunggu persetujuan admin.</h1>
            <p class="section-copy">Setiap lowongan yang diajukan alumni otomatis berstatus pending dan tidak tampil di
                halaman publik sebelum disetujui admin. Data kontak Anda akan ditampilkan kepada pelamar.</p>
        </div>
        <div class="space-y-5">
            @if ($userInfo['name'])
                <div class="glass-panel p-6">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-4">Preview Informasi Kontak Anda</p>
                    <div class="flex gap-4">
                        @if ($userInfo['photo'])
                            <img src="{{ $userInfo['photo'] }}" alt="{{ $userInfo['name'] }}"
                                class="h-16 w-16 rounded-lg object-cover shrink-0">
                        @else
                            <div
                                class="h-16 w-16 rounded-lg bg-linear-to-br from-violet-400 to-fuchsia-400 flex items-center justify-center text-white font-bold text-lg shrink-0">
                                {{ substr($userInfo['name'], 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-slate-900">{{ $userInfo['name'] }}</p>
                            <p class="text-sm text-slate-600 mt-1">{{ $userInfo['email'] }}</p>
                            @if ($userInfo['phone'])
                                <p class="text-sm text-slate-600">{{ $userInfo['phone'] }}</p>
                            @endif
                            <p class="text-xs text-slate-500 mt-2 italic">Pelamar bisa menghubungi melalui kontak ini
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="glass-panel p-6">
                <form wire:submit="submit" class="space-y-4">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Judul Lowongan</span>
                        <input wire:model.blur="title" class="input-shell" type="text"
                            placeholder="Backend Engineer">
                        @error('title')
                            <span class="text-sm text-rose-300">{{ $message }}</span>
                        @enderror
                    </label>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Perusahaan</span>
                            <input wire:model.blur="company" class="input-shell" type="text"
                                placeholder="Nama perusahaan">
                            @error('company')
                                <span class="text-sm text-rose-300">{{ $message }}</span>
                            @enderror
                        </label>
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Lokasi</span>
                            <input wire:model.blur="location" class="input-shell" type="text"
                                placeholder="Jakarta / Remote">
                            @error('location')
                                <span class="text-sm text-rose-300">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Tipe</span>
                            <select wire:model="employmentType" class="input-shell">
                                <option>Full-time</option>
                                <option>Part-time</option>
                                <option>Internship</option>
                                <option>Contract</option>
                            </select>
                        </label>
                        <label class="space-y-2 text-sm text-slate-600">
                            <span>Batas Lamar</span>
                            <input wire:model.blur="closesAt" class="input-shell" type="date">
                            @error('closesAt')
                                <span class="text-sm text-rose-300">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Link Apply</span>
                        <input wire:model.blur="applyUrl" class="input-shell" type="url" placeholder="https://...">
                        <p class="text-xs text-slate-500 mt-1">Link ini akan dipakai langsung sebagai tombol apply di
                            halaman lowongan.</p>
                        @error('applyUrl')
                            <span class="text-sm text-rose-300">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Ringkasan</span>
                        <textarea wire:model.blur="summary" rows="5" class="input-shell" placeholder="Deskripsi singkat lowongan"></textarea>
                        @error('summary')
                            <span class="text-sm text-rose-300">{{ $message }}</span>
                        @enderror
                    </label>

                    <button type="submit" class="purple-btn">Ajukan
                        Lowongan</button>
                </form>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Riwayat Pengajuan Saya</p>
                <h2 class="section-title">Status approval lowongan yang pernah diajukan.</h2>
            </div>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @forelse ($myJobs as $job)
                <article class="glass-panel interactive-card p-5">
                    <p class="font-display text-2xl text-slate-900">{{ $job->title }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ $job->company }} · {{ $job->location }}</p>
                    <div
                        class="mt-3 inline-flex rounded-full border border-violet-200 bg-violet-50 px-3 py-1 text-xs uppercase tracking-[0.2em] text-violet-700">
                        {{ $job->approval_status }}</div>
                    @if ($job->approval_notes)
                        <p class="mt-3 text-sm text-slate-500">Catatan admin: {{ $job->approval_notes }}</p>
                    @endif
                </article>
            @empty
                <div class="glass-panel p-6 text-slate-500">Belum ada lowongan yang Anda ajukan.</div>
            @endforelse
        </div>
    </section>
</div>
