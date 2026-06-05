<?php

namespace App\Livewire\Pages\Alumni;

use App\Models\AlumniProfile;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public AlumniProfile $alumniProfile;

    public function mount(AlumniProfile $alumniProfile): void
    {
        $this->alumniProfile = $alumniProfile;
    }

    public function render(): View
    {
        return view('livewire.pages.alumni.show', [
            'relatedAlumni' => AlumniProfile::query()
                ->where('program', $this->alumniProfile->program)
                ->whereKeyNot($this->alumniProfile->getKey())
                ->orderByDesc('is_featured')
                ->orderBy('name')
                ->limit(3)
                ->get(),
        ]);
    }
}
