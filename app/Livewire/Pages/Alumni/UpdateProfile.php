<?php

namespace App\Livewire\Pages\Alumni;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class UpdateProfile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $program = '';
    public string $campus_name = '';
    public string $batch_year = '';
    public string $graduation_year = '';
    public string $employer = '';
    public string $job_title = '';
    public string $city = '';
    public string $province = '';
    public string $industry = '';
    public string $employment_status = 'Bekerja';
    public string $bio = '';
    public array $achievements = [];
    public string $linkedin_url = '';
    public string $testimonial_quote = '';
    public $photo_file = null;
    public string $photo_url = '';

    public function mount(): void
    {
        if (! Auth::user()?->alumniProfile) {
            return;
        }

        $profile = Auth::user()->alumniProfile;

        $this->name = $profile->name;
        $this->email = $profile->email ?? '';
        $this->phone = $profile->phone ?? '';
        $this->program = $profile->program;
        $this->campus_name = $profile->campus_name ?? '';
        $this->batch_year = (string) $profile->batch_year;
        $this->graduation_year = (string) ($profile->graduation_year ?? '');
        $this->employer = $profile->employer ?? '';
        $this->job_title = $profile->job_title ?? '';
        $this->city = $profile->city ?? '';
        $this->province = $profile->province ?? '';
        $this->industry = $profile->industry ?? '';
        $this->employment_status = $profile->employment_status ?? 'Bekerja';
        $this->bio = $profile->bio ?? '';
        $this->achievements = $profile->achievements ?? [];
        $this->linkedin_url = $profile->linkedin_url ?? '';
        $this->photo_url = $profile->photo_url ?? '';
        $this->testimonial_quote = $profile->testimonial_quote ?? '';
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
            'program' => ['required', 'string'],
            'campus_name' => ['required', 'string', 'max:180'],
            'batch_year' => ['required', 'integer', 'min:1990', 'max:2100'],
            'graduation_year' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'employer' => ['nullable', 'string'],
            'job_title' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'province' => ['nullable', 'string'],
            'industry' => ['nullable', 'string'],
            'employment_status' => ['required', 'string'],
            'bio' => ['nullable', 'string', 'max:500'],
            'achievements' => ['nullable', 'array'],
            'linkedin_url' => ['nullable', 'url'],
            'testimonial_quote' => ['nullable', 'string', 'max:300'],
            'photo_file' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $profile = Auth::user()?->alumniProfile ?? new \App\Models\AlumniProfile();

        if ($this->photo_file) {
            $path = $this->photo_file->storePublicly('alumni-photos', 'public');
            $profile->photo_url = asset('storage/' . $path);
        } else if (!$profile->photo_url) {
            $profile->photo_url = $this->photo_url ?: null;
        }

        $profile->user_id = Auth::id();
        $profile->name = $validated['name'];
        $profile->slug = Str::slug($validated['name']) . '-' . Str::random(5);
        $profile->email = $validated['email'];
        $profile->phone = $validated['phone'] ?: null;
        $profile->program = $validated['program'];
        $profile->campus_name = $validated['campus_name'];
        $profile->batch_year = $validated['batch_year'];
        $profile->graduation_year = $validated['graduation_year'] ?: null;
        $profile->employer = $validated['employer'] ?: null;
        $profile->job_title = $validated['job_title'] ?: null;
        $profile->city = $validated['city'] ?: null;
        $profile->province = $validated['province'] ?: null;
        $profile->industry = $validated['industry'] ?: null;
        $profile->employment_status = $validated['employment_status'];
        $profile->bio = $validated['bio'] ?: null;
        $profile->achievements = $validated['achievements'] ?: null;
        $profile->linkedin_url = $validated['linkedin_url'] ?: null;
        $profile->testimonial_quote = $validated['testimonial_quote'] ?: null;

        $profile->save();

        $this->photo_file = null;
        $this->dispatch('toast', type: 'success', message: 'Profil berhasil diperbarui!');
    }

    public function addAchievement(string $achievement): void
    {
        if (trim($achievement)) {
            $this->achievements[] = trim($achievement);
        }
    }

    public function removeAchievement(int $index): void
    {
        unset($this->achievements[$index]);
        $this->achievements = array_values($this->achievements);
    }

    public function render(): View
    {
        return view('livewire.pages.alumni.update-profile');
    }
}
