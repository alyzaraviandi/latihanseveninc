<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClassList;
use App\Models\Prof;

class ClassListFactory extends Factory
{
    protected $model = ClassList::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'class_id' => $this->faker->unique()->numberBetween(1, 100),
            'prof_id' => Prof::factory(), // Creating related professor
        ];
    }
}
