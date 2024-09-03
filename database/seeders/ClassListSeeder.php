<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassList;
use App\Models\Prof;

class ClassListSeeder extends Seeder
{
    public function run()
    {
        // Fetch all professors
        $professors = Prof::all();

        // Create 3 class lists with related professors
        ClassList::factory()->count(3)->create()->each(function ($classList) use ($professors) {
            // Randomly assign a professor to each class list
            $professor = $professors->random();
            $classList->professor()->associate($professor)->save();
        });
    }
}
