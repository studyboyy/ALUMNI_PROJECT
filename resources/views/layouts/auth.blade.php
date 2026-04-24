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

        <main id="auth-content" class="relative z-10">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
