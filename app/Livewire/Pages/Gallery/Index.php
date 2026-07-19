<?php

namespace App\Livewire\Pages\Gallery;

use App\Models\GalleryItem;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.pages.gallery.index', [
            'galleryItems' => GalleryItem::query()
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->get(),
        ]);
    }
}
