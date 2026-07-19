<?php

use App\Models\AlumniProfile;
use App\Models\CareerOpportunity;
use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public sitemap pages render successfully', function () {
    $this->seed();

    $alumnus = AlumniProfile::query()->firstOrFail();
    $article = NewsArticle::query()->firstOrFail();

    $this->get(route('home'))->assertOk();
    $this->get(route('profile.index'))->assertOk();
    $this->get(route('alumni.index'))->assertOk();
    $this->get(route('alumni.show', $alumnus))->assertOk();
    $this->get(route('tracer-study.index'))->assertOk();
    $this->get(route('news.index'))->assertOk();
    $this->get(route('news.show', $article))->assertOk();
    $this->get(route('career.index'))->assertOk();
    $this->get(route('gallery.index'))->assertOk();
    $this->get(route('contact.index'))->assertOk();
});

test('alumni and article pages resolve by slug', function () {
    $alumnus = AlumniProfile::query()->create([
        'name' => 'Salsa Permata',
        'slug' => 'salsa-permata',
        'program' => 'Teknik Informatika',
        'batch_year' => 2021,
        'graduation_year' => 2025,
        'employment_status' => 'Bekerja',
    ]);

    $article = NewsArticle::query()->create([
        'title' => 'Artikel Demo',
        'slug' => 'artikel-demo',
        'category' => 'Berita',
        'excerpt' => 'Ringkasan singkat artikel demo.',
        'content' => 'Konten lengkap artikel demo.',
        'published_at' => now(),
    ]);

    $this->get('/data-alumni/'.$alumnus->slug)->assertOk()->assertSee('Salsa Permata');
    $this->get('/berita-agenda/'.$article->slug)->assertOk()->assertSee('Artikel Demo');
});

test('career opportunity pages resolve by slug', function () {
    $job = CareerOpportunity::factory()->create([
        'title' => 'Backend Engineer Alumni',
        'slug' => 'backend-engineer-alumni',
        'company' => 'FTI Career Lab',
        'approval_status' => CareerOpportunity::STATUS_APPROVED,
        'closes_at' => now()->addMonth(),
    ]);

    $this->get('/karier-kolaborasi/'.$job->slug)
        ->assertOk()
        ->assertSee('Backend Engineer Alumni')
        ->assertSee('FTI Career Lab');
});

test('community button uses the internal forum', function () {
    $this->get(route('career.index'))
        ->assertOk()
        ->assertSee(route('login'), false)
        ->assertDontSee('https://discord.com', false);

    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    $this->actingAs($alumni)
        ->get(route('career.index'))
        ->assertOk()
        ->assertSee(route('alumni.forum'), false)
        ->assertSee('Masuk Forum Alumni')
        ->assertDontSee('https://discord.com', false);
});
