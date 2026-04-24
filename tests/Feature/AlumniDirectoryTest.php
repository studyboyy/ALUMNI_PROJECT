<?php

use App\Livewire\Pages\Alumni\Index as AlumniIndex;
use App\Models\AlumniProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('alumni directory can filter by program and search term', function () {
    AlumniProfile::query()->create([
        'name' => 'Rizal Data',
        'slug' => 'rizal-data',
        'program' => 'Sistem Informasi',
        'batch_year' => 2019,
        'employer' => 'Mekari',
        'job_title' => 'Business Analyst',
        'employment_status' => 'Bekerja',
    ]);

    AlumniProfile::query()->create([
        'name' => 'Tania Code',
        'slug' => 'tania-code',
        'program' => 'Teknik Informatika',
        'batch_year' => 2019,
        'employer' => 'GoTo Group',
        'job_title' => 'Backend Engineer',
        'employment_status' => 'Bekerja',
    ]);

    Livewire::test(AlumniIndex::class)
        ->set('program', 'Teknik Informatika')
        ->set('search', 'Tania')
        ->assertSee('Tania Code')
        ->assertDontSee('Rizal Data');
});
