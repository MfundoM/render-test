<?php

namespace Database\Factories;

use App\Models\Coverage;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coverage>
 */
class CoverageFactory extends Factory
{
    protected $model = Coverage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['Liability', 'Collision', 'Comprehensive']),
            'limit' => $this->faker->numberBetween(25000, 100000),
            'deductible' => $this->faker->randomElement([250, 500, 1000]),
        ];
    }
}
