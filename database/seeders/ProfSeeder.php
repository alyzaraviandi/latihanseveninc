<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prof;
use App\Models\User;

class ProfSeeder extends Seeder
{
    public function run()
    {
        // Create 5 professors
        User::factory()->count(1)->create(['role' => 'prof'])->each(function ($user) {
            Prof::factory()->create(['user_id' => $user->id]);
        });
    }
}
