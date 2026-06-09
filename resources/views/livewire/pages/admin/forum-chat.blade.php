@section('title', 'Forum Chat')

<div class="space-y-8">
    <section class="section-shell">
        <div class="grid gap-5 lg:grid-cols-[1fr_320px] lg:items-stretch">
            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow">Admin Panel</p>
                <h1 class="section-title mt-2">Forum chat realtime yang lebih rapi.</h1>
                <p class="section-copy mt-3 max-w-2xl">
                    Pantau percakapan alumni, balas pesan penting, dan kelola interaksi komunitas dari satu panel yang bersih.
                </p>
            </div>

            <div class="glass-panel p-6 sm:p-7">
                <p class="section-eyebrow mb-4">Aksi Cepat</p>
                <div class="space-y-3">
                    <a href="{{ route('admin.alumni') }}" wire:navigate class="outline-btn w-full">Kelola Alumni</a>
                    <a href="{{ route('admin.jobs') }}" wire:navigate class="outline-btn w-full">Kelola Lowongan</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="glass-panel overflow-hidden">
            <div class="border-b px-6 py-4" style="border-color:var(--border)">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="section-eyebrow">Percakapan</p>
                        <h2 class="mt-1 font-sans text-xl font-semibold" style="color:var(--ink)">Forum chat (realtime)</h2>
                    </div>
                    <div class="rounded-full px-3 py-1 text-xs font-semibold" style="background:var(--brand-soft);color:var(--brand-deep)">
                        Poll 2 detik
                    </div>
                </div>
            </div>

            <div id="chat-messages" wire:poll.2s="loadMessages"
                class="max-h-[58vh] space-y-4 overflow-y-auto bg-[linear-gradient(180deg,rgba(248,249,252,.8),rgba(255,255,255,.95))] p-5 sm:p-6">
                @forelse ($messages as $message)
                    @php
                        $isMine = (int) ($message['user']['id'] ?? 0) === (int) auth()->id();
                        $isReplyTarget = (int) ($message['id'] ?? 0) === (int) $replyToId;
                        $photoUrl = $message['user']['photo_url'] ?? null;
                        $initials = $message['user']['initials'] ?? '';
                        $roleLabel = $message['user']['role'] ?? '-';
                    @endphp

                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="flex max-w-3xl gap-3 {{ $isMine ? 'flex-row-reverse' : 'flex-row' }} items-end">
                            @if ($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $message['user']['name'] ?? 'User' }}"
                                    class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-sm"
                                    loading="lazy">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full text-xs font-semibold shadow-sm ring-2 ring-white"
                                    style="background:var(--brand-soft);color:var(--brand-deep)">
                                    {{ $initials !== '' ? $initials : '?' }}
                                </div>
                            @endif

                            <article
                                class="w-full rounded-2xl border px-4 py-3 shadow-sm {{ $isMine ? 'border-[rgba(var(--brand-rgb),.2)] bg-[rgba(var(--brand-rgb),.06)]' : 'border-slate-200 bg-white' }}
                                {{ $isReplyTarget ? 'ring-2 ring-[rgba(var(--brand-rgb),.18)]' : '' }}">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold" style="color:var(--ink)">
                                            {{ $message['user']['name'] ?? 'User' }}
                                            <span class="text-xs font-medium" style="color:var(--ink-muted)">({{ $roleLabel }})</span>
                                        </p>
                                        <p class="mt-0.5 text-[0.65rem] font-semibold uppercase tracking-widest" style="color:var(--ink-muted)">
                                            {{ $isMine ? 'Anda' : 'Anggota komunitas' }}
                                        </p>
                                    </div>
                                    <p class="whitespace-nowrap text-xs" style="color:var(--ink-muted)">{{ $message['created_at'] }}</p>
                                </div>

                                @if (!empty($message['reply_to']))
                                    <div class="mt-3 rounded-xl border px-3 py-2"
                                        style="border-color:rgba(var(--brand-rgb),.12);background:rgba(var(--brand-rgb),.05)">
                                        <p class="text-xs font-semibold" style="color:var(--brand-deep)">
                                            Membalas {{ $message['reply_to']['user']['name'] ?? 'User' }}
                                        </p>
                                        <p class="mt-1 line-clamp-2 text-xs leading-6" style="color:var(--ink-muted)">
                                            {{ $message['reply_to']['body'] }}
                                        </p>
                                    </div>
                                @endif

                                <p class="mt-3 whitespace-pre-line text-sm leading-7" style="color:var(--ink-2)">
                                    {{ $message['body'] }}
                                </p>

                                <div class="mt-3 flex {{ $isMine ? 'justify-end' : 'justify-start' }} gap-3">
                                    <button type="button" wire:click="reply({{ $message['id'] }})"
                                        class="text-xs font-semibold transition" style="color:var(--brand-deep)">
                                        Balas
                                    </button>
                                    <button type="button"
                                        wire:click="deleteMessage({{ $message['id'] }})"
                                        wire:confirm="Hapus pesan ini?"
                                        class="text-xs font-semibold transition text-rose-500 hover:text-rose-700">
                                        Hapus
                                    </button>
                                </div>
                            </article>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border bg-white p-6 text-center text-sm" style="border-color:var(--border);color:var(--ink-muted)">
                        Belum ada pesan.
                    </div>
                @endforelse
            </div>

            <div class="border-t p-4 sm:p-5" style="border-color:var(--border)">
                @if ($replyToId)
                    @php
                        $replyTarget = collect($messages)->firstWhere('id', $replyToId);
                    @endphp
                    <div class="mb-4 rounded-2xl border px-4 py-3"
                        style="border-color:rgba(var(--brand-rgb),.12);background:rgba(var(--brand-rgb),.05)">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-widest" style="color:var(--brand-deep)">
                                    Membalas: {{ data_get($replyTarget, 'user.name') ?? 'User' }}
                                </p>
                                <p class="mt-1 line-clamp-2 text-xs leading-6" style="color:var(--ink-muted)">
                                    {{ data_get($replyTarget, 'body') ?? 'Pesan tidak ditemukan.' }}
                                </p>
                            </div>
                            <button type="button" wire:click="cancelReply"
                                class="text-xs font-semibold transition text-rose-600 hover:text-rose-700">
                                Batal
                            </button>
                        </div>
                    </div>
                @endif

                <form wire:submit="send" class="flex flex-col gap-3 sm:flex-row">
                    <div class="flex-1">
                        <input id="chat-input" wire:model.defer="body" type="text" class="input-shell"
                            placeholder="Tulis pesan sebagai admin...">
                        @error('body')
                            <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="purple-btn sm:w-auto">Kirim</button>
                </form>
            </div>
        </div>
    </section>
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
