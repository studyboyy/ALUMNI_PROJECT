@section('title', 'Login Alumni / Admin')

<div class="flex min-h-screen items-stretch">
    <div class="hidden lg:flex lg:w-1/2 xl:w-[45%]">

        {{-- Left side: brand gradient with grid pattern --}}
        <div class="relative flex w-full flex-col justify-between overflow-hidden p-10 xl:p-14"
             style="background:linear-gradient(135deg,var(--brand) 0%,var(--brand-2) 100%)">

            {{-- Subtle grid pattern --}}
            <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
                 style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:32px 32px"></div>

            {{-- Decorative blobs --}}
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full opacity-20"
                 style="background:rgba(255,255,255,.3);filter:blur(60px)"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-16 h-56 w-56 rounded-full opacity-15"
                 style="background:rgba(255,255,255,.4);filter:blur(50px)"></div>

            {{-- Brand --}}
            <div class="relative flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold"
                     style="background:rgba(255,255,255,.2);color:white;border:1px solid rgba(255,255,255,.25)">A</div>
                <span class="text-lg font-semibold text-white">Alumni FTI</span>
            </div>

            {{-- Main text --}}
            <div class="relative space-y-4">
                <a href="{{ route('home') }}" wire:navigate
                   class="inline-flex items-center gap-1.5 text-sm font-medium text-white/70 transition hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke beranda
                </a>
                <h1 class="font-display text-4xl text-white leading-snug">Selamat datang<br>kembali!</h1>
                <p class="text-sm text-white/75 max-w-xs leading-relaxed">
                    Masuk untuk mengakses dashboard alumni, update profil, dan kelola lowongan karier.
                </p>

                {{-- Feature bullets --}}
                <ul class="space-y-3 pt-2">
                    <li class="flex items-center gap-3 text-sm text-white/85">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg"
                              style="background:rgba(255,255,255,.15)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </span>
                        Jaringan alumni lintas angkatan
                    </li>
                    <li class="flex items-center gap-3 text-sm text-white/85">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg"
                              style="background:rgba(255,255,255,.15)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        Akses lowongan eksklusif dari alumni
                    </li>
                    <li class="flex items-center gap-3 text-sm text-white/85">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg"
                              style="background:rgba(255,255,255,.15)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </span>
                        Statistik & tracer study terkini
                    </li>
                </ul>
            </div>

            <div class="relative text-xs text-white/40">
                Platform alumni FTI
            </div>
        </div>
    </div>

    {{-- Right side: Form --}}
    <div class="flex flex-1 items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            {{-- Mobile back link --}}
            <div class="lg:hidden mb-6">
                <a href="{{ route('home') }}" wire:navigate
                    class="inline-flex items-center gap-1.5 text-sm font-medium" style="color:var(--ink-muted)">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke beranda
                </a>
            </div>

            <div class="glass-panel p-7 sm:p-9"
                 style="box-shadow:0 20px 60px rgba(0,0,0,.1),0 4px 16px rgba(0,0,0,.06)">
                <div class="mb-6">
                    <p class="section-eyebrow">Login Area</p>
                    <h2 class="font-display text-3xl mt-1" style="color:var(--ink)">Masuk Akun</h2>
                    <p class="mt-1.5 text-sm" style="color:var(--ink-muted)">Gunakan email dan password yang terdaftar.</p>
                </div>

                <form wire:submit="authenticate" class="space-y-5">
                    <div class="form-group">
                        <label class="form-label">NIM / Email</label>
                        <input wire:model.blur="email" type="text" class="input-shell"
                            placeholder="21123456 atau admin@alumni-fti.ac.id" autocomplete="username">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input wire:model.blur="password" type="password" class="input-shell"
                            placeholder="••••••••" autocomplete="current-password">
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="purple-btn w-full justify-center mt-2">
                        Masuk
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm" style="color:var(--ink-muted)">
                    Belum punya akun?
                    <a href="{{ route('register') }}" wire:navigate
                        class="font-semibold" style="color:var(--brand)">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
