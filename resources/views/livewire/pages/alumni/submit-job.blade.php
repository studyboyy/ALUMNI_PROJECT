@section('title', 'Submit Lowongan Alumni')

<div class="py-10 lg:py-12">
    <div class="section-shell space-y-6">

        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Info kiri --}}
            <div class="space-y-5">
                <div>
                    <p class="section-eyebrow">Lowongan oleh Alumni</p>
                    <h1 class="section-title mt-1 max-w-lg">Ajukan lowongan dan tunggu persetujuan admin.</h1>
                    <p class="mt-3 section-copy">Lowongan berstatus pending hingga disetujui admin. Data kontak Anda akan ditampilkan kepada pelamar.</p>
                </div>

                @if ($userInfo['name'])
                    <div class="glass-panel p-5">
                        <p class="section-eyebrow mb-4">Kontak Anda (tampil ke pelamar)</p>
                        <div class="flex items-center gap-3">
                            @if ($userInfo['photo'])
                                <img src="{{ $userInfo['photo'] }}" alt="{{ $userInfo['name'] }}"
                                    class="h-12 w-12 flex-shrink-0 rounded-xl object-cover">
                            @else
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl font-bold text-white"
                                    style="background:var(--brand)">
                                    {{ mb_strtoupper(mb_substr($userInfo['name'], 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-semibold" style="color:var(--ink)">{{ $userInfo['name'] }}</p>
                                <p class="text-sm" style="color:var(--ink-muted)">{{ $userInfo['email'] }}</p>
                                @if ($userInfo['phone'])
                                    <p class="text-sm" style="color:var(--ink-muted)">{{ $userInfo['phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Form --}}
            <div class="glass-panel p-6 sm:p-7">
                <h2 class="mb-5 text-base font-semibold" style="color:var(--ink)">Detail Lowongan</h2>
                <form wire:submit="submit" class="space-y-5">

                    <div class="form-group">
                        <label class="form-label">Judul Lowongan <span class="required">*</span></label>
                        <input wire:model.blur="title" class="input-shell" type="text" placeholder="Backend Engineer">
                        @error('title') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="form-group">
                            <label class="form-label">Perusahaan <span class="required">*</span></label>
                            <input wire:model.blur="company" class="input-shell" type="text" placeholder="Nama perusahaan">
                            @error('company') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lokasi <span class="required">*</span></label>
                            <input wire:model.blur="location" class="input-shell" type="text" placeholder="Jakarta / Remote">
                            @error('location') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="form-group">
                            <label class="form-label">Tipe Pekerjaan</label>
                            <select wire:model="employmentType" class="input-shell">
                                <option>Full-time</option>
                                <option>Part-time</option>
                                <option>Internship</option>
                                <option>Contract</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Batas Lamar <span class="required">*</span></label>
                            <input wire:model.blur="closesAt" class="input-shell" type="date">
                            @error('closesAt') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Link Apply <span class="required">*</span></label>
                        <input wire:model.blur="applyUrl" class="input-shell" type="url" placeholder="https://…">
                        <p class="form-hint">Link ini digunakan langsung sebagai tombol apply.</p>
                        @error('applyUrl') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ringkasan <span class="required">*</span></label>
                        <textarea wire:model.blur="summary" rows="4" class="input-shell"
                            placeholder="Deskripsi singkat lowongan…"></textarea>
                        @error('summary') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-1">
                        <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                            <span wire:loading.remove>Ajukan Lowongan</span>
                            <span wire:loading>Mengirim…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Riwayat --}}
        <div>
            <div class="mb-5">
                <p class="section-eyebrow">Riwayat Pengajuan</p>
                <h2 class="section-title">Status approval lowongan Anda.</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                @forelse ($myJobs as $job)
                    <article class="glass-panel p-5">
                        <p class="font-sans text-xl" style="color:var(--ink)">{{ $job->title }}</p>
                        <p class="mt-1 text-sm" style="color:var(--ink-muted)">{{ $job->company }} · {{ $job->location }}</p>
                        <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                            {{ $job->approval_status === 'approved' ? 'bg-emerald-50 text-emerald-700' :
                               ($job->approval_status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                            {{ ucfirst($job->approval_status) }}
                        </span>
                        @if ($job->approval_notes)
                            <p class="mt-2.5 text-sm" style="color:var(--ink-muted)">Catatan: {{ $job->approval_notes }}</p>
                        @endif
                    </article>
                @empty
                    <div class="glass-panel col-span-full py-10 text-center text-sm" style="color:var(--ink-muted)">
                        Belum ada lowongan yang diajukan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
