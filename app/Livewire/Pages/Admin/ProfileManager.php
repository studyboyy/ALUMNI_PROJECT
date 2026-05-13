<?php

namespace App\Livewire\Pages\Admin;

use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ProfileManager extends Component
{
    use WithFileUploads;

    public string $logoUrl = '';

    public $logoUpload;

    public string $vision = '';

    /** @var array<int, string> */
    public array $missions = [];

    /** @var array<int, array{year: string, title: string, description: string}> */
    public array $timeline = [];

    /** @var array<int, array{label: string, value: string}> */
    public array $contactChannels = [];

    public string $mapEmbedUrl = '';

    public function mount(): void
    {
        $defaults = $this->profileDefaults();

        $this->logoUrl = SiteSetting::getValue('site_logo_url', '');

        $this->vision = SiteSetting::getValue('profile_vision', $defaults['vision']);
        $this->missions = SiteSetting::getValue('profile_missions', $defaults['missions']);
        $this->timeline = SiteSetting::getValue('profile_timeline', $defaults['timeline']);

        $this->contactChannels = SiteSetting::getValue('contact_channels', $this->contactDefaults());
        $this->mapEmbedUrl = SiteSetting::getValue('contact_map_embed_url', $this->defaultMapUrl());
    }

    public function removeLogo(): void
    {
        $this->logoUrl = '';
        $this->logoUpload = null;

        SiteSetting::setValue('site_logo_url', '');
        SiteSetting::setValue('site_logo_updated_at', now()->timestamp);

        $this->dispatch('toast', type: 'success', message: 'Logo berhasil dihapus.');
    }

    public function saveLogo(): void
    {
        $this->validate([
            'logoUpload' => ['nullable', 'image', 'max:2048'],
            'logoUrl' => ['nullable', 'string'],
        ]);

        if ($this->logoUpload) {
            $path = $this->logoUpload->storePublicly('site-assets', 'public');
            $this->logoUrl = asset('storage/' . $path);
        }

        $cleanLogo = trim($this->logoUrl);

        SiteSetting::setValue('site_logo_url', $cleanLogo);
        SiteSetting::setValue('site_logo_updated_at', now()->timestamp);

        $this->logoUrl = $cleanLogo;
        $this->logoUpload = null;

        $this->dispatch('toast', type: 'success', message: 'Logo berhasil disimpan.');
    }

    public function addMission(): void
    {
        $this->missions[] = '';
    }

    public function removeMission(int $index): void
    {
        if (! isset($this->missions[$index])) {
            return;
        }

        unset($this->missions[$index]);
        $this->missions = array_values($this->missions);
    }

    public function addTimelineItem(): void
    {
        $this->timeline[] = [
            'year' => '',
            'title' => '',
            'description' => '',
        ];
    }

    public function removeTimelineItem(int $index): void
    {
        if (! isset($this->timeline[$index])) {
            return;
        }

        unset($this->timeline[$index]);
        $this->timeline = array_values($this->timeline);
    }

    public function addContactChannel(): void
    {
        $this->contactChannels[] = [
            'label' => '',
            'value' => '',
        ];
    }

    public function removeContactChannel(int $index): void
    {
        if (! isset($this->contactChannels[$index])) {
            return;
        }

        unset($this->contactChannels[$index]);
        $this->contactChannels = array_values($this->contactChannels);
    }

    public function save(): void
    {
        $this->validate([
            'logoUpload' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->logoUpload) {
            $path = $this->logoUpload->storePublicly('site-assets', 'public');
            $this->logoUrl = asset('storage/' . $path);
        }

        $cleanLogo = trim($this->logoUrl);
        $cleanVision = trim($this->vision);

        $cleanMissions = collect($this->missions)
            ->map(fn(string $mission) => trim($mission))
            ->filter()
            ->values()
            ->all();

        $cleanTimeline = collect($this->timeline)
            ->map(fn(array $item) => [
                'year' => trim((string) ($item['year'] ?? '')),
                'title' => trim((string) ($item['title'] ?? '')),
                'description' => trim((string) ($item['description'] ?? '')),
            ])
            ->filter(fn(array $item) => $item['year'] !== '' && $item['title'] !== '' && $item['description'] !== '')
            ->values()
            ->all();

        $cleanContacts = collect($this->contactChannels)
            ->map(fn(array $channel) => [
                'label' => trim((string) ($channel['label'] ?? '')),
                'value' => trim((string) ($channel['value'] ?? '')),
            ])
            ->filter(fn(array $channel) => $channel['label'] !== '' && $channel['value'] !== '')
            ->values()
            ->all();

        $cleanMap = $this->normalizeMapUrl($this->mapEmbedUrl);

        SiteSetting::setValue('site_logo_url', $cleanLogo);
        SiteSetting::setValue('site_logo_updated_at', now()->timestamp);
        SiteSetting::setValue('profile_vision', $cleanVision);
        SiteSetting::setValue('profile_missions', $cleanMissions);
        SiteSetting::setValue('profile_timeline', $cleanTimeline);
        SiteSetting::setValue('contact_channels', $cleanContacts);
        SiteSetting::setValue('contact_map_embed_url', $cleanMap);

        $this->logoUrl = $cleanLogo;
        $this->logoUpload = null;
        $this->vision = $cleanVision;
        $this->missions = $cleanMissions;
        $this->timeline = $cleanTimeline;
        $this->contactChannels = $cleanContacts;
        $this->mapEmbedUrl = $cleanMap;

        $this->dispatch('toast', type: 'success', message: 'Konten profil dan kontak berhasil disimpan.');
    }

    public function render(): View
    {
        return view('livewire.pages.admin.profile-manager');
    }

    private function profileDefaults(): array
    {
        return [
            'vision' => 'Menjadi jejaring alumni FTI yang solid, adaptif, dan berdampak bagi pengembangan karier alumni, kemajuan fakultas, dan kolaborasi industri.',
            'missions' => [
                'Membangun basis data alumni yang relevan dan mudah diperbarui.',
                'Memfasilitasi kolaborasi karier, mentoring, dan pengembangan kapasitas.',
                'Menghubungkan alumni, mahasiswa, dan mitra industri secara berkelanjutan.',
            ],
            'timeline' => [
                [
                    'year' => '2008',
                    'title' => 'Komunitas Alumni FTI Terbentuk',
                    'description' => 'Dimulai dari inisiatif lintas angkatan untuk membangun jejaring profesional dan kontribusi ke fakultas.',
                ],
                [
                    'year' => '2016',
                    'title' => 'Program Mentoring Pertama',
                    'description' => 'Alumni senior mulai rutin mendampingi mahasiswa tingkat akhir dan fresh graduate.',
                ],
                [
                    'year' => '2023',
                    'title' => 'Platform Jejaring Alumni Digital',
                    'description' => 'Pengelolaan data alumni dan komunikasi lintas angkatan mulai ditata lebih terstruktur.',
                ],
                [
                    'year' => '2026',
                    'title' => 'Arah Baru Kolaborasi Industri',
                    'description' => 'Fokus organisasi diperkuat pada tracer study, peluang karier, dan kolaborasi strategis.',
                ],
            ],
        ];
    }

    private function contactDefaults(): array
    {
        return [
            ['label' => 'Email Humas', 'value' => 'humas@alumni-fti.test'],
            ['label' => 'WhatsApp Admin', 'value' => '+62 811-2222-3333'],
            ['label' => 'Sekretariat', 'value' => 'Gedung FTI Lt. 2, Kampus Utama'],
        ];
    }

    private function defaultMapUrl(): string
    {
        return 'https://www.google.com/maps?q=universitas%20teknologi%20indonesia&output=embed';
    }

    private function normalizeMapUrl(string $rawUrl): string
    {
        $rawUrl = trim($rawUrl);

        if ($rawUrl === '') {
            return $this->defaultMapUrl();
        }

        if (str_contains($rawUrl, '<iframe')) {
            if (preg_match('/src=[\"\"]([^\"\"]+)[\"\"]/i', $rawUrl, $matches)) {
                $rawUrl = trim($matches[1]);
            }
        }

        if ($rawUrl === '') {
            return $this->defaultMapUrl();
        }

        if (str_contains($rawUrl, 'output=embed') || str_contains($rawUrl, '/maps/embed')) {
            return $rawUrl;
        }

        if (str_contains($rawUrl, 'google.com/maps') || str_contains($rawUrl, 'maps.google.com')) {
            $separator = str_contains($rawUrl, '?') ? '&' : '?';
            return $rawUrl . $separator . 'output=embed';
        }

        return $rawUrl;
    }
}
