<?php

namespace App\Livewire\Pages\Career;

use App\Models\AlumniProfile;
use App\Models\CareerOpportunity;
use App\Models\WorkProgram;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.pages.career.index', [
            'jobs' => CareerOpportunity::query()->open()->with(['submitter', 'submitter.alumniProfile'])->get(),
            'featuredMentors' => AlumniProfile::query()->where('is_featured', true)->limit(3)->get(),
            'collaborations' => WorkProgram::query()->whereIn('category', ['Karier', 'Kolaborasi'])->orderBy('sort_order')->get(),
            'myPendingJobs' => Auth::check()
                ? CareerOpportunity::query()
                ->where('submitted_by', Auth::id())
                ->where('approval_status', CareerOpportunity::STATUS_PENDING)
                ->count()
                : 0,
        ]);
    }
}
