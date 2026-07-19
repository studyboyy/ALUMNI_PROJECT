<?php

use App\Models\AlumniProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('homepage uses employment status instead of subjective featured status', function () {
    AlumniProfile::factory()->create([
        'name' => 'Alumni Sudah Bekerja',
        'slug' => 'alumni-sudah-bekerja',
        'employment_status' => 'Bekerja',
    ]);

    AlumniProfile::factory()->create([
        'name' => 'Alumni Pilihan Lama',
        'slug' => 'alumni-pilihan-lama',
        'employment_status' => 'Belum Bekerja',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Alumni Sudah Bekerja')
        ->assertDontSee('Alumni Pilihan Lama');
});

test('alumni directory labels working alumni objectively', function () {
    AlumniProfile::factory()->create([
        'name' => 'Profesional Alumni',
        'slug' => 'profesional-alumni',
        'employment_status' => 'Bekerja',
    ]);

    $this->get(route('alumni.index'))
        ->assertOk()
        ->assertSee('Profesional Alumni')
        ->assertSee('Sudah Bekerja')
        ->assertDontSee('Featured');
});
