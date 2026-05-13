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

        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3">
            <div class="brand-badge {{ $siteLogo ? 'brand-badge--logo' : '' }}">
                @if ($siteLogo)
                    <img src="{{ $logoSrc }}" alt="Logo FTI" class="h-7 w-7 rounded-full object-contain" />
                @else
                    FTI
                @endif
            </div>
            <div>
                <p class="brand-title">Alumni FTI</p>
                <p class="brand-subtitle">Jejaring, Karier, Kolaborasi</p>
            </div>
        </a>

        <nav class="nav-links">
            @foreach ($links as $link)
                <a href="{{ $link['url'] }}" wire:navigate.hover
                    @if ($link['exact']) wire:current.exact="nav-pill-active" @else wire:current="nav-pill-active" @endif
                    class="nav-pill">
                    {{ $link['label'] }}
                </a>
            @endforeach

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.homepage') }}" wire:navigate class="nav-pill">Dashboard
                        Admin</a>
                @else
                    <a href="{{ route('alumni.forum') }}" wire:navigate class="nav-pill">Forum
                        Chat</a>
                    <a href="{{ route('alumni.dashboard') }}" wire:navigate class="nav-pill">Dashboard
                        Mahasiswa</a>
                @endif
            @else
                <a href="{{ route('register') }}" wire:navigate class="nav-pill nav-pill-cta">Join</a>
            @endauth
        </nav>
    </div>
</header>
