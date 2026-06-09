@section('title', 'Tracer Study Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Header --}}
    <section class="section-shell mb-8 grid gap-6 lg:grid-cols-[1fr_320px]">
        <div class="space-y-4">
            <p class="section-eyebrow">Tracer Study</p>
            <h1 class="section-title max-w-xl">Isi form tracer study alumni FTI.</h1>
            <p class="section-copy">
                Tracer study membantu fakultas memahami kondisi alumni setelah lulus.
                Data Anda langsung tersimpan ke sistem.
            </p>
            <div class="flex flex-wrap gap-3 pt-1">
                <a href="#form-tracer" class="purple-btn">Isi Form Sekarang</a>
                <a href="#hasil" class="outline-btn">Lihat Hasil</a>
            </div>
        </div>
        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-3">Tujuan Tracer Study</p>
            <ul class="space-y-3">
                @foreach([
                    'Mengukur relevansi kurikulum dengan kebutuhan industri.',
                    'Memetakan status kerja, bidang industri, dan lokasi alumni.',
                    'Menjadi dasar perumusan program kerja alumni dan fakultas.',
                ] as $item)
                    <li class="flex items-start gap-2.5 text-sm" style="color:var(--ink-2)">
                        <span class="mt-1.5 h-1.5 w-1.5 flex-shrink-0 rounded-full" style="background:var(--brand)"></span>
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
            @if ($totalResponses > 0)
                <div class="mt-4 rounded-lg px-3 py-2.5 text-sm font-medium"
                    style="background:var(--brand-soft);color:var(--brand-deep)">
                    {{ number_format($totalResponses) }} alumni sudah mengisi form ini.
                </div>
            @endif
        </div>
    </section>

    {{-- Form --}}
    <section id="form-tracer" class="section-shell mb-10">
        <div class="mb-5">
            <p class="section-eyebrow">Form Tracer Study</p>
            <h2 class="section-title">Isi data Anda</h2>
        </div>

        @if ($submitted)
            <div class="glass-panel flex flex-col items-center gap-4 py-14 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-full"
                    style="background:var(--brand-soft)">
                    <svg class="h-7 w-7" style="color:var(--brand)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="font-sans text-2xl" style="color:var(--ink)">Terima kasih, {{ $name }}!</p>
                    <p class="mt-1 text-sm" style="color:var(--ink-muted)">Respons Anda tersimpan dan sangat berarti bagi pengembangan FTI.</p>
                </div>
                <a href="#hasil" class="outline-btn mt-2">Lihat Ringkasan Data</a>
            </div>

        @elseif ($alreadySubmitted)
            <div class="glass-panel flex flex-col items-center gap-3 py-14 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-amber-50">
                    <svg class="h-7 w-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="font-sans text-2xl" style="color:var(--ink)">Anda sudah mengisi form ini</p>
                <p class="text-sm" style="color:var(--ink-muted)">Terima kasih atas partisipasi Anda!</p>
            </div>

        @else
            <form wire:submit="submit" class="space-y-6">

                {{-- A. Identitas --}}
                <div class="glass-panel p-6">
                    <h3 class="mb-5 text-base font-semibold" style="color:var(--ink)">A. Identitas Diri</h3>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input wire:model="name" type="text" class="input-shell" placeholder="Nama lengkap Anda">
                            @error('name') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIM</label>
                            <input wire:model="nim" type="text" class="input-shell" placeholder="Nomor Induk Mahasiswa">
                            @error('nim') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input wire:model="email" type="email" class="input-shell" placeholder="email@example.com">
                            @error('email') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor HP</label>
                            <input wire:model="phone" type="tel" class="input-shell" placeholder="+62 812…">
                            @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program Studi <span class="required">*</span></label>
                            <input wire:model="program" type="text" class="input-shell" placeholder="Teknik Informatika">
                            @error('program') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Angkatan <span class="required">*</span></label>
                            <input wire:model="batch_year" type="number" class="input-shell" placeholder="2018">
                            @error('batch_year') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun Lulus</label>
                            <input wire:model="graduation_year" type="number" class="input-shell" placeholder="2022">
                            @error('graduation_year') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- B. Pekerjaan --}}
                <div class="glass-panel p-6">
                    <h3 class="mb-5 text-base font-semibold" style="color:var(--ink)">B. Kondisi Pekerjaan Saat Ini</h3>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="form-group">
                            <label class="form-label">Status Pekerjaan <span class="required">*</span></label>
                            <select wire:model.live="employment_status" class="input-shell">
                                <option value="Bekerja">Bekerja</option>
                                <option value="Berwiraswasta">Berwiraswasta / Wirausaha</option>
                                <option value="Melanjutkan Kuliah">Melanjutkan Studi (S2/S3)</option>
                                <option value="Menganggur">Belum Bekerja</option>
                                <option value="Tidak Mencari Kerja">Tidak Mencari Kerja</option>
                            </select>
                            @error('employment_status') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        @if (in_array($employment_status, ['Bekerja', 'Berwiraswasta']))
                            <div class="form-group">
                                <label class="form-label">Nama Perusahaan / Instansi</label>
                                <input wire:model="employer" type="text" class="input-shell" placeholder="PT / CV / Instansi">
                                @error('employer') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jabatan / Posisi</label>
                                <input wire:model="job_title" type="text" class="input-shell" placeholder="Software Engineer">
                                @error('job_title') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bidang Industri</label>
                                <input wire:model="industry" type="text" class="input-shell" placeholder="Teknologi, Perbankan…">
                                @error('industry') <span class="form-error">{{ $message }}</span> @enderror
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
                            <div class="form-group">
                                <label class="form-label">Kesesuaian Bidang Studi dengan Pekerjaan</label>
                                <select wire:model="job_relevance" class="input-shell">
                                    <option value="">— Pilih —</option>
                                    <option value="Sangat Sesuai">Sangat Sesuai</option>
                                    <option value="Sesuai">Sesuai</option>
                                    <option value="Kurang Sesuai">Kurang Sesuai</option>
                                    <option value="Tidak Sesuai">Tidak Sesuai</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Lama mencari kerja setelah lulus</label>
                                <input wire:model="waiting_time_months" type="number" class="input-shell"
                                    placeholder="3" min="0" max="120">
                                <p class="form-hint">Dalam satuan bulan</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- C. Evaluasi --}}
                <div class="glass-panel p-6">
                    <h3 class="mb-5 text-base font-semibold" style="color:var(--ink)">C. Evaluasi Kurikulum & Saran</h3>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="form-group">
                            <label class="form-label">Penilaian Kurikulum (1–5)</label>
                            <select wire:model="curriculum_rating" class="input-shell">
                                <option value="">— Pilih —</option>
                                <option value="5">5 – Sangat Baik</option>
                                <option value="4">4 – Baik</option>
                                <option value="3">3 – Cukup</option>
                                <option value="2">2 – Kurang</option>
                                <option value="1">1 – Sangat Kurang</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-5">
                        <label class="form-label">Saran untuk Program Studi</label>
                        <textarea wire:model="suggestion" class="input-shell"
                            placeholder="Tuliskan saran atau masukan untuk program studi…" maxlength="1000"></textarea>
                        <p class="form-hint">Maks. 1000 karakter</p>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                    @guest
                        <p class="text-sm" style="color:var(--ink-muted)">
                            <a href="{{ route('login') }}" wire:navigate class="font-semibold" style="color:var(--brand)">Login</a>
                            agar respons tersimpan ke akun Anda.
                        </p>
                    @endguest
                    <div class="ml-auto">
                        <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                            <span wire:loading.remove>Kirim Respons</span>
                            <span wire:loading>Menyimpan…</span>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </section>

    {{-- Hasil --}}
    <section id="hasil" class="section-shell">
        <div class="mb-5">
            <p class="section-eyebrow">Ringkasan Data</p>
            <h2 class="section-title">Statistik Alumni FTI</h2>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            <div class="glass-panel p-5">
                <p class="section-eyebrow mb-3">Status Kerja</p>
                @forelse ($employmentBreakdown as $item)
                    <div class="flex items-center justify-between border-b py-2.5 text-sm last:border-0"
                        style="border-color:var(--border)">
                        <span style="color:var(--ink-2)">{{ $item->employment_status }}</span>
                        <span class="font-semibold" style="color:var(--ink)">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-sm" style="color:var(--ink-muted)">Belum ada data.</p>
                @endforelse
            </div>
            <div class="glass-panel p-5">
                <p class="section-eyebrow mb-3">Bidang Industri (Top 5)</p>
                @forelse ($industryBreakdown as $item)
                    <div class="flex items-center justify-between border-b py-2.5 text-sm last:border-0"
                        style="border-color:var(--border)">
                        <span style="color:var(--ink-2)">{{ $item->industry }}</span>
                        <span class="font-semibold" style="color:var(--ink)">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-sm" style="color:var(--ink-muted)">Belum ada data.</p>
                @endforelse
            </div>
            <div class="glass-panel p-5">
                <p class="section-eyebrow mb-3">Lokasi Kerja (Top 5)</p>
                @forelse ($cityBreakdown as $item)
                    <div class="flex items-center justify-between border-b py-2.5 text-sm last:border-0"
                        style="border-color:var(--border)">
                        <span style="color:var(--ink-2)">{{ $item->city }}</span>
                        <span class="font-semibold" style="color:var(--ink)">{{ $item->total }}</span>
                    </div>
                @empty
                    <p class="text-sm" style="color:var(--ink-muted)">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
