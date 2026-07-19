<?php

namespace App\Livewire\Components;

use App\Models\CareerOpportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveNotifications extends Component
{
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function markAllAsSeen(): void
    {
        $user = Auth::user();

        if (! $user || $user->isAdmin()) {
            return;
        }

        $user->forceFill([
            'job_notifications_seen_at' => now(),
        ])->save();
    }

    public function render(): View
    {
        if (! Auth::check()) {
            return view('livewire.components.live-notifications', [
                'unreadCount' => 0,
                'items' => collect(),
            ]);
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            $items = CareerOpportunity::query()
                ->pending()
                ->with('submitter')
                ->limit(5)
                ->get();

            return view('livewire.components.live-notifications', [
                'unreadCount' => $items->count(),
                'items' => $items,
            ]);
        }

        $baseQuery = CareerOpportunity::query()
            ->where('submitted_by', $user->id)
            ->whereIn('approval_status', [
                CareerOpportunity::STATUS_APPROVED,
                CareerOpportunity::STATUS_REJECTED,
            ])
            ->whereNotNull('approved_at');

        $items = (clone $baseQuery)
            ->latest('approved_at')
            ->limit(5)
            ->get();

        $unreadCount = (clone $baseQuery)
            ->when(
                $user->job_notifications_seen_at,
                fn ($query) => $query->where('approved_at', '>', $user->job_notifications_seen_at)
            )
            ->count();

        return view('livewire.components.live-notifications', [
            'unreadCount' => $unreadCount,
            'items' => $items,
        ]);
    }
}
