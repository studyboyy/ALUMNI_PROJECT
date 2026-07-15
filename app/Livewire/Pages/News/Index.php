<?php

namespace App\Livewire\Pages\News;

use App\Models\EventAgenda;
use App\Models\GalleryItem;
use App\Models\NewsArticle;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.pages.news.index', [
            'featuredArticle' => NewsArticle::query()->published()->where('is_featured', true)->first(),
            'articles' => NewsArticle::query()->published()->get(),
            'upcomingEvents' => EventAgenda::query()->upcoming()->limit(3)->get(),
            'galleryItems' => GalleryItem::query()
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->limit(4)
                ->get(),
        ]);
    }
}
