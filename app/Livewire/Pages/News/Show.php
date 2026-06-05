<?php

namespace App\Livewire\Pages\News;

use App\Models\NewsArticle;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public NewsArticle $newsArticle;

    public function mount(NewsArticle $newsArticle): void
    {
        // Tolak akses ke artikel yang belum dipublish
        if ($newsArticle->published_at === null) {
            $this->redirect(route('news.index'), navigate: true);
            return;
        }

        $this->newsArticle = $newsArticle;
    }

    public function render(): View
    {
        return view('livewire.pages.news.show', [
            'relatedArticles' => NewsArticle::query()
                ->published()
                ->whereKeyNot($this->newsArticle->getKey())
                ->limit(3)
                ->get(),
        ]);
    }
}
