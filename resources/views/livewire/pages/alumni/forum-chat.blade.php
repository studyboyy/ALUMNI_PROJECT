@section('title', 'Forum Chat Alumni')

<div class="py-10 lg:py-12">
    <div class="section-shell">
        <div class="mb-5 flex items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Forum Chat</p>
                <h1 class="section-title mt-0.5">Obrolan alumni lintas angkatan.</h1>
            </div>
            <a href="{{ route('alumni.dashboard') }}" wire:navigate class="section-link">Dashboard</a>
        </div>

        <div class="glass-panel p-5">
            {{-- Pesan --}}
            <div id="chat-messages" wire:poll.2s="loadMessages"
                class="max-h-[55vh] space-y-3 overflow-y-auto rounded-xl border border-gray-100 bg-gray-50/60 p-4">
                @forelse ($messages as $message)
                    @php
                        $isMine = (int)($message['user']['id'] ?? 0) === (int)auth()->id();
                        $isReplyTarget = (int)($message['id'] ?? 0) === (int)$replyToId;
                        $photoUrl = $message['user']['photo_url'] ?? null;
                        $initials = $message['user']['initials'] ?? '?';
                    @endphp
                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="flex {{ $isMine ? 'flex-row-reverse' : 'flex-row' }} items-end gap-2.5 max-w-lg">
                            @if ($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $message['user']['name'] ?? 'User' }}"
                                    class="h-8 w-8 flex-shrink-0 rounded-full border border-gray-200 object-cover" loading="lazy">
                            @else
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full border border-gray-200 bg-white text-xs font-semibold text-gray-600">
                                    {{ $initials }}
                                </div>
                            @endif

                            <article class="rounded-2xl border bg-white p-3
                                {{ $isReplyTarget ? 'border-indigo-200 ring-1 ring-indigo-100' : 'border-gray-200' }}">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $message['user']['name'] ?? 'User' }}
                                        <span class="text-xs font-normal text-gray-400">({{ $message['user']['role'] ?? '-' }})</span>
                                    </p>
                                    <p class="whitespace-nowrap text-xs text-gray-400">{{ $message['created_at'] }}</p>
                                </div>

                                @if (!empty($message['reply_to']))
                                    <div class="mt-2 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2">
                                        <p class="text-xs font-semibold text-gray-500">
                                            ↩ {{ $message['reply_to']['user']['name'] ?? 'User' }}
                                        </p>
                                        <p class="mt-0.5 line-clamp-2 text-xs text-gray-500">
                                            {{ $message['reply_to']['body'] }}
                                        </p>
                                    </div>
                                @endif

                                <p class="mt-1.5 whitespace-pre-line text-sm text-gray-700">{{ $message['body'] }}</p>

                                <div class="mt-1.5 flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                    <button type="button" wire:click="reply({{ $message['id'] }})"
                                        class="text-xs font-medium text-gray-400 transition hover:text-gray-700">
                                        Balas
                                    </button>
                                </div>
                            </article>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-center text-sm text-gray-400">
                        Belum ada pesan. Mulai obrolan pertama!
                    </div>
                @endforelse
            </div>

            {{-- Reply preview --}}
            @if ($replyToId)
                @php $replyTarget = collect($messages)->firstWhere('id', $replyToId); @endphp
                <div class="mt-3 rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-600">
                                ↩ Membalas {{ data_get($replyTarget, 'user.name') ?? 'User' }}
                            </p>
                            <p class="mt-0.5 line-clamp-1 text-xs text-gray-500">
                                {{ data_get($replyTarget, 'body') ?? '' }}
                            </p>
                        </div>
                        <button type="button" wire:click="cancelReply"
                            class="text-xs font-semibold text-red-500 hover:text-red-700 flex-shrink-0">Batal</button>
                    </div>
                </div>
            @endif

            {{-- Input --}}
            <form wire:submit="send" class="mt-3 flex gap-2">
                <input id="chat-input" wire:model.defer="body" type="text" class="input-shell flex-1"
                    placeholder="Tulis pesan…" autocomplete="off">
                @error('body')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
                <button type="submit" class="purple-btn flex-shrink-0">Kirim</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('chat:scroll', () => {
            const box = document.getElementById('chat-messages');
            if (box) box.scrollTop = box.scrollHeight;
        });
        document.addEventListener('DOMContentLoaded', () => {
            const box = document.getElementById('chat-messages');
            if (box) box.scrollTop = box.scrollHeight;
        });
        window.addEventListener('chat:focus', () => {
            const input = document.getElementById('chat-input');
            if (input) input.focus();
        });
    </script>
@endpush
