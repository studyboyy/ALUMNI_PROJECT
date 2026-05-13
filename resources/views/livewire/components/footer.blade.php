<footer class="relative mt-16 border-t border-slate-200/80 bg-linear-to-b from-white/80 to-slate-100/70">
    <div
        class="pointer-events-none absolute inset-x-0 top-0 h-24 bg-[radial-gradient(circle_at_12%_0%,rgba(232,93,87,0.2),transparent_42%),radial-gradient(circle_at_86%_0%,rgba(255,138,101,0.22),transparent_40%)]">
    </div>
    <div
        class="relative mx-auto grid max-w-7xl gap-10 px-4 py-14 text-sm text-slate-600 sm:px-6 lg:grid-cols-[1.4fr_1fr_1fr] lg:px-8">
        <div class="space-y-4">
            <p class="font-display text-3xl text-slate-900">Bersama Membangun Teknologi dan Karier</p>
            <p class="max-w-xl text-slate-500">Website alumni FTI ini dirancang sebagai pusat informasi, jejaring,
                peluang karier, dan kolaborasi lintas angkatan untuk kebutuhan presentasi maupun pengembangan jangka
                panjang.</p>
        </div>

        <div class="space-y-3">
            <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Tautan Cepat</p>
            <a href="{{ route('profile.index') }}" wire:navigate class="block transition hover:text-violet-700">Profil
                Alumni FTI</a>
            <a href="{{ route('alumni.index') }}" wire:navigate class="block transition hover:text-violet-700">Direktori
                Alumni</a>
            <a href="{{ route('news.index') }}" wire:navigate class="block transition hover:text-violet-700">Berita &
                Agenda</a>
            <a href="{{ route('career.index') }}" wire:navigate class="block transition hover:text-violet-700">Karier &
                Kolaborasi</a>
        </div>

        @php
            $footerContacts = \App\Models\SiteSetting::getValue('contact_channels', [
                ['label' => 'Email Humas', 'value' => 'humas@alumni-fti.test'],
                ['label' => 'WhatsApp Admin', 'value' => '+62 811-2222-3333'],
                ['label' => 'Sekretariat', 'value' => 'Gedung FTI Lt. 2, Kampus Utama'],
            ]);
        @endphp

        <div class="space-y-3">
            <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Kontak</p>
            @foreach (array_slice($footerContacts, 0, 3) as $contact)
                <p>{{ $contact['value'] ?? '' }}</p>
            @endforeach
        </div>
    </div>
</footer>
