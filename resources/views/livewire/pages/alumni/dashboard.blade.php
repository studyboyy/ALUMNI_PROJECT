@section('title', 'Dashboard Mahasiswa')

<div class="space-y-10 py-10 lg:py-14">
    <section class="section-shell grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
        <div class="glass-panel p-6 sm:p-8">
            <p class="section-eyebrow">Dashboard Mahasiswa</p>
            <h1 class="section-title">Kelola profil alumni dan kontribusi karier dari satu tempat.</h1>
            <p class="section-copy">Dashboard ini merangkum progres profil, status lowongan yang pernah diajukan, dan
                akses cepat ke fitur alumni.</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <article class="card-subtle">
                    <p class="text-sm text-slate-500">Profil Lengkap</p>
                    <p class="mt-2 font-display text-3xl text-slate-900">{{ $completionRate }}%</p>
                </article>
                <article class="card-subtle">
                    <p class="text-sm text-slate-500">Lowongan Diajukan</p>
                    <p class="mt-2 font-display text-3xl text-slate-900">{{ $jobStats['submitted'] }}</p>
                </article>
                <article class="card-subtle">
                    <p class="text-sm text-slate-500">Menunggu Review</p>
                    <p class="mt-2 font-display text-3xl text-slate-900">{{ $jobStats['pending'] }}</p>
                </article>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('alumni.update-profile') }}" wire:navigate class="purple-btn">Update Profil</a>
                <a href="{{ route('alumni.submit-job') }}" wire:navigate
                    class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Ajukan
                    Lowongan</a>
                @if ($profile?->slug)
                    <a href="{{ route('alumni.show', $profile->slug) }}" wire:navigate
                        class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Lihat
                        Profil Publik</a>
                @endif
            </div>
        </div>

        <div class="glass-panel p-6">
            <div class="flex items-center gap-4">
                @if ($profile?->photo_url)
                    <img src="{{ $profile->photo_url }}" alt="{{ $profile->name }}"
                        class="h-20 w-20 rounded-3xl object-cover">
                @else
                    <div
                        class="flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-200 text-2xl font-bold text-slate-500">
                        {{ auth()->user()?->initials() }}
                    </div>
                @endif
                <div>
                    <p class="font-display text-2xl text-slate-900">{{ $profile?->name ?? auth()->user()?->name }}</p>
                    <p class="text-sm text-slate-500">{{ $profile?->campus_name ?: 'Kampus belum diisi' }}</p>
                    <p class="text-sm text-violet-700">{{ $profile?->program ?: 'Program studi belum diisi' }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                    <span>Email</span>
                    <span class="font-semibold text-slate-900">{{ auth()->user()?->email }}</span>
                </div>
                <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                    <span>Status kerja</span>
                    <span class="font-semibold text-slate-900">{{ $profile?->employment_status ?: '-' }}</span>
                </div>
                <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                    <span>Lowongan disetujui</span>
                    <span class="font-semibold text-slate-900">{{ $jobStats['approved'] }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit"
                    class="w-full rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Logout</button>
            </form>
        </div>
    </section>

    <section class="section-shell grid gap-6 lg:grid-cols-[1fr_0.9fr]">
        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">Lowongan Terbaru</p>
                    <h2 class="section-title">Riwayat pengajuan lowongan Anda.</h2>
                </div>
                <a href="{{ route('alumni.submit-job') }}" wire:navigate class="section-link">Kelola lowongan</a>
            </div>

            <div class="space-y-3">
                @forelse ($recentJobs as $job)
                    <article class="card-subtle">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $job->company }} · {{ $job->location }}</p>
                            </div>
                            <span
                                class="rounded-full px-3 py-1 text-xs font-semibold {{ $job->approval_status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($job->approval_status === 'rejected' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                                {{ ucfirst($job->approval_status) }}
                            </span>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-slate-200 p-4 text-sm text-slate-500">
                        Belum ada lowongan yang diajukan.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">Langkah Berikutnya</p>
                    <h2 class="section-title">Checklist agar profil alumni Anda lebih kuat.</h2>
                </div>
            </div>

            <div class="space-y-3 text-sm text-slate-600">
                <div class="card-subtle">Lengkapi foto profil profesional.</div>
                <div class="card-subtle">Isi kampus, kota, dan posisi kerja terbaru.</div>
                <div class="card-subtle">Tambahkan LinkedIn dan pencapaian utama.</div>
                <div class="card-subtle">Ajukan lowongan jika perusahaan Anda sedang membuka posisi.</div>
            </div>
        </div>
    </section>
</div>
