<?php

namespace App\Livewire\Pages\Admin;

use App\Models\NewsArticle;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class NewsManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public ?int $editingId = null;

    public string $title = '';

    public string $category = 'Berita';

    public string $coverImageUrl = '';

    public $coverImageFile = null;

    public string $content = '';

    public bool $isFeatured = false;

    public bool $publishNow = true;

    protected string $paginationTheme = 'tailwind';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:8'],
            'category' => ['required', 'string'],
            'coverImageUrl' => ['nullable', 'url'],
            'coverImageFile' => ['nullable', 'image', 'max:5120'],
            'content' => ['required', 'string', 'min:40'],
            'isFeatured' => ['boolean'],
            'publishNow' => ['boolean'],
        ];
    }

    public function create(): void
    {
        $validated = $this->validate();
        $normalizedContent = $this->normalizeContent($validated['content']);

        $coverImageUrl = $validated['coverImageUrl'];

        // Handle file upload if provided
        if ($this->coverImageFile) {
            $path = $this->coverImageFile->storePublicly('news-images', 'public');
            $coverImageUrl = asset('storage/'.$path);
        }

        NewsArticle::query()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(5)),
            'category' => $validated['category'],
            'excerpt' => Str::limit(trim(strip_tags($normalizedContent)), 180),
            'content' => $normalizedContent,
            'cover_image_url' => $coverImageUrl ?: null,
            'published_at' => $validated['publishNow'] ? now() : null,
            'is_featured' => $validated['isFeatured'],
        ]);

        $this->resetForm();
        $this->dispatch('toast', type: 'success', message: 'Berita berhasil dibuat.');
    }

    public function edit(int $id): void
    {
        $article = NewsArticle::query()->findOrFail($id);

        $this->editingId = $article->id;
        $this->title = $article->title;
        $this->category = $article->category;
        $this->coverImageUrl = $article->cover_image_url ?? '';
        $this->content = $article->content;
        $this->isFeatured = (bool) $article->is_featured;
        $this->publishNow = $article->published_at !== null;

        $this->dispatch('editor-sync', content: $this->content);
    }

    public function update(): void
    {
        if (! $this->editingId) {
            return;
        }

        $validated = $this->validate();
        $normalizedContent = $this->normalizeContent($validated['content']);

        $article = NewsArticle::query()->findOrFail($this->editingId);

        $coverImageUrl = $validated['coverImageUrl'];

        // Handle file upload if provided
        if ($this->coverImageFile) {
            $path = $this->coverImageFile->storePublicly('news-images', 'public');
            $coverImageUrl = asset('storage/'.$path);
        }

        $article->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'excerpt' => Str::limit(trim(strip_tags($normalizedContent)), 180),
            'content' => $normalizedContent,
            'cover_image_url' => $coverImageUrl ?: null,
            'published_at' => $validated['publishNow'] ? ($article->published_at ?? now()) : null,
            'is_featured' => $validated['isFeatured'],
        ]);

        $this->resetForm();
        $this->dispatch('toast', type: 'success', message: 'Berita berhasil diperbarui.');
    }

    public function togglePublish(int $id): void
    {
        $article = NewsArticle::query()->findOrFail($id);

        $article->update([
            'published_at' => $article->published_at ? null : now(),
        ]);

        $this->dispatch('toast', type: 'success', message: 'Status publish berita berhasil diubah.');
    }

    public function delete(int $id): void
    {
        NewsArticle::query()->findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', type: 'success', message: 'Berita berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'coverImageUrl', 'coverImageFile', 'content', 'isFeatured']);
        $this->category = 'Berita';
        $this->publishNow = true;

        $this->dispatch('editor-sync', content: '');
    }

    private function normalizeContent(string $content): string
    {
        $normalized = preg_replace('/&(nbsp|#160|#xA0);/i', ' ', $content);

        return str_replace("\u{00A0}", ' ', $normalized ?? $content);
    }

    public function render(): View
    {
        return view('livewire.pages.admin.news-manager', [
            'articles' => NewsArticle::query()->latest()->paginate(8),
        ]);
    }
}
