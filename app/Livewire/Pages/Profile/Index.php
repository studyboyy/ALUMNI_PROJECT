<?php

namespace App\Livewire\Pages\Profile;

use App\Models\OrganizationMember;
use App\Models\SiteSetting;
use App\Models\WorkProgram;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render(): View
    {
        $timeline = SiteSetting::getValue('profile_timeline', []);
        $vision = SiteSetting::getValue('profile_vision', '');
        $missions = SiteSetting::getValue('profile_missions', []);

        if (empty($timeline)) {
            $timeline = [
                ['year' => '2008', 'title' => 'Komunitas Alumni FTI Terbentuk', 'description' => 'Dimulai dari inisiatif lintas angkatan untuk membangun jejaring profesional dan kontribusi ke fakultas.'],
                ['year' => '2016', 'title' => 'Program Mentoring Pertama', 'description' => 'Alumni senior mulai rutin mendampingi mahasiswa tingkat akhir dan fresh graduate.'],
                ['year' => '2023', 'title' => 'Platform Jejaring Alumni Digital', 'description' => 'Pengelolaan data alumni dan komunikasi lintas angkatan mulai ditata lebih terstruktur.'],
                ['year' => '2026', 'title' => 'Arah Baru Kolaborasi Industri', 'description' => 'Fokus organisasi diperkuat pada tracer study, peluang karier, dan kolaborasi strategis.'],
            ];
        }

        if ($vision === '') {
            $vision = 'Menjadi jejaring alumni FTI yang solid, adaptif, dan berdampak bagi pengembangan karier alumni, kemajuan fakultas, dan kolaborasi industri.';
        }

        if (empty($missions)) {
            $missions = [
                'Membangun basis data alumni yang relevan dan mudah diperbarui.',
                'Memfasilitasi kolaborasi karier, mentoring, dan pengembangan kapasitas.',
                'Menghubungkan alumni, mahasiswa, dan mitra industri secara berkelanjutan.',
            ];
        }

        return view('livewire.pages.profile.index', [
            'timeline' => $timeline,
            'vision' => $vision,
            'missions' => $missions,
            'organizationMembers' => OrganizationMember::query()->orderBy('sort_order')->get(),
            'workPrograms' => WorkProgram::query()->orderBy('sort_order')->get(),
        ]);
    }
}
