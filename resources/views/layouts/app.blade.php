<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="{{ \App\Models\SiteSetting::getValue('site_theme', 'coral') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Alumni FTI'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @stack('head')
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="theme-light min-h-screen antialiased" style="background-color:var(--bg-base);color:var(--ink)">

    {{-- Aurora background --}}
    <div class="aurora-bg" aria-hidden="true">
        <div class="aurora-blob-3"></div>
    </div>

    {{-- Toast stack --}}
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

    <div class="theme-shell relative z-10 min-h-screen">
        <livewire:components.navigation />
        <main id="page-content">
            {{ $slot }}
        </main>
        <livewire:components.footer />
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
                    setTimeout(() => {
                        const t = this.toasts.find(t => t.id === id);
                        if (t) t.show = false;
                    }, 2800);
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 3200);
                }
            }
        }
    </script>
</body>
</html>
