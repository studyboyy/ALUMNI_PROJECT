@section('title', 'Forum Chat Alumni')

<div class="section-shell">
    <div class="section-heading">
        <div>
            <p class="section-eyebrow">Forum Chat</p>
            <h1 class="section-title">Forum Chat</h1>
        </div>
        <a href="{{ route('alumni.dashboard') }}" wire:navigate class="section-link">Kembali ke dashboard</a>
    </div>

    <div class="glass-panel p-6">
        <div id="chat-messages" wire:poll.2s="loadMessages"
            class="max-h-[50vh] space-y-3 overflow-y-auto rounded-3xl border border-slate-200 bg-white/60 p-4">
            @forelse ($messages as $message)
                @php
                    $isMine = (int) ($message['user']['id'] ?? 0) === (int) auth()->id();
                    $isReplyTarget = (int) ($message['id'] ?? 0) === (int) $replyToId;
                    $photoUrl = $message['user']['photo_url'] ?? null;
                    $initials = $message['user']['initials'] ?? '';
                    $roleLabel = $message['user']['role'] ?? '-';
                @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="flex {{ $isMine ? 'flex-row-reverse' : 'flex-row' }} items-end gap-3">
                        @if ($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $message['user']['name'] ?? 'User' }}"
                                class="h-10 w-10 rounded-full border border-slate-200 bg-white object-cover"
                                loading="lazy">
                        @else
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white/80 text-xs font-semibold text-slate-700">
                                {{ $initials !== '' ? $initials : '?' }}
                            </div>
                        @endif

                        <article
                            class="w-full max-w-md rounded-2xl border bg-white p-3 {{ $isReplyTarget ? 'border-violet-200' : 'border-slate-200' }}">
                            <div class="flex items-center justify-between gap-4">
                                <p class="min-w-0 truncate text-sm font-semibold text-slate-900">
                                    {{ $message['user']['name'] ?? 'User' }}
                                    <span class="text-xs font-medium text-slate-500">({{ $roleLabel }})</span>
                                </p>
                                <p class="whitespace-nowrap text-xs text-slate-500">{{ $message['created_at'] }}</p>
                            </div>

                            @if (!empty($message['reply_to']))
                                <div class="mt-2 rounded-2xl border border-slate-200 bg-slate-50/80 px-3 py-2">
                                    <p class="text-xs font-semibold text-slate-700">
                                        Membalas {{ $message['reply_to']['user']['name'] ?? 'User' }}
                                    </p>
                                    <p class="mt-1 line-clamp-2 text-xs leading-6 text-slate-600">
                                        {{ $message['reply_to']['body'] }}
                                    </p>
                                </div>
                            @endif

                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $message['body'] }}
                            </p>

                            <div class="mt-2 flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <button type="button" wire:click="reply({{ $message['id'] }})"
                                    class="text-xs font-semibold text-slate-500 hover:text-violet-700">
                                    Balas
                                </button>
                            </div>
                        </article>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-600">
                    Belum ada pesan. Mulai obrolan pertama.
                </div>
            @endforelse
        </div>

        @if ($replyToId)
            @php
                $replyTarget = collect($messages)->firstWhere('id', $replyToId);
            @endphp
            <div class="mt-4 rounded-2xl border border-slate-200 bg-white/70 p-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-700">
                            Membalas: {{ data_get($replyTarget, 'user.name') ?? 'User' }}
                        </p>
                        <p class="mt-1 line-clamp-2 text-xs leading-6 text-slate-600">
                            {{ data_get($replyTarget, 'body') ?? 'Pesan tidak ditemukan.' }}
                        </p>
                    </div>
                    <button type="button" wire:click="cancelReply"
                        class="text-xs font-semibold text-rose-600 hover:text-rose-700">
                        Batal
                    </button>
                </div>
            </div>
        @endif

        <form wire:submit="send" class="mt-4 flex flex-col gap-3 sm:flex-row">
            <div class="flex-1">
                <input id="chat-input" wire:model.defer="body" type="text" class="input-shell"
                    placeholder="Tulis pesan...">
                @error('body')
                    <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="purple-btn sm:w-auto">Kirim</button>
        </form>
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
