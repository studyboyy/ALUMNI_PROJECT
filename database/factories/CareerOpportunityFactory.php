<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CareerOpportunityFactory extends Factory
{
    public function definition(): array
    {
        $companies = ['GoTo Group', 'Tokopedia', 'Shopee', 'Traveloka', 'Mekari', 'Dicoding', 'Gojek'];
        $positions = ['Backend Engineer', 'Frontend Engineer', 'Data Analyst', 'Product Manager', 'UI/UX Designer'];
        $jobBoardUrls = [
            'https://linkedin.com/jobs/view/' . fake()->numerify('##########'),
            'https://www.kalibrr.id/jobs/' . fake()->slug(),
            'https://www.jobstreet.co.id/en/job/' . fake()->slug(),
            'https://glints.com/en/opportunities/' . fake()->slug(),
            'https://careers.tokopedia.com/jobs/' . fake()->slug(),
        ];

        return [
            'title' => fake()->randomElement($positions),
            'slug' => Str::slug(fake()->randomElement($positions) . ' ' . fake()->name()),
            'company' => fake()->randomElement($companies),
            'location' => fake()->randomElement(['Jakarta', 'Bandung', 'Yogyakarta', 'Surabaya', 'Remote']),
            'employment_type' => fake()->randomElement(['Full-time', 'Contract', 'Internship']),
            'summary' => fake()->paragraph(),
            'apply_url' => fake()->randomElement($jobBoardUrls),
            'closes_at' => fake()->dateTimeBetween('+1 days', '+3 months')->format('Y-m-d'),
            'is_featured' => fake()->boolean(40),
            'submitted_by' => User::where('role', 'alumni')->first()?->id,
            'approved_by' => User::where('role', 'admin')->first()?->id,
            'approval_status' => 'approved',
            'approval_notes' => 'Disetujui',
            'approved_at' => now(),
        ];
    }
}
