<header
    class="sticky top-0 z-30 border-b border-slate-300/80 bg-white/70 shadow-sm shadow-slate-200/40 backdrop-blur-2xl">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-2 px-4 py-2 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3">
            <div
                class="flex h-11 w-11 items-center justify-center rounded-2xl bg-linear-to-br from-violet-500 to-fuchsia-500 text-sm font-extrabold text-white shadow-lg shadow-violet-200/70">
                FTI</div>
            <div>
                <p class="font-display text-lg leading-none text-slate-900">Alumni FTI</p>
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Jejaring, Karier, Kolaborasi</p>
            </div>
        </a>

        <nav class="flex flex-1 items-center justify-end gap-1 text-xs font-medium text-slate-700 sm:text-sm">
            @foreach ($links as $link)
                <a href="{{ $link['url'] }}" wire:navigate.hover
                    @if ($link['exact']) wire:current.exact="bg-violet-100 text-violet-800" @else wire:current="bg-violet-100 text-violet-800" @endif
                    class="whitespace-nowrap rounded-full border border-slate-300/85 bg-white/70 px-2.5 py-1.5 transition hover:border-violet-300 hover:text-violet-700">
                    {{ $link['label'] }}
                </a>
            @endforeach

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.homepage') }}" wire:navigate
                        class="whitespace-nowrap rounded-full border border-slate-300/85 bg-white/70 px-2.5 py-1.5 text-slate-600 transition hover:border-violet-300 hover:text-violet-700">Dashboard
                        Admin</a>
                @else
                    <a href="{{ route('alumni.dashboard') }}" wire:navigate
                        class="whitespace-nowrap rounded-full border border-slate-300/85 bg-white/70 px-2.5 py-1.5 text-slate-600 transition hover:border-violet-300 hover:text-violet-700">Dashboard
                        Mahasiswa</a>
                @endif
            @else
                <a href="{{ route('register') }}" wire:navigate
                    class="whitespace-nowrap rounded-full bg-linear-to-r from-violet-600 to-fuchsia-500 px-2.5 py-1.5 text-white transition hover:from-violet-500 hover:to-fuchsia-400">Join</a>
            @endauth
        </nav>
    </div>
</header>
