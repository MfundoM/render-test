<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Policy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-5 years', '-1 years');
        $end = (clone $start)->modify('+5 years');

        return [
            'policy_id' => Policy::inRandomOrder()->first()->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(20, 35),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'marital_status' => $this->faker->randomElement(['Single', 'Married', 'Divoced']),
            'license_number' => strtoupper($this->faker->bothify('??######')),
            'license_state' => $this->faker->stateAbbr,
            'license_status' => $this->faker->randomElement(['Valid', 'Suspended', 'Expired']),
            'license_effective_date' => $start->format('Y-m-d'),
            'license_expiration_date' => $end->format('Y-m-d'),
            'license_class' => $this->faker->randomElement(['B', 'C1', 'D']),
        ];
    }
}
