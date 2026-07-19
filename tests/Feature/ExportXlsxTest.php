<?php

use App\Models\AlumniProfile;
use App\Models\TracerStudyResponse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can export alumni data as a formatted xlsx file', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    AlumniProfile::factory()->create([
        'name' => 'Raka Pratama',
        'nim' => '0123456789',
        'email' => 'raka@example.test',
        'phone' => '081234567890',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.alumni.export'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->assertHeader('Content-Disposition', 'attachment; filename="data-alumni-'.now()->format('Y-m-d').'.xlsx"');

    expect(substr($response->getContent(), 0, 2))->toBe('PK');
    expect(readXlsxEntry($response->getContent(), 'xl/worksheets/sheet1.xml'))->toContain('Raka Pratama');
    expect(readXlsxEntry($response->getContent(), 'xl/workbook.xml'))->toContain('Data Alumni');
});

test('admin can export tracer study data as a formatted xlsx file', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    TracerStudyResponse::query()->create([
        'name' => 'Nadia Azzahra',
        'nim' => '0987654321',
        'email' => 'nadia@example.test',
        'phone' => '081122223333',
        'program' => 'Sistem Informasi',
        'batch_year' => 2020,
        'graduation_year' => 2024,
        'employment_status' => 'Bekerja',
        'employer' => 'Bank BSI',
        'job_title' => 'Business Analyst',
        'industry' => 'Finance',
        'city' => 'Jakarta',
        'province' => 'DKI Jakarta',
        'job_relevance' => 'Sesuai',
        'waiting_time_months' => 2,
        'curriculum_rating' => 5,
        'suggestion' => 'Pertahankan kolaborasi industri.',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.tracer-study.export'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->assertHeader('Content-Disposition', 'attachment; filename="tracer-study-'.now()->format('Y-m-d').'.xlsx"');

    expect(substr($response->getContent(), 0, 2))->toBe('PK');
    expect(readXlsxEntry($response->getContent(), 'xl/worksheets/sheet1.xml'))->toContain('Nadia Azzahra');
    expect(readXlsxEntry($response->getContent(), 'xl/workbook.xml'))->toContain('Tracer Study');
});

function readXlsxEntry(string $contents, string $entry): string
{
    $path = tempnam(sys_get_temp_dir(), 'xlsx-test-');
    file_put_contents($path, $contents);

    $zip = new ZipArchive;
    expect($zip->open($path))->toBeTrue();

    $entryContents = $zip->getFromName($entry);
    $zip->close();
    unlink($path);

    expect($entryContents)->not->toBeFalse();

    return (string) $entryContents;
}
