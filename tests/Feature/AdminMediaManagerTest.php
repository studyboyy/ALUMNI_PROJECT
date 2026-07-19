<?php

use App\Livewire\Pages\Admin\MediaManager;
use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('admin media upload is synchronized with the public gallery', function () {
    Storage::fake('public');

    /** @var User $admin */
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin);

    Livewire::test(MediaManager::class)
        ->set('title', 'Dokumentasi Reuni Alumni')
        ->set('caption', 'Pertemuan alumni lintas angkatan.')
        ->set('eventName', 'Reuni Alumni 2026')
        ->set('publishNow', true)
        ->set('file', UploadedFile::fake()->image('reuni.jpg'))
        ->call('upload')
        ->assertHasNoErrors();

    $item = GalleryItem::query()->firstOrFail();

    expect($item->title)->toBe('Dokumentasi Reuni Alumni');
    expect($item->published_at)->not->toBeNull();
    expect(Storage::disk('public')->files('gallery-images'))->toHaveCount(1);

    $this->get(route('gallery.index'))
        ->assertOk()
        ->assertSee('Dokumentasi Reuni Alumni');
});

test('unpublished media is hidden from the public gallery', function () {
    GalleryItem::query()->create([
        'title' => 'Dokumentasi Internal',
        'media_type' => 'image',
        'media_url' => 'https://example.com/internal.jpg',
        'published_at' => null,
    ]);

    $this->get(route('gallery.index'))
        ->assertOk()
        ->assertDontSee('Dokumentasi Internal');
});
