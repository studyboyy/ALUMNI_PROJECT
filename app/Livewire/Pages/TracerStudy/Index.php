<?php

namespace App\Livewire\Pages\TracerStudy;

use App\Models\AlumniProfile;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.pages.tracer-study.index', [
            'employmentBreakdown' => AlumniProfile::query()
                ->selectRaw('employment_status, count(*) as total')
                ->groupBy('employment_status')
                ->orderByDesc('total')
                ->get(),
            'industryBreakdown' => AlumniProfile::query()
                ->selectRaw('industry, count(*) as total')
                ->whereNotNull('industry')
                ->groupBy('industry')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'cityBreakdown' => AlumniProfile::query()
                ->selectRaw('city, count(*) as total')
                ->whereNotNull('city')
                ->groupBy('city')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
        ]);
    }
}
