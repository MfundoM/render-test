<?php

namespace Database\Factories;

use App\Models\PolicyHolder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PolicyHolder>
 */
class PolicyHolderFactory extends Factory
{
    protected $model = PolicyHolder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'street'     => $this->faker->streetAddress,
            'city'       => $this->faker->city,
            'state'      => $this->faker->stateAbbr,
            'zip'        => $this->faker->postcode,
        ];
    }
}
