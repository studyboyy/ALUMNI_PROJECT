<?php

use App\Livewire\Pages\Admin\NewsManager;
use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('admin news page requires authentication', function () {
    $this->get(route('admin.news'))->assertRedirect(route('login'));
});

test('alumni cannot access admin news page', function () {
    /** @var User $alumni */
    $alumni = User::factory()->create(['role' => 'alumni']);

    $this->actingAs($alumni)
        ->get(route('admin.news'))
        ->assertForbidden();
});

test('admin can create a published news article', function () {
    /** @var User $admin */
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin);

    Livewire::test(NewsManager::class)
        ->set('title', 'Alumni FTI Menjalankan Program Inkubasi Teknologi')
        ->set('category', 'Berita')
        ->set('coverImageUrl', 'https://example.com/cover.jpg')
        ->set('content', '<h2>Program Baru</h2><p>Konten berita yang cukup panjang untuk validasi pengelolaan berita admin.</p>')
        ->set('isFeatured', true)
        ->set('publishNow', true)
        ->call('create')
        ->assertHasNoErrors();

    $article = NewsArticle::query()->firstOrFail();

    expect($article->title)->toBe('Alumni FTI Menjalankan Program Inkubasi Teknologi');
    expect($article->published_at)->not->toBeNull();
    expect($article->is_featured)->toBeTrue();
});
