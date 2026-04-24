@section('title', $alumniProfile->name)

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[0.75fr_1.25fr]">
        <div class="glass-panel p-5">
            <img src="{{ $alumniProfile->photo_url }}" alt="{{ $alumniProfile->name }}"
                class="h-[28rem] w-full rounded-[2rem] object-cover">
        </div>
        <div class="space-y-6">
            <div>
                <a href="{{ route('alumni.index') }}" wire:navigate class="section-link">Kembali ke direktori alumni</a>
                <h1 class="mt-4 font-display text-5xl text-slate-900">{{ $alumniProfile->name }}</h1>
                <p class="mt-3 text-lg text-violet-700">{{ $alumniProfile->job_title }} · {{ $alumniProfile->employer }}
                </p>
                <p class="mt-2 text-slate-500">{{ $alumniProfile->campus_name ?: 'Kampus belum diisi' }}</p>
                <p class="mt-2 text-slate-500">{{ $alumniProfile->program }} · Angkatan {{ $alumniProfile->batch_year }}
                    · {{ $alumniProfile->city }}, {{ $alumniProfile->province }}</p>
            </div>

            <div class="glass-panel p-6">
                <p class="font-display text-2xl text-slate-900">Biodata Singkat</p>
                <p class="mt-4 text-base leading-8 text-slate-600">{{ $alumniProfile->bio }}</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="card-subtle text-sm text-slate-600">Email:
                        {{ $alumniProfile->email }}</div>
                    <div class="card-subtle text-sm text-slate-600">Kampus:
                        {{ $alumniProfile->campus_name ?: '-' }}</div>
                    <div class="card-subtle text-sm text-slate-600">Status:
                        {{ $alumniProfile->employment_status }}</div>
                    <div class="card-subtle text-sm text-slate-600">Bidang Industri:
                        {{ $alumniProfile->industry }}</div>
                    <div class="card-subtle text-sm text-slate-600">LinkedIn: <a
                            href="{{ $alumniProfile->linkedin_url }}" target="_blank" rel="noreferrer"
                            class="text-violet-700">{{ $alumniProfile->linkedin_url }}</a></div>
                </div>
            </div>

            <div class="glass-panel p-6">
                <p class="font-display text-2xl text-slate-900">Prestasi & Sorotan</p>
                <div class="mt-4 space-y-3">
                    @foreach ($alumniProfile->achievements ?? [] as $achievement)
                        <div class="card-subtle text-slate-600">
                            {{ $achievement }}</div>
                    @endforeach
                </div>
                <blockquote class="mt-6 border-l-2 border-violet-400 pl-4 text-slate-600">
                    “{{ $alumniProfile->testimonial_quote }}”</blockquote>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Alumni Terkait</p>
                <h2 class="section-title">Alumni lain dari program studi yang sama.</h2>
            </div>
        </div>
        <div class="grid gap-6 lg:grid-cols-3">
            @foreach ($relatedAlumni as $related)
                <a href="{{ route('alumni.show', $related) }}" wire:navigate
                    class="glass-panel interactive-card block p-4">
                    <p class="font-display text-2xl text-slate-900">{{ $related->name }}</p>
                    <p class="mt-2 text-sm text-violet-700">{{ $related->job_title }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $related->employer }} · {{ $related->city }}</p>
                </a>
            @endforeach
        </div>
    </section>
</div>
