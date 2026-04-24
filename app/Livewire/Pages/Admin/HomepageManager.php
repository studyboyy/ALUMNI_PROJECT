<?php

namespace App\Livewire\Pages\Admin;

use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class HomepageManager extends Component
{
    use WithFileUploads;

    public array $slides = [];

    public array $slideUploads = [];

    public function mount(): void
    {
        $this->slides = SiteSetting::getValue('home_hero_slides', [
            [
                'title' => 'Bersama Membangun Teknologi dan Karier',
                'subtitle' => 'Jejaring alumni FTI untuk kolaborasi, pembelajaran, dan peluang profesional.',
                'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Direktori Alumni',
                'cta_url' => '/data-alumni',
            ],
            [
                'title' => 'Kolaborasi Nyata Lintas Angkatan',
                'subtitle' => 'Hubungkan alumni, mahasiswa, dan industri dalam satu ekosistem modern.',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1600&q=80',
                'cta_label' => 'Lihat Karier',
                'cta_url' => '/karier-kolaborasi',
            ],
        ]);
    }

    public function addSlide(): void
    {
        $this->slides[] = [
            'title' => '',
            'subtitle' => '',
            'image' => '',
            'cta_label' => '',
            'cta_url' => '',
        ];
    }

    public function removeSlide(int $index): void
    {
        if (! isset($this->slides[$index])) {
            return;
        }

        unset($this->slides[$index]);
        $this->slides = array_values($this->slides);

        if (isset($this->slideUploads[$index])) {
            unset($this->slideUploads[$index]);
        }

        $this->slideUploads = array_values($this->slideUploads);
    }

    public function save(): void
    {
        $this->validate([
            'slideUploads.*' => ['nullable', 'image', 'max:5120'],
        ]);

        $clean = collect($this->slides)
            ->map(function (array $slide, int $index) {
                if (isset($this->slideUploads[$index]) && $this->slideUploads[$index]) {
                    $path = $this->slideUploads[$index]->storePublicly('homepage-images', 'public');
                    $slide['image'] = asset('storage/' . $path);
                }

                return [
                    'title' => trim($slide['title'] ?? ''),
                    'subtitle' => trim($slide['subtitle'] ?? ''),
                    'image' => trim($slide['image'] ?? ''),
                    'cta_label' => trim($slide['cta_label'] ?? ''),
                    'cta_url' => trim($slide['cta_url'] ?? ''),
                ];
            })
            ->filter(fn(array $slide) => $slide['title'] !== '')
            ->values()
            ->all();

        SiteSetting::setValue('home_hero_slides', $clean);

        $this->slides = $clean;
        $this->slideUploads = [];

        $this->dispatch('toast', type: 'success', message: 'Carousel homepage berhasil disimpan.');
    }

    public function render(): View
    {
        return view('livewire.pages.admin.homepage-manager');
    }
}
