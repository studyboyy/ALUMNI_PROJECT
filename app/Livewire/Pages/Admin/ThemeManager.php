<?php

namespace App\Livewire\Pages\Admin;

use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ThemeManager extends Component
{
    public string $theme = 'blue';

    public array $availableThemes = [
        'blue' => [
            'name' => 'Aurora Blue',
            'description' => 'Tema biru cerah yang bersih dan modern',
            'colors' => ['Blue', 'Cyan'],
        ],
        'mint' => [
            'name' => 'Aurora Mint',
            'description' => 'Tema hijau yang segar dan menenangkan',
            'colors' => ['Green', 'Teal'],
        ],
        'indigo' => [
            'name' => 'Aurora Indigo',
            'description' => 'Tema biru-ungu yang profesional dan modern',
            'colors' => ['Indigo', 'Purple'],
        ],
    ];

    public function mount(): void
    {
        $theme = SiteSetting::getValue('site_theme', 'blue');
        $this->theme = $theme === 'coral' ? 'blue' : $theme;

        if ($theme === 'coral') {
            SiteSetting::setValue('site_theme', 'blue');
        }
    }

    public function setTheme(string $theme): void
    {
        if (!isset($this->availableThemes[$theme])) {
            return;
        }

        SiteSetting::setValue('site_theme', $theme);
        $this->theme = $theme;

        $this->dispatch('theme-changed', theme: $theme);
        $this->dispatch('toast', type: 'success', message: 'Tema berhasil diubah menjadi ' . $this->availableThemes[$theme]['name']);
    }

    public function render(): View
    {
        return view('livewire.pages.admin.theme-manager');
    }
}
