@section('title', 'Daftar Alumni')

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
                    <p class="section-eyebrow">Registrasi Alumni</p>
                    <h1 class="section-title">Buat akun untuk update profil dan ajukan lowongan.</h1>
                    <p class="mt-3 section-copy">
                        Setelah daftar, kamu bisa lengkapi profil alumni, mengirim lowongan kerja, dan terkoneksi di jaringan alumni FTI.
                    </p>
                </div>
                <p class="text-sm" style="color:var(--ink-muted)">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" wire:navigate class="font-semibold" style="color:var(--brand)">Masuk di sini</a>
                </p>
            </div>

            {{-- Kanan: Form --}}
            <div class="glass-panel p-7 sm:p-8">
                <h2 class="font-display text-2xl" style="color:var(--ink)">Daftar Akun Alumni</h2>
                <p class="mt-1.5 text-sm" style="color:var(--ink-muted)">Cari NIM kamu, lalu buat akun dengan email dan password.</p>

                <form wire:submit="register" class="mt-7 space-y-5">

                    {{-- NIM Search --}}
                    <div class="form-group">
                        <label class="form-label">Cari NIM</label>
                        <input wire:model.live.debounce.250ms="nimQuery" type="text" class="input-shell"
                            placeholder="Ketik NIM kamu" autocomplete="off">
                        <p class="form-hint">NIM harus sudah didaftarkan oleh admin.</p>

                        @if (count($nimResults))
                            <div class="mt-1.5 max-h-48 overflow-auto rounded-xl border bg-white p-1.5 shadow-lg"
                                style="border-color:var(--border-md)">
                                @foreach ($nimResults as $result)
                                    @php $isReg = $result['is_registered'] ?? false; @endphp
                                    <button type="button"
                                        wire:click="selectAlumni({{ $result['id'] }})"
                                        @if($isReg) disabled @endif
                                        class="block w-full rounded-lg px-3 py-2.5 text-left text-sm transition
                                            {{ $isReg ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-50' }}">
                                        <span class="font-semibold" style="color:var(--ink)">{{ $result['nim'] }}</span>
                                        <span style="color:var(--ink-muted)"> — {{ $result['name'] }}</span>
                                        @if ($isReg)
                                            <span class="ml-1.5 rounded-full bg-emerald-50 px-2 py-0.5 text-[0.6rem] font-bold uppercase tracking-wider text-emerald-700">Terdaftar</span>
                                        @endif
                                        <span class="mt-0.5 block text-xs" style="color:var(--ink-muted)">
                                            {{ $result['program'] }} · Angkatan {{ $result['batch_year'] }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        @error('alumniProfileId')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Alumni terpilih --}}
                    @if ($this->selectedAlumni)
                        <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-3.5">
                            <p class="text-sm font-semibold text-emerald-800">✓ Alumni ditemukan</p>
                            <div class="mt-1.5 space-y-0.5 text-sm text-emerald-700">
                                <p>{{ $this->selectedAlumni->name }}</p>
                                <p>{{ $this->selectedAlumni->program }} · Angkatan {{ $this->selectedAlumni->batch_year }}</p>
                                @if($this->selectedAlumni->campus_name)
                                    <p>{{ $this->selectedAlumni->campus_name }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input wire:model.blur="email" type="email" class="input-shell"
                            placeholder="email@contoh.com" autocomplete="email">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input wire:model.blur="password" type="password" class="input-shell"
                                placeholder="Min. 8 karakter" autocomplete="new-password">
                            @error('password') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input wire:model.blur="passwordConfirmation" type="password" class="input-shell"
                                placeholder="Ulangi password" autocomplete="new-password">
                            @error('passwordConfirmation') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <button type="submit" class="purple-btn w-full justify-center mt-2" wire:loading.attr="disabled">
                        <span wire:loading.remove>Daftar Sekarang</span>
                        <span wire:loading>Mendaftarkan…</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
