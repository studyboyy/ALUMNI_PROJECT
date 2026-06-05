<div class="relative" wire:poll.5s>
    <button type="button" wire:click="toggle"
        class="ghost-btn relative flex items-center gap-1.5">
        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="text-sm">Notifikasi</span>
        @if ($unreadCount > 0)
            <span class="flex h-5 w-5 items-center justify-center rounded-full text-[10px] font-bold text-white"
                style="background:var(--brand)">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    @if ($open)
        <div class="absolute right-0 z-50 mt-2 w-80 rounded-2xl border border-gray-200 bg-white p-4 shadow-xl">
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-800">Notifikasi</p>
                @if (auth()->check() && auth()->user()->isAlumni() && $unreadCount > 0)
                    <button wire:click="markAllAsSeen" type="button"
                        class="text-xs font-medium transition" style="color:var(--brand)">
                        Tandai dibaca
                    </button>
                @endif
            </div>
            <div class="space-y-2">
                @forelse ($items as $item)
                    <article class="rounded-xl border border-gray-100 bg-gray-50 px-3 py-2.5 text-sm">
                        <p class="font-semibold text-gray-800">{{ $item->title }}</p>
                        @if (auth()->check() && auth()->user()->isAdmin())
                            <p class="mt-0.5 text-xs text-gray-500">
                                Pengaju: {{ $item->submitter?->name ?? 'Alumni' }} · Menunggu approval
                            </p>
                        @else
                            <p class="mt-0.5 text-xs text-gray-500">
                                Status: {{ strtoupper($item->approval_status) }}
                                @if($item->approved_at) · {{ optional($item->approved_at)->translatedFormat('d M Y') }} @endif
                            </p>
                        @endif
                    </article>
                @empty
                    <div class="py-4 text-center text-xs text-gray-400">Belum ada notifikasi.</div>
                @endforelse
            </div>
        </div>
    @endif
</div>
