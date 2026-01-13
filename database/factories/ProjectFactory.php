<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
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
        $name = $this->faker->unique()->company();

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'thumbnail'   => $this->faker->optional()->imageUrl(640, 480, 'business', true),
            'description' => $this->faker->optional()->paragraphs(3, true),
            'address'     => $this->faker->optional()->address(),
            'status'      => 'published', // default per schema
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }

    /**
     * Indicate that the project is published.
     */
    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
        ]);
    }
}
