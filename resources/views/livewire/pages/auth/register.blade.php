@section('title', 'Daftar Alumni')

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
                <h1 class="font-display text-4xl text-white leading-snug">Bergabung<br>dengan kami!</h1>
                <p class="text-sm text-white/75 max-w-xs leading-relaxed">
                    Buat akun untuk update profil alumni, mengirim lowongan, dan terkoneksi di jaringan alumni FTI.
                </p>

                {{-- Feature bullets --}}
                <ul class="space-y-3 pt-2">
                    <li class="flex items-center gap-3 text-sm text-white/85">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg"
                              style="background:rgba(255,255,255,.15)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        Profil alumni yang bisa diperbarui kapan saja
                    </li>
                    <li class="flex items-center gap-3 text-sm text-white/85">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg"
                              style="background:rgba(255,255,255,.15)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </span>
                        Forum diskusi & komunitas alumni FTI
                    </li>
                    <li class="flex items-center gap-3 text-sm text-white/85">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg"
                              style="background:rgba(255,255,255,.15)">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </span>
                        Submit & kelola lowongan kerja
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
                    <p class="section-eyebrow">Registrasi Alumni</p>
                    <h2 class="font-display text-3xl mt-1" style="color:var(--ink)">Buat Akun</h2>
                    <p class="mt-1.5 text-sm" style="color:var(--ink-muted)">Cari NIM kamu, lalu buat akun dengan email dan password.</p>
                </div>

                <form wire:submit="register" class="space-y-5">

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
                        <span wire:loading.remove class="flex items-center gap-2">
                            Daftar Sekarang
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                        <span wire:loading>Mendaftarkan…</span>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm" style="color:var(--ink-muted)">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" wire:navigate class="font-semibold" style="color:var(--brand)">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
