<?php

namespace Tests\Feature;

use App\Models\Policy;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PolicyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_can_list_policies()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Policy::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/policies');

        $response->assertOk()->assertJsonStructure(['success', 'data' => ['data']]);
    }

    public function test_it_can_create_a_policy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = $this->validPayload();

        $response = $this->postJson('/api/policies', $payload);

        $response->assertStatus(201)->assertJson(['success' => true]);
    }

    public function test_it_can_show_a_policy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $policy = Policy::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/policies/{$policy->id}");

        $response->assertOk()->assertJson(['success' => true]);
    }

    public function test_it_can_update_a_policy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $policy = Policy::factory()->create(['user_id' => $user->id]);
        $payload = $this->validPayload();

        $response = $this->putJson("/api/policies/{$policy->id}", $payload);

        $response->assertOk()->assertJson(['success' => true, 'message' => 'Policy updated successfully.']);
    }

    public function test_it_can_delete_a_policy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $policy = Policy::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/policies/{$policy->id}");

        $response->assertNoContent();
    }

    protected function validPayload()
    {
        return [
            'policy_effective_date' => now()->format('Y-m-d'),
            'policy_expiration_date' => now()->addYear()->format('Y-m-d'),
            'policy_holder' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'street' => '123 Main St',
                'city' => 'JHB',
                'state' => 'SA',
                'zip' => '2000'
            ],
            'drivers' => [
                [
                    'first_name' => 'Jane',
                    'last_name' => 'Doe',
                    'age' => 30,
                    'gender' => 'Female',
                    'marital_status' => 'Married',
                    'license_number' => 'ABC123',
                    'license_state' => 'SA',
                    'license_status' => 'Valid',
                    'license_effective_date' => now()->subYears(5)->toDateString(),
                    'license_expiration_date' => now()->addYears(5)->toDateString(),
                    'license_class' => 'C1'
                ]
            ],
            'vehicles' => [
                [
                    'year' => 2020,
                    'make' => 'Toyota',
                    'model' => 'Camry',
                    'vin' => '1234567890VIN',
                    'usage' => 'Personal',
                    'primary_use' => 'Commuting',
                    'annual_mileage' => 12000,
                    'ownership' => 'Owned',
                    'garaging_address' => [
                        'street' => '100 Test St',
                        'city' => 'JHB',
                        'state' => 'SA',
                        'zip' => '2000'
                    ],
                    'coverages' => [
                        ['type' => 'Liability', 'limit' => 100000, 'deductible' => 500],
                        ['type' => 'Collision', 'limit' => 50000, 'deductible' => 1000]
                    ]
                ]
            ]
        ];
    }
}
