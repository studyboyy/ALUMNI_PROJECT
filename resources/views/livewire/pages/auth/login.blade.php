@section('title', 'Login Alumni / Admin')

<div class="flex min-h-screen items-center justify-center px-4 py-12">
    <div class="w-full max-w-4xl">
        <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">

            {{-- Kiri --}}
            <div class="flex flex-col justify-center space-y-5">
                <a href="{{ route('home') }}" wire:navigate
                    class="inline-flex items-center gap-1.5 text-sm font-medium" style="color:var(--ink-muted)">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke beranda
                </a>
                <div>
                    <p class="section-eyebrow">Login Area</p>
                    <h1 class="section-title">Masuk sebagai admin atau alumni.</h1>
                    <p class="mt-3 section-copy">
                        Admin mengelola data alumni dan approval lowongan.
                        Alumni dapat mengajukan lowongan yang diverifikasi admin.
                    </p>
                </div>
            </div>

            {{-- Kanan: Form --}}
            <div class="glass-panel p-7 sm:p-8">
                <h2 class="font-display text-2xl" style="color:var(--ink)">Masuk Akun</h2>
                <p class="mt-1.5 text-sm" style="color:var(--ink-muted)">Gunakan email dan password yang terdaftar.</p>

                <form wire:submit="authenticate" class="mt-7 space-y-5">

                    <div class="form-group">
                        <label class="form-label">NIM / Email</label>
                        <input wire:model.blur="email" type="text" class="input-shell"
                            placeholder="21123456 atau admin@alumni-fti.test" autocomplete="username">
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

                    <button type="submit" class="purple-btn w-full justify-center mt-2">Masuk</button>
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
