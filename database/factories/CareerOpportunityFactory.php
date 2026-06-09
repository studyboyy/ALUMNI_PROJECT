<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CareerOpportunityFactory extends Factory
{
    public function definition(): array
    {
        $alumniId = User::where('role', 'alumni')->inRandomOrder()->value('id');
        $adminId = User::where('role', 'admin')->inRandomOrder()->value('id');
        $companies = ['GoTo Group', 'Tokopedia', 'Shopee', 'Traveloka', 'Mekari', 'Dicoding', 'Gojek'];
        $positions = ['Backend Engineer', 'Frontend Engineer', 'Data Analyst', 'Product Manager', 'UI/UX Designer'];
        $jobBoardUrls = [
            'https://linkedin.com/jobs/view/' . fake()->numerify('##########'),
            'https://www.kalibrr.id/jobs/' . fake()->slug(),
            'https://www.jobstreet.co.id/en/job/' . fake()->slug(),
            'https://glints.com/en/opportunities/' . fake()->slug(),
            'https://careers.tokopedia.com/jobs/' . fake()->slug(),
        ];

        $title   = fake()->randomElement($positions);
        $company = fake()->randomElement($companies);

        return [
            'title'           => $title,
            'slug'            => Str::slug($title . '-' . $company . '-' . fake()->numerify('###')),
            'company'         => $company,
            'location' => fake()->randomElement(['Jakarta', 'Bandung', 'Yogyakarta', 'Surabaya', 'Remote']),
            'employment_type' => fake()->randomElement(['Full-time', 'Contract', 'Internship']),
            'summary' => fake()->paragraph(),
            'apply_url' => fake()->randomElement($jobBoardUrls),
            'closes_at' => fake()->dateTimeBetween('+1 days', '+3 months')->format('Y-m-d'),
            'is_featured' => fake()->boolean(40),
            'submitted_by' => $alumniId,
            'approved_by' => $adminId,
            'approval_status' => $adminId ? 'approved' : 'pending',
            'approval_notes' => $adminId ? 'Disetujui seeder.' : null,
            'approved_at' => $adminId ? now() : null,
        ];
    }
}
