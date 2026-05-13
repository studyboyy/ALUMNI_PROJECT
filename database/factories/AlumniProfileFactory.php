<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlumniProfileFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->name();
        $programs = ['Teknik Informatika', 'Sistem Informasi', 'Teknik Industri'];
        $employers = ['Tokopedia', 'Shopee', 'Gojek', 'Traveloka', 'Grab', 'Bank BNI', 'Telkom'];
        $industries = ['E-commerce', 'Financial Services', 'Tech Startup', 'Government', 'Education'];

        return [
            'user_id' => null,
            'nim' => fake()->unique()->numerify('20##########'),
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '08' . fake()->numerify('##########'),
            'program' => fake()->randomElement($programs),
            'campus_name' => 'Universitas ' . fake()->lastName(),
            'batch_year' => fake()->numberBetween(2015, 2022),
            'graduation_year' => fake()->numberBetween(2019, 2024),
            'employer' => fake()->randomElement($employers),
            'job_title' => fake()->jobTitle(),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'industry' => fake()->randomElement($industries),
            'employment_status' => 'Bekerja',
            'bio' => fake()->paragraph(),
            'achievements' => [fake()->sentence(), fake()->sentence()],
            'linkedin_url' => 'https://linkedin.com/in/' . Str::slug($name),
            'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
            'testimonial_quote' => fake()->sentence(),
            'is_featured' => fake()->boolean(30),
        ];
    }
}
