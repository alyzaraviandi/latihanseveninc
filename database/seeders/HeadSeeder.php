<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Head;
use App\Models\User;

class HeadSeeder extends Seeder
{
    public function run()
    {
        $count = 1; // Adjust the count as needed

        // Create the specified number of Head records
        Head::factory()->count($count)->create()->each(function ($head) {
            // Create a user with the 'head' role for each Head record
            $user = User::factory()->create(['role' => 'head']);
            $head->user_id = $user->id;
            $head->save();
        });
    }
}
