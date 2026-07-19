<?php

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Navigation extends Component
{
    public function render(): View
    {
        $links = [
            ['label' => 'Beranda', 'route' => 'home', 'exact' => true],
            ['label' => 'Profil', 'route' => 'profile.index', 'exact' => false],
            ['label' => 'Data Alumni', 'route' => 'alumni.index', 'exact' => false],
            ['label' => 'Tracer Study', 'route' => 'tracer-study.index', 'exact' => false],
            ['label' => 'Berita & Agenda', 'route' => 'news.index', 'exact' => false],
            ['label' => 'Karier & Kolaborasi', 'route' => 'career.index', 'exact' => false],
            ['label' => 'Galeri', 'route' => 'gallery.index', 'exact' => false],
            ['label' => 'Kontak', 'route' => 'contact.index', 'exact' => false],
        ];

        return view('livewire.components.navigation', [
            'links' => collect($links)
                ->map(fn (array $link): array => [
                    ...$link,
                    'url' => route($link['route']),
                ])
                ->all(),
        ]);
    }
}
