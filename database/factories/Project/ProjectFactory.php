<?php

namespace Database\Factories\Project;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> 
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'user_id' => fake()->randomElement(User::pluck('id')),
            'logo_url' => fake()->url(),
            'description' => fake()->paragraph(1, false),
            'description' => fake()->paragraph(1, false),
            'status' => fake()->randomElement(['active', 'inactive']),
            'is_archive' => fake()->randomElement(['true', 'false'])
        ];
    }
}
