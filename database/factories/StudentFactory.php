<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\User;    

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'student', // Explicitly set the role to 'head'
            ]), // Creating related user
            'student_number' => $this->faker->unique()->numberBetween(10000, 99999),
            'name' => $this->faker->name,
            'place_of_birth' => $this->faker->city,
            'date_of_birth' => $this->faker->date,
            'edit' => $this->faker->sentence,
        ];
    }
}
