<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'policy_id' => Policy::inRandomOrder()->first()->id,
            'year' => $this->faker->year,
            'make' => $this->faker->company,
            'model' => $this->faker->word,
            'vin' => strtoupper($this->faker->bothify('1HGBH41JXMN#######')),
            'usage' => $this->faker->randomElement(['Personal', 'Commercial']),
            'primary_use' => $this->faker->randomElement(['Commute', 'Pleasure', 'Business']),
            'annual_mileage' => $this->faker->numberBetween(8000, 20000),
            'ownership' => $this->faker->randomElement(['Owned', 'Leased', 'Financed']),
        ];
    }
}
