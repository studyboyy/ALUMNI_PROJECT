<?php

namespace App\Livewire\Pages\Admin;

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
    public array $images = [];
    public string $searchQuery = '';
    public string $selectedCategory = 'all';
    public array $categories = ['all', 'alumni-photos', 'news-images', 'homepage-images'];

    public function mount(): void
    {
        $this->loadImages();
    }

    public function loadImages(): void
    {
        $this->images = [];
        $basePath = storage_path('app/public');

        if (!is_dir($basePath)) {
            return;
        }

        $folders = ['alumni-photos', 'news-images', 'homepage-images'];

        foreach ($folders as $folder) {
            $folderPath = $basePath . '/' . $folder;
            if (!is_dir($folderPath)) {
                continue;
            }

            $files = File::files($folderPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $relativePath = $folder . '/' . $filename;

                // Filter by search
                if ($this->searchQuery && !str_contains(strtolower($filename), strtolower($this->searchQuery))) {
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
                        'url' => asset('storage/' . $relativePath),
                        'size' => $file->getSize(),
                        'category' => $folder,
                        'mtime' => $file->getMTime(),
                    ];
                }
            }
        }

        // Sort by modification time descending
        usort($this->images, fn($a, $b) => $b['mtime'] <=> $a['mtime']);
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
        $this->validate([
            'file' => ['required', 'image', 'max:10240'],
        ]);

        $path = $this->file->storePublicly('homepage-images', 'public');

        $this->file = null;
        $this->loadImages();

        $this->dispatch('toast', type: 'success', message: 'Gambar berhasil diupload!');
    }

    public function copyUrl(string $url): void
    {
        $this->dispatch('toast', type: 'success', message: 'URL telah disalin ke clipboard!');
    }

    public function delete(string $path): void
    {
        try {
            Storage::disk('public')->delete($path);
            $this->loadImages();
            $this->dispatch('toast', type: 'success', message: 'Gambar berhasil dihapus!');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Gagal menghapus gambar: ' . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.pages.admin.media-manager', [
            'categoryCount' => max(count(array_filter($this->categories, fn (string $category) => $category !== 'all')), 0),
        ]);
    }
}
