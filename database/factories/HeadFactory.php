<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Head;
use App\Models\User;

class HeadFactory extends Factory
{
    protected $model = Head::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'head', // Explicitly set the role to 'head'
            ]), // Creates a related user with the 'head' role
            'prof_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'nip' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'name' => $this->faker->name,
        ];
    }
}
