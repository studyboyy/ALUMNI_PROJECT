@section('title', 'Admin Kelola Berita')

@push('head')
    <script src="https://cdn.tiny.cloud/1/1umi7k21480sffk7bf9gc4j8q0hjlxkttzhk6hw45md6wfpn/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
@endpush

<div class="space-y-10">
    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Admin Panel Berita</p>
                <h1 class="section-title">Buat dan kelola berita dengan editor yang kaya fitur.</h1>
            </div>
            <a href="{{ route('news.index') }}" wire:navigate class="section-link">Lihat halaman berita publik</a>
        </div>

        <div class="glass-panel p-6">
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="space-y-2 text-sm text-slate-600">
                    <span>Judul Berita</span>
                    <input wire:model.blur="title" class="input-shell" type="text" placeholder="Judul berita">
                    @error('title')
                        <span class="text-sm text-rose-500">{{ $message }}</span>
                    @enderror
                </label>

                <label class="space-y-2 text-sm text-slate-600">
                    <span>Kategori</span>
                    <select wire:model="category" class="input-shell">
                        <option>Berita</option>
                        <option>Agenda</option>
                        <option>Prestasi</option>
                    </select>
                </label>
            </div>

            <label class="mt-4 block space-y-2 text-sm text-slate-600">
                <span>Cover Image (URL atau Upload)</span>
                <div class="grid gap-3 sm:grid-cols-2">
                    <input wire:model.blur="coverImageUrl" class="input-shell" type="url"
                        placeholder="https://... atau upload file di bawah">
                    <div class="relative">
                        <input wire:model="coverImageFile" class="input-shell absolute inset-0 cursor-pointer opacity-0"
                            type="file" accept="image/*">
                        <div
                            class="flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-3 text-slate-600 transition hover:border-violet-300 hover:bg-violet-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $coverImageFile ? 'File: ' . $coverImageFile->getClientOriginalName() : 'Pilih file' }}</span>
                        </div>
                    </div>
                </div>
                @if ($coverImageFile)
                    <div class="mt-3">
                        <p class="mb-2 text-xs font-semibold text-slate-700">Preview:</p>
                        <img src="{{ $coverImageFile->temporaryUrl() }}" alt="Preview"
                            class="h-32 w-full rounded-lg object-cover">
                    </div>
                @elseif ($coverImageUrl)
                    <div class="mt-3">
                        <p class="mb-2 text-xs font-semibold text-slate-700">Preview:</p>
                        <img src="{{ $coverImageUrl }}" alt="Preview" class="h-32 w-full rounded-lg object-cover">
                    </div>
                @endif
                @error('coverImageUrl')
                    <span class="text-sm text-rose-500">{{ $message }}</span>
                @enderror
                @error('coverImageFile')
                    <span class="text-sm text-rose-500">{{ $message }}</span>
                @enderror
            </label>

            <div class="mt-4">
                <label class="mb-2 block text-sm text-slate-600">Konten Berita (TinyMCE)</label>
                <div wire:ignore>
                    <textarea id="news-content-editor" class="input-shell min-h-[22rem]">{!! $content !!}</textarea>
                </div>
                @error('content')
                    <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4 flex flex-wrap gap-6 text-sm text-slate-600">
                <label class="inline-flex items-center gap-2">
                    <input wire:model="isFeatured" type="checkbox">
                    <span>Featured</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input wire:model="publishNow" type="checkbox">
                    <span>Publish sekarang</span>
                </label>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                @if ($editingId)
                    <button wire:click="update" type="button" class="purple-btn">Update Berita</button>
                    <button wire:click="resetForm" type="button"
                        class="rounded-full border border-slate-300 px-6 py-3 font-semibold text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Batal
                        Edit</button>
                @else
                    <button wire:click="create" type="button" class="purple-btn">Buat Berita</button>
                @endif
            </div>
        </div>
    </section>

    <section>
        <div class="section-heading">
            <div>
                <p class="section-eyebrow">Daftar Berita</p>
                <h2 class="section-title">Kelola publish, edit, dan hapus berita.</h2>
            </div>
        </div>

        <div class="grid gap-5">
            @foreach ($articles as $article)
                <article class="glass-panel p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="font-display text-2xl text-slate-900">{{ $article->title }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $article->category }} ·
                                {{ $article->published_at ? 'Published' : 'Draft' }}</p>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $article->excerpt }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="edit({{ $article->id }})" type="button"
                                class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 transition hover:border-violet-300 hover:text-violet-700">Edit</button>
                            <button wire:click="togglePublish({{ $article->id }})" type="button"
                                class="rounded-full border border-violet-300 px-4 py-2 text-sm text-violet-700 transition hover:bg-violet-50">{{ $article->published_at ? 'Unpublish' : 'Publish' }}</button>
                            <button wire:click="delete({{ $article->id }})" type="button"
                                class="rounded-full border border-rose-300 px-4 py-2 text-sm text-rose-600 transition hover:bg-rose-50">Hapus</button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $articles->links() }}</div>
    </section>
</div>

@push('scripts')
    <script>
        function initTinyMceNewsEditor() {
            const targetId = 'news-content-editor';
            const target = document.getElementById(targetId);

            if (!target || typeof tinymce === 'undefined') return;

            const existing = tinymce.get(targetId);
            if (existing) return;

            tinymce.init({
                selector: '#' + targetId,
                height: 420,
                menubar: true,
                branding: false,
                promotion: false,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | forecolor backcolor | removeformat code preview',
                content_style: 'body { font-family: Poppins, sans-serif; font-size: 15px; line-height: 1.7; color: #0f172a; }',
                entity_encoding: 'raw',
                nonbreaking_force_tab: false,
                images_upload_url: '{{ route('admin.upload-image') }}',
                automatic_uploads: true,
                file_picker_types: 'image',
                images_reuse_filename: false,
                images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                        'content');

                    if (!csrfToken) {
                        reject('CSRF token tidak ditemukan. Refresh halaman lalu coba lagi.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('_token', csrfToken);

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route('admin.upload-image') }}');
                    xhr.withCredentials = true;
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    xhr.upload.onprogress = (event) => {
                        if (event.lengthComputable) {
                            progress((event.loaded / event.total) * 100);
                        }
                    };

                    xhr.onload = () => {
                        if (xhr.status === 419) {
                            reject(
                                'Session berakhir (419). Silakan refresh halaman dan login ulang jika diminta.'
                            );
                            return;
                        }

                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('Upload gagal (HTTP ' + xhr.status + ').');
                            return;
                        }

                        let json;

                        try {
                            json = JSON.parse(xhr.responseText);
                        } catch (error) {
                            reject('Respons upload tidak valid.');
                            return;
                        }

                        if (!json || typeof json.location !== 'string') {
                            reject(json?.error?.message ??
                                'URL gambar tidak ditemukan pada respons upload.');
                            return;
                        }

                        resolve(json.location);
                    };

                    xhr.onerror = () => {
                        reject('Terjadi gangguan jaringan saat upload gambar.');
                    };

                    xhr.send(formData);
                }),
                setup(editor) {
                    editor.on('init', () => {
                        editor.setContent(@js($content));
                    });

                    const syncToLivewire = () => {
                        const componentElement = editor.getElement().closest('[wire\\:id]');
                        if (!componentElement) return;

                        const wireId = componentElement.getAttribute('wire:id');
                        const instance = Livewire.find(wireId);
                        if (!instance) return;

                        instance.set('content', editor.getContent());
                    };

                    editor.on('change keyup undo redo', syncToLivewire);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initTinyMceNewsEditor);
        document.addEventListener('livewire:navigated', initTinyMceNewsEditor);

        document.addEventListener('livewire:init', () => {
            Livewire.on('editor-sync', ({
                content
            }) => {
                const editor = tinymce.get('news-content-editor');

                if (!editor) {
                    initTinyMceNewsEditor();
                    return;
                }

                editor.setContent(content || '');
            });
        });
    </script>
@endpush
