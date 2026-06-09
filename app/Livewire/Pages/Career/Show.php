<?php

namespace App\Livewire\Pages\Career;

use App\Models\CareerOpportunity;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public CareerOpportunity $job;

    public function mount(CareerOpportunity $careerOpportunity): void
    {
        $careerOpportunity->load(['submitter', 'submitter.alumniProfile']);
        $this->job = $careerOpportunity;

        if ($careerOpportunity->approval_status !== CareerOpportunity::STATUS_APPROVED) {
            $this->redirectRoute('career.index', navigate: true);

            return;
        }
    }

    public function render(): View
    {
        return view('livewire.pages.career.show');
    }
}
