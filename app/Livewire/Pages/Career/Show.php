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

    public function mount(CareerOpportunity $job): void
    {
        $job->load(['submitter', 'submitter.alumniProfile']);
        $this->job = $job;

        // Redirect jika job tidak approved — gunakan $this->redirect() agar eksekusi berhenti
        if ($job->approval_status !== CareerOpportunity::STATUS_APPROVED) {
            $this->redirect(route('career.index'), navigate: true);
            return;
        }
    }

    public function render(): View
    {
        return view('livewire.pages.career.show');
    }
}
