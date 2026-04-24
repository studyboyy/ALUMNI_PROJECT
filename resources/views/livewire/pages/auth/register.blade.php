@section('title', 'Daftar Alumni')

<div class="py-10 sm:py-14">
    <section class="section-shell grid items-start gap-8 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="space-y-6">
            <a href="{{ route('home') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-violet-700">
                <span aria-hidden="true">&larr;</span>
                <span>Kembali ke halaman publik</span>
            </a>
            <p class="section-eyebrow">Registrasi Alumni</p>
            <h1 class="section-title max-w-2xl">Buat akun alumni untuk update profil dan kontribusi lowongan.</h1>
            <p class="section-copy">Setelah daftar, kamu bisa lengkapi profil alumni, mengirim lowongan kerja, dan ikut
                terkoneksi di jaringan alumni.</p>
            <p class="text-sm text-slate-600">Sudah punya akun? <a href="{{ route('login') }}" wire:navigate
                    class="font-semibold text-violet-700 hover:text-violet-800">Login di sini</a></p>

            <div class="rounded-2xl border border-slate-200 bg-white/75 p-4 text-sm text-slate-600 shadow-sm">
                <p class="font-semibold text-slate-900">Data kampus Indonesia</p>
                <p class="mt-2">Field nama kampus memakai pencarian dari API data kampus Indonesia. Ketik minimal 2
                    huruf untuk melihat rekomendasi.</p>
            </div>
        </div>

        <div class="glass-panel p-6 sm:p-8" x-data="{
            campusQuery: @entangle('campusName').live,
            campusOptions: [],
            isLoading: false,
            timer: null,
            async fetchCampuses() {
                const q = (this.campusQuery || '').trim();
                if (q.length < 2) { this.campusOptions = []; return; }
                this.isLoading = true;
                try {
                    const res = await fetch(`{{ route('api.campuses') }}?q=${encodeURIComponent(q)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const json = await res.json();
                    this.campusOptions = Array.isArray(json.data) ? json.data : [];
                } catch (_) {
                    this.campusOptions = [];
                } finally {
                    this.isLoading = false;
                }
            },
            onCampusInput() {
                clearTimeout(this.timer);
                this.timer = setTimeout(() => this.fetchCampuses(), 220);
            }
        }">
            <h2 class="font-display text-2xl text-slate-900">Daftar Akun Alumni</h2>
            <p class="mt-1 text-sm text-slate-600">Lengkapi data awal, nanti profil bisa diperbarui kapan saja.</p>

            <form wire:submit="register" class="mt-6 space-y-4">
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Nama Lengkap</span>
                    <input wire:model.blur="name" type="text" class="input-shell" placeholder="Nama lengkap">
                    @error('name')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <label class="space-y-2 text-sm text-slate-600">
                    <span>Email</span>
                    <input wire:model.blur="email" type="email" class="input-shell" placeholder="email@contoh.com">
                    @error('email')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Password</span>
                        <input wire:model.blur="password" type="password" class="input-shell"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Konfirmasi Password</span>
                        <input wire:model.blur="passwordConfirmation" type="password" class="input-shell"
                            placeholder="Ulangi password">
                        @error('passwordConfirmation')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600 sm:col-span-2">
                        <span>Nama Kampus</span>
                        <input x-model="campusQuery" @input="onCampusInput" type="text" class="input-shell"
                            placeholder="Ketik nama kampus, contoh: Universitas Indonesia" autocomplete="off">
                        <p class="text-xs text-slate-500">Boleh pilih dari rekomendasi atau isi manual jika kampus belum tersedia di API.</p>
                        <div x-show="isLoading" class="text-xs text-slate-500">Memuat data kampus...</div>

                        <template x-if="campusOptions.length">
                            <div
                                class="max-h-48 overflow-auto rounded-xl border border-slate-200 bg-white p-2 shadow-sm">
                                <template x-for="(campus, idx) in campusOptions" :key="idx">
                                    <button type="button" @click="campusQuery = campus; campusOptions = [];"
                                        class="block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-violet-50 hover:text-violet-800"
                                        x-text="campus"></button>
                                </template>
                            </div>
                        </template>

                        @error('campusName')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Program Studi</span>
                        <input wire:model.blur="program" type="text" class="input-shell"
                            placeholder="Teknik Informatika">
                        @error('program')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Angkatan</span>
                        <input wire:model.blur="batchYear" type="number" class="input-shell" placeholder="2018">
                        @error('batchYear')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Tahun Lulus (opsional)</span>
                        <input wire:model.blur="graduationYear" type="number" class="input-shell" placeholder="2022">
                        @error('graduationYear')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>No. HP (opsional)</span>
                        <input wire:model.blur="phone" type="text" class="input-shell" placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <button type="submit" class="purple-btn w-full">Daftar Alumni</button>
            </form>
        </div>
    </section>
</div>
