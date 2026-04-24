<?php

namespace App\Livewire\Pages\Alumni;

use App\Models\CareerOpportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render(): View
    {
        $user = Auth::user();
        $profile = $user?->alumniProfile;

        $completionFields = [
            $profile?->photo_url,
            $profile?->phone,
            $profile?->campus_name,
            $profile?->bio,
            $profile?->city,
            $profile?->job_title,
            $profile?->employer,
            $profile?->linkedin_url,
            $profile?->testimonial_quote,
        ];

        $completedCount = collect($completionFields)
            ->filter(fn($value) => filled($value))
            ->count();

        $completionRate = (int) round(($completedCount / max(count($completionFields), 1)) * 100);

        return view('livewire.pages.alumni.dashboard', [
            'profile' => $profile,
            'completionRate' => $completionRate,
            'jobStats' => [
                'submitted' => CareerOpportunity::query()->where('submitted_by', $user?->id)->count(),
                'pending' => CareerOpportunity::query()->where('submitted_by', $user?->id)->where('approval_status', CareerOpportunity::STATUS_PENDING)->count(),
                'approved' => CareerOpportunity::query()->where('submitted_by', $user?->id)->where('approval_status', CareerOpportunity::STATUS_APPROVED)->count(),
            ],
            'recentJobs' => CareerOpportunity::query()
                ->where('submitted_by', $user?->id)
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}
