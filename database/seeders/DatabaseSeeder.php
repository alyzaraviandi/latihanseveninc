<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProfSeeder::class,
            ClassListSeeder::class,
            HeadSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
