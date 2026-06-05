@section('title', 'Kontak & Bantuan Alumni FTI')

<div class="py-10 lg:py-12">

    <section class="section-shell mb-8 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">

        {{-- Kiri: Info + Map --}}
        <div class="space-y-5">
            <div>
                <p class="section-eyebrow">Kontak & Bantuan</p>
                <h1 class="section-title max-w-xl">Hubungi admin atau kirim pesan langsung.</h1>
                <p class="mt-3 section-copy">Halaman layanan publik untuk alumni yang membutuhkan bantuan atau ingin mengirim saran.</p>
            </div>

            <div class="glass-panel p-5">
                <p class="section-eyebrow mb-4">Saluran Kontak</p>
                <div class="space-y-4">
                    @foreach ($contactChannels as $channel)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider" style="color:var(--ink-muted)">{{ $channel['label'] }}</p>
                            <p class="mt-1 text-sm font-medium" style="color:var(--ink)">{{ $channel['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border" style="border-color:var(--border)">
                <iframe title="Lokasi FTI" src="{{ $mapEmbedUrl }}"
                    class="h-52 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        {{-- Kanan: Form --}}
        <div class="glass-panel p-6 sm:p-7">
            <h2 class="font-display text-2xl" style="color:var(--ink)">Kirim Pesan</h2>
            <p class="mt-1.5 text-sm" style="color:var(--ink-muted)">Isi form di bawah dan kami akan merespons secepatnya.</p>

            <form wire:submit="save" class="mt-7 space-y-5">

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama <span class="required">*</span></label>
                        <input wire:model.blur="name" type="text" class="input-shell" placeholder="Nama lengkap">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input wire:model.blur="email" type="email" class="input-shell" placeholder="nama@email.com">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Subjek <span class="required">*</span></label>
                    <input wire:model.blur="subject" type="text" class="input-shell" placeholder="Topik pesan">
                    @error('subject') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Pesan <span class="required">*</span></label>
                    <textarea wire:model.blur="message" rows="5" class="input-shell"
                        placeholder="Tuliskan kebutuhan atau saran Anda…"></textarea>
                    @error('message') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="purple-btn" wire:loading.attr="disabled">
                    <span wire:loading.remove>Kirim Pesan</span>
                    <span wire:loading>Mengirim…</span>
                </button>

            </form>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">FAQ</p>
                <h2 class="section-title">Pertanyaan umum alumni.</h2>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($faqs as $faq)
                <article class="glass-panel p-5">
                    <p class="font-semibold" style="color:var(--ink)">{{ $faq->question }}</p>
                    <p class="mt-2.5 text-sm leading-relaxed" style="color:var(--ink-muted)">{{ $faq->answer }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
