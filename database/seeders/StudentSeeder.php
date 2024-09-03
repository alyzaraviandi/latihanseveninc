<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassList;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::factory()->count(20)->create()->each(function ($student) {
            $classes = ClassList::all();
            $student->classes()->attach(
                $classes->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
