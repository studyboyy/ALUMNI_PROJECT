@section('title', 'Admin Approval Lowongan')

<div class="space-y-10">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Admin Panel</p>
                <h1 class="section-title">Approval lowongan dari alumni.</h1>
            </div>
            <a href="{{ route('admin.alumni') }}" wire:navigate class="section-link">Ke kelola alumni</a>
        </div>

        <div class="glass-panel p-6">
            <label class="space-y-2 text-sm text-slate-600">
                <span>Catatan approval (opsional, dipakai untuk aksi berikutnya)</span>
                <textarea wire:model="notes" rows="3" class="input-shell" placeholder="Catatan untuk pengaju lowongan"></textarea>
            </label>
        </div>
    </section>

    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Pending</p>
                <h2 class="section-title">Lowongan menunggu persetujuan.</h2>
            </div>
        </div>

        <div class="grid gap-5">
            @forelse ($pendingJobs as $job)
                <article class="glass-panel p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="font-display text-2xl text-slate-900">{{ $job->title }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $job->company }} · {{ $job->location }} ·
                                {{ $job->employment_type }}</p>
                            <p class="mt-1 text-sm text-slate-500">Pengaju: {{ $job->submitter?->name ?? 'Alumni' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="approve({{ $job->id }})" type="button"
                                class="rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-400">Approve</button>
                            <button wire:click="reject({{ $job->id }})" type="button"
                                class="rounded-full bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-400">Reject</button>
                        </div>
                    </div>
                    <p class="mt-3 text-sm leading-7 text-slate-500">{{ $job->summary }}</p>
                </article>
            @empty
                <div class="glass-panel p-6 text-slate-500">Tidak ada lowongan pending saat ini.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $pendingJobs->links() }}</div>
    </section>

    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Riwayat Keputusan</p>
                <h2 class="section-title">Approval terbaru oleh admin.</h2>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            @foreach ($latestDecisions as $decision)
                <article class="glass-panel p-5">
                    <p class="font-display text-2xl text-slate-900">{{ $decision->title }}</p>
                    <p class="mt-2 text-sm text-slate-600">Status: {{ $decision->approval_status }}</p>
                    <p class="text-sm text-slate-500">Pengaju: {{ $decision->submitter?->name ?? '-' }} · Admin:
                        {{ $decision->approver?->name ?? '-' }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $decision->approval_notes }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
