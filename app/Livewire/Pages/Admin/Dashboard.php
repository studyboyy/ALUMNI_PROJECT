<?php

namespace App\Livewire\Pages\Admin;

use App\Models\AlumniProfile;
use App\Models\CareerOpportunity;
use App\Models\EventAgenda;
use App\Models\NewsArticle;
use App\Models\TracerStudyResponse;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render(): View
    {
        $totalAlumni = AlumniProfile::query()->count();
        $registeredAlumni = AlumniProfile::query()->whereNotNull('user_id')->count();
        $unregisteredAlumni = max($totalAlumni - $registeredAlumni, 0);

        $newsCount = NewsArticle::query()->published()->count();
        $eventCount = EventAgenda::query()->upcoming()->count();
        $tracerStudyCount = TracerStudyResponse::query()->count();

        $jobStatusCounts = CareerOpportunity::query()
            ->selectRaw('approval_status, count(*) as total')
            ->groupBy('approval_status')
            ->pluck('total', 'approval_status')
            ->all();

        $approvedJobs = (int) ($jobStatusCounts[CareerOpportunity::STATUS_APPROVED] ?? 0);
        $pendingJobs = (int) ($jobStatusCounts[CareerOpportunity::STATUS_PENDING] ?? 0);
        $rejectedJobs = (int) ($jobStatusCounts[CareerOpportunity::STATUS_REJECTED] ?? 0);
        $openJobs = CareerOpportunity::query()->open()->count();

        $stats = [
            [
                'label' => 'Total Alumni',
                'value' => $totalAlumni,
                'note' => 'Termasuk alumni belum terdaftar.',
            ],
            [
                'label' => 'Akun Alumni',
                'value' => $registeredAlumni,
                'note' => 'Sudah terhubung ke login.',
            ],
            [
                'label' => 'Lowongan Aktif',
                'value' => $openJobs,
                'note' => 'Disetujui dan belum tutup.',
            ],
            [
                'label' => 'Berita & Agenda',
                'value' => $newsCount + $eventCount,
                'note' => 'Konten publik aktif.',
            ],
            [
                'label' => 'Responden Tracer Study',
                'value' => $tracerStudyCount,
                'note' => 'Alumni yang telah mengisi form.',
            ],
        ];

        $registrationTotal = max($totalAlumni, 1);
        $registrationBreakdown = [
            [
                'label' => 'Terdaftar',
                'value' => $registeredAlumni,
                'percent' => (int) round(($registeredAlumni / $registrationTotal) * 100),
                'bar' => 'bg-[color:var(--brand)]',
            ],
            [
                'label' => 'Belum Terdaftar',
                'value' => $unregisteredAlumni,
                'percent' => (int) round(($unregisteredAlumni / $registrationTotal) * 100),
                'bar' => 'bg-slate-300',
            ],
        ];

        $jobTotal = max($approvedJobs + $pendingJobs + $rejectedJobs, 1);
        $jobBreakdown = [
            [
                'label' => 'Disetujui',
                'value' => $approvedJobs,
                'percent' => (int) round(($approvedJobs / $jobTotal) * 100),
                'bar' => 'bg-emerald-400',
            ],
            [
                'label' => 'Menunggu',
                'value' => $pendingJobs,
                'percent' => (int) round(($pendingJobs / $jobTotal) * 100),
                'bar' => 'bg-amber-400',
            ],
            [
                'label' => 'Ditolak',
                'value' => $rejectedJobs,
                'percent' => (int) round(($rejectedJobs / $jobTotal) * 100),
                'bar' => 'bg-rose-400',
            ],
        ];

        $programStats = AlumniProfile::query()
            ->selectRaw('program, count(*) as total')
            ->whereNotNull('program')
            ->groupBy('program')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'label' => $item->program ?: 'Lainnya',
                'value' => (int) $item->total,
            ])
            ->all();

        $cityStats = AlumniProfile::query()
            ->selectRaw('city, count(*) as total')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'label' => $item->city ?: 'Lainnya',
                'value' => (int) $item->total,
            ])
            ->all();

        $programMax = max(collect($programStats)->max('value') ?? 0, 1);
        $cityMax = max(collect($cityStats)->max('value') ?? 0, 1);

        return view('livewire.pages.admin.dashboard', [
            'stats' => $stats,
            'registrationBreakdown' => $registrationBreakdown,
            'jobBreakdown' => $jobBreakdown,
            'programStats' => $programStats,
            'cityStats' => $cityStats,
            'programMax' => $programMax,
            'cityMax' => $cityMax,
        ]);
    }
}
