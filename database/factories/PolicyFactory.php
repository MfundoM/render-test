<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Policy>
 */
class PolicyFactory extends Factory
{
    protected $model = Policy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 years', 'now');
        $end = (clone $start)->modify('+1 year');

        return [
            'user_id' => User::factory(),
            'policy_no' => 'POL' . strtoupper(Str::random(10)),
            'policy_status' => $this->faker->randomElement(['Pending', 'Active', 'Expired', 'Cancelled']),
            'policy_type' => 'Auto',
            'policy_effective_date' => $start->format('Y-m-d'),
            'policy_expiration_date' => $end->format('Y-m-d'),
        ];
    }
}
