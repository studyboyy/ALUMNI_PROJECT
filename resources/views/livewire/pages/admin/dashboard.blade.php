@section('title', 'Dashboard Admin')

<div class="space-y-8">
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <article class="glass-panel p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-3 font-display text-3xl text-slate-900">{{ $stat['value'] }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $stat['note'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
        <div class="glass-panel p-6">
            <p class="section-eyebrow">Registrasi</p>
            <h2 class="section-title">Status Alumni</h2>
            <div class="mt-6 space-y-4">
                @foreach ($registrationBreakdown as $item)
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>{{ $item['label'] }}</span>
                            <span class="font-semibold text-slate-900">{{ $item['value'] }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full {{ $item['bar'] }}" style="width: {{ $item['percent'] }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="glass-panel p-6">
            <p class="section-eyebrow">Lowongan</p>
            <h2 class="section-title">Status Approval</h2>
            <div class="mt-6 space-y-4">
                @foreach ($jobBreakdown as $item)
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>{{ $item['label'] }}</span>
                            <span class="font-semibold text-slate-900">{{ $item['value'] }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full {{ $item['bar'] }}" style="width: {{ $item['percent'] }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
        <div class="glass-panel p-6">
            <p class="section-eyebrow">Program Studi</p>
            <h2 class="section-title">Distribusi Alumni</h2>
            <div class="mt-6 space-y-3">
                @forelse ($programStats as $item)
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>{{ $item['label'] }}</span>
                            <span class="font-semibold text-slate-900">{{ $item['value'] }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-[color:var(--brand-2)]"
                                style="width: {{ (int) round(($item['value'] / $programMax) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data program studi.</p>
                @endforelse
            </div>
        </div>

        <div class="glass-panel p-6">
            <p class="section-eyebrow">Kota Teratas</p>
            <h2 class="section-title">Sebaran Alumni</h2>
            <div class="mt-6 space-y-3">
                @forelse ($cityStats as $item)
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>{{ $item['label'] }}</span>
                            <span class="font-semibold text-slate-900">{{ $item['value'] }}</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-[color:var(--brand)]"
                                style="width: {{ (int) round(($item['value'] / $cityMax) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data kota alumni.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
