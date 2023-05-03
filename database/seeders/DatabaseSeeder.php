<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Master\Deliverable;
use App\Models\Master\Team;
use App\Models\Project\Project;
use App\Models\User\User;
use Database\Factories\Project\ProjectFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->create();
        // Team::factory(5)->create();
        // Deliverable::factory(5)->create();
        // Project::factory(5)->create();

        // User::factory()->count(2)->has(Project::factory(10), 'createdProjects')->create();
        User::factory()->count(2)->hasCreatedProjects(3, function ($attributes, User $user) {
            return ['name' => fake()->word() . " - By " . $user->firstname];
        })->create();
    }
}
