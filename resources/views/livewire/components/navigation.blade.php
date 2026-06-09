<header class="header-shell">
    <div class="header-inner">
        @php
            $siteLogo = \App\Models\SiteSetting::getValue('site_logo_url', '');
            $siteLogoVersion = \App\Models\SiteSetting::getValue('site_logo_updated_at', '');
            $logoSrc = '';
            if ($siteLogo) {
                $separator = str_contains($siteLogo, '?') ? '&' : '?';
                $logoSrc = $siteLogoVersion ? $siteLogo . $separator . 'v=' . $siteLogoVersion : $siteLogo;
            }
        @endphp

        <a href="{{ route('home') }}" wire:navigate class="flex flex-shrink-0 items-center gap-2.5">
            <div class="brand-badge {{ $siteLogo ? 'brand-badge--logo' : '' }}">
                @if ($siteLogo)
                    <img src="{{ $logoSrc }}" alt="Logo FTI" class="h-6 w-6 rounded-lg object-contain" />
                @else
                    <span class="text-xs font-bold">FTI</span>
                @endif
            </div>
            <div>
                <p class="brand-title">Alumni FTI</p>
                <p class="brand-subtitle">Jejaring · Karier · Kolaborasi</p>
            </div>
        </a>

        <nav class="nav-links hidden lg:flex">
            @foreach ($links as $link)
                <a href="{{ $link['url'] }}" wire:navigate.hover
                    @if ($link['exact']) wire:current.exact="nav-pill-active" @else wire:current="nav-pill-active" @endif
                    class="nav-pill relative px-3.5 py-2 text-sm transition-colors duration-150">
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="ml-2 flex items-center gap-1.5 border-l pl-3" style="border-color:var(--border-md)">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" wire:navigate class="nav-pill px-3.5 py-2 text-sm">Admin</a>
                    @else
                        <a href="{{ route('alumni.dashboard') }}" wire:navigate class="nav-pill px-3.5 py-2 text-sm">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" wire:navigate class="nav-pill px-3.5 py-2 text-sm">Masuk</a>
                    <a href="{{ route('register') }}" wire:navigate class="nav-pill-cta rounded-lg px-4 py-2 text-sm font-semibold text-white">Daftar</a>
                @endauth
            </div>
        </nav>

        <div class="flex lg:hidden" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="ghost-btn p-2"
                aria-label="Toggle menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                @click.outside="open = false"
                class="absolute left-0 right-0 top-full z-50 border-b border-t border-gray-100 bg-white/95 px-4 py-4 shadow-lg backdrop-blur-md">
                <nav class="flex flex-col gap-1">
                    @foreach ($links as $link)
                        <a href="{{ $link['url'] }}" wire:navigate @click="open = false"
                            class="rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                    <div class="my-2 border-t border-gray-100"></div>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" wire:navigate @click="open = false"
                                class="rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Admin</a>
                        @else
                            <a href="{{ route('alumni.dashboard') }}" wire:navigate @click="open = false"
                                class="rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" wire:navigate @click="open = false"
                            class="rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}" wire:navigate @click="open = false"
                           class="purple-btn mt-1 text-center">Daftar</a>
                    @endauth
                </nav>
            </div>
        </div>
    </div>
</header>
