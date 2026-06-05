<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    // Pool nama Indonesia agar konsisten dengan AlumniProfileFactory
    private static array $indonesianNames = [
        'Raka Pratama', 'Fadhil Nugroho', 'Dimas Arief', 'Rizqi Ananda', 'Hendra Saputra',
        'Bagas Kurniawan', 'Aldi Setiawan', 'Taufik Hidayat', 'Wahyu Santoso', 'Irfan Maulana',
        'Nadia Azzahra', 'Sinta Larasati', 'Alya Nurfadila', 'Nabila Rahma', 'Aulia Putri',
        'Desi Ratnasari', 'Fitri Handayani', 'Laila Zahra', 'Mutia Dewi', 'Rini Kusuma',
    ];

    private static int $nameIndex = 0;

    public function definition(): array
    {
        $name = self::$indonesianNames[self::$nameIndex % count(self::$indonesianNames)];
        self::$nameIndex++;

        return [
            'name'               => $name,
            'email'              => Str::slug($name) . '.' . fake()->unique()->numerify('##') . '@gmail.com',
            'email_verified_at'  => now(),
            'password'           => static::$password ??= Hash::make('password'),
            'remember_token'     => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
