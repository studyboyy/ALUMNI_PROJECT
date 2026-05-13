@section('title', 'Daftar Alumni')

<div class="py-12 sm:py-16">
    <section class="section-shell grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="space-y-7">
            <a href="{{ route('home') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-slate-700">
                <span aria-hidden="true">&larr;</span>
                <span>Kembali ke halaman publik</span>
            </a>
            <p class="section-eyebrow">Registrasi Alumni</p>
            <h1 class="section-title max-w-2xl">Buat akun alumni untuk update profil dan kontribusi lowongan.</h1>
            <p class="section-copy">Setelah daftar, kamu bisa lengkapi profil alumni, mengirim lowongan kerja, dan ikut
                terkoneksi di jaringan alumni.</p>
            <p class="text-sm text-slate-600">Sudah punya akun? <a href="{{ route('login') }}" wire:navigate
                    class="section-link">Login di sini</a></p>
        </div>

        <div class="glass-panel p-7 sm:p-9">
            <h2 class="font-display text-2xl text-slate-900 sm:text-3xl">Daftar Akun Alumni</h2>
            <p class="mt-1 text-sm text-slate-600">Cari NIM kamu, lalu buat akun dengan email dan password.</p>

            <form wire:submit="register" class="mt-7 space-y-5">
                <label class="space-y-2 text-sm font-medium text-slate-600">
                    <span>Cari NIM</span>
                    <input wire:model.live.debounce.250ms="nimQuery" type="text" class="input-shell"
                        placeholder="Ketik NIM kamu" autocomplete="off">
                    <p class="text-xs text-slate-500">NIM harus sudah didaftarkan admin.</p>

                    @if (count($nimResults))
                        <div
                            class="max-h-52 overflow-auto rounded-2xl border border-slate-200/80 bg-white/90 p-2 shadow-sm shadow-slate-200/60">
                            @foreach ($nimResults as $result)
                                @php
                                    $isRegistered = $result['is_registered'] ?? false;
                                @endphp
                                <button type="button" wire:click="selectAlumni({{ $result['id'] }})"
                                    @if ($isRegistered) disabled
                                        class="block w-full cursor-not-allowed rounded-xl px-3 py-2 text-left text-sm text-slate-400 opacity-70"
                                    @else
                                        class="block w-full rounded-xl px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-[color:var(--brand-soft)] hover:text-[color:var(--brand-deep)]" @endif>
                                    <span class="font-semibold">{{ $result['nim'] }}</span>
                                    <span class="text-slate-500">— {{ $result['name'] }}</span>
                                    @if ($isRegistered)
                                        <span
                                            class="ml-2 inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-emerald-700">Terdaftar</span>
                                    @endif
                                    <span class="block text-xs text-slate-500">{{ $result['program'] }} · Angkatan
                                        {{ $result['batch_year'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @error('alumniProfileId')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                @if ($this->selectedAlumni)
                    <div class="card-subtle text-sm text-slate-700">
                        <p class="font-semibold text-slate-900">Data alumni ditemukan</p>
                        <p class="mt-2">Nama: <span class="font-medium">{{ $this->selectedAlumni->name }}</span></p>
                        <p>Program Studi: <span class="font-medium">{{ $this->selectedAlumni->program }}</span></p>
                        <p>Angkatan: <span class="font-medium">{{ $this->selectedAlumni->batch_year }}</span></p>
                        <p>Kampus: <span class="font-medium">{{ $this->selectedAlumni->campus_name ?: '-' }}</span></p>
                    </div>
                @endif

                <label class="space-y-2 text-sm font-medium text-slate-600">
                    <span>Email</span>
                    <input wire:model.blur="email" type="email" class="input-shell" placeholder="email@contoh.com">
                    @error('email')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="space-y-2 text-sm font-medium text-slate-600">
                        <span>Password</span>
                        <input wire:model.blur="password" type="password" class="input-shell"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm font-medium text-slate-600">
                        <span>Konfirmasi Password</span>
                        <input wire:model.blur="passwordConfirmation" type="password" class="input-shell"
                            placeholder="Ulangi password">
                        @error('passwordConfirmation')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <button type="submit" class="purple-btn w-full">Daftar Alumni</button>
            </form>
        </div>
    </section>
</div>
