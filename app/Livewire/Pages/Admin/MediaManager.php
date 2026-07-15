<?php

namespace App\Livewire\Pages\Admin;

use App\Models\GalleryItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class MediaManager extends Component
{
    use WithFileUploads;

    public $file = null;

    public string $title = '';

    public string $caption = '';

    public string $eventName = '';

    public bool $publishNow = true;

    public array $images = [];

    public string $searchQuery = '';

    public string $selectedCategory = 'all';

    public array $categories = ['all', 'gallery-images', 'alumni-photos', 'news-images', 'homepage-images'];

    public function mount(): void
    {
        $this->loadImages();
    }

    public function loadImages(): void
    {
        $this->images = [];
        $basePath = storage_path('app/public');

        if (! is_dir($basePath)) {
            return;
        }

        $folders = ['gallery-images', 'alumni-photos', 'news-images', 'homepage-images'];

        foreach ($folders as $folder) {
            $folderPath = $basePath.'/'.$folder;
            if (! is_dir($folderPath)) {
                continue;
            }

            $files = File::files($folderPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $relativePath = $folder.'/'.$filename;

                // Filter by search
                if ($this->searchQuery && ! str_contains(strtolower($filename), strtolower($this->searchQuery))) {
                    continue;
                }

                // Filter by category
                if ($this->selectedCategory !== 'all' && $this->selectedCategory !== $folder) {
                    continue;
                }

                if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $this->images[] = [
                        'name' => $filename,
                        'path' => $relativePath,
                        'url' => asset('storage/'.$relativePath),
                        'size' => $file->getSize(),
                        'category' => $folder,
                        'mtime' => $file->getMTime(),
                    ];
                }
            }
        }

        // Sort by modification time descending
        usort($this->images, fn ($a, $b) => $b['mtime'] <=> $a['mtime']);
    }

    public function updatedSearchQuery(): void
    {
        $this->loadImages();
    }

    public function updatedSelectedCategory(): void
    {
        $this->loadImages();
    }

    public function upload(): void
    {
        $validated = $this->validate([
            'file' => ['required', 'image', 'max:10240'],
            'title' => ['required', 'string', 'max:160'],
            'caption' => ['nullable', 'string', 'max:500'],
            'eventName' => ['nullable', 'string', 'max:160'],
            'publishNow' => ['boolean'],
        ]);

        $path = $this->file->storePublicly('gallery-images', 'public');

        GalleryItem::query()->create([
            'title' => trim($validated['title']),
            'media_type' => 'image',
            'media_url' => asset('storage/'.$path),
            'caption' => trim($validated['caption']) ?: null,
            'event_name' => trim($validated['eventName']) ?: null,
            'published_at' => $validated['publishNow'] ? now() : null,
        ]);

        $this->reset(['file', 'title', 'caption', 'eventName']);
        $this->publishNow = true;
        $this->loadImages();

        $this->dispatch('toast', type: 'success', message: 'Media berhasil disimpan dan tersinkron dengan Galeri publik.');
    }

    public function toggleGalleryPublication(int $id): void
    {
        $item = GalleryItem::query()->findOrFail($id);
        $item->update(['published_at' => $item->published_at ? null : now()]);

        $this->dispatch('toast', type: 'success', message: $item->published_at
            ? 'Media ditampilkan di Galeri publik.'
            : 'Media disembunyikan dari Galeri publik.');
    }

    public function deleteGalleryItem(int $id): void
    {
        GalleryItem::query()->findOrFail($id)->delete();

        $this->dispatch('toast', type: 'success', message: 'Item Galeri berhasil dihapus.');
    }

    public function copyUrl(string $url): void
    {
        $this->dispatch('toast', type: 'success', message: 'URL telah disalin ke clipboard!');
    }

    public function delete(string $path): void
    {
        try {
            $url = asset('storage/'.$path);
            GalleryItem::query()->where('media_url', $url)->delete();
            Storage::disk('public')->delete($path);
            $this->loadImages();
            $this->dispatch('toast', type: 'success', message: 'Gambar berhasil dihapus!');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Gagal menghapus gambar: '.$e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pages.admin.media-manager', [
            'categoryCount' => max(count(array_filter($this->categories, fn (string $category) => $category !== 'all')), 0),
            'galleryItems' => GalleryItem::query()->latest()->get(),
        ]);
    }
}
