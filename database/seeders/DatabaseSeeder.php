<?php

namespace Database\Seeders;

use App\Models\Coverage;
use App\Models\Driver;
use App\Models\GaragingAddress;
use App\Models\Policy;
use App\Models\PolicyHolder;
use App\Models\User;
use App\Models\Vehicle;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        Policy::factory(10)->create([
            // Assign a random user_id per policy
        ])->each(function ($policy) use ($users) {
            $policy->update([
                'user_id' => $users->random()->id,
            ]);

            // Add policy holder
            PolicyHolder::factory()->create([
                'policy_id' => $policy->id,
            ]);

            // Add 1–3 drivers
            Driver::factory(rand(1, 3))->create([
                'policy_id' => $policy->id,
            ]);

            // Add 1–2 vehicles per policy
            Vehicle::factory(rand(1, 2))->create([
                'policy_id' => $policy->id,
            ])->each(function ($vehicle) {
                GaragingAddress::factory()->create([
                    'vehicle_id' => $vehicle->id,
                ]);

                Coverage::factory(rand(1, 3))->create([
                    'vehicle_id' => $vehicle->id,
                ]);
            });
        });

        // \App\Models\Policy::factory(5)->create()->each(function ($policy) {
        //     \App\Models\PolicyHolder::factory()->create(['policy_id' => $policy->id]);
        // });

        // \App\Models\Driver::factory(10)->create();
        // \App\Models\Vehicle::factory(10)->create()->each(function ($vehicle) {
        //     \App\Models\GaragingAddress::factory()->create(['vehicle_id' => $vehicle->id]);
        //     \App\Models\Coverage::factory(2)->create(['vehicle_id' => $vehicle->id]);
        // });
    }
}
