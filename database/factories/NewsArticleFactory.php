<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => fake()->randomElement(['Berita', 'Agenda', 'Prestasi', 'Update']),
            'excerpt' => fake()->sentence(10),
            'content' => fake()->paragraphs(3, true),
            'cover_image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
            'published_at' => fake()->dateTimeBetween('-3 months'),
            'is_featured' => fake()->boolean(30),
        ];
    }
}
