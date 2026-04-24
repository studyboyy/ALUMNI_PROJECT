<div class="relative" wire:poll.5s>
    <button type="button" wire:click="toggle"
        class="relative rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700 transition hover:border-violet-300 hover:text-violet-700">
        Notifikasi
        @if ($unreadCount > 0)
            <span
                class="ml-2 inline-flex min-w-6 justify-center rounded-full bg-violet-600 px-2 py-0.5 text-[10px] font-bold text-white">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    @if ($open)
        <div
            class="absolute right-0 z-40 mt-3 w-[22rem] rounded-3xl border border-slate-200 bg-white p-4 shadow-2xl shadow-slate-300/60 backdrop-blur-xl">
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-800">Update Real-time</p>
                @if (auth()->check() && auth()->user()->isAlumni() && $unreadCount > 0)
                    <button wire:click="markAllAsSeen" type="button"
                        class="text-xs text-violet-700 hover:text-violet-500">Tandai dibaca</button>
                @endif
            </div>

            <div class="space-y-2">
                @forelse ($items as $item)
                    <article class="rounded-2xl border border-slate-200 bg-slate-50/80 px-3 py-2 text-sm">
                        <p class="font-semibold text-slate-900">{{ $item->title }}</p>
                        @if (auth()->check() && auth()->user()->isAdmin())
                            <p class="mt-1 text-xs text-slate-500">Pengaju:
                                {{ $item->submitter?->name ?? 'Alumni' }} · Menunggu approval</p>
                        @else
                            <p class="mt-1 text-xs text-slate-500">Status: {{ strtoupper($item->approval_status) }}
                                · {{ optional($item->approved_at)->translatedFormat('d M Y H:i') }}</p>
                        @endif
                    </article>
                @empty
                    <div class="rounded-2xl border border-slate-200 px-3 py-4 text-center text-xs text-slate-500">
                        Belum ada notifikasi baru.
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
