<?php

namespace App\Livewire\Pages\Admin;

use App\Models\AlumniProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class AlumniManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $search = '';
    public ?int $editingId = null;
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
    public string $linkedin_url = '';
    public $photo_file = null;
    public string $photo_url = '';

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->resetPage();
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
            'linkedin_url' => ['nullable', 'url'],
            'photo_file' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function edit(int $id): void
    {
        $alumni = AlumniProfile::query()->findOrFail($id);

        $this->editingId = $alumni->id;
        $this->name = $alumni->name;
        $this->email = $alumni->email ?? '';
        $this->phone = $alumni->phone ?? '';
        $this->program = $alumni->program;
        $this->campus_name = $alumni->campus_name ?? '';
        $this->batch_year = (string) $alumni->batch_year;
        $this->graduation_year = (string) ($alumni->graduation_year ?? '');
        $this->employer = $alumni->employer ?? '';
        $this->job_title = $alumni->job_title ?? '';
        $this->city = $alumni->city ?? '';
        $this->province = $alumni->province ?? '';
        $this->industry = $alumni->industry ?? '';
        $this->employment_status = $alumni->employment_status ?? 'Bekerja';
        $this->bio = $alumni->bio ?? '';
        $this->linkedin_url = $alumni->linkedin_url ?? '';
        $this->photo_url = $alumni->photo_url ?? '';
    }

    public function save(): void
    {
        if (!$this->editingId) {
            return;
        }

        $validated = $this->validate();

        $alumni = AlumniProfile::query()->findOrFail($this->editingId);

        if ($this->photo_file) {
            $path = $this->photo_file->storePublicly('alumni-photos', 'public');
            $alumni->photo_url = asset('storage/' . $path);
        }

        $alumni->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'program' => $validated['program'],
            'campus_name' => $validated['campus_name'],
            'batch_year' => $validated['batch_year'],
            'graduation_year' => $validated['graduation_year'] ?: null,
            'employer' => $validated['employer'] ?: null,
            'job_title' => $validated['job_title'] ?: null,
            'city' => $validated['city'] ?: null,
            'province' => $validated['province'] ?: null,
            'industry' => $validated['industry'] ?: null,
            'employment_status' => $validated['employment_status'],
            'bio' => $validated['bio'] ?: null,
            'linkedin_url' => $validated['linkedin_url'] ?: null,
        ]);

        $this->resetForm();
        $this->dispatch('toast', type: 'success', message: 'Alumni berhasil diperbarui.');
    }

    public function toggleFeatured(int $id): void
    {
        $alumni = AlumniProfile::query()->findOrFail($id);
        $alumni->update(['is_featured' => ! $alumni->is_featured]);

        $this->dispatch('toast', type: 'success', message: 'Status alumni unggulan berhasil diperbarui.');
    }

    public function delete(int $id): void
    {
        AlumniProfile::query()->findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', type: 'success', message: 'Alumni berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'email', 'phone', 'program', 'campus_name', 'batch_year', 'graduation_year', 'employer', 'job_title', 'city', 'province', 'industry', 'employment_status', 'bio', 'linkedin_url', 'photo_file', 'photo_url']);
        $this->employment_status = 'Bekerja';
    }

    public function render(): View
    {
        return view('livewire.pages.admin.alumni-manager', [
            'alumni' => AlumniProfile::query()
                ->when($this->search !== '', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('program', 'like', "%{$this->search}%")
                        ->orWhere('campus_name', 'like', "%{$this->search}%")
                        ->orWhere('employer', 'like', "%{$this->search}%");
                })
                ->orderByDesc('is_featured')
                ->orderBy('name')
                ->paginate(10),
        ]);
    }
}
