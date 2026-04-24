@section('title', 'Profil Alumni FTI')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="space-y-5">
            <p class="section-eyebrow">Profil Alumni FTI</p>
            <h1 class="section-title max-w-2xl">Sejarah, visi misi, struktur organisasi, dan program kerja dalam satu
                halaman yang rapi.</h1>
            <p class="section-copy">Halaman ini dirancang sebagai pusat informasi kelembagaan Ikatan Alumni FTI. Cocok
                untuk kebutuhan presentasi tugas karena seluruh elemen penting berada dalam satu narasi yang utuh.</p>
        </div>
        <div class="glass-panel space-y-4 p-6">
            <p class="font-display text-3xl text-slate-900">Visi</p>
            <p class="text-base leading-8 text-slate-600">{{ $vision }}</p>
            <div>
                <p class="mb-3 font-display text-2xl text-slate-900">Misi</p>
                <div class="space-y-3">
                    @foreach ($missions as $mission)
                        <div class="card-subtle text-slate-600">
                            {{ $mission }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Sejarah</p>
                <h2 class="section-title">Perjalanan komunitas alumni dari inisiatif sederhana menjadi organisasi yang
                    lebih terstruktur.</h2>
            </div>
        </div>
        <div class="grid gap-4 lg:grid-cols-4">
            @foreach ($timeline as $item)
                <article class="glass-panel interactive-card p-5">
                    <p class="text-sm text-violet-700">{{ $item['year'] }}</p>
                    <p class="mt-3 font-display text-2xl text-slate-900">{{ $item['title'] }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">{{ $item['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-shell grid gap-6 lg:grid-cols-[1fr_1fr]">
        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">Struktur Organisasi</p>
                    <h2 class="section-title">Pengurus inti Ikatan Alumni FTI.</h2>
                </div>
            </div>
            <div class="space-y-4">
                @foreach ($organizationMembers as $member)
                    <article class="card-subtle flex gap-4">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                            class="h-20 w-20 rounded-[1.25rem] object-cover">
                        <div>
                            <p class="font-display text-2xl text-slate-900">{{ $member->name }}</p>
                            <p class="text-sm text-violet-700">{{ $member->role }} · {{ $member->division }}</p>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $member->focus_area }}</p>
                            <p class="mt-2 text-xs uppercase tracking-[0.2em] text-slate-500">Periode
                                {{ $member->period }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="glass-panel p-6">
            <div class="section-heading mb-6">
                <div>
                    <p class="section-eyebrow">Program Kerja</p>
                    <h2 class="section-title">Program prioritas yang menjawab kebutuhan alumni dan fakultas.</h2>
                </div>
            </div>
            <div class="space-y-4">
                @foreach ($workPrograms as $program)
                    <article class="card-subtle">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="badge-pill">{{ $program->category }}</span>
                            <span
                                class="text-xs uppercase tracking-[0.22em] text-slate-500">{{ $program->status }}</span>
                        </div>
                        <p class="mt-4 font-display text-2xl text-slate-900">{{ $program->title }}</p>
                        <p class="mt-3 text-sm leading-7 text-slate-500">{{ $program->summary }}</p>
                        <p class="mt-3 text-sm text-violet-700">Target: {{ $program->impact_target }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
