@section('title', 'Profil Alumni FTI')

<div class="py-10 lg:py-12">

    {{-- Header --}}
    <section class="section-shell mb-8 grid gap-5 lg:grid-cols-2">
        <div class="space-y-3">
            <p class="section-eyebrow">Profil Alumni FTI</p>
            <h1 class="section-title max-w-xl">Sejarah, visi misi, dan program kerja alumni.</h1>
            <p class="section-copy">Pusat informasi kelembagaan Ikatan Alumni FTI — sejarah, struktur organisasi, dan program prioritas.</p>
        </div>
        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-2">Visi</p>
            <p class="text-sm leading-relaxed text-gray-600">{{ $vision }}</p>
            <div class="mt-4">
                <p class="section-eyebrow mb-2">Misi</p>
                <ul class="space-y-2">
                    @foreach ($missions as $mission)
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <span class="mt-1.5 h-1.5 w-1.5 flex-shrink-0 rounded-full" style="background:var(--brand)"></span>
                            {{ $mission }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Timeline --}}
    <section class="section-shell mb-8">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Sejarah</p>
                <h2 class="section-title">Perjalanan komunitas alumni FTI.</h2>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($timeline as $item)
                <article class="glass-panel p-5">
                    <p class="text-xs font-semibold" style="color:var(--brand)">{{ $item['year'] }}</p>
                    <p class="mt-2 font-display text-xl text-gray-900">{{ $item['title'] }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-500">{{ $item['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Org + Programs --}}
    <section class="section-shell grid gap-5 lg:grid-cols-2">
        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-4">Struktur Organisasi</p>
            <div class="space-y-3">
                @foreach ($organizationMembers as $member)
                    <article class="card-subtle flex gap-3">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                            class="h-14 w-14 flex-shrink-0 rounded-xl object-cover">
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900">{{ $member->name }}</p>
                            <p class="text-sm" style="color:var(--brand-deep)">{{ $member->role }} · {{ $member->division }}</p>
                            <p class="mt-0.5 text-xs text-gray-500">{{ $member->focus_area }}</p>
                            <p class="mt-0.5 text-xs uppercase tracking-wider text-gray-400">{{ $member->period }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="glass-panel p-5">
            <p class="section-eyebrow mb-4">Program Kerja</p>
            <div class="space-y-3">
                @foreach ($workPrograms as $program)
                    <article class="card-subtle">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="badge-pill">{{ $program->category }}</span>
                            <span class="text-xs uppercase tracking-wider text-gray-400">{{ $program->status }}</span>
                        </div>
                        <p class="mt-2 font-display text-lg text-gray-900">{{ $program->title }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-gray-500">{{ $program->summary }}</p>
                        <p class="mt-1.5 text-xs font-medium" style="color:var(--brand)">Target: {{ $program->impact_target }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
