<footer class="relative mt-20 overflow-hidden" style="background:#0d1117;color:#e2e8f0">

    {{-- Subtle background gradient accent --}}
    <div class="pointer-events-none absolute inset-0 opacity-20" aria-hidden="true"
         style="background:radial-gradient(ellipse 80% 60% at 10% 90%, rgba(var(--brand-rgb),.35) 0%, transparent 65%),
                radial-gradient(ellipse 60% 50% at 85% 10%, rgba(var(--brand-2-rgb),.25) 0%, transparent 60%)"></div>

    {{-- Subtle dot grid pattern --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.035]" aria-hidden="true"
         style="background-image:radial-gradient(circle, #fff 1px, transparent 1px);background-size:28px 28px"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">

        {{-- Top section --}}
        <div class="grid gap-10 lg:grid-cols-[1.8fr_1fr_1fr_1fr]">

            {{-- Brand + tagline --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl text-xs font-bold text-white"
                         style="background:linear-gradient(135deg,var(--brand),var(--brand-2))">
                        A
                    </div>
                    <span class="text-lg font-semibold tracking-tight text-white">Alumni FTI</span>
                </div>
                <p class="max-w-[22ch] text-sm leading-relaxed" style="color:#94a3b8">
                    Platform jejaring alumni Fakultas Teknologi Informasi — menghubungkan lintas angkatan untuk karier, kolaborasi, dan komunitas.
                </p>
                <div class="flex gap-3 pt-1">
                    {{-- Social placeholder icons --}}
                    <a href="#" aria-label="Instagram"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border transition-all duration-150 hover:-translate-y-0.5"
                       style="border-color:rgba(255,255,255,.12);color:#94a3b8"
                       onmouseover="this.style.borderColor='rgba(var(--brand-rgb),.5)';this.style.color='white'"
                       onmouseout="this.style.borderColor='rgba(255,255,255,.12)';this.style.color='#94a3b8'">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="LinkedIn"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border transition-all duration-150 hover:-translate-y-0.5"
                       style="border-color:rgba(255,255,255,.12);color:#94a3b8"
                       onmouseover="this.style.borderColor='rgba(var(--brand-rgb),.5)';this.style.color='white'"
                       onmouseout="this.style.borderColor='rgba(255,255,255,.12)';this.style.color='#94a3b8'">
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <p class="mb-4 text-xs font-semibold uppercase tracking-widest" style="color:#64748b">Tautan</p>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('profile.index') }}" wire:navigate class="footer-link text-sm">Profil Alumni FTI</a></li>
                    <li><a href="{{ route('alumni.index') }}" wire:navigate class="footer-link text-sm">Direktori Alumni</a></li>
                    <li><a href="{{ route('news.index') }}" wire:navigate class="footer-link text-sm">Berita & Agenda</a></li>
                    <li><a href="{{ route('career.index') }}" wire:navigate class="footer-link text-sm">Karier & Kolaborasi</a></li>
                    <li><a href="{{ route('tracer-study.index') }}" wire:navigate class="footer-link text-sm">Tracer Study</a></li>
                </ul>
            </div>

            {{-- Platform --}}
            <div>
                <p class="mb-4 text-xs font-semibold uppercase tracking-widest" style="color:#64748b">Platform</p>
                <ul class="space-y-2.5">
                    @auth
                        <li><a href="{{ route('alumni.dashboard') }}" wire:navigate class="footer-link text-sm">Dashboard Alumni</a></li>
                        <li><a href="{{ route('alumni.update-profile') }}" wire:navigate class="footer-link text-sm">Update Profil</a></li>
                        <li><a href="{{ route('alumni.submit-job') }}" wire:navigate class="footer-link text-sm">Submit Lowongan</a></li>
                    @else
                        <li><a href="{{ route('login') }}" wire:navigate class="footer-link text-sm">Login</a></li>
                        <li><a href="{{ route('register') }}" wire:navigate class="footer-link text-sm">Daftar Alumni</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Contact --}}
            @php
                $footerContacts = \App\Models\SiteSetting::getValue('contact_channels', [
                    ['label' => 'Email', 'value' => 'humas@alumni-fti.ac.id'],
                    ['label' => 'WhatsApp', 'value' => '+62 811-2222-3333'],
                    ['label' => 'Sekretariat', 'value' => 'Gedung FTI Lt. 2'],
                ]);
            @endphp
            <div>
                <p class="mb-4 text-xs font-semibold uppercase tracking-widest" style="color:#64748b">Kontak</p>
                <ul class="space-y-3">
                    @foreach (array_slice($footerContacts, 0, 3) as $contact)
                        <li>
                            <p class="text-xs" style="color:#64748b">{{ $contact['label'] ?? '' }}</p>
                            <p class="text-sm text-white/80 mt-0.5">{{ $contact['value'] ?? '' }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Divider --}}
        <div class="mt-12 border-t pt-6" style="border-color:rgba(255,255,255,.08)">
            <div class="flex flex-wrap items-center justify-center gap-4">
                <p class="text-xs" style="color:#475569">© {{ date('Y') }} Alumni FTI. Hak cipta dilindungi.</p>
              
            </div>
        </div>
    </div>
</footer>

<style>
.footer-link {
    color: #94a3b8;
    transition: color 0.15s;
    position: relative;
    display: inline-block;
}
.footer-link::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 0;
    height: 1px;
    background: var(--brand);
    transition: width 0.2s ease;
}
.footer-link:hover {
    color: #ffffff;
}
.footer-link:hover::after {
    width: 100%;
}
</style>
