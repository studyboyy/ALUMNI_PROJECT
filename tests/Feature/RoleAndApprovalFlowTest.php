<?php

use App\Livewire\Pages\Admin\JobApproval;
use App\Livewire\Pages\Alumni\SubmitJob;
use App\Models\CareerOpportunity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('guest is redirected when accessing admin routes', function () {
    $this->get(route('admin.jobs'))->assertRedirect(route('login'));
});

test('non admin cannot access admin routes', function () {
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    $this->actingAs($alumni)
        ->get(route('admin.jobs'))
        ->assertForbidden();
});

test('alumni submitted job is pending by default', function () {
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    $this->actingAs($alumni);

    Livewire::test(SubmitJob::class)
        ->set('title', 'Frontend Engineer')
        ->set('company', 'PT Alumni Teknologi')
        ->set('location', 'Jakarta')
        ->set('employmentType', 'Full-time')
        ->set('summary', 'Membutuhkan kandidat yang menguasai Vue atau React serta memiliki pengalaman API integration.')
        ->set('applyUrl', 'https://example.com/jobs/frontend-engineer')
        ->set('closesAt', now()->addDays(14)->toDateString())
        ->call('submit')
        ->assertHasNoErrors();

    $job = CareerOpportunity::query()->firstOrFail();

    expect($job->approval_status)->toBe(CareerOpportunity::STATUS_PENDING);
    expect($job->submitted_by)->toBe($alumni->id);
});

test('pending jobs are hidden from public career page', function () {
    /** @var User $admin */
    $admin = User::factory()->create(['role' => 'admin']);
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    CareerOpportunity::query()->create([
        'title' => 'Approved Job',
        'slug' => 'approved-job',
        'company' => 'PT Approved',
        'location' => 'Bandung',
        'employment_type' => 'Full-time',
        'summary' => 'Approved summary content for test.',
        'apply_url' => 'https://example.com/jobs/approved',
        'closes_at' => now()->addDays(10)->toDateString(),
        'approval_status' => CareerOpportunity::STATUS_APPROVED,
        'submitted_by' => $alumni->id,
        'approved_by' => $admin->id,
        'approved_at' => now(),
    ]);

    CareerOpportunity::query()->create([
        'title' => 'Pending Job',
        'slug' => 'pending-job',
        'company' => 'PT Pending',
        'location' => 'Jakarta',
        'employment_type' => 'Full-time',
        'summary' => 'Pending summary content for test.',
        'apply_url' => 'https://example.com/jobs/pending',
        'closes_at' => now()->addDays(10)->toDateString(),
        'approval_status' => CareerOpportunity::STATUS_PENDING,
        'submitted_by' => $alumni->id,
    ]);

    $this->get(route('career.index'))
        ->assertOk()
        ->assertSee('Approved Job')
        ->assertDontSee('Pending Job');
});

test('admin can approve pending job', function () {
    /** @var User $admin */
    $admin = User::factory()->create(['role' => 'admin']);
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    $job = CareerOpportunity::query()->create([
        'title' => 'Data Engineer',
        'slug' => 'data-engineer-test',
        'company' => 'PT Data',
        'location' => 'Yogyakarta',
        'employment_type' => 'Full-time',
        'summary' => 'Lowongan data engineer untuk validasi approval flow.',
        'apply_url' => 'https://example.com/jobs/data-engineer',
        'closes_at' => now()->addDays(12)->toDateString(),
        'approval_status' => CareerOpportunity::STATUS_PENDING,
        'submitted_by' => $alumni->id,
    ]);

    $this->actingAs($admin);

    Livewire::test(JobApproval::class)
        ->set('notes', 'Konten lowongan valid dan siap tayang.')
        ->call('approve', $job->id)
        ->assertHasNoErrors();

    $job->refresh();

    expect($job->approval_status)->toBe(CareerOpportunity::STATUS_APPROVED);
    expect($job->approved_by)->toBe($admin->id);
});
