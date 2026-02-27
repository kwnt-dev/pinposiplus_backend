<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PinSessionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course' => fake()->randomElement(['OUT', 'IN']),
            'status' => 'draft',
            'target_date' => fake()->date(),
            'event_name' => fake()->optional()->sentence(3),
            'groups_count' => fake()->numberBetween(5, 20),
            'is_rainy' => false,
            'created_by' => User::factory(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function confirmed(): static
    {
        return $this->state(fn () => [
            'status' => 'confirmed',
            'published_at' => now(),
            'submitted_at' => now(),
            'submitted_by' => User::factory(),
        ]);
    }
}
