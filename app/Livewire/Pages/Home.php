<?php

namespace App\Livewire\Pages;

use App\Models\AlumniProfile;
use App\Models\CareerOpportunity;
use App\Models\EventAgenda;
use App\Models\FaqItem;
use App\Models\NewsArticle;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Home extends Component
{
    public function render(): View
    {
        $alumniCount = AlumniProfile::query()->count();

        $stats = [
            ['label' => 'Total Alumni Terdata', 'value' => $alumniCount],
            ['label' => 'Lowongan Aktif', 'value' => CareerOpportunity::query()->open()->count()],
            ['label' => 'Agenda Mendatang', 'value' => EventAgenda::query()->upcoming()->count()],
            ['label' => 'Sebaran Kota Kerja', 'value' => AlumniProfile::query()->whereNotNull('city')->distinct('city')->count('city')],
        ];

        $topCities = AlumniProfile::query()
            ->selectRaw('city, count(*) as total')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(4)
            ->get();

        $heroSlides = SiteSetting::getValue('home_hero_slides', []);

        if (empty($heroSlides)) {
            $heroSlides = [
                [
                    'title' => 'Bersama Membangun Teknologi dan Karier',
                    'subtitle' => 'Platform ini menghubungkan alumni FTI dalam satu ekosistem modern dan kolaboratif.',
                    'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80',
                    'cta_label' => 'Lihat Direktori Alumni',
                    'cta_url' => route('alumni.index'),
                ],
            ];
        }

        return view('livewire.pages.home', [
            'stats' => $stats,
            'topCities' => $topCities,
            'heroSlides' => $heroSlides,
            'featuredAlumni' => AlumniProfile::query()->where('is_featured', true)->limit(4)->get(),
            'latestNews' => NewsArticle::query()->published()->limit(3)->get(),
            'upcomingEvents' => EventAgenda::query()->upcoming()->limit(3)->get(),
            'testimonials' => Testimonial::query()->orderBy('sort_order')->limit(3)->get(),
            'contactChannels' => [
                ['label' => 'Email Humas', 'value' => 'humas@alumni-fti.test'],
                ['label' => 'WhatsApp Admin', 'value' => '+62 811-2222-3333'],
                ['label' => 'Sekretariat', 'value' => 'Gedung FTI Lt. 2, Kampus Utama'],
            ],
            'homeFaqs' => FaqItem::query()->orderBy('sort_order')->limit(3)->get(),
        ]);
    }
}
