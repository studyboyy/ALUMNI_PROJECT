<?php

namespace App\Livewire\Pages\Admin;

use App\Models\AlumniProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class AlumniManager extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showModal = false;
    public ?int $editingId = null;

    public string $nim = '';
    public string $name = '';
    public string $program = '';
    public string $campus_name = '';
    public string $batch_year = '';

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    protected function rules(): array
    {
        return [
            'nim' => [
                'required',
                'string',
                'max:32',
                Rule::unique('alumni_profiles', 'nim')->ignore($this->editingId),
            ],
            'name' => ['required', 'string', 'min:3'],
            'program' => ['required', 'string'],
            'campus_name' => ['required', 'string', 'max:180'],
            'batch_year' => ['required', 'integer', 'min:1990', 'max:2100'],
        ];
    }

    public function edit(int $id): void
    {
        $alumni = AlumniProfile::query()->findOrFail($id);

        $this->showModal = true;
        $this->editingId = $alumni->id;
        $this->nim = $alumni->nim ?? '';
        $this->name = $alumni->name;
        $this->program = $alumni->program;
        $this->campus_name = $alumni->campus_name ?? '';
        $this->batch_year = (string) $alumni->batch_year;
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $alumni = $this->editingId
            ? AlumniProfile::query()->findOrFail($this->editingId)
            : new AlumniProfile();

        if (! $this->editingId) {
            $alumni->slug = $this->generateUniqueSlug($validated['name'], $validated['nim']);
            $alumni->employment_status = 'Bekerja';
        }

        $alumni->fill([
            'nim' => $validated['nim'],
            'name' => $validated['name'],
            'program' => $validated['program'],
            'campus_name' => $validated['campus_name'],
            'batch_year' => $validated['batch_year'],
        ]);

        $alumni->save();

        $this->resetForm();
        $this->dispatch('toast', type: 'success', message: 'Data alumni berhasil disimpan.');
    }

    private function generateUniqueSlug(string $name, string $nim): string
    {
        $base = Str::slug($name) . '-' . Str::slug($nim);
        $slug = $base;
        $suffix = 1;

        while (AlumniProfile::query()->where('slug', $slug)->exists()) {
            $suffix++;
            $slug = $base . '-' . $suffix;
        }

        return $slug;
    }

    public function toggleFeatured(int $id): void
    {
        $alumni = AlumniProfile::query()->findOrFail($id);
        $alumni->update(['is_featured' => ! $alumni->is_featured]);

        $this->dispatch('toast', type: 'success', message: 'Status alumni unggulan berhasil diperbarui.');
    }

    public function delete(int $id): void
    {
        AlumniProfile::query()->whereKey($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', type: 'success', message: 'Alumni berhasil dihapus.');
    }

    public function resetForm(): void
    {
        $this->reset(['showModal', 'editingId', 'nim', 'name', 'program', 'campus_name', 'batch_year']);
    }

    public function render(): View
    {
        return view('livewire.pages.admin.alumni-manager', [
            'alumni' => AlumniProfile::query()
                ->when($this->search !== '', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('nim', 'like', "%{$this->search}%")
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
