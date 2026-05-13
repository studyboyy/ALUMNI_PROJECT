@section('title', 'Login Alumni / Admin')

<div class="py-12 sm:py-16">
    <section class="section-shell grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="space-y-7">
            <a href="{{ route('home') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-slate-700">
                <span aria-hidden="true">&larr;</span>
                <span>Kembali ke halaman publik</span>
            </a>
            <p class="section-eyebrow">Login Area</p>
            <h1 class="section-title max-w-2xl">Masuk sebagai admin atau alumni.</h1>
            <p class="section-copy">Admin dapat mengelola data alumni dan approval lowongan. Alumni dapat mengajukan
                lowongan yang akan diverifikasi oleh admin terlebih dahulu.</p>
        </div>

        <div class="glass-panel p-7 sm:p-9">
            <h2 class="font-display text-2xl text-slate-900 sm:text-3xl">Masuk Akun</h2>
            <p class="mt-1 text-sm text-slate-600">Gunakan NIM atau email dan password yang terdaftar.</p>

            <form wire:submit="authenticate" class="mt-8 space-y-7">
                <label class="space-y-3 text-sm font-medium text-slate-600">
                    <span>NIM / Email</span>
                    <input wire:model.blur="email" type="text" class="input-shell"
                        placeholder="21123456 atau admin@alumni-fti.test">
                    @error('email')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <label class="space-y-3 text-sm font-medium text-slate-600">
                    <span>Password</span>
                    <input wire:model.blur="password" type="password" class="input-shell" placeholder="password">
                    @error('password')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <button type="submit" class="purple-btn w-full">Login</button>
            </form>

            <div class="mt-5 text-center text-sm text-slate-600">
                Belum punya akun alumni?
                <a href="{{ route('register') }}" wire:navigate class="section-link">Daftar di sini</a>
            </div>
        </div>
    </section>
</div>
