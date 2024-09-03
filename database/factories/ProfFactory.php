<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prof;
use App\Models\User;

class ProfFactory extends Factory
{
    protected $model = Prof::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'prof', // Explicitly set the role to 'head'
            ]), // Creating related user
            'prof_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'nip' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'name' => $this->faker->name,
        ];
    }
}


