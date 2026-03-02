<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Plan::create([
            'name' => 'Starter',
            'slug' => 'starter',
            'monthly_minutes' => 500,
            'max_agents' => 1,
            'max_users' => 2,
            'price' => 29,
            'allow_call_transfer' => false,
        ]);
    }
}
