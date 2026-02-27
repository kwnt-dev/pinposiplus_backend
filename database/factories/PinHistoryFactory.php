<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PinHistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'hole_number' => fake()->numberBetween(1, 18),
            'x' => fake()->numberBetween(50, 300),
            'y' => fake()->numberBetween(50, 300),
            'submitted_by' => User::factory(),
        ];
    }
}
