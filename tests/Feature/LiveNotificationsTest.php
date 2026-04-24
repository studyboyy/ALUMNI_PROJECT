<?php

use App\Livewire\Components\LiveNotifications;
use App\Models\CareerOpportunity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('admin gets pending job notifications', function () {
    /** @var User $admin */
    $admin = User::factory()->create(['role' => 'admin']);
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    CareerOpportunity::query()->create([
        'title' => 'Pending QA Engineer',
        'slug' => 'pending-qa-engineer',
        'company' => 'PT QA',
        'location' => 'Bandung',
        'employment_type' => 'Full-time',
        'summary' => 'Lowongan pending untuk notifikasi admin.',
        'apply_url' => 'https://example.com/jobs/qa',
        'closes_at' => now()->addDays(10)->toDateString(),
        'submitted_by' => $alumni->id,
        'approval_status' => CareerOpportunity::STATUS_PENDING,
    ]);

    $this->actingAs($admin);

    Livewire::test(LiveNotifications::class)
        ->call('toggle')
        ->assertSee('Pending QA Engineer')
        ->assertSee('1');
});

test('alumni can mark notifications as seen', function () {
    /** @var User $admin */
    $admin = User::factory()->create(['role' => 'admin']);
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    CareerOpportunity::query()->create([
        'title' => 'Approved Backend Engineer',
        'slug' => 'approved-backend-engineer',
        'company' => 'PT Backend',
        'location' => 'Jakarta',
        'employment_type' => 'Full-time',
        'summary' => 'Lowongan approved untuk notifikasi alumni.',
        'apply_url' => 'https://example.com/jobs/backend',
        'closes_at' => now()->addDays(8)->toDateString(),
        'submitted_by' => $alumni->id,
        'approved_by' => $admin->id,
        'approval_status' => CareerOpportunity::STATUS_APPROVED,
        'approved_at' => now(),
    ]);

    $this->actingAs($alumni);

    Livewire::test(LiveNotifications::class)
        ->call('toggle')
        ->assertSee('Approved Backend Engineer')
        ->call('markAllAsSeen')
        ->assertHasNoErrors();

    expect($alumni->fresh()->job_notifications_seen_at)->not->toBeNull();
});
