<?php

namespace Database\Factories;

use App\Models\ModelUnit;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelUnit>
 */
class ModelUnitFactory extends Factory
{
    protected $model = ModelUnit::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
//            'project_id' => Project::factory(),
            'project_id' => 25,
            'name'       => ucwords($name),
            'slug'       => Str::slug($name),
            'thumbnail'  => $this->faker->boolean(70)
                ? 'model-units/' . $this->faker->uuid . '.jpg'
                : null,
            'description'=> $this->faker->optional()->paragraph(3),
            'status'     => $this->faker->randomElement(['draft', 'published', 'archived']),
            'type'       => $this->faker->randomElement([
                'Single Detached',
                'Duplex',
                'Townhouse',
                'Bungalow',
                'Condominium'
            ]),
            'lot_area'   => $this->faker->optional()->randomFloat(2, 40, 300) . ' sqm',
            'floor_area' => $this->faker->optional()->randomFloat(2, 30, 250) . ' sqm',
        ];
    }

    /**
     * State: Published model unit
     */
    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
        ]);
    }

    /**
     * State: Draft model unit
     */
    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => 'draft',
        ]);
    }
}
