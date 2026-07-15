<?php

namespace App\Livewire\Pages\Alumni;

use App\Models\AlumniProfile;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $program = '';

    public string $batchYear = '';

    public string $employer = '';

    protected string $paginationTheme = 'tailwind';

    protected function queryString(): array
    {
        return [
            'search' => ['except' => ''],
            'program' => ['except' => ''],
            'batchYear' => ['except' => ''],
            'employer' => ['except' => ''],
        ];
    }

    public function updated(string $name): void
    {
        if (in_array($name, ['search', 'program', 'batchYear', 'employer'], true)) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset('search', 'program', 'batchYear', 'employer');
        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.pages.alumni.index', [
            'alumni' => AlumniProfile::query()
                ->filter([
                    'search' => $this->search,
                    'program' => $this->program,
                    'batch_year' => $this->batchYear,
                    'employer' => $this->employer,
                ])
                ->orderByRaw("case when employment_status = 'Bekerja' then 0 else 1 end")
                ->orderBy('name')
                ->paginate(6),
            'programs' => AlumniProfile::query()->select('program')->distinct()->orderBy('program')->pluck('program'),
            'batchYears' => AlumniProfile::query()->select('batch_year')->distinct()->orderByDesc('batch_year')->pluck('batch_year'),
            'industryStats' => AlumniProfile::query()
                ->selectRaw('industry, count(*) as total')
                ->whereNotNull('industry')
                ->groupBy('industry')
                ->orderByDesc('total')
                ->limit(4)
                ->get(),
        ]);
    }
}
