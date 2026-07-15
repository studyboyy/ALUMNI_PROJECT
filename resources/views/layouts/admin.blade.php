<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="{{ \App\Models\SiteSetting::getValue('site_theme', 'coral') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Alumni FTI')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @stack('head')
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/editor.js'])
</head>

<body class="theme-light min-h-screen antialiased" style="background-color:var(--bg-base);color:var(--ink)">

    {{-- Toast --}}
    <div x-data="toastStack()" x-on:toast.window="add($event.detail)"
        class="fixed left-4 top-4 z-[70] space-y-2 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="toast-shell pointer-events-auto">
                <p class="font-semibold"
                    :class="toast.type === 'error' ? 'toast-text-error' : 'toast-text'"
                    x-text="toast.message"></p>
            </div>
        </template>
    </div>

    <div class="flex min-h-screen">

        {{-- -- SIDEBAR -- --}}
        <aside class="admin-sidebar lg:fixed lg:inset-y-0 lg:left-0 lg:w-64">

            {{-- Brand --}}
            @php
                $siteLogo        = \App\Models\SiteSetting::getValue('site_logo_url', '');
                $siteLogoVersion = \App\Models\SiteSetting::getValue('site_logo_updated_at', '');
                $logoSrc = '';
                if ($siteLogo) {
                    $sep     = str_contains($siteLogo, '?') ? '&' : '?';
                    $logoSrc = $siteLogoVersion ? $siteLogo . $sep . 'v=' . $siteLogoVersion : $siteLogo;
                }
            @endphp

            <a href="{{ route('home') }}" wire:navigate class="mb-6 flex items-center gap-2.5">
                <div class="brand-badge {{ $siteLogo ? 'brand-badge--logo' : '' }}">
                    @if ($siteLogo)
                        <img src="{{ $logoSrc }}" alt="Logo" class="h-6 w-6 rounded-lg object-contain" />
                    @else
                        <span class="text-xs font-bold">FTI</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold leading-tight" style="color:var(--ink)">Admin Panel</p>
                    <p class="text-xs uppercase tracking-widest" style="color:var(--ink-muted)">Alumni FTI</p>
                </div>
            </a>

            {{-- Divider --}}
            <div class="mb-4 h-px" style="background:var(--border)"></div>

            {{-- Nav --}}
            <nav class="space-y-0.5">

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Divider --}}
                <div class="my-2 h-px" style="background:var(--border)"></div>
                <p class="px-2 pb-1 text-[0.65rem] font-semibold uppercase tracking-widest" style="color:var(--ink-muted)">Konten</p>

                {{-- Homepage --}}
                <a href="{{ route('admin.homepage') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                    </svg>
                    Kelola Beranda
                </a>

                {{-- Profil --}}
                <a href="{{ route('admin.profile') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Kelola Profil & Kontak
                </a>

                {{-- Organisasi --}}
                <a href="{{ route('admin.organisation') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Struktur Organisasi
                </a>

                {{-- Program Kerja --}}
                <a href="{{ route('admin.work-programs') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Kelola Karier & Kolaborasi
                </a>

                {{-- Berita --}}
                <a href="{{ route('admin.news') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Kelola Berita & Agenda
                </a>

                {{-- Media --}}
                <a href="{{ route('admin.media') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Kelola Galeri & Media
                </a>

                {{-- Testimoni --}}
                <a href="{{ route('admin.testimoni') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Testimoni
                </a>

                {{-- FAQ --}}
                <a href="{{ route('admin.faq') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    FAQ
                </a>

                {{-- Divider --}}
                <div class="my-2 h-px" style="background:var(--border)"></div>
                <p class="px-2 pb-1 text-[0.65rem] font-semibold uppercase tracking-widest" style="color:var(--ink-muted)">Alumni</p>

                {{-- Alumni --}}
                <a href="{{ route('admin.alumni') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Kelola Data Alumni
                </a>

                {{-- Forum --}}
                <a href="{{ route('admin.forum') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Forum Chat
                </a>

                {{-- Lowongan --}}
                <a href="{{ route('admin.jobs') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Approval Lowongan
                </a>

                {{-- Tracer Study --}}
                <a href="{{ route('admin.tracer-study') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Tracer Study
                </a>

                {{-- Divider --}}
                <div class="my-2 h-px" style="background:var(--border)"></div>
                <p class="px-2 pb-1 text-[0.65rem] font-semibold uppercase tracking-widest" style="color:var(--ink-muted)">Sistem</p>

                {{-- Tema --}}
                <a href="{{ route('admin.theme') }}" wire:navigate wire:current="admin-nav-link-active"
                    class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                    Kelola Tema
                </a>

                {{-- Divider --}}
                <div class="my-2 h-px" style="background:var(--border)"></div>

                {{-- Kembali ke Website --}}
                <a href="{{ route('home') }}" wire:navigate class="admin-nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Ke Website
                </a>

            </nav>
        </aside>

        {{-- -- MAIN -- --}}
        <main class="flex min-w-0 flex-1 flex-col lg:ml-64">

            {{-- Topbar --}}
            <div class="admin-topbar">
                <div class="flex items-center justify-between gap-4">
                    <h1 class="font-sans text-lg font-semibold tracking-tight" style="color:var(--ink)">
                        @yield('title', 'Admin Alumni FTI')
                    </h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ghost-btn">Logout</button>
                    </form>
                </div>
            </div>

            <div class="admin-content flex-1 px-4 py-5 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
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
                    const type    = payload?.type ?? 'success';
                    const id      = Date.now() + Math.random();
                    this.toasts.push({ id, message, type, show: true });
                    setTimeout(() => { const t = this.toasts.find(t => t.id === id); if (t) t.show = false; }, 2800);
                    setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 3200);
                }
            }
        }
        window.addEventListener('theme-changed', (e) => {
            const theme = e.detail?.theme || e.detail;
            document.documentElement.setAttribute('data-theme', theme);
        });
    </script>
</body>
</html>
