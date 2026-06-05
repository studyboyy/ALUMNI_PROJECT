<?php

namespace App\Livewire\Pages\Alumni;

use App\Models\CareerOpportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SubmitJob extends Component
{
    public string $title = '';

    public string $company = '';

    public string $location = '';

    public string $employmentType = 'Full-time';

    public string $summary = '';

    public string $applyUrl = '';

    public string $closesAt = '';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5'],
            'company' => ['required', 'string', 'min:2'],
            'location' => ['required', 'string', 'min:2'],
            'employmentType' => ['required', 'string'],
            'summary' => ['required', 'string', 'min:20'],
            'applyUrl' => ['required', 'url'],
            'closesAt' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        CareerOpportunity::query()->create([
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'company' => $validated['company'],
            'location' => $validated['location'],
            'employment_type' => $validated['employmentType'],
            'summary' => $validated['summary'],
            'apply_url' => $validated['applyUrl'],
            'closes_at' => $validated['closesAt'],
            'submitted_by' => Auth::id(),
            'approval_status' => CareerOpportunity::STATUS_PENDING,
            'is_featured' => false,
        ]);

        $this->reset(['title', 'company', 'location', 'summary', 'applyUrl', 'closesAt']);
        $this->employmentType = 'Full-time';
        $this->dispatch('toast', type: 'success', message: 'Lowongan berhasil diajukan dan menunggu persetujuan admin.');
    }

    private function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 1;

        while (CareerOpportunity::query()->where('slug', $slug)->exists()) {
            $suffix++;
            $slug = $base . '-' . $suffix;
        }

        return $slug;
    }

    public function render(): View
    {
        $user = Auth::user();
        $alumniProfile = $user?->alumniProfile;

        return view('livewire.pages.alumni.submit-job', [
            'myJobs' => CareerOpportunity::query()
                ->where('submitted_by', Auth::id())
                ->latest()
                ->limit(8)
                ->get(),
            'userInfo' => [
                'name' => $user?->name,
                'email' => $user?->email,
                'phone' => $alumniProfile?->phone,
                'photo' => $alumniProfile?->photo_url,
            ],
        ]);
    }
}
