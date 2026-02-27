<?php

namespace Database\Factories;

use App\Models\PinSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PinFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hole_number' => fake()->numberBetween(1, 18),
            'x' => fake()->numberBetween(50, 300),
            'y' => fake()->numberBetween(50, 300),
            'session_id' => PinSession::factory(),
            'created_by' => User::factory(),
        ];
    }
}
