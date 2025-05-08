<?php

namespace App\Services;

use App\Models\Policy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PolicyService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createPolicy(array $data, User $user)
    {
        $currentDate = now();
        $policyEffectiveDate = Carbon::parse($data['policy_effective_date']);
        $policyExpirationDate = Carbon::parse($data['policy_expiration_date']);

        $status = $this->determinePolicyStatus($currentDate, $policyEffectiveDate, $policyExpirationDate);

        $policy = Policy::create([
            'user_id' => $user->id,
            'policy_no' => $this->generatePolicyNumber(),
            'policy_status' => $status,
            'policy_type' => 'Auto',
            'policy_effective_date' => $data['policy_effective_date'],
            'policy_expiration_date' => $data['policy_expiration_date'],
        ]);

        if (isset($data['policy_holder'])) {
            $policy->policyHolder()->create($data['policy_holder']);
        }

        if (!empty($data['drivers'])) {
            foreach ($data['drivers'] as $driver) {
                $policy->drivers()->create($driver);
            }
        }

        if (!empty($data['vehicles'])) {
            foreach ($data['vehicles'] as $vehicleData) {
                $garaging = $vehicleData['garaging_address'] ?? null;
                $coverages = $vehicleData['coverages'] ?? [];
                unset($vehicleData['garaging_address'], $vehicleData['coverages']);

                $vehicle = $policy->vehicles()->create($vehicleData);

                if ($garaging) {
                    $vehicle->garagingAddress()->create($garaging);
                }

                foreach ($coverages as $coverage) {
                    $vehicle->coverages()->create($coverage);
                }
            }
        }

        return $policy->load(['policyHolder', 'drivers', 'vehicles.garagingAddress', 'vehicles.coverages']);
    }

    public function updatePolicy(array $data, Policy $policy)
    {
        $currentDate = now();
        $policyEffectiveDate = Carbon::parse($data['policy_effective_date']);
        $policyExpirationDate = Carbon::parse($data['policy_expiration_date']);

        $status = $this->determinePolicyStatus($currentDate, $policyEffectiveDate, $policyExpirationDate);

        $policy->update([
            'policy_status' => $status,
            'policy_effective_date' => $data['policy_effective_date'],
            'policy_expiration_date' => $data['policy_expiration_date'],
        ]);

        if (isset($data['policy_holder'])) {
            $policy->policyHolder()->updateOrCreate([], $data['policy_holder']);
        }

        $policy->drivers()->delete();
        foreach ($data['drivers'] as $driver) {
            $policy->drivers()->create($driver);
        }

        foreach ($policy->vehicles as $vehicle) {
            $vehicle->garagingAddress()->delete();
            $vehicle->coverages()->delete();
            $vehicle->delete();
        }

        foreach ($data['vehicles'] as $vehicleData) {
            $garaging = $vehicleData['garaging_address'] ?? null;
            $coverages = $vehicleData['coverages'] ?? [];
            unset($vehicleData['garaging_address'], $vehicleData['coverages']);

            $vehicle = $policy->vehicles()->create($vehicleData);

            if ($garaging) {
                $vehicle->garagingAddress()->create($garaging);
            }

            foreach ($coverages as $coverage) {
                $vehicle->coverages()->create($coverage);
            }
        }

        return $policy->load(['policyHolder', 'drivers', 'vehicles.garagingAddress', 'vehicles.coverages']);
    }

    protected function generatePolicyNumber()
    {
        do {
            $number = 'POL' . strtoupper(Str::random(8));
        } while (Policy::where('policy_no', $number)->exists());

        return $number;
    }

    protected function determinePolicyStatus(Carbon $currentDate, Carbon $effectiveDate, Carbon $expirationDate)
    {
        if ($currentDate < $effectiveDate) {
            return 'Pending';
        }

        if ($currentDate >= $effectiveDate && $currentDate <= $expirationDate) {
            return 'Active';
        }

        return 'Expired';
    }

    public function generatePolicyPDF(Policy $policy)
    {
        $policyData = $policy->load([
            'policyHolder',
            'drivers',
            'vehicles.garagingAddress',
            'vehicles.coverages'
        ]);

        // dd($policyData);
        $pdf = PDF::loadView('policy.pdf', ['policy' => $policyData]);

        return $pdf->download('policy_' . $policy->policy_no . '.pdf');
    }
}
