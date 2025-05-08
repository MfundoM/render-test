<?php

namespace Tests\Feature;

use App\Models\Policy;
use App\Models\User;
use App\Services\PolicyService;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PolicyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PolicyService $policyService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policyService = new PolicyService();
    }

    public function test_it_creates_a_policy_with_relations()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = $this->getTestPolicyData();

        $policy = $this->policyService->createPolicy($data, $user);

        $this->assertInstanceOf(Policy::class, $policy);
        $this->assertNotNull($policy->policyHolder);
        $this->assertCount(1, $policy->drivers);
        $this->assertCount(1, $policy->vehicles);

        $vehicle = $policy->vehicles->first();
        $this->assertNotNull($vehicle->garagingAddress);
        $this->assertCount(2, $vehicle->coverages);
    }

    public function test_it_updates_a_policy_and_replaces_relations()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $originalData = $this->policyService->createPolicy($this->getTestPolicyData(), $user);

        $updateData = $this->getTestPolicyData([
            'policy_holder' => ['first_name' => 'Updated'],
            'drivers' => [[
                'first_name' => 'Updated',
                'last_name' => 'Driver',
                'age' => 34,
                'gender' => 'Female',
                'marital_status' => 'Single',
                'license_number' => 'XYZ123',
                'license_state' => 'SA',
                'license_status' => 'Valid',
                'license_effective_date' => now()->subYear(),
                'license_expiration_date' => now()->addYear(),
                'license_class' => 'D'
            ]],
        ]);

        $policy = $this->policyService->updatePolicy($updateData, $originalData);

        $this->assertEquals('Updated', $policy->policyHolder->first_name);
        $this->assertEquals('Updated', $policy->drivers->first()->first_name);
    }

    private function getTestPolicyData(array $overrides = []): array
    {
        return array_merge([
            'policy_effective_date' => now()->toDateString(),
            'policy_expiration_date' => now()->addMonth()->toDateString(),
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
        ], $overrides);
    }
}
