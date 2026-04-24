<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventAgendaFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => fake()->randomElement(['Seminar', 'Workshop', 'Reuni', 'Networking']),
            'summary' => fake()->sentence(15),
            'location' => fake()->city(),
            'starts_at' => fake()->dateTimeBetween('+1 days', '+3 months'),
            'registration_url' => 'https://example.com/register',
            'is_featured' => fake()->boolean(40),
        ];
    }
}
