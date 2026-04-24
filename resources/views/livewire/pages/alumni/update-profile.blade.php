@section('title', 'Update Profil Alumni')

<div class="space-y-10">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Profil Alumni</p>
                <h1 class="section-title">Update informasi profil Anda di direktori alumni.</h1>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('alumni.show', auth()->user()->alumniProfile?->slug ?? '#') }}" wire:navigate
                    class="section-link">Lihat profil publik</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="rounded-full border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Logout</button>
                </form>
            </div>
        </div>
    </section>

    <form wire:submit="save" class="space-y-10">
        <!-- Foto Profil -->
        <section>
            <div class="glass-panel p-6">
                <h2 class="mb-6 text-lg font-semibold text-slate-900">Foto Profil</h2>

                <div class="flex flex-col gap-6 lg:flex-row">
                    <!-- Current/Preview Photo -->
                    <div class="flex flex-col items-center gap-3">
                        @if ($photo_file)
                            <img src="{{ $photo_file->temporaryUrl() }}" alt="Preview"
                                class="h-32 w-32 rounded-full object-cover border-2 border-violet-200">
                            <p class="text-sm text-slate-600">Preview foto baru</p>
                        @elseif ($photo_url)
                            <img src="{{ $photo_url }}" alt="Foto profil"
                                class="h-32 w-32 rounded-full object-cover border-2 border-violet-200">
                            <p class="text-sm text-slate-600">Foto saat ini</p>
                        @else
                            <div class="h-32 w-32 rounded-full bg-slate-200 flex items-center justify-center">
                                <svg class="h-16 w-16 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <p class="text-sm text-slate-600">Belum ada foto</p>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1 space-y-3">
                        <label class="block">
                            <div class="relative">
                                <input wire:model="photo_file" type="file" accept="image/*" class="sr-only">
                                <div
                                    class="flex items-center gap-3 rounded-full border-2 border-dashed border-slate-300 bg-white px-6 py-4 cursor-pointer transition hover:border-violet-300 hover:bg-violet-50">
                                    <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $photo_file ? 'Ubah foto' : 'Upload foto' }}
                                    </span>
                                </div>
                            </div>
                        </label>
                        @error('photo_file')
                            <span class="text-sm text-rose-500">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-slate-500">JPG, PNG, GIF. Max 5MB. Foto akan ditampilkan di profil
                            publik.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Informasi Dasar -->
        <section>
            <div class="glass-panel p-6">
                <h2 class="mb-6 text-lg font-semibold text-slate-900">Informasi Dasar</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Nama Lengkap *</span>
                        <input wire:model="name" type="text" class="input-shell" placeholder="Nama lengkap Anda">
                        @error('name')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Email *</span>
                        <input wire:model="email" type="email" class="input-shell" placeholder="email@example.com">
                        @error('email')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Nomor Telepon</span>
                        <input wire:model="phone" type="tel" class="input-shell" placeholder="+62 812...">
                        @error('phone')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Program/Jurusan *</span>
                        <input wire:model="program" type="text" class="input-shell" placeholder="Teknik Informatika">
                        @error('program')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Nama Kampus *</span>
                        <input wire:model="campus_name" type="text" class="input-shell"
                            placeholder="Universitas / Institut / Politeknik">
                        @error('campus_name')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Tahun Masuk *</span>
                        <input wire:model="batch_year" type="number" class="input-shell" placeholder="2015">
                        @error('batch_year')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Tahun Lulus</span>
                        <input wire:model="graduation_year" type="number" class="input-shell" placeholder="2019">
                        @error('graduation_year')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <label class="mt-4 block space-y-2 text-sm text-slate-600">
                    <span>Bio/Deskripsi Singkat</span>
                    <textarea wire:model="bio" class="input-shell min-h-24" placeholder="Cerita singkat tentang Anda (max 500 karakter)..."
                        maxlength="500"></textarea>
                    @error('bio')
                        <span class="text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </section>

        <!-- Informasi Karir -->
        <section>
            <div class="glass-panel p-6">
                <h2 class="mb-6 text-lg font-semibold text-slate-900">Informasi Karir</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Status Pekerjaan *</span>
                        <select wire:model="employment_status" class="input-shell">
                            <option>Bekerja</option>
                            <option>Menganggur</option>
                            <option>Melanjutkan Kuliah</option>
                            <option>Berwiraswasta</option>
                            <option>Tidak Mencari Kerja</option>
                        </select>
                        @error('employment_status')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Industri</span>
                        <input wire:model="industry" type="text" class="input-shell"
                            placeholder="Teknologi, Keuangan, dll">
                        @error('industry')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Nama Perusahaan</span>
                        <input wire:model="employer" type="text" class="input-shell" placeholder="PT/CV...">
                        @error('employer')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Jabatan</span>
                        <input wire:model="job_title" type="text" class="input-shell"
                            placeholder="Senior Developer">
                        @error('job_title')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Kota Bekerja</span>
                        <input wire:model="city" type="text" class="input-shell" placeholder="Jakarta">
                        @error('city')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Provinsi</span>
                        <input wire:model="province" type="text" class="input-shell" placeholder="DKI Jakarta">
                        @error('province')
                            <span class="text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
            </div>
        </section>

        <!-- Koneksi & Testimoni -->
        <section>
            <div class="glass-panel p-6">
                <h2 class="mb-6 text-lg font-semibold text-slate-900">Koneksi & Testimoni</h2>

                <label class="block space-y-2 text-sm text-slate-600">
                    <span>URL LinkedIn</span>
                    <input wire:model="linkedin_url" type="url" class="input-shell"
                        placeholder="https://linkedin.com/in/yourprofile">
                    @error('linkedin_url')
                        <span class="text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <label class="mt-4 block space-y-2 text-sm text-slate-600">
                    <span>Testimoni/Kutipan Motivasi</span>
                    <textarea wire:model="testimonial_quote" class="input-shell min-h-20"
                        placeholder="Pesan motivasi atau kutipan favorit Anda (max 300 karakter)..." maxlength="300"></textarea>
                    <p class="text-xs text-slate-500">Testimoni ini akan ditampilkan di halaman publik Anda.</p>
                    @error('testimonial_quote')
                        <span class="text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </section>

        <!-- Pencapaian -->
        <section>
            <div class="glass-panel p-6">
                <h2 class="mb-6 text-lg font-semibold text-slate-900">Pencapaian</h2>

                <div class="space-y-3">
                    @foreach ($achievements as $index => $achievement)
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model="achievements.{{ $index }}"
                                class="input-shell flex-1" placeholder="Pencapaian Anda">
                            <button type="button" wire:click="removeAchievement({{ $index }})"
                                class="rounded-full border border-rose-300 p-2 text-rose-600 transition hover:bg-rose-50">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" wire:click="addAchievement('')"
                    class="mt-3 text-sm text-violet-600 hover:text-violet-700 font-medium">
                    + Tambah Pencapaian
                </button>
            </div>
        </section>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('home') }}" wire:navigate
                class="rounded-full border border-slate-300 px-8 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">
                Batal
            </a>
            <button type="submit" class="purple-btn">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
