import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// ─────────────────────────────────────────────
// Quill News Editor — dipakai di admin Kelola Berita
// ─────────────────────────────────────────────

let quillInstance = null;

const TOOLBAR_OPTIONS = [
    [{ header: [1, 2, 3, false] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ color: [] }, { background: [] }],
    [{ list: 'ordered' }, { list: 'bullet' }],
    [{ indent: '-1' }, { indent: '+1' }],
    [{ align: [] }],
    ['blockquote', 'code-block'],
    ['link', 'image'],
    ['clean'],
];

/**
 * Kirim gambar ke route admin.upload-image dan embed URL-nya.
 */
function imageUploadHandler(quill) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';

    input.onchange = async () => {
        const file = input.files[0];
        if (!file) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            alert('CSRF token tidak ditemukan. Refresh halaman lalu coba lagi.');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', csrfToken);

        try {
            const res = await fetch(window.__uploadImageUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            if (!res.ok) throw new Error('HTTP ' + res.status);

            const json = await res.json();
            if (!json?.location) throw new Error('URL gambar tidak ditemukan.');

            const range = quill.getSelection(true);
            quill.insertEmbed(range.index, 'image', json.location, Quill.sources.USER);
            quill.setSelection(range.index + 1, Quill.sources.SILENT);
        } catch (err) {
            alert('Upload gambar gagal: ' + err.message);
        }
    };

    input.click();
}

/**
 * Sync konten Quill ke Livewire property `content`.
 */
function syncToLivewire(quill) {
    const el = document.getElementById('quill-editor-wrapper');
    if (!el) return;

    const wireEl = el.closest('[wire\\:id]');
    if (!wireEl) return;

    const wireId = wireEl.getAttribute('wire:id');
    const instance = window.Livewire?.find(wireId);
    if (!instance) return;

    const html = quill.getSemanticHTML();
    instance.set('content', html === '<p></p>' ? '' : html);
}

/**
 * Inisialisasi Quill pada #quill-editor-wrapper.
 * Dipanggil saat DOMContentLoaded dan livewire:navigated.
 */
function initEditor() {
    const wrapper = document.getElementById('quill-editor-wrapper');
    if (!wrapper) return;

    // Sudah ada instance — jangan buat ulang
    if (quillInstance) return;

    quillInstance = new Quill(wrapper, {
        theme: 'snow',
        modules: {
            toolbar: {
                container: TOOLBAR_OPTIONS,
                handlers: {
                    image: () => imageUploadHandler(quillInstance),
                },
            },
        },
        placeholder: 'Tuliskan isi berita di sini…',
    });

    // Set konten awal dari data attribute
    const initial = wrapper.dataset.content || '';
    if (initial) {
        quillInstance.clipboard.dangerouslyPasteHTML(initial);
    }

    // Sync ke Livewire setiap perubahan
    quillInstance.on('text-change', () => syncToLivewire(quillInstance));
}

/**
 * Reset editor: hapus instance lama, buat ulang.
 * Dipanggil dari Livewire event 'editor-sync'.
 */
function resetEditor(content = '') {
    const wrapper = document.getElementById('quill-editor-wrapper');
    if (!wrapper) return;

    // Hancurkan instance lama
    if (quillInstance) {
        quillInstance.off('text-change');
        quillInstance = null;

        // Bersihkan DOM toolbar + editor yang dibuat Quill
        const container = wrapper.closest('.quill-container');
        if (container) {
            const oldToolbar = container.querySelector('.ql-toolbar');
            if (oldToolbar) oldToolbar.remove();

            // Reset wrapper ke kondisi kosong
            wrapper.innerHTML = '';
            wrapper.className = 'ql-container-reset';
        }
    }

    // Re-init
    initEditor();

    // Set konten
    if (quillInstance && content) {
        quillInstance.clipboard.dangerouslyPasteHTML(content);
    } else if (quillInstance) {
        quillInstance.setText('');
    }
}

// ── Lifecycle hooks ──────────────────────────
document.addEventListener('DOMContentLoaded', initEditor);
document.addEventListener('livewire:navigated', () => {
    quillInstance = null; // reset state saat SPA navigate
    initEditor();
});

// Livewire event dari PHP: edit berita mengisi konten
document.addEventListener('livewire:init', () => {
    window.Livewire.on('editor-sync', ({ content }) => {
        resetEditor(content || '');
    });
});
