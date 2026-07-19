<?php

namespace App\Livewire\Pages\Admin;

use App\Models\TracerStudyResponse;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class TracerStudyManager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterStatus = '';

    public string $filterProgram = '';

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterProgram(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        TracerStudyResponse::query()->whereKey($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Data berhasil dihapus.');
    }

    public function render(): View
    {
        $query = TracerStudyResponse::query()
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('nim', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('employer', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus !== '', fn ($q) => $q->where('employment_status', $this->filterStatus))
            ->when($this->filterProgram !== '', fn ($q) => $q->where('program', 'like', "%{$this->filterProgram}%"))
            ->orderByDesc('created_at');

        return view('livewire.pages.admin.tracer-study-manager', [
            'responses' => $query->paginate(15),
            'totalCount' => TracerStudyResponse::count(),
            'programs' => TracerStudyResponse::query()->distinct()->orderBy('program')->pluck('program'),
            'statuses' => TracerStudyResponse::query()->distinct()->orderBy('employment_status')->pluck('employment_status'),
        ]);
    }
}
