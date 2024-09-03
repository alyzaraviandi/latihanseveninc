<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Use a default password
            'email_verified_at' => now(),
            'role' => $this->faker->randomElement(['head', 'prof', 'student']), // Random role assignment
        ];
    }
}
