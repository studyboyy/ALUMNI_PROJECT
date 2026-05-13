<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="{{ \App\Models\SiteSetting::getValue('site_theme', 'coral') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Alumni FTI')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair+display:600,700,800|poppins:400,500,600,700,800"
        rel="stylesheet" />
    @stack('head')

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="theme-light min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div x-data="toastStack()" x-on:toast.window="add($event.detail)" class="fixed left-4 top-4 z-[70] space-y-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="toast-shell">
                <p class="font-semibold" :class="toast.type === 'error' ? 'toast-text-error' : 'toast-text'"
                    x-text="toast.message"></p>
            </div>
        </template>
    </div>

    <div class="theme-shell min-h-screen">
        <div class="theme-particles theme-particles--far" aria-hidden="true">
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
        </div>

        <div class="theme-particles theme-particles--near" aria-hidden="true">
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
            <span class="theme-particle"></span>
        </div>

        <aside class="admin-sidebar lg:fixed lg:inset-y-0 lg:left-0 lg:w-[280px]">
            @php
                $siteLogo = \App\Models\SiteSetting::getValue('site_logo_url', '');
                $siteLogoVersion = \App\Models\SiteSetting::getValue('site_logo_updated_at', '');
                $logoSrc = '';
                if ($siteLogo) {
                    $separator = str_contains($siteLogo, '?') ? '&' : '?';
                    $logoSrc = $siteLogoVersion ? $siteLogo . $separator . 'v=' . $siteLogoVersion : $siteLogo;
                }
            @endphp

            <a href="{{ route('home') }}" wire:navigate class="mb-8 flex items-center gap-3">
                <div class="brand-badge {{ $siteLogo ? 'brand-badge--logo' : '' }}">
                    @if ($siteLogo)
                        <img src="{{ $logoSrc }}" alt="Logo FTI" class="h-8 w-8 rounded-full object-contain" />
                    @else
                        FTI
                    @endif
                </div>
                <div>
                    <p class="font-display text-xl text-slate-900">Admin Panel</p>
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Alumni FTI</p>
                </div>
            </a>

            <nav class="space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.homepage') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Kelola Homepage</a>
                <a href="{{ route('admin.profile') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Kelola Profil & Kontak</a>
                <a href="{{ route('admin.alumni') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Kelola Alumni</a>
                <a href="{{ route('admin.forum') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Forum Chat</a>
                <a href="{{ route('admin.jobs') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Approval Lowongan</a>
                <a href="{{ route('admin.news') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Kelola Berita</a>
                <a href="{{ route('admin.media') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Kelola Media</a>
                <a href="{{ route('admin.theme') }}" wire:navigate class="admin-nav-link"
                    wire:current="admin-nav-link-active">Kelola Tema</a>
                <a href="{{ route('home') }}" wire:navigate class="admin-nav-link">Kembali ke Website</a>
            </nav>
        </aside>

        <main class="min-w-0 lg:ml-[280px]">
            <div class="admin-topbar">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Dashboard</p>
                        <h1 class="font-display text-2xl text-slate-900">@yield('title', 'Admin Alumni FTI')</h1>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ghost-btn">Logout</button>
                    </form>
                </div>
            </div>

            <section class="px-4 py-7 sm:px-8 lg:px-10">
                {{ $slot }}
            </section>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
    <script>
        function toastStack() {
            return {
                toasts: [],
                add(detail) {
                    const payload = Array.isArray(detail) ? detail[0] : detail;
                    const message = payload?.message ?? payload ?? 'Perubahan tersimpan.';
                    const type = payload?.type ?? 'success';
                    const id = Date.now() + Math.random();

                    this.toasts.push({
                        id,
                        message,
                        type,
                        show: true
                    });

                    setTimeout(() => {
                        const found = this.toasts.find((t) => t.id === id);
                        if (found) found.show = false;
                    }, 2600);

                    setTimeout(() => {
                        this.toasts = this.toasts.filter((t) => t.id !== id);
                    }, 3000);
                }
            }
        }

        // Listen for theme change event from Livewire
        window.addEventListener('theme-changed', (e) => {
            const themeName = e.detail?.theme || e.detail;
            document.documentElement.setAttribute('data-theme', themeName);
        });
    </script>
</body>

</html>
