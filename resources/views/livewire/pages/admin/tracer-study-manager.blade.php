@section('title', 'Admin Tracer Study')

<div class="space-y-8">

    {{-- Header --}}
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Admin Panel</p>
                <h1 class="section-title">Data Tracer Study</h1>
                <p class="mt-1 text-sm text-slate-500">Total {{ $totalCount }} responden telah mengisi form.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.tracer-study.export') }}"
                    class="purple-btn flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel (CSV)
                </a>
            </div>
        </div>
    </section>

    {{-- Filter --}}
    <section class="glass-panel p-6">
        <div class="grid gap-4 sm:grid-cols-3">
            <label class="space-y-2 text-sm text-slate-600">
                <span>Cari nama / NIM / email</span>
                <input wire:model.live.debounce.300ms="search" class="input-shell" placeholder="Ketik untuk mencari...">
            </label>
            <label class="space-y-2 text-sm text-slate-600">
                <span>Filter Status Pekerjaan</span>
                <select wire:model.live="filterStatus" class="input-shell">
                    <option value="">-- Semua Status --</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </label>
            <label class="space-y-2 text-sm text-slate-600">
                <span>Filter Program Studi</span>
                <select wire:model.live="filterProgram" class="input-shell">
                    <option value="">-- Semua Prodi --</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program }}">{{ $program }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </section>

    {{-- Tabel --}}
    <section>
        @if ($responses->isEmpty())
            <div class="glass-panel p-12 text-center text-slate-400">
                <p class="text-lg">Belum ada data tracer study.</p>
            </div>
        @else
            <div class="glass-panel overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama / NIM</th>
                                <th class="px-4 py-3">Prodi & Angkatan</th>
                                <th class="px-4 py-3">Status Kerja</th>
                                <th class="px-4 py-3">Bekerja di</th>
                                <th class="px-4 py-3">Kota</th>
                                <th class="px-4 py-3">Rating</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($responses as $i => $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3 text-slate-400">
                                        {{ $responses->firstItem() + $i }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-slate-900">{{ $item->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->nim ?: $item->email }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-slate-700">{{ $item->program }}</p>
                                        <p class="text-xs text-slate-500">Angkatan {{ $item->batch_year }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColor = match($item->employment_status) {
                                                'Bekerja', 'Berwiraswasta' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'Melanjutkan Kuliah'       => 'bg-blue-50 text-blue-700 border-blue-200',
                                                default                     => 'bg-slate-50 text-slate-600 border-slate-200',
                                            };
                                        @endphp
                                        <span class="rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusColor }}">
                                            {{ $item->employment_status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-slate-700">{{ $item->employer ?: '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->job_title ?: '' }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        {{ $item->city ?: '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($item->curriculum_rating)
                                            <span class="font-semibold text-violet-700">{{ $item->curriculum_rating }}/5</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ $item->created_at?->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="delete({{ $item->id }})"
                                            wire:confirm="Yakin hapus data responden ini?"
                                            type="button"
                                            class="rounded-full border border-rose-300 px-3 py-1.5 text-xs text-rose-600 transition hover:bg-rose-50">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $responses->links() }}
            </div>
        @endif
    </section>

</div>
