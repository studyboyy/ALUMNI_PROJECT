@section('title', 'Dashboard Alumni')

<div class="py-10 lg:py-12">
    <div class="section-shell space-y-5">

        {{-- Top stats + profile card --}}
        <div class="grid gap-5 lg:grid-cols-[1fr_300px] lg:items-start">

            <div class="glass-panel p-6">
                <p class="section-eyebrow">Dashboard Alumni</p>
                <h1 class="section-title mt-1">Kelola profil dan kontribusi karier.</h1>

                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    <article class="card-subtle">
                        <p class="text-xs text-gray-500">Profil Lengkap</p>
                        <p class="mt-1.5 font-display text-2xl text-gray-900">{{ $completionRate }}%</p>
                    </article>
                    <article class="card-subtle">
                        <p class="text-xs text-gray-500">Lowongan Diajukan</p>
                        <p class="mt-1.5 font-display text-2xl text-gray-900">{{ $jobStats['submitted'] }}</p>
                    </article>
                    <article class="card-subtle">
                        <p class="text-xs text-gray-500">Menunggu Review</p>
                        <p class="mt-1.5 font-display text-2xl text-gray-900">{{ $jobStats['pending'] }}</p>
                    </article>
                </div>

                <div class="mt-5 flex flex-wrap gap-2.5">
                    <a href="{{ route('alumni.update-profile') }}" wire:navigate class="purple-btn">Update Profil</a>
                    <a href="{{ route('alumni.submit-job') }}" wire:navigate class="outline-btn">Ajukan Lowongan</a>
                    @if ($profile?->slug)
                        <a href="{{ route('alumni.show', $profile->slug) }}" wire:navigate class="ghost-btn">Lihat Profil Publik</a>
                    @endif
                </div>
            </div>

            <div class="glass-panel p-5">
                <div class="flex items-center gap-3">
                    @if ($profile?->photo_url)
                        <img src="{{ $profile->photo_url }}" alt="{{ $profile->name }}"
                            class="h-16 w-16 flex-shrink-0 rounded-xl object-cover">
                    @else
                        <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-xl bg-gray-100 text-lg font-bold text-gray-400">
                            {{ auth()->user()?->initials() }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $profile?->name ?? auth()->user()?->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $profile?->campus_name ?: '—' }}</p>
                        <p class="text-sm truncate" style="color:var(--brand-deep)">{{ $profile?->program ?: '—' }}</p>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="card-subtle flex items-center justify-between text-sm">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium text-gray-800 truncate ml-3">{{ auth()->user()?->email }}</span>
                    </div>
                    <div class="card-subtle flex items-center justify-between text-sm">
                        <span class="text-gray-500">Status</span>
                        <span class="font-medium text-gray-800">{{ $profile?->employment_status ?: '—' }}</span>
                    </div>
                    <div class="card-subtle flex items-center justify-between text-sm">
                        <span class="text-gray-500">Disetujui</span>
                        <span class="font-medium text-gray-800">{{ $jobStats['approved'] }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="ghost-btn w-full justify-center">Logout</button>
                </form>
            </div>
        </div>

        {{-- Jobs + Checklist --}}
        <div class="grid gap-5 lg:grid-cols-[1fr_340px]">
            <div class="glass-panel p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="section-eyebrow">Riwayat Lowongan</p>
                        <h2 class="mt-0.5 font-display text-xl text-gray-900">Pengajuan lowongan Anda.</h2>
                    </div>
                    <a href="{{ route('alumni.submit-job') }}" wire:navigate class="section-link">Kelola</a>
                </div>
                <div class="space-y-2.5">
                    @forelse ($recentJobs as $job)
                        <article class="card-subtle flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900">{{ $job->title }}</p>
                                <p class="text-sm text-gray-500">{{ $job->company }} · {{ $job->location }}</p>
                            </div>
                            <span class="flex-shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $job->approval_status === 'approved' ? 'bg-emerald-50 text-emerald-700' :
                                   ($job->approval_status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                                {{ ucfirst($job->approval_status) }}
                            </span>
                        </article>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada lowongan yang diajukan.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-panel p-5">
                <p class="section-eyebrow mb-3">Langkah Berikutnya</p>
                <ul class="space-y-2">
                    @foreach([
                        'Lengkapi foto profil profesional.',
                        'Isi kampus, kota, dan posisi kerja terbaru.',
                        'Tambahkan LinkedIn dan pencapaian.',
                        'Ajukan lowongan jika ada posisi terbuka.',
                    ] as $tip)
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <span class="mt-1.5 h-1.5 w-1.5 flex-shrink-0 rounded-full" style="background:var(--brand)"></span>
                            {{ $tip }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>
