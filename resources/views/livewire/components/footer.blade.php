<footer class="mt-16 border-t border-gray-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1.6fr_1fr_1fr]">

            {{-- Brand --}}
            <div class="space-y-4">
                <p class="font-display text-2xl text-gray-900">Alumni FTI</p>
                <p class="max-w-sm text-sm leading-relaxed text-gray-500">
                    Platform jejaring alumni Fakultas Teknologi Informasi — menghubungkan lintas angkatan untuk karier, kolaborasi, dan komunitas.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400">Tautan</p>
                <ul class="space-y-2">
                    <li><a href="{{ route('profile.index') }}" wire:navigate
                        class="text-sm text-gray-600 transition hover:text-gray-900">Profil Alumni FTI</a></li>
                    <li><a href="{{ route('alumni.index') }}" wire:navigate
                        class="text-sm text-gray-600 transition hover:text-gray-900">Direktori Alumni</a></li>
                    <li><a href="{{ route('news.index') }}" wire:navigate
                        class="text-sm text-gray-600 transition hover:text-gray-900">Berita & Agenda</a></li>
                    <li><a href="{{ route('career.index') }}" wire:navigate
                        class="text-sm text-gray-600 transition hover:text-gray-900">Karier & Kolaborasi</a></li>
                    <li><a href="{{ route('tracer-study.index') }}" wire:navigate
                        class="text-sm text-gray-600 transition hover:text-gray-900">Tracer Study</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            @php
                $footerContacts = \App\Models\SiteSetting::getValue('contact_channels', [
                    ['label' => 'Email', 'value' => 'humas@alumni-fti.test'],
                    ['label' => 'WhatsApp', 'value' => '+62 811-2222-3333'],
                    ['label' => 'Sekretariat', 'value' => 'Gedung FTI Lt. 2'],
                ]);
            @endphp
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400">Kontak</p>
                <ul class="space-y-2">
                    @foreach (array_slice($footerContacts, 0, 3) as $contact)
                        <li>
                            <span class="text-xs text-gray-400">{{ $contact['label'] ?? '' }}</span>
                            <p class="text-sm text-gray-700">{{ $contact['value'] ?? '' }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-gray-100 pt-6 flex flex-wrap items-center justify-between gap-3">
            <p class="text-xs text-gray-400">© {{ date('Y') }} Alumni FTI. Hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
