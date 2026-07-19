<?php

namespace App\Livewire\Pages\TracerStudy;

use App\Models\AlumniProfile;
use App\Models\TracerStudyResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    // Form fields
    public string $name = '';

    public string $nim = '';

    public string $email = '';

    public string $phone = '';

    public string $program = '';

    public string $batch_year = '';

    public string $graduation_year = '';

    public string $employment_status = 'Bekerja';

    public string $employer = '';

    public string $job_title = '';

    public string $industry = '';

    public string $city = '';

    public string $province = '';

    public string $job_relevance = '';

    public string $waiting_time_months = '';

    public string $curriculum_rating = '';

    public string $suggestion = '';

    public bool $submitted = false;

    public bool $alreadySubmitted = false;

    public function mount(): void
    {
        if (Auth::check()) {
            // Pre-fill dari profil alumni jika sudah login
            $profile = Auth::user()?->alumniProfile;
            if ($profile) {
                $this->name = $profile->name ?? '';
                $this->nim = $profile->nim ?? '';
                $this->email = $profile->email ?? Auth::user()->email ?? '';
                $this->phone = $profile->phone ?? '';
                $this->program = $profile->program ?? '';
                $this->batch_year = (string) ($profile->batch_year ?? '');
                $this->graduation_year = (string) ($profile->graduation_year ?? '');
                $this->employer = $profile->employer ?? '';
                $this->job_title = $profile->job_title ?? '';
                $this->industry = $profile->industry ?? '';
                $this->city = $profile->city ?? '';
                $this->province = $profile->province ?? '';
                $this->employment_status = $profile->employment_status ?? 'Bekerja';
            } else {
                $this->email = Auth::user()->email ?? '';
            }

            // Cek apakah sudah pernah isi (berdasarkan user_id)
            $this->alreadySubmitted = TracerStudyResponse::query()
                ->where('user_id', Auth::id())
                ->exists();
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'nim' => ['nullable', 'string', 'max:32'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'program' => ['required', 'string'],
            'batch_year' => ['required', 'integer', 'min:1990', 'max:2100'],
            'graduation_year' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'employment_status' => ['required', 'string'],
            'employer' => ['nullable', 'string', 'max:200'],
            'job_title' => ['nullable', 'string', 'max:200'],
            'industry' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'job_relevance' => ['nullable', 'string'],
            'waiting_time_months' => ['nullable', 'integer', 'min:0', 'max:120'],
            'curriculum_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'suggestion' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        // Cek duplikat berdasarkan email (menangkap guest maupun user yang ganti akun)
        if (TracerStudyResponse::query()->where('email', $validated['email'])->exists()) {
            $this->addError('email', 'Email ini sudah digunakan untuk mengisi tracer study sebelumnya.');

            return;
        }

        // Jika login, cek juga berdasarkan user_id
        if (Auth::check() && TracerStudyResponse::query()->where('user_id', Auth::id())->exists()) {
            $this->alreadySubmitted = true;

            return;
        }

        TracerStudyResponse::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'nim' => $validated['nim'] ?: null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'program' => $validated['program'],
            'batch_year' => $validated['batch_year'],
            'graduation_year' => $validated['graduation_year'] ?: null,
            'employment_status' => $validated['employment_status'],
            'employer' => $validated['employer'] ?: null,
            'job_title' => $validated['job_title'] ?: null,
            'industry' => $validated['industry'] ?: null,
            'city' => $validated['city'] ?: null,
            'province' => $validated['province'] ?: null,
            'job_relevance' => $validated['job_relevance'] ?: null,
            'waiting_time_months' => $validated['waiting_time_months'] ?: null,
            'curriculum_rating' => $validated['curriculum_rating'] ?: null,
            'suggestion' => $validated['suggestion'] ?: null,
        ]);

        $this->submitted = true;
        $this->alreadySubmitted = true;
        $this->dispatch('toast', type: 'success', message: 'Terima kasih! Respons tracer study Anda telah disimpan.');
    }

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
            'totalResponses' => TracerStudyResponse::count(),
        ]);
    }
}
