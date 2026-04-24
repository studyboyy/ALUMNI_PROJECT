@section('title', 'Tracer Study Alumni FTI')

<div class="space-y-12 py-10 lg:py-14">
    <section class="section-shell grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-5">
            <p class="section-eyebrow">Tracer Study</p>
            <h1 class="section-title max-w-2xl">Pengantar, akses form, dan ringkasan hasil tracer study alumni FTI.</h1>
            <p class="section-copy">Untuk tahap pertama tugas, form tracer dapat memakai Google Form eksternal, sementara
                halaman ini menampilkan analisis ringkas dari data dummy agar tetap presentable.</p>
            <div class="flex flex-wrap gap-3">
                <a href="https://forms.gle" target="_blank" rel="noreferrer" class="purple-btn">Isi
                    Form Tracer Study</a>
                <a href="#hasil"
                    class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Lihat
                    Hasil</a>
            </div>
        </div>
        <div class="glass-panel p-6">
            <p class="font-display text-3xl text-slate-900">Tujuan Tracer Study</p>
            <div class="mt-4 space-y-3 text-sm leading-7 text-slate-600">
                <p>Mengukur relevansi kurikulum dengan kebutuhan industri.</p>
                <p>Memetakan status kerja, bidang industri, dan persebaran lokasi alumni.</p>
                <p>Menjadi dasar perumusan program kerja alumni dan fakultas.</p>
            </div>
        </div>
    </section>

    <section id="hasil" class="section-shell grid gap-6 lg:grid-cols-3">
        <div class="glass-panel p-6">
            <p class="section-eyebrow">Status Kerja</p>
            <div class="mt-4 space-y-3">
                @foreach ($employmentBreakdown as $item)
                    <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                        <span>{{ $item->employment_status }}</span>
                        <span class="font-semibold text-slate-900">{{ $item->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="glass-panel p-6">
            <p class="section-eyebrow">Bidang Industri</p>
            <div class="mt-4 space-y-3">
                @foreach ($industryBreakdown as $item)
                    <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                        <span>{{ $item->industry }}</span>
                        <span class="font-semibold text-slate-900">{{ $item->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="glass-panel p-6">
            <p class="section-eyebrow">Lokasi Kerja</p>
            <div class="mt-4 space-y-3">
                @foreach ($cityBreakdown as $item)
                    <div class="card-subtle flex items-center justify-between text-sm text-slate-600">
                        <span>{{ $item->city }}</span>
                        <span class="font-semibold text-slate-900">{{ $item->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
