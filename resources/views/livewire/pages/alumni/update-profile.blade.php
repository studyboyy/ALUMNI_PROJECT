@section('title', 'Update Profil Alumni')

<div class="py-10 lg:py-12">
    <div class="section-shell">

        {{-- Header --}}
        <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="section-eyebrow">Profil Alumni</p>
                <h1 class="section-title">Update informasi profil Anda.</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 pt-1">
                @if(auth()->user()->alumniProfile?->slug)
                    <a href="{{ route('alumni.show', auth()->user()->alumniProfile->slug) }}" wire:navigate
                        class="ghost-btn">Lihat profil publik</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="ghost-btn">Logout</button>
                </form>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">

            {{-- Foto --}}
            <div class="glass-panel p-6">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wider" style="color:var(--ink-muted)">Foto Profil</h2>
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                    <div class="flex flex-col items-center gap-2">
                        @if ($photo_file)
                            <img src="{{ $photo_file->temporaryUrl() }}" alt="Preview"
                                class="h-24 w-24 rounded-xl object-cover border" style="border-color:var(--border-md)">
                            <span class="text-xs" style="color:var(--ink-muted)">Preview baru</span>
                        @elseif ($photo_url)
                            <img src="{{ $photo_url }}" alt="Foto profil"
                                class="h-24 w-24 rounded-xl object-cover border" style="border-color:var(--border-md)">
                            <span class="text-xs" style="color:var(--ink-muted)">Foto saat ini</span>
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-xl"
                                style="background:var(--bg-base);border:1px solid var(--border-md)">
                                <svg class="h-10 w-10" style="color:var(--border-md)" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <span class="text-xs" style="color:var(--ink-muted)">Belum ada foto</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input wire:model="photo_file" type="file" accept="image/*"
                            class="block w-full text-sm file:mr-3 file:cursor-pointer file:rounded-lg file:border-0 file:px-4 file:py-2 file:text-sm file:font-medium file:transition"
                            style="color:var(--ink-muted)"
                            x-bind:style="'--file-bg:var(--brand-soft);--file-color:var(--brand-deep)'">
                        @error('photo_file') <span class="form-error mt-2">{{ $message }}</span> @enderror
                        <p class="form-hint mt-2">JPG, PNG, GIF. Maks 5MB.</p>
                    </div>
                </div>
            </div>

            {{-- Info Dasar --}}
            <div class="glass-panel p-6">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wider" style="color:var(--ink-muted)">Informasi Dasar</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input wire:model="name" type="text" class="input-shell" placeholder="Nama lengkap Anda">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input wire:model="email" type="email" class="input-shell" placeholder="email@example.com">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input wire:model="phone" type="tel" class="input-shell" placeholder="+62 812…">
                        @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Program / Jurusan <span class="required">*</span></label>
                        <input wire:model="program" type="text" class="input-shell" placeholder="Teknik Informatika">
                        @error('program') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Kampus <span class="required">*</span></label>
                        <input wire:model="campus_name" type="text" class="input-shell" placeholder="Universitas / Politeknik">
                        @error('campus_name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tahun Masuk <span class="required">*</span></label>
                        <input wire:model="batch_year" type="number" class="input-shell" placeholder="2018">
                        @error('batch_year') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tahun Lulus</label>
                        <input wire:model="graduation_year" type="number" class="input-shell" placeholder="2022">
                        @error('graduation_year') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group mt-5">
                    <label class="form-label">Bio Singkat</label>
                    <textarea wire:model="bio" class="input-shell" rows="3"
                        placeholder="Cerita singkat tentang Anda…" maxlength="500"></textarea>
                    <p class="form-hint">Maks. 500 karakter</p>
                    @error('bio') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Karir --}}
            <div class="glass-panel p-6">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wider" style="color:var(--ink-muted)">Informasi Karir</h2>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Status Pekerjaan <span class="required">*</span></label>
                        <select wire:model="employment_status" class="input-shell">
                            <option>Bekerja</option>
                            <option>Berwiraswasta</option>
                            <option>Melanjutkan Kuliah</option>
                            <option>Menganggur</option>
                            <option>Tidak Mencari Kerja</option>
                        </select>
                        @error('employment_status') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Industri</label>
                        <input wire:model="industry" type="text" class="input-shell" placeholder="Teknologi, Keuangan…">
                        @error('industry') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Perusahaan</label>
                        <input wire:model="employer" type="text" class="input-shell" placeholder="PT / CV…">
                        @error('employer') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jabatan</label>
                        <input wire:model="job_title" type="text" class="input-shell" placeholder="Senior Developer">
                        @error('job_title') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kota Bekerja</label>
                        <input wire:model="city" type="text" class="input-shell" placeholder="Jakarta">
                        @error('city') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Provinsi</label>
                        <input wire:model="province" type="text" class="input-shell" placeholder="DKI Jakarta">
                        @error('province') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Koneksi --}}
            <div class="glass-panel p-6">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wider" style="color:var(--ink-muted)">Koneksi & Testimoni</h2>
                <div class="space-y-5">
                    <div class="form-group">
                        <label class="form-label">URL LinkedIn</label>
                        <input wire:model="linkedin_url" type="url" class="input-shell"
                            placeholder="https://linkedin.com/in/…">
                        @error('linkedin_url') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kutipan / Testimoni</label>
                        <textarea wire:model="testimonial_quote" class="input-shell" rows="3"
                            placeholder="Maks. 300 karakter…" maxlength="300"></textarea>
                        <p class="form-hint">Ditampilkan di halaman profil publik Anda.</p>
                        @error('testimonial_quote') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Pencapaian --}}
            <div class="glass-panel p-6">
                <h2 class="mb-5 text-sm font-semibold uppercase tracking-wider" style="color:var(--ink-muted)">Pencapaian</h2>
                <div class="space-y-3">
                    @foreach ($achievements as $index => $achievement)
                        <div class="flex items-center gap-3">
                            <input type="text" wire:model="achievements.{{ $index }}"
                                class="input-shell flex-1" placeholder="Pencapaian Anda">
                            <button type="button" wire:click="removeAchievement({{ $index }})"
                                class="flex-shrink-0 rounded-lg border p-2 transition hover:bg-red-50"
                                style="border-color:#fca5a5;color:#ef4444">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" wire:click="addAchievement('')"
                    class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold transition"
                    style="color:var(--brand)">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pencapaian
                </button>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('alumni.dashboard') }}" wire:navigate class="ghost-btn">Batal</a>
                <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan…</span>
                </button>
            </div>
        </form>
    </div>
</div>
