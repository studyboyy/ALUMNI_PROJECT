<?php

namespace App\Livewire\Pages\Admin;

use App\Models\WorkProgram;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class WorkProgramManager extends Component
{
    public bool $showForm = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $category = 'Karier';

    public string $summary = '';

    public string $impact_target = '';

    public string $status = 'Berjalan';

    public string $sort_order = '0';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5'],
            'category' => ['required', 'string'],
            'summary' => ['required', 'string', 'min:10'],
            'impact_target' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $program = WorkProgram::findOrFail($id);

        $this->editingId = $program->id;
        $this->title = $program->title;
        $this->category = $program->category;
        $this->summary = $program->summary;
        $this->impact_target = $program->impact_target ?? '';
        $this->status = $program->status;
        $this->sort_order = (string) $program->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $data = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'summary' => $validated['summary'],
            'impact_target' => $validated['impact_target'] ?: null,
            'status' => $validated['status'],
            'sort_order' => (int) $validated['sort_order'],
        ];

        if ($this->editingId) {
            WorkProgram::findOrFail($this->editingId)->update($data);
            $this->dispatch('toast', type: 'success', message: 'Program kerja berhasil diperbarui.');
        } else {
            WorkProgram::create($data);
            $this->dispatch('toast', type: 'success', message: 'Program kerja baru berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        WorkProgram::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Program kerja berhasil dihapus.');
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->reset(['title', 'summary', 'impact_target']);
        $this->category = 'Karier';
        $this->status = 'Berjalan';
        $this->sort_order = '0';
    }

    public function render(): View
    {
        return view('livewire.pages.admin.work-program-manager', [
            'programs' => WorkProgram::query()->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }
}
