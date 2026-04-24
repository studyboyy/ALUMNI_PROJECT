@section('title', 'Kontak & Bantuan Alumni FTI')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="space-y-5">
            <p class="section-eyebrow">Kontak & Bantuan</p>
            <h1 class="section-title max-w-2xl">Kontak admin, peta lokasi, form pesan, dan FAQ dalam satu halaman.</h1>
            <p class="section-copy">Ini adalah halaman layanan publik untuk alumni yang membutuhkan bantuan, ingin
                bertanya, atau mengirim saran kepada pengelola website.</p>

            <div class="glass-panel space-y-4 p-6">
                @foreach ($contactChannels as $channel)
                    <div>
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">{{ $channel['label'] }}</p>
                        <p class="mt-2 text-base text-slate-900">{{ $channel['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="overflow-hidden rounded-4xl border border-slate-200">
                <iframe title="Lokasi FTI"
                    src="https://www.google.com/maps?q=universitas%20teknologi%20indonesia&output=embed"
                    class="h-80 w-full"></iframe>
            </div>
        </div>

        <div class="glass-panel p-6">
            <p class="font-display text-3xl text-slate-900">Kirim pesan atau saran</p>

            <form wire:submit="save" class="mt-6 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Nama</span>
                        <input wire:model.blur="name" type="text" class="input-shell" placeholder="Nama lengkap">
                        @error('name')
                            <span class="text-sm text-rose-300">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="space-y-2 text-sm text-slate-600">
                        <span>Email</span>
                        <input wire:model.blur="email" type="email" class="input-shell" placeholder="nama@email.com">
                        @error('email')
                            <span class="text-sm text-rose-300">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <label class="space-y-2 text-sm text-slate-600">
                    <span>Subjek</span>
                    <input wire:model.blur="subject" type="text" class="input-shell" placeholder="Topik pesan">
                    @error('subject')
                        <span class="text-sm text-rose-300">{{ $message }}</span>
                    @enderror
                </label>

                <label class="space-y-2 text-sm text-slate-600">
                    <span>Pesan</span>
                    <textarea wire:model.blur="message" rows="6" class="input-shell" placeholder="Tuliskan kebutuhan atau saran Anda"></textarea>
                    @error('message')
                        <span class="text-sm text-rose-300">{{ $message }}</span>
                    @enderror
                </label>

                <button type="submit" class="purple-btn">Kirim
                    Pesan</button>
            </form>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">FAQ</p>
                <h2 class="section-title">Pertanyaan umum yang sering diajukan alumni.</h2>
            </div>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            @foreach ($faqs as $faq)
                <article class="glass-panel interactive-card p-5">
                    <p class="font-display text-2xl text-slate-900">{{ $faq->question }}</p>
                    <p class="mt-4 text-sm leading-7 text-slate-500">{{ $faq->answer }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
