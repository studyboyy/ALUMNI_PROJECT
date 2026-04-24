<?php

use App\Livewire\Pages\Contact\Index as ContactIndex;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('contact form stores a message', function () {
    Livewire::test(ContactIndex::class)
        ->set('name', 'Adit Saputra')
        ->set('email', 'adit@example.com')
        ->set('subject', 'Pertanyaan update data alumni')
        ->set('message', 'Saya ingin mengetahui mekanisme update data alumni untuk presentasi tugas ini.')
        ->call('save')
        ->assertHasNoErrors();

    expect(ContactMessage::query()->count())->toBe(1);

    expect(ContactMessage::query()->first()->subject)->toBe('Pertanyaan update data alumni');
});
