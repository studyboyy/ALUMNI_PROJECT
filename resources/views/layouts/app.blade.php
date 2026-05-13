<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-theme="{{ \App\Models\SiteSetting::getValue('site_theme', 'coral') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Alumni FTI'))</title>

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

    <div class="theme-shell">
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

        <livewire:components.navigation />

        <main id="page-content" class="relative z-10">
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
    </script>
</body>

</html>
