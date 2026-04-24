<?php

namespace App\Livewire\Pages\Admin;

use App\Models\CareerOpportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class JobApproval extends Component
{
    use WithPagination;

    public string $notes = '';

    protected string $paginationTheme = 'tailwind';

    public function approve(int $jobId): void
    {
        $job = CareerOpportunity::query()->findOrFail($jobId);

        $job->update([
            'approval_status' => CareerOpportunity::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_notes' => $this->notes !== '' ? $this->notes : 'Disetujui admin.',
        ]);

        $this->notes = '';
        $this->dispatch('toast', type: 'success', message: 'Lowongan berhasil disetujui.');
    }

    public function reject(int $jobId): void
    {
        $job = CareerOpportunity::query()->findOrFail($jobId);

        $job->update([
            'approval_status' => CareerOpportunity::STATUS_REJECTED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_notes' => $this->notes !== '' ? $this->notes : 'Ditolak admin.',
        ]);

        $this->notes = '';
        $this->dispatch('toast', type: 'success', message: 'Lowongan berhasil ditolak.');
    }

    public function render(): View
    {
        return view('livewire.pages.admin.job-approval', [
            'pendingJobs' => CareerOpportunity::query()->pending()->with('submitter')->paginate(8),
            'latestDecisions' => CareerOpportunity::query()
                ->whereIn('approval_status', [CareerOpportunity::STATUS_APPROVED, CareerOpportunity::STATUS_REJECTED])
                ->latest('approved_at')
                ->with(['submitter', 'approver'])
                ->limit(6)
                ->get(),
        ]);
    }
}
