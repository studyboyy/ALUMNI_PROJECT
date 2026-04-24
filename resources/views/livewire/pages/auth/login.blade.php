@section('title', 'Login Alumni / Admin')

<div class="py-10 sm:py-14">
    <section class="section-shell grid items-start gap-8 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="space-y-6">
            <a href="{{ route('home') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-violet-700">
                <span aria-hidden="true">&larr;</span>
                <span>Kembali ke halaman publik</span>
            </a>
            <p class="section-eyebrow">Login Area</p>
            <h1 class="section-title max-w-2xl">Masuk sebagai admin atau alumni.</h1>
            <p class="section-copy">Admin dapat mengelola data alumni dan approval lowongan. Alumni dapat mengajukan
                lowongan yang akan diverifikasi oleh admin terlebih dahulu.</p>

            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4 text-sm text-slate-600 shadow-sm">
                <p class="font-semibold text-slate-900">Akun demo seeder</p>
                <p class="mt-2">Admin: admin@alumni-fti.test</p>
                <p>Alumni: alumni@alumni-fti.test</p>
                <p class="mt-1 text-slate-500">Password default user factory umumnya "password".</p>
            </div>
        </div>

        <div class="glass-panel p-6 sm:p-8">
            <h2 class="font-display text-2xl text-slate-900">Masuk Akun</h2>
            <p class="mt-1 text-sm text-slate-600">Gunakan email dan password yang terdaftar.</p>

            <form wire:submit="authenticate" class="mt-6 space-y-4">
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Email</span>
                    <input wire:model.blur="email" type="email" class="input-shell"
                        placeholder="admin@alumni-fti.test">
                    @error('email')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <label class="space-y-2 text-sm text-slate-600">
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
                <a href="{{ route('register') }}" wire:navigate
                    class="font-semibold text-violet-700 hover:text-violet-800">Daftar di sini</a>
            </div>
        </div>
    </section>
</div>
